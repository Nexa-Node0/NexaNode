<?php
namespace Database\Factories;

use App\Enums\ApprovedStatus;
use App\Enums\Priority;
use App\Enums\ProjectStatus;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $now = now();

        return [
            'title'             => ucwords($this->faker->words(rand(1, 3), true)),

            'code'              => Str::random(10),

            'description'       => $this->faker->paragraph(rand(2, 4)),

            'status'            => $this->faker->randomElement(ProjectStatus::cases())->value,
            'priority'          => $this->faker->randomElement(Priority::cases())->value,

            'start_date'        => $this->faker->dateTimeBetween(
                $now->copy()->addDay(),
                $now->copy()->addDays(15)
            ),

            'budget_amount'     => $this->faker->randomFloat(2, 10000, 999999999.99),

            'actual_cost'       => $this->faker->randomFloat(2, 10000, 999999999.99),

            'requires_approval' => $this->faker->boolean(),

            'approved_status'   => $this->faker->randomElement(ApprovedStatus::cases())->value,

            'supervisor_id'     => User::inRandomOrder()->value('id'),
        ];
    }

    public function supervisor(User $user): static
    {
        return $this->state(fn(array $attributes) => [
            'supervisor_id' => $user->id,
        ]);
    }
}
