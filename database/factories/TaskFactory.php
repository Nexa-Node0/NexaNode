<?php
namespace Database\Factories;

use App\Enums\Priority;
use App\Enums\ProjectStatus;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'title'       => $this->faker->sentence(rand(1, 3)),
            'description' => $this->faker->sentence(rand(10,30)),
            'due_date'    => now()->addDays(rand(1,15)),
            'assigned_to' => User::inRandomOrder()->value('id'),
            'project_id'  => Project::inRandomOrder()->value('id'),
            'status'      => $this->faker->randomElement(ProjectStatus::cases()),
            'priority'    => $this->faker->randomElement(Priority::cases()),
        ];
    }
}
