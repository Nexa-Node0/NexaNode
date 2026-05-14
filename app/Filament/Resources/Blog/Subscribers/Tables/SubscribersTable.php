<?php

namespace App\Filament\Resources\Blog\Subscribers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Table;
use Filament\Tables;

class SubscribersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),

                Tables\Columns\ToggleColumn::make('can_receive_updates')
                    ->label('Received Updates')
                    ->afterStateUpdated(function (){
                        Notification::make()
                            ->title('Status Updated!')
                            ->success()
                            ->send();
                    })
                    
             ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
