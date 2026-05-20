<?php

namespace App\Filament\Resources\HR\Positions\Tables;

use App\Models\Department;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use App\Models\Position;
use Filament\Actions\ActionGroup;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;

class PositionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('code')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type')
                    ->searchable()
                    ->sortable(),

                SelectColumn::make('department_id')
                    ->label('Department')
                    ->selectablePlaceholder(false)
                    ->searchableOptions()
                    ->searchable()
                    ->sortable()
                    ->options(fn() =>  Department::pluck('name', 'id')->toArray()),

                SelectColumn::make('reports_to')
                    ->label('Reports to')
                    ->selectablePlaceholder(false)
                    ->searchableOptions()
                    ->searchable()
                    ->options(
                        fn() => Position::where('is_active', true)
                            ->pluck('name', 'id')
                            ->toArray()
                    )
                    ->afterStateUpdated(function ($record, $state) {
                        Notification::make('reports_to_updated')
                            ->icon(Heroicon::CheckCircle)
                            ->iconColor('success')
                            ->title("{$record->name} will now reports to {$record->supervisor->name}")
                            ->body('Position has been updated')
                            ->send();
                    }),

                ToggleColumn::make('is_active')
                    ->afterStateUpdated(function ($record, $state) {
                        $newStatus = $state ? 'Activated' : 'Disabled';
                        Notification::make('position_status')
                            ->iconColor($state ? 'success' : 'warning')
                            ->icon($state ? Heroicon::CheckCircle : Heroicon::ExclamationTriangle)
                            ->title("{$record->name} is now $newStatus")
                            ->body('Position has been updated')
                            ->send();
                    }),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->multiple()
                    ->options(\App\Enums\PositionEnum::options())
                    ->searchable()
                    ->preload(),

                SelectFilter::make('department')
                    ->relationship('department', 'name')
                    ->searchable()
                    ->preload(),

                TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->default(true)

            ])
            ->recordActions([
                // 
                ActionGroup::make([
                    EditAction::make(),
                ])
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
