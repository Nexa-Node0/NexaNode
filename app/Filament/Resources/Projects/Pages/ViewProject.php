<?php
namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use App\Filament\Resources\Projects\Widgets\ProjectPrioritiesDoughnutWidget;
use App\Filament\Resources\Projects\Widgets\ProjectStatWidget;
use App\Filament\Resources\Projects\Widgets\StatusDoughnutWidget;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewProject extends ViewRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ProjectStatWidget::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            StatusDoughnutWidget::class,
            ProjectPrioritiesDoughnutWidget::class,
        ];
    }

}
