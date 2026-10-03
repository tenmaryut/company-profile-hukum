<?php

namespace Database\Factories;

use App\Models\PracticeArea;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<PracticeArea>
 */
class PracticeAreaFactory extends Factory
{
    public function definition(): array
    {
        $name = 'Hukum '.Str::title(fake()->unique()->word());

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'summary' => fake()->sentence(12),
            'description' => fake()->paragraphs(2, true),
            'services' => fake()->sentences(3),
            'legal_basis' => ['Undang-Undang Nomor 1 Tahun 2023 tentang Kitab Undang-Undang Hukum Pidana'],
            'icon' => 'timbangan',
            'sort_order' => fake()->numberBetween(1, 50),
            'is_published' => true,
        ];
    }
}
