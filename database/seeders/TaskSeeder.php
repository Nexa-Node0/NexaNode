<?php
namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hasProjects = Project::exists();

        if (! $hasProjects) {
            $this->command->warn('Process Skipped: No Projects available');
            return;
        }

        $count = (int) $this->command->ask('How many Tasks do you want to create?', 5);

        if ($count < 1) {
            $this->command->warn('Process Skipped: No Task Created');
            return;
        }

        // =========================
        // PROJECT SELECTION MODE
        // =========================
        $randomProject = $this->command->confirm(
            'Randomize project selection? (otherwise pick from 5 sample projects)',
            true
        );

        if ($randomProject) {
            $project = Project::inRandomOrder()->first();
        } else {
            $projects = Project::inRandomOrder()->limit(5)->get();

            $this->command->info('Choose a project:');

            foreach ($projects as $index => $p) {
                $this->command->line("[$index] {$p->title}");
            }

            $selectedIndex = (int) $this->command->ask('Enter index (0-4)', 0);

            $project = $projects[$selectedIndex] ?? $projects->first();
        }

        // =========================
        // USER / SUPERVISOR MODE
        // =========================
        $assignUser = $this->command->confirm(
            'Assign Supervisor / First User?',
            true
        );

        $user = null;

        if ($assignUser) {
            $user = User::where('name', 'super_admin')->first() ?? User::first();
        }

        // =========================
        // CREATE TASKS
        // =========================
        $tasks = Task::factory($count)
            ->for($project)
            ->when($user, function ($factory) use ($user) {
                return $factory->state([
                    'assigned_to' => $user->id,
                ]);
            })
            ->create();

        // =========================
        // OUTPUT
        // =========================
        foreach ($tasks as $task) {
            $this->command->line(
                "Task created: {$task->title}" .
                " | Project: {$project->title}" .
                ($user ? " | Assigned: {$user->name}" : "")
            );
        }

        $this->command->newLine();
    }
}
