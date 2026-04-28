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
        $count = (int) $this->command->ask(
            'How many Projects do you want to create?',
            5
        );

        if ($count <= 0) {
            $this->command->info('Process Skipped: No Project Created');
            return;
        }

        $useSuperAdmin = false;
        $user          = null;

        if (User::exists()) {
            $useSuperAdmin = $this->command->confirm(
                'Assign Super Admin (or first user) as supervisor?',
                true
            );

            if ($useSuperAdmin) {
                $user = User::where('name', 'super_admin')->first() ?? User::first();

                $this->command->info(
                    "Selected user: {$user->name} - {$user->email}"
                );
            }
        }

        // CREATE PROJECTS (single source of truth)
        $projects = Project::factory($count)
            ->when($useSuperAdmin && $user, function ($factory) use ($user) {
                return $factory->state([
                    'supervisor_id' => $user->id,
                ]);
            })
            ->create();

        foreach ($projects as $project) {

            $users = User::take(5)->pluck('id')->toArray();

            $project->users()->attach($users);

            $this->command->line(
                "Project created: {$project->title} (supervisor: {$project->supervisor?->name})"
            );
        }

        $this->command->newLine();
    }
}
