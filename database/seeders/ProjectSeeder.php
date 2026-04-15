<?php
namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Making random Projects');

        $count = $this->command->ask('How many projects do you want to make?');

        if ($count > 0) {

            Project::factory($count)->create();

            $this->command->info("{$count} projects created");

            // Get supervisors
            $supervisors = \App\Models\User::whereIn(
                'id',
                Project::pluck('supervisor_id')->unique()
            )->get();

            $this->command->info('List of Supervisors:');

            foreach ($supervisors as $user) {
                $this->command->line("- {$user->id} | {$user->name}");
            }

            //attach users to the projects
            $this->command->info('Attaching users to the projects');

            $projects = Project::all();

            foreach ($projects as $project) {

                $users = User::inRandomOrder()
                    ->limit(rand(1, 10))
                    ->pluck('id')
                    ->toArray();

                $project->users()->sync($users);

                $this->command->line(count($users) . " users attached to {$project->title}");
            }

        } else {
            $this->command->warn("-SKIPPED- No projects created");
        }
    }
}
