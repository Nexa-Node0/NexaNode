<?php
namespace App\Filament\Resources\Location\Addresses\Tables;

use App\Models\Address;
// use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
// use Filament\Notifications\Notification;
// use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AddressesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('employee.avatar')
                    ->label('Display')
                    ->disk('public')
                    ->circular()
                    ->imageHeight(60)
                    ->url(fn($record) => route(
                        'filament.admin.resources.employees.view',
                        ['record' => $record->employee?->id]
                    )),

                TextColumn::make('employee.fullname')
                    ->label('Full Name')
                    ->numeric()
                    ->sortable()
                    ->url(fn($record) => route(
                        'filament.admin.resources.employees.view',
                        ['record' => $record->employee?->id]
                    )),

                // TextColumn::make('country.name')
                //     ->numeric()
                //     ->sortable(),

                // TextColumn::make('state.name')
                //     ->numeric()
                //     ->sortable(),
                // TextColumn::make('city.name')
                //     ->numeric()
                //     ->sortable(),

                TextColumn::make('line1')
                    ->searchable(),

                TextColumn::make('line2')
                    ->searchable(),

                TextColumn::make('address')
                    ->label('Address')
                    ->getStateUsing(function (Address $record) {
                        $city      = $record->city?->name ?? '';
                        $stateName = $record->state?->name ?? '';
                        $country   = $record->country?->name ?? '';

                        return implode(', ', array_filter([$city, $stateName, $country]));
                    }),

                TextColumn::make('postal_code')
                    ->searchable(),

                // IconColumn::make('is_default')
                //     ->boolean()
                //     ->action(function (Address $record) {
                //         if ($record->is_default) {
                //             Notification::make()
                //                 ->title('This address is already active')
                //                 ->danger()
                //                 ->send();

                //             return;
                //         }

                //         $record->update(['is_default' => true]);

                //         Notification::make()
                //             ->title('The address has been set to default')
                //             ->success()
                //             ->send();
                //     }),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                // Action::make('Set Default')
                //     ->requiresConfirmation()
                //     ->action(function (Address $record) {
                //         $record->update(['is_default' => true]);

                //         Notification::make()
                //             ->title('This Address has been set to default')
                //             ->success()
                //             ->send();
                //     })
                //     ->visible(fn(Address $record) => !$record->is_default),
                EditAction::make(),

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
