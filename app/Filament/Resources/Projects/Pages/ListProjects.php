<?php
namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use App\Filament\Resources\Projects\Widgets\ProjectCreationBarWidget;
use App\Filament\Resources\Projects\Widgets\ProjectPrioritiesDoughnutWidget;
use App\Filament\Resources\Projects\Widgets\ProjectStatWidget;
use App\Filament\Resources\Projects\Widgets\StatusDonutWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProjects extends ListRecords
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
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
            StatusDonutWidget::class,
            ProjectPrioritiesDoughnutWidget::class,
            ProjectCreationBarWidget::class,
        ];
    }
}
