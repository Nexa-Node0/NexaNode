<?php
namespace App\Filament\Resources\Projects\Widgets;

use App\Enums\ProjectStatus;
use App\Models\Project;
use Filament\Widgets\ChartWidget;

class StatusDoughnutWidget extends ChartWidget
{
    protected ?string $heading = 'Project Status Distribution';

    protected function getData(): array
    {
        $status = Project::all()
            ->groupBy('status')
            ->map(fn($items) => $items->count());

        $colors = $status->keys()->map(function (string $statusValue) {
            // Safely try to get enum color, fallback to gray
            $enum          = ProjectStatus::tryFrom($statusValue);
            $filamentColor = $enum?->color() ?? 'gray';

            return $this->resolveColor($filamentColor);
        })->toArray();

        return [
            'datasets' => [
                [
                    'label'           => 'Project Stats',
                    'data'            => $status->values()->toArray(),
                    'backgroundColor' => $colors,
                ],
            ],
            'labels'   => $status->keys()->toArray(),
        ];
    }

    protected function resolveColor(string $filamentColor): string
    {
        return match ($filamentColor) {
            'success'   => '#22c55e',
            'info'      => '#3b82f6',
            'warning'   => '#f59e0b',
            'danger'    => '#ef4444',
            'gray'      => '#6b7280',
            'secondary' => '#a855f7',
            default     => '#6b7280',
        };
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
