<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
<<<<<<< HEAD
=======
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Support\Enums\FontWeight;
>>>>>>> 310109f0ebe242ce81c079cee55f9e3bf858c50b
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Storage;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
<<<<<<< HEAD
                //
=======
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->disk('public')
                    ->imageSize(50),

                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold),
                
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Author')
                    ->searchable()
                    ->sortable()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('published_date')
                    ->label('Publishing date')
                    ->sortable()
                    ->date('M d, Y')
                    ->color('gray'),

                Tables\Columns\SelectColumn::make('status')
                    ->options(\App\Enums\PostStatus::options())
                    ->selectablePlaceholder(false)
                    ->afterStateUpdated(function ($record, $state) {
                        $record->save();

                        Notification::make()
                            ->success()
                            ->body('Record updated successfully to ' . $state)
                            ->send();
                    }),
>>>>>>> 310109f0ebe242ce81c079cee55f9e3bf858c50b
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'Draft'     => 'Draft',
                        'Published' => 'Published',
                        'Archived'  => 'Archived'
                    ])
                    ->default('Published')
                    ->multiple(),

                SelectFilter::make('user_id')
                    ->label('Author')
                    ->relationship('user', 'name')
                    ->preload()

            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make()
                ])
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateIcon(Heroicon::Bookmark)
            ->emptyStateHeading('No posts yet')
            ->emptyStateDescription('Once you write your first post, It will appear here.')
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
