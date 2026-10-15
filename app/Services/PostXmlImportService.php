<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use SimpleXMLElement;

class PostXmlImportService
{
    /**
     * Import posts from XML string content.
     *
     * @param  array{default_category_id?: ?int, auto_create_category?: bool, status_mode?: string, duplicate_handling?: string, user_id?: ?int}  $options
     * @return array{success: bool, imported_count: int, skipped_count: int, created_categories: array<string>, errors: array<string>, titles: array<string>}
     */
    public function import(string $xmlContent, array $options = []): array
    {
        $defaultCategoryId = $options['default_category_id'] ?? null;
        $autoCreateCategory = (bool) ($options['auto_create_category'] ?? true);
        $statusMode = $options['status_mode'] ?? 'keep'; // 'keep', 'publish', 'draft'
        $duplicateHandling = $options['duplicate_handling'] ?? 'allow'; // 'allow', 'skip'
        $userId = $options['user_id'] ?? Auth::id();

        $result = [
            'success' => false,
            'imported_count' => 0,
            'skipped_count' => 0,
            'created_categories' => [],
            'errors' => [],
            'titles' => [],
        ];

        libxml_use_internal_errors(true);
        try {
            $cleanXml = $this->sanitizeXml($xmlContent);
            if (trim($cleanXml) === '') {
                $result['errors'][] = 'Konten XML kosong.';

                return $result;
            }

            $xml = simplexml_load_string($cleanXml, 'SimpleXMLElement', LIBXML_NOCDATA | LIBXML_NONET);
        } catch (\Throwable $e) {
            $result['errors'][] = 'Gagal memproses XML: '.$e->getMessage();

            return $result;
        }

        if ($xml === false) {
            $xmlErrors = libxml_get_errors();
            libxml_clear_errors();
            $messages = [];
            foreach ($xmlErrors as $err) {
                $messages[] = trim($err->message);
            }
            $result['errors'][] = 'Format XML tidak valid: '.implode(', ', array_unique($messages));

            return $result;
        }

        $items = $this->extractItems($xml);
        if (count($items) === 0) {
            $result['errors'][] = 'Tidak ditemukan elemen berita/artikel (<item>, <post>, <article>, atau <entry>) di dalam file XML.';

            return $result;
        }

        $namespaces = $xml->getDocNamespaces(true);

        foreach ($items as $itemNode) {
            try {
                $parsed = $this->parseItem($itemNode, $namespaces);

                if (empty($parsed['title'])) {
                    $result['skipped_count']++;

                    continue;
                }

                // Skip non-post items from WordPress WXR (e.g. pages, attachments, nav_menu_item)
                if (! empty($parsed['post_type']) && ! in_array($parsed['post_type'], ['post', 'berita', 'article'], true)) {
                    $result['skipped_count']++;

                    continue;
                }

                // Check for duplicate title if configured to skip
                if ($duplicateHandling === 'skip') {
                    $exists = Post::where('title', $parsed['title'])->exists();
                    if ($exists) {
                        $result['skipped_count']++;

                        continue;
                    }
                }

                // Resolve Category
                $categoryId = $this->resolveCategory(
                    $parsed['category_name'],
                    $defaultCategoryId,
                    $autoCreateCategory,
                    $result['created_categories']
                );

                // Resolve Publishing Status
                $isPublished = true;
                if ($statusMode === 'publish') {
                    $isPublished = true;
                } elseif ($statusMode === 'draft') {
                    $isPublished = false;
                } else {
                    $isPublished = $parsed['is_published'];
                }

                // Resolve Published Date
                $publishedAt = $parsed['published_at'] ?? now();

                // Excerpt fallback
                $excerpt = $parsed['excerpt'];
                if (empty($excerpt) && ! empty($parsed['content'])) {
                    $excerpt = Str::limit(strip_tags($parsed['content']), 160);
                }

                // Featured Image fallback (try to extract from content if not present)
                $featuredImage = $parsed['featured_image'];
                if (empty($featuredImage) && ! empty($parsed['content'])) {
                    $featuredImage = $this->extractImageFromHtml($parsed['content']);
                }

                // Generate Unique Slug
                $baseSlug = ! empty($parsed['slug']) ? Str::slug($parsed['slug']) : Str::slug($parsed['title']);
                $slug = $baseSlug.'-'.Str::random(5);

                $post = Post::create([
                    'title' => $parsed['title'],
                    'slug' => $slug,
                    'category_id' => $categoryId,
                    'user_id' => $userId,
                    'excerpt' => $excerpt,
                    'content' => $parsed['content'] ?: '<p>'.e($parsed['title']).'</p>',
                    'featured_image' => $featuredImage,
                    'views_count' => $parsed['views_count'] ?? 0,
                    'is_featured' => $parsed['is_featured'] ?? false,
                    'is_published' => $isPublished,
                    'published_at' => $publishedAt,
                    'tags' => $parsed['tags'],
                ]);

                $result['imported_count']++;
                $result['titles'][] = $post->title;
            } catch (\Throwable $e) {
                Log::warning('Error importing XML post item: '.$e->getMessage());
                $result['errors'][] = 'Gagal mengimpor artikel "'.($parsed['title'] ?? 'Tanpa Judul').'": '.$e->getMessage();
            }
        }

        $result['success'] = $result['imported_count'] > 0;

        return $result;
    }

