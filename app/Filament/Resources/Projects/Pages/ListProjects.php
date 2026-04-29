<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Projects\Widgets\ProjectCreationBarWidget;
use App\Filament\Resources\Projects\Widgets\ProjectPrioritiesDoughnutWidget;
use App\Filament\Resources\Projects\Widgets\ProjectStatWidget;
use App\Filament\Resources\Projects\Widgets\StatusDoughnutWidget;

class ListProjects extends ListRecords
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
     /* ||Kindly add this section to the EditProject.php if you want it to render also there
 */
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
            ProjectCreationBarWidget::class,
            ProjectPrioritiesDoughnutWidget::class,
        ];
    }
}
