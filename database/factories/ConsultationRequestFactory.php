<?php

namespace Database\Factories;

use App\Enums\ConsultationStatus;
use App\Models\ConsultationRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ConsultationRequest>
 */
class ConsultationRequestFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => null,
            'message' => fake()->paragraph(),
            'status' => ConsultationStatus::Baru,
            'consented_at' => now(),
            'is_sample' => false,
        ];
    }

    public function sample(): static
    {
        return $this->state(fn () => ['is_sample' => true]);
    }
}
