<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Services\PostXmlImportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('cari');
        $categoryId = $request->query('kategori');

        $query = Post::with(['category', 'author'])->orderBy('created_at', 'desc');

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $posts = $query->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('admin.posts.index', compact('posts', 'categories', 'search', 'categoryId'));
    }

    public function showImport(): View
    {
        $categories = Category::all();

        return view('admin.posts.import', compact('categories'));
    }

    public function importXml(Request $request, PostXmlImportService $importService): RedirectResponse
    {
        @set_time_limit(600);
        @ini_set('memory_limit', '1024M');

        if (! extension_loaded('simplexml') || ! extension_loaded('libxml')) {
            return redirect()->back()->with('error', 'Ekstensi PHP SimpleXML / LibXML belum aktif di server. Silakan aktifkan ekstensi php-xml pada panel hosting/VPS Anda.');
        }

        // Tangkap error jika ukuran file melebihi upload_max_filesize di php.ini server
        if (isset($_FILES['xml_file']['error']) && in_array($_FILES['xml_file']['error'], [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE], true)) {
            $maxUpload = ini_get('upload_max_filesize');

            return redirect()->back()->with('error', "Ukuran file XML melebihi batas upload_max_filesize di server ({$maxUpload}). Silakan naikkan upload_max_filesize & post_max_size di php.ini atau gunakan tab 'Tempel Teks XML'.");
        }

        $request->validate([
            'xml_file' => 'nullable|file|max:204800',
            'xml_content' => 'nullable|string',
            'default_category_id' => 'nullable|exists:categories,id',
            'auto_create_category' => 'nullable|boolean',
            'status_mode' => 'required|in:keep,publish,draft',
            'duplicate_handling' => 'required|in:allow,skip',
        ]);

        $safeInputs = $request->except(['xml_file', 'xml_content']);
        $xmlString = '';

        try {
            if ($request->hasFile('xml_file')) {
                $file = $request->file('xml_file');
                if (! $file || ! $file->isValid()) {
                    return redirect()->back()
                        ->withInput($safeInputs)
                        ->with('error', 'Gagal mengunggah file XML (Error Code: '.($file ? $file->getError() : 'Unknown').'). Pastikan ukuran file tidak melebihi batas upload server.');
                }

                $ext = strtolower($file->getClientOriginalExtension());
                if (! in_array($ext, ['xml', 'txt', 'rss', 'wxr'], true)) {
                    return redirect()->back()
                        ->withInput($safeInputs)
                        ->with('error', 'Format berkas harus berupa file .xml, .rss, atau .txt.');
                }

                $xmlString = (string) $file->getContent();
            } elseif ($request->filled('xml_content')) {
                $xmlString = (string) $request->input('xml_content');
            } else {
                return redirect()->back()
                    ->withInput($safeInputs)
                    ->with('error', 'Harap pilih berkas file XML atau tempel kode XML pada kolom yang tersedia.');
            }

            $result = $importService->import($xmlString, [
                'default_category_id' => $request->filled('default_category_id') ? (int) $request->input('default_category_id') : null,
                'auto_create_category' => $request->boolean('auto_create_category', true),
                'status_mode' => $request->input('status_mode', 'keep'),
                'duplicate_handling' => $request->input('duplicate_handling', 'allow'),
                'user_id' => Auth::id(),
            ]);
        } catch (\Throwable $e) {
            return redirect()->back()
                ->withInput($safeInputs)
                ->with('error', 'Terjadi kesalahan saat memproses XML: '.$e->getMessage());
        }

        if (! $result['success'] && count($result['errors']) > 0) {
            $sampleErrors = array_slice($result['errors'], 0, 3);
            $errorSummary = implode(' | ', $sampleErrors);
            if (count($result['errors']) > 3) {
                $errorSummary .= ' (dan '.(count($result['errors']) - 3).' kesalahan lainnya)';
            }

            return redirect()->back()
                ->withInput($safeInputs)
                ->with('error', 'Impor gagal: '.$errorSummary);
        }

        $message = "Berhasil mengimpor {$result['imported_count']} artikel berita dari XML!";
        if ($result['skipped_count'] > 0) {
            $message .= " ({$result['skipped_count']} artikel dilewati).";
        }
        if (count($result['created_categories']) > 0) {
            $message .= ' Kategori baru dibuat: '.implode(', ', array_slice($result['created_categories'], 0, 5)).'.';
        }

        return redirect()->route('admin.posts.index')->with('success', $message);
    }

    public function downloadXmlTemplate(PostXmlImportService $importService): Response
    {
        $xml = $importService->getSampleXml();

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="template-berita-uptpjj.xml"',
        ]);
    }

    public function create()
    {
        $categories = Category::all();

        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'featured_image_url' => 'nullable|url',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'tags' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $imagePath = $request->input('featured_image_url');
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('posts', 'public');
        }

        $post = Post::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']).'-'.Str::random(4),
            'category_id' => $validated['category_id'],
            'user_id' => Auth::id(),
            'excerpt' => $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 160),
            'content' => $validated['content'],
            'featured_image' => $imagePath,
            'is_featured' => $request->boolean('is_featured'),
            'is_published' => $request->boolean('is_published', true),
            'published_at' => $validated['published_at'] ?? now(),
            'tags' => $validated['tags'] ?? null,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil dipublikasikan!');
    }

    public function edit(Post $post)
    {
        $categories = Category::all();

        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'featured_image_url' => 'nullable|url',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'tags' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $imagePath = $post->featured_image;
        if ($request->filled('featured_image_url')) {
            $imagePath = $request->input('featured_image_url');
        }
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('posts', 'public');
        }

        $post->update([
            'title' => $validated['title'],
            'category_id' => $validated['category_id'],
            'excerpt' => $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 160),
            'content' => $validated['content'],
            'featured_image' => $imagePath,
            'is_featured' => $request->boolean('is_featured'),
            'is_published' => $request->boolean('is_published'),
            'published_at' => $validated['published_at'] ?? $post->published_at,
            'tags' => $validated['tags'] ?? null,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil dihapus.');
    }

    /**
     * Upload an embedded image from the rich text editor.
     */
    public function uploadContentImage(Request $request): JsonResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
        ]);

        $file = $request->file('image');
        $filename = time().'_'.Str::random(10).'.'.$file->getClientOriginalExtension();
        $path = $file->storeAs('posts/content', $filename, 'public');
        $url = asset('storage/'.$path);

        return response()->json([
            'success' => true,
            'url' => $url,
            'filename' => $filename,
        ]);
    }
}
