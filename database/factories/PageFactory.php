<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Page>
 */
class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(4);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => fake()->paragraph(),
            'content' => '<p>'.fake()->paragraphs(3, true).'</p>',
            'template' => 'default',
            'is_published' => true,
            'published_at' => now(),
            'views_count' => fake()->numberBetween(0, 500),
            'meta_title' => $title,
            'meta_description' => fake()->sentence(10),
        ];
    }
}
