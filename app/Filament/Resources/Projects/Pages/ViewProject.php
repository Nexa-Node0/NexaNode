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
            Action::make('manageSummary')
                ->label('Summary')
                ->color(fn($record) => $record->summary ? 'info' : 'danger')
                ->url(fn($record) => ProjectResource::getUrl('summary', ['record' => $record]))
                ->icon(fn($record) => $record->summary ? 'heroicon-o-document-magnifying-glass' : 'heroicon-o-exclamation-circle')
                ->visible(fn($record) => auth()->user()->can('update', $record)),
            Action::make('manageDetails')
                ->label('Details')
                ->color(fn($record) => $record->details ? 'info' : 'danger')
                ->url(fn($record) => ProjectResource::getUrl('details', ['record' => $record]))
                ->icon(fn($record) => $record->details ? 'heroicon-o-document-text' : 'heroicon-o-exclamation-circle')
                ->visible(fn($record) => auth()->user()->can('update', $record)),
        ];
    }

}
