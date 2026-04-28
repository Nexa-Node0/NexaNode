<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Storage;
use App\Enums\PostStatus;
class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
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
                    ->options(PostStatus::options())
                    ->selectablePlaceholder(false)
                    ->afterStateUpdated(function ($record, $state) {
                        $record->save();

                        Notification::make()
                            ->success()
                            ->body('Record updated successfully to ' . $state)
                            ->send();
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(PostStatus::options())
                    ->default(PostStatus::Published->value)
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
