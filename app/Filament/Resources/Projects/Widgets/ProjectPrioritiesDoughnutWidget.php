<?php
namespace App\Filament\Resources\Projects\Widgets;

use App\Enums\Priority;
use App\Models\Project;
use Filament\Widgets\ChartWidget;

class ProjectPrioritiesDoughnutWidget extends ChartWidget
{
    protected ?string $heading = 'Project Priorities Distribution';

    protected function getData(): array
    {
        $priorities = Project::all()
            ->groupBy('priority')
            ->map(fn($items) => $items->count());

        $colors = $priorities->keys()->map(function (string $priorityValue) {
            $enum          = Priority::tryFrom($priorityValue);
            $filamentColor = $enum?->color() ?? 'gray';

            return $this->resolveColor($filamentColor);
        })->toArray();

        return [
            'datasets' => [
                [
                    'label'           => 'Project Priorities',
                    'data'            => $priorities->values()->toArray(),
                    'backgroundColor' => $colors,
                ],
            ],
            'labels'   => $priorities->keys()->toArray(),
        ];
    }

    protected function resolveColor(string $filamentColor): string
    {
        return match ($filamentColor) {
            'info'    => '#3b82f6',
            'warning' => '#f59e0b',
            'danger'  => '#ef4444',
            'gray'    => '#6b7280',
            default   => '#6b7280',
        };
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
