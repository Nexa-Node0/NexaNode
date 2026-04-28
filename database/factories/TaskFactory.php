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
        $now = now();
        return [
            //
            'title'       => ucwords($this->faker->words(rand(1, 3), true)),
            'description' => $this->faker->paragraph(2, 5),
            'due_date'    => $this->faker->dateTimeBetween(
                $now->copy()->addDay(),
                $now->copy()->addDays(15)
            ),
            'assigned_to' => User::inRandomOrder()->value('id'),
            'project_id'  => Project::inRandomOrder()->value('id'),
            'status'      => $this->faker->randomElement(ProjectStatus::cases()),
            'priority'    => $this->faker->randomElement(Priority::cases()),
        ];
    }

    public function assign(User $user): static
    {
        return $this->state(fn(array $attributes) => [
            'assigned_to' => $user->id,
        ]);
    }

    public function project(Project $project): static
    {
        return $this->state(fn(array $attributes) => [
            'project_id' => $project->id,
        ]);
    }
}
