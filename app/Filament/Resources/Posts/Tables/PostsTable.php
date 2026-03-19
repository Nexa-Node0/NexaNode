<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Support\Icons\Heroicon;

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

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn($state) => 
                        $state == 'Published' 
                            ? 'success' 
                            : ($state == 'Unpublished' ? 'warning' : 'gray')
                    ),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
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