    /**
     * Sanitize and strip problematic characters from XML.
     * Enforces strict XXE (XML External Entity) and entity expansion prevention.
     */
    protected function sanitizeXml(string $content): string
    {
        // Remove UTF-8 BOM if present
        $content = preg_replace('/^\xEF\xBB\xBF/', '', $content);

        // Reject XML External Entity (XXE) and billion laughs attempts
        if (preg_match('/<!ENTITY|<!DOCTYPE/i', $content)) {
            throw new \InvalidArgumentException('Berkas XML mengandung deklarasi DOCTYPE atau ENTITY yang berpotensi membahayakan keamanan server.');
        }

        return trim($content);
    }

    /**
     * Extract item nodes from various XML formats.
     *
     * @return array<SimpleXMLElement>
     */
    protected function extractItems(SimpleXMLElement $xml): array
    {
        // 1. RSS 2.0 / WordPress WXR: <rss><channel><item>
        if (isset($xml->channel->item)) {
            $items = [];
            foreach ($xml->channel->item as $item) {
                $items[] = $item;
            }

            return $items;
        }

        // 2. Direct items: <posts><post> or <articles><article>
        if (isset($xml->post)) {
            $items = [];
            foreach ($xml->post as $item) {
                $items[] = $item;
            }

            return $items;
        }

        if (isset($xml->article)) {
            $items = [];
            foreach ($xml->article as $item) {
                $items[] = $item;
            }

            return $items;
        }

        if (isset($xml->item)) {
            $items = [];
            foreach ($xml->item as $item) {
                $items[] = $item;
            }

            return $items;
        }

        // 3. Atom: <feed><entry>
        if (isset($xml->entry)) {
            $items = [];
            foreach ($xml->entry as $item) {
                $items[] = $item;
            }

            return $items;
        }

        // 4. Fallback: Search children for post-like tags
        $items = [];
        foreach ($xml->children() as $child) {
            $name = strtolower($child->getName());
            if (in_array($name, ['item', 'post', 'article', 'entry', 'berita'], true)) {
                $items[] = $child;
            }
        }

        return $items;
    }

