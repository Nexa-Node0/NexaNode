<?php

namespace App\Filament\Resources\PostCategories\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Filters\TernaryFilter;

class PostCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->weight(FontWeight::Bold)
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->color('gray')
                    ->copyable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('posts_count')
                    ->label('Post Count')
                    ->badge()
                    ->sortable()
                    ->alignCenter()
                    ->tooltip('Total number of posts in this category')
                    ->color(fn($state) => match(true){
                        $state === 0 => 'gray',
                        $state <=  5 => 'warning',
                        default      => 'success'
                    }),

                Tables\Columns\ToggleColumn::make('is_visible')
                    ->label('Active')
                    ->onColor('success')
                    ->offColor('danger')
                    ->afterStateUpdated(function($record, $state){
                        $record->is_visible = $state;
                        Notification::make()
                            ->title('Status updated!')
                            ->success()
                            ->send();
                    }),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->date('M d, Y')
                    ->sortable()
                    ->toggleable(true),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->date('M d, Y')
                    ->sortable()
                    ->toggleable(true)
            ])
            
            ->defaultSort('created_at', 'desc')
            ->emptyStateIcon(Heroicon::Tag)
            ->emptyStateHeading('No categories yet')
            ->filters([
                TernaryFilter::make('is_visible')->label('Active Status'),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make()
                ])
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),

                    BulkAction::make('Visible selected')
                        ->action(fn($records) => $records->each->update(['is_visible' => true]))
                        ->color('success')
                        ->requiresConfirmation()
                        ->icon(Heroicon::RocketLaunch),

                    BulkAction::make('Hide selected')
                        ->action(fn($records) => $records->each->update(['is_visible' => false]))
                        ->color('warning')
                        ->requiresConfirmation()
                        ->icon(Heroicon::ExclamationTriangle)
                ]),
            ]);
    }
}
