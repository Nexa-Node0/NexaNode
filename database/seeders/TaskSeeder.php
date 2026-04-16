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
        if (Project::count() <= 0) {

            $resp = $this->command->ask(
                'No Projects detected, skip creating tasks? [y,n]',
                'y'
            );

            while (! in_array($resp, ['y', 'n'])) {
                $resp = $this->command->ask('Please type y or n', 'y');
            }

            if ($resp === 'y') {
                $this->command->info('-SKIPPED- No tasks created');
                return;
            }

            Project::factory(5)->create();

            $projects = Project::all();

            foreach ($projects as $project) {
                $users = User::inRandomOrder()
                    ->limit(rand(1, 10))
                    ->pluck('id');

                if ($users->isNotEmpty()) {
                    $project->users()->sync($users);
                }
            }

            $this->command->line('5 Projects created');
        }

        $taskCount = (int) $this->command->ask('How many tasks you want to make', 5);

        if ($taskCount <= 0) {
            $this->command->info('-SKIPPED- No tasks created');
            return;
        }

        $tasks = Task::factory($taskCount)->create();

        foreach ($tasks as $task) {

            $this->command->line(
                'Created | ' . $task->title .
                ' | Project: ' . $task->project->title.
                ' | Assigned to: ' . $task->user->name
            );
        }
    }
}
