<?php
namespace App\Filament\Resources\Clients\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ReplicateAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ClientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('contact_number')
                    ->icon('heroicon-m-phone')
                    ->badge(),
                TextColumn::make('address'),
            ])
            ->filters([
                //
                TrashedFilter::make()
                    ->visible(fn() =>
                        auth()->user()?->can('ForceDelete:Client') ||
                        auth()->user()?->can('Restore:Client')
                    ),
            ])
            ->recordActions([
                ViewAction::make()
                    ->visible(fn($record) => $record->deleted_at == null),
                ActionGroup::make([
                    EditAction::make()
                        ->visible(fn($record) => $record->deleted_at == null),
                    ReplicateAction::make()
                        ->requiresConfirmation(),
                    DeleteAction::make()
                        ->requiresConfirmation(),
                    RestoreAction::make()
                        ->requiresConfirmation(),
                    ForceDeleteAction::make()
                        ->requiresConfirmation(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->requiresConfirmation(),
                    RestoreBulkAction::make()
                        ->requiresConfirmation(),
                ]),
            ]);
    }
}
