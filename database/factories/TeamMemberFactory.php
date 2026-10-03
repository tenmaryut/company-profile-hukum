<?php

namespace Database\Factories;

use App\Models\TeamMember;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<TeamMember>
 */
class TeamMemberFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->name();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'position' => 'Advokat',
            'focus' => 'Hukum Perdata',
            'bio' => fake()->paragraph(),
            'avatar_variant' => fake()->numberBetween(1, 8),
            'sort_order' => fake()->numberBetween(1, 50),
            'is_published' => true,
        ];
    }
}
