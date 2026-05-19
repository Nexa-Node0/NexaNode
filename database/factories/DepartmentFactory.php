<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;
use Override;

/**
 * @extends Factory<Department>
 */

class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    #[Override]
    public function definition()
    {
        return [
            'name' => fake()->unique()->randomElement([
                'Engineering',
                'Quality Assurance',
                'Product Management',
                'Human Resources',
                'Finance',
                'Marketing',
                'Operations',
                'Legal',
                'Sales',
                'Customer Support',
            ])
        ];
    }
}
