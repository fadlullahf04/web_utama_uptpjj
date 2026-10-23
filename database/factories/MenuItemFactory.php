<?php

namespace Database\Factories;

use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MenuItem>
 */
class MenuItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'location' => 'header',
            'parent_id' => null,
            'title' => fake()->words(2, true),
            'type' => 'custom',
            'page_id' => null,
            'route_name' => null,
            'url' => fake()->url(),
            'target' => '_self',
            'icon' => null,
            'badge' => null,
            'badge_color' => 'emerald',
            'order' => fake()->numberBetween(0, 10),
            'is_active' => true,
        ];
    }
}
