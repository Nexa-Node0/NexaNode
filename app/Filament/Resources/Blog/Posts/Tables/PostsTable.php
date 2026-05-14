<?php

namespace App\Filament\Resources\Blog\Posts\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\Action;
use App\Models\Post;
use App\Jobs\SendPostJob;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Filters\SelectFilter;
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
                    DeleteAction::make(),
                    Action::make('send')
                        ->label('Send To All Subscribers')
                        ->icon('heroicon-o-paper-airplane')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Send Post')
                        ->modalDescription('This will send the post to all subscribers')
                        ->modalSubmitActionLabel('Yes, Send Now')
                        ->action(function (Post $post){
                            SendPostJob::dispatch($post);
                            Notification::make()
                                ->title('Post queued!')
                                ->body('It will be sent to all users shortly')
                                ->success()
                                ->send();
                    })
                ]),
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
