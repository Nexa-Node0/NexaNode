<?php
namespace App\Filament\Project\Resources\Projects\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('code')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('priority')
                    ->searchable(),
                TextColumn::make('start_date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('budget_amount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('actual_cost')
                    ->money()
                    ->sortable(),
                IconColumn::make('requires_approval')
                    ->boolean(),
                TextColumn::make('approved_status')
                    ->searchable(),
                TextColumn::make('approved_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('supervisor_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                ViewAction::make(),

                ActionGroup::make([
                    EditAction::make(),
                    Action::make('join')
                        ->label(fn($record) => $record->users()->whereKey(auth()->id())->exists() ? 'Leave' : 'Join')
                        ->color(fn($record) => $record->users()->whereKey(auth()->id())->exists() ? 'danger' : 'success')
                        ->action(function($record) {
                            $user = auth()->user();
                            $notif = Notification::make()->success();

                            if ($record->users()->whereKey($user)->exists()) {
                                $record->users()->detach($user);
                                $notif->title('Successfully left the project');
                            } else {
                                $record->users()->attach($user);
                                $notif->title('Successfully joined the project');
                            }

                            $notif->send();
                        }),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
