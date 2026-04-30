<?php
namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewProject extends ViewRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            Action::make('manageDetails')
                ->label('Details')
                ->url(fn($record) => ProjectResource::getUrl('details', ['record' => $record]))
                ->icon('heroicon-o-document-text'),
        ];
    }

}
