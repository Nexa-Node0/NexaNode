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
        // Title
        $title = ucwords($this->faker->words(rand(1, 4), true));

        $approvedStatuses = [
            'approved',
            'pending',
            'rejected',
        ];

        $approved_status = $this->faker->randomElement($approvedStatuses);

        return [
            'title'             => $title,
            'code'              => Str::upper(Str::random(10)),
            'description'       => $this->faker->paragraph(),
            'status'            => $this->faker->randomElement(ProjectStatus::cases()),
            'priority'          => $this->faker->randomElement(Priority::cases()),
            'start_date'        => now()->addDays(rand(2, 15)),
            'budget_amount'     => $this->faker->numberBetween(10000, 999999999),
            'actual_cost'       => $this->faker->numberBetween(10000, 999999999),
            'requires_approval' => $this->faker->boolean(),
            'approved_status'   => $this->faker->randomElement(ApprovedStatus::cases()),
            'supervisor_id'     => User::inRandomOrder()->value('id'),
        ];
    }
}
