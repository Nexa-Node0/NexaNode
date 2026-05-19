<?php

namespace Database\Factories;

use App\Models\Position;
use App\Models\Department;
use App\Enums\PositionEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Position>
 */
class PositionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'department_id' => Department::factory(),
            'name'          => fake()->jobTitle(),
            'code'          => strtoupper(fake()->bothify('??-##')),
            'level'         => fake()->numberBetween(1, 3),
            'type'          => fake()->randomElement(PositionEnum::values()),
            'max_headcount' => fake()->optional()->numberBetween(1, 5),
            'is_active'     => true,
            'description'   => fake()->optional()->sentence(),
            'reports_to'    => null
        ];
    }

    public function junior(): static
    {
        return $this->state(fn() => [
            'level' => 3,
        ]);
    }

    public function senior(): static
    {
        return $this->state(fn() => [
            'level' => 1
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn() => [
            'is_active' => false,
        ]);
    }
}