    /**
     * Parse an individual XML item node.
     *
     * @param  array<string, string>  $namespaces
     * @return array{title: string, slug: ?string, content: string, excerpt: ?string, category_name: ?string, tags: ?string, featured_image: ?string, published_at: ?Carbon, is_published: bool, is_featured: bool, views_count: int, post_type: ?string}
     */
    protected function parseItem(SimpleXMLElement $item, array $namespaces): array
    {
        // Extract title
        $title = trim((string) $item->title);

        // Extract content with support for WordPress <content:encoded>
        $content = '';
        if (isset($namespaces['content'])) {
            $contentNode = $item->children($namespaces['content'])->encoded;
            if ($contentNode !== null && (string) $contentNode !== '') {
                $content = (string) $contentNode;
            }
        }
        if ($content === '' && isset($item->content)) {
            $content = (string) $item->content;
        }
        if ($content === '' && isset($item->description)) {
            $content = (string) $item->description;
        }
        if ($content === '' && isset($item->body)) {
            $content = (string) $item->body;
        }

        // Extract excerpt with support for WordPress <excerpt:encoded>
        $excerpt = null;
        if (isset($namespaces['excerpt'])) {
            $excerptNode = $item->children($namespaces['excerpt'])->encoded;
            if ($excerptNode !== null && (string) $excerptNode !== '') {
                $excerpt = trim((string) $excerptNode);
            }
        }
        if (empty($excerpt) && isset($item->excerpt)) {
            $excerpt = trim((string) $item->excerpt);
        }
        if (empty($excerpt) && isset($item->summary)) {
            $excerpt = trim((string) $item->summary);
        }

        // Extract WordPress-specific fields
        $postType = 'post';
        $postDate = null;
        $wpStatus = null;

        if (isset($namespaces['wp'])) {
            $wp = $item->children($namespaces['wp']);
            if (isset($wp->post_type)) {
                $postType = strtolower(trim((string) $wp->post_type));
            }
            if (isset($wp->post_date)) {
                $postDate = trim((string) $wp->post_date);
            }
            if (isset($wp->status)) {
                $wpStatus = strtolower(trim((string) $wp->status));
            }
            if (isset($wp->post_name) && (string) $wp->post_name !== '') {
                $slug = trim((string) $wp->post_name);
            }
        }

        $slug = $slug ?? (isset($item->slug) ? trim((string) $item->slug) : null);

        // Extract category & tags
        $categoryName = null;
        $tagList = [];

        if (isset($item->category)) {
            foreach ($item->category as $cat) {
                $attributes = $cat->attributes();
                $domain = isset($attributes['domain']) ? (string) $attributes['domain'] : 'category';
                $catText = trim((string) $cat);

                if ($domain === 'category' || empty($categoryName)) {
                    if (empty($categoryName) && $catText !== '') {
                        $categoryName = $catText;
                    }
                } elseif ($domain === 'post_tag' || $domain === 'tag') {
                    if ($catText !== '') {
                        $tagList[] = $catText;
                    }
                }
            }
        }

        if (isset($item->tags)) {
            $tagsText = trim((string) $item->tags);
            if ($tagsText !== '') {
                $tagList = array_merge($tagList, array_map('trim', explode(',', $tagsText)));
            }
        }

        // Extract featured image
        $featuredImage = null;
        if (isset($item->featured_image) && (string) $item->featured_image !== '') {
            $featuredImage = trim((string) $item->featured_image);
        } elseif (isset($item->image) && (string) $item->image !== '') {
            $featuredImage = trim((string) $item->image);
        } elseif (isset($item->enclosure)) {
            $enclosureAttrs = $item->enclosure->attributes();
            if (isset($enclosureAttrs['url'])) {
                $featuredImage = (string) $enclosureAttrs['url'];
            }
        }

        // Extract date
        $publishedAt = null;
        $dateCandidates = [
            $postDate,
            isset($item->published_at) ? (string) $item->published_at : null,
            isset($item->pubDate) ? (string) $item->pubDate : null,
            isset($item->date) ? (string) $item->date : null,
            isset($item->updated) ? (string) $item->updated : null,
        ];

        foreach ($dateCandidates as $cand) {
            if (! empty($cand)) {
                try {
                    $publishedAt = Carbon::parse($cand);
                    break;
                } catch (\Throwable) {
                    // Try next candidate
                }
            }
        }

        // Extract publication status
        $isPublished = true;
        if ($wpStatus !== null) {
            $isPublished = ($wpStatus === 'publish');
        } elseif (isset($item->is_published)) {
            $val = trim((string) $item->is_published);
            $isPublished = in_array(strtolower($val), ['1', 'true', 'yes', 'publish', 'published'], true);
        }

        // Extract featured flag
        $isFeatured = false;
        if (isset($item->is_featured)) {
            $val = trim((string) $item->is_featured);
            $isFeatured = in_array(strtolower($val), ['1', 'true', 'yes'], true);
        }

        // Views count
        $viewsCount = 0;
        if (isset($item->views_count)) {
            $viewsCount = (int) $item->views_count;
        }

        return [
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'excerpt' => $excerpt,
            'category_name' => $categoryName,
            'tags' => count($tagList) > 0 ? implode(', ', array_unique($tagList)) : null,
            'featured_image' => $featuredImage,
            'published_at' => $publishedAt,
            'is_published' => $isPublished,
            'is_featured' => $isFeatured,
            'views_count' => $viewsCount,
            'post_type' => $postType,
        ];
    }

