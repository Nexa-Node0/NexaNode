<?php
namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

// use NunoMaduro\Collision\Adapters\Phpunit\State;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('Unverified')
                    ->color('success'),
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
                Action::make('verify')
                    ->label(fn(User $user) => $user->email_verified_at === null ? 'Verify' : 'Unverify')
                    ->requiresConfirmation()
                    ->action(function (User $record) {

                        $Notification = Notification::make()
                            ->success();

                        if ($record->email_verified_at === null) {
                            $record->markEmailAsVerified();

                            $Notification->title('User verified successfully')
                                ->send();
                        } else {
                            $record->email_verified_at = null;
                            $record->save();

                            $Notification->title('User unverified successfully')
                                ->send();
                        }
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
