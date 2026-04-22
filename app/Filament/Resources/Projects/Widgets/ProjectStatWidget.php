<?php
namespace App\Filament\Resources\Projects\Widgets;

use App\Enums\ApprovedStatus;
use App\Enums\ProjectStatus;
use App\Models\Project;
use App\Models\Task;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProjectStatWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {

        $start = now()->startOfYear();
        $end   = now()->endOfYear();

        /*
        |-------------------------------|
        |        Project Widgets        |
        |-------------------------------|
        */

        $numberOfProjects = Project::whereBetween('created_at', [$start, $end])
            ->count();

        $projectProgression = Project::whereBetween('created_at', [$start, $end])
            ->selectRaw("strftime('%m', created_at) as month, COUNT(*) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total')
            ->toArray();

        /*
        |--------------------------------|
        |           Task Widget          |
        |--------------------------------|
        */

        $numberOfTasks = Task::whereBetween('created_at', [$start, $end])
            ->count();

        $taskProgression = Task::whereBetween('created_at', [$start, $end])
            ->selectRaw("strftime('%m', created_at) as month, COUNT(*) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total')
            ->toArray();

        /*
        |--------------------------------|
        |       Completed Projects       |
        |--------------------------------|
        */

        $completedProjectsCount = Project::where(function ($q) use ($end, $start) {
            $q->where('status', ProjectStatus::Completed)
                ->whereBetween('created_at', [$start, $end]);
        })
            ->count();

        /*
        |--------------------------------|
        |        Approved Projects       |
        |--------------------------------|
        */

        $approvedProjects = Project::where(function ($q) use ($end, $start) {
            $q->where('approved_status', ApprovedStatus::Approved)
                ->whereBetween('created_at', [$start, $end]);
        })
            ->count();

        /*
        |--------------------------------|
        |          User's Project        |
        |--------------------------------|
        */

        $userProjects = Project::where(function ($q) use ($end, $start) {
            $q->where('supervisor_id', auth()->user()->id)
                ->whereBetween('created_at', [$start, $end]);
        })
            ->count();

        return [
            Stat::make('Projects', $numberOfProjects)
                ->description('Created Projects as of ' . now()->year)
                ->color('success')
                ->chart($projectProgression),

            Stat::make('Tasks', $numberOfTasks)
                ->description('Created Tasks as of ' . now()->year)
                ->color('info')
                ->chart($taskProgression),

            Stat::make('Completed Projects', $completedProjectsCount)
                ->description('Projects that completed as of' . now()->year),

            Stat::make('Approved Projects', $approvedProjects)
                ->description('Projects that completed as of' . now()->year),

            Stat::make('Your Projects', $userProjects)
                ->description('Projects you handle as of ' . now()->year),
        ];
    }
}