    /**
     * Resolve or create category for imported post.
     *
     * @param  array<string>  $createdCategoriesTracker
     */
    protected function resolveCategory(?string $categoryName, ?int $defaultCategoryId, bool $autoCreate, array &$createdCategoriesTracker): int
    {
        if (! empty($categoryName)) {
            $category = Category::where('name', $categoryName)
                ->orWhere('slug', Str::slug($categoryName))
                ->first();

            if ($category) {
                return $category->id;
            }

            if ($autoCreate) {
                $newCategory = Category::create([
                    'name' => $categoryName,
                    'slug' => Str::slug($categoryName),
                    'type' => 'berita',
                    'color' => 'emerald',
                    'description' => 'Kategori hasil impor XML',
                ]);

                if (! in_array($categoryName, $createdCategoriesTracker, true)) {
                    $createdCategoriesTracker[] = $categoryName;
                }

                return $newCategory->id;
            }
        }

        if ($defaultCategoryId) {
            return $defaultCategoryId;
        }

        // Fallback to first existing category or create a default one
        $firstCat = Category::first();
        if ($firstCat) {
            return $firstCat->id;
        }

        $default = Category::create([
            'name' => 'Berita & Informasi',
            'slug' => 'berita-dan-informasi',
            'type' => 'berita',
            'color' => 'blue',
            'description' => 'Kategori umum berita UPT PJJ',
        ]);

        return $default->id;
    }

    /**
     * Extract the first image src from an HTML string.
     */
    protected function extractImageFromHtml(string $html): ?string
    {
        if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $html, $matches)) {
            $src = trim($matches[1]);
            if (filter_var($src, FILTER_VALIDATE_URL) || str_starts_with($src, '/') || str_starts_with($src, 'data:image')) {
                return $src;
            }
        }

        return null;
    }

    /**
     * Generate standard sample XML string for download and guidance.
     */
    public function getSampleXml(): string
    {
        return <<<'XML'
<?xml version="1.0" encoding="UTF-8"?>
<posts>
    <post>
        <title>UIN Siber Syekh Nurjati Siapkan Ekosistem Micro-Learning Berbasis AI</title>
        <slug>uin-siber-ekosistem-micro-learning-ai</slug>
        <category>Berita &amp; Informasi</category>
        <excerpt>UPT PJJ UINSSC menghadirkan inovasi micro-learning cerdas untuk mendukung fleksibilitas belajar mahasiswa siber di seluruh Indonesia.</excerpt>
        <content><![CDATA[<p><strong>CIREBON</strong> — Unit Pelaksana Teknis Pendidikan Jarak Jauh (UPT PJJ) UIN Siber Syekh Nurjati Cirebon resmi mengumumkan penguatan integrasi sistem <em>micro-learning</em> interaktif berbasis kecerdasan buatan pada platform LMS Pillar.</p><p>Langkah strategis ini dirancang untuk memudahkan mahasiswa mengakses materi esensial secara terfokus kapan pun dan di mana pun, serta dilengkapi evaluasi formatif mandiri yang adaptif.</p>]]></content>
        <featured_image>https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&amp;w=800</featured_image>
        <tags>Micro-learning, AI, LMS Pillar, Pendidikan Siber</tags>
        <is_featured>1</is_featured>
        <is_published>1</is_published>
        <published_at>2026-10-14 10:00:00</published_at>
    </post>
    <post>
        <title>Bimbingan Teknis Penyusunan Bahan Ajar Digital dan Video MOOC Semester Baru</title>
        <slug>bimtek-penyusunan-bahan-ajar-digital-mooc</slug>
        <category>Bimtek &amp; Pelatihan</category>
        <excerpt>Peningkatan kompetensi pedagogik dosen dan tutor siber dalam merancang materi ajar modular berkualitas tinggi.</excerpt>
        <content><![CDATA[<p>Sebanyak 150 dosen pengampu mata kuliah PJJ mengikuti bimbingan teknis intensif pembuatan bahan ajar modular multimedia di Studio Siber Kampus UINSSC.</p><p>Hasil dari pelatihan ini adalah terciptanya modul digital berstandar SCORM dan video ajar 4K yang siap diunggah ke repositori pembelajaran daring.</p>]]></content>
        <featured_image>https://images.unsplash.com/photo-1531403009284-440f080d1e12?q=80&amp;w=800</featured_image>
        <tags>Bimtek, Bahan Ajar, MOOC, Studio Siber</tags>
        <is_featured>0</is_featured>
        <is_published>1</is_published>
        <published_at>2026-10-12 14:30:00</published_at>
    </post>
</posts>
XML;
    }
}
