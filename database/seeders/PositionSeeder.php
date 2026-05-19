<?php

namespace Database\Seeders;

use App\Models\Position;
use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = Department::factory(10)->create();

        $departments->each(function ($department) {
            Position::factory()->count(3)->create([
                'department_id' => $department->id
            ]);
        });
    }
}
