<?php
namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        //initialize super admin user
        $user = User::whereName('super_admin')->first();

        //get the first user if null
        if ($user == null) {
            $user = User::first();
        }

        //Creating Project
        $project = Project::create([
            'title' => 'Seeded Project',
            'code' => Str::random(10),
            'slug' => 'seeded-project',
            'description' => 'Project Description',
            'status' => 'draft',
            'priority' => 'medium',
            'start_date' => now()->addWeek(),
            'budget_amount' => 10000,
            'actual_cost' => 10000,
            'requires_approval' => false,
            'approved_status' => 'pending',
            'supervisor_id' => $user->id,
        ]);

        //attach user to the project
        $user->projects()->attach($project->id);
    }
}
