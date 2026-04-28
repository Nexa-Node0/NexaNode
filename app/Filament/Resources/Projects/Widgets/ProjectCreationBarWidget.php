<?php
namespace App\Filament\Resources\Projects\Widgets;

use App\Models\Project;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProjectCreationBarWidget extends ChartWidget
{
    protected ?string $heading = 'Project Creation (Last 3 Years)';

    protected function getData(): array
    {
        // Fixed 12 month labels
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        // Oldest year = most faded, current year = most vivid
        $years = [
            Carbon::now()->subYears(2)->year, // e.g. 2023 — most faded
            Carbon::now()->subYears(1)->year, // e.g. 2024 — mid opacity
            Carbon::now()->year,              // e.g. 2025 — most vivid
        ];

        $opacities = [0.25, 0.55, 1.0];

        $datasets = [];

        foreach ($years as $i => $year) {
            // for mysql
            // $counts = Project::select(
            //     DB::raw('MONTH(created_at) as month'),
            //     DB::raw('COUNT(*) as total')
            // )
            //     ->whereYear('created_at', $year)
            //     ->groupBy('month')
            //     ->get()
            //     ->keyBy('month'); // keyed by integer month 1–12

            // $data = array_map(
            //     fn($m) => $counts->get($m)?->total ?? 0,
            //     range(1, 12)
            // );

            //for sqlite
            $counts = Project::select(
                DB::raw("CAST(strftime('%m', created_at) AS INTEGER) as month"),
                DB::raw('COUNT(*) as total')
            )
                ->whereRaw("strftime('%Y', created_at) = ?", [(string) $year])
                ->groupBy('month')
                ->get()
                ->keyBy('month'); // keyed by integer month 1–12

            $data = array_map(
                fn($m) => $counts->get($m)?->total ?? 0,
                range(1, 12)
            );

            $opacity    = $opacities[$i];
            $datasets[] = [
                'label'           => (string) $year,
                'data'            => $data,
                'backgroundColor' => "rgba(59, 130, 246, {$opacity})",
                'borderColor' => "rgba(37, 99, 235, {$opacity})",
                'borderWidth'  => 1,
                'borderRadius' => 4,
            ];
        }

        return [
            'datasets' => $datasets,
            'labels'   => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
