<?php
namespace App\Filament\Resources\ProductPossessions\Tables;

use App\Enums\ProductStatusEnum;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;

class ProductPossessionsTable
{
    public static function configure(Table $table): Table
    {
        return static::getTableContents($table, true);
    }

    public static function getTableContents(Table $table, $full = false)
    {
        return self::getExpandedTable($table, $full);
    }

    private static function formulateTableColumns()
    {
        return [
            TextColumn::make('originalOwner.name')
                ->searchable(),
            SelectColumn::make('current_owner')
                ->options(User::query()->pluck('name', 'id')->toArray()),
            SelectColumn::make('status')
                ->options(ProductStatusEnum::options())
                ->selectablePlaceholder(false)
                ->getStateUsing(fn($record) => $record->status->value),
            TextColumn::make('release_date')
                ->date('M d, Y - D')
                ->sortable(),
            TextColumn::make('transferred_date')
                ->date('M d, Y - D')
                ->placeholder('Not Set')
                ->sortable()
                ->toggleable()
                ->toggledHiddenByDefault(),
            TextColumn::make('returned_date')
                ->date('M d, Y - D')
                ->placeholder('Not Set')
                ->sortable()
                ->toggleable()
                ->toggledHiddenByDefault(),
        ];
    }

    private static function formulateFilters(): array
    {
        return [
            TrashedFilter::make(),
        ];
    }

    private static function formulateActions(): array
    {
        return [
            Action::make('return')
                ->action(function ($record) {
                    $record->update(['status' => ProductStatusEnum::Returned]);
                    Notification::make()
                        ->title('Product Returned')
                        ->body($record->product?->name . ' has been retuned')
                        ->color('warning')
                        ->sendToDatabase($record->currentOwner);
                })
                ->color('danger')
                ->visible(fn($record) => $record->status !== ProductStatusEnum::Returned),
            // EditAction::make(),
            DeleteAction::make(),
        ];
    }

    private static function formulateGroups(): array
    {
        return [
            Group::make('originalOwner.name')
                ->label('Original Owner'),
            Group::make('currentOwner.name')
                ->label('Current Owner'),
            Group::make('status')
                ->label('Status')
                ->getTitleFromRecordUsing(fn($record) => $record->status->label()),
        ];
    }

    private static function registerAdditionalColumns(array $columns)
    {
        array_splice($columns, 2, 0, [
            TextColumn::make('product.name'),
            TextColumn::make('product.category.name'),
        ]);

        return $columns;
    }

    private static function registerAdditionalFilters(array $filters)
    {
        array_splice($filters, 0, 0, [
            // RestoreAction::make(),
            // ForceDeleteAction::make(),
        ]);
        return $filters;
    }

    private static function registerAdditionalActions(array $actions)
    {
        array_splice($actions, 0, 0, [
            RestoreAction::make(),
            ForceDeleteAction::make(),
        ]);
        return $actions;
    }

    private static function registerAdditionalgGroups(array $groups)
    {
        array_splice($groups, 0, 0, [
            Group::make('product.category.name')
                ->label('Category'),
        ]);
        return $groups;
    }

    private static function getExpandedTable(Table $table, bool $choice = true)
    {
        //original columns
        $columns = self::formulateTableColumns();
        $filters = self::formulateFilters();
        $actions = self::formulateActions();
        $groups  = self::formulateGroups();
        if ($choice) {
            $columns = self::registerAdditionalColumns($columns);
            $filters = self::registerAdditionalFilters($filters);
            $actions = self::registerAdditionalActions($actions);
            $groups  = self::registerAdditionalgGroups($groups);
        }

        return $table
            ->groups($groups)
            ->columns($columns)
            ->filters($filters)
            ->actions($actions);

    }

}
