<?php

namespace App\Filament\Resources\HR\Users\Tables;

use App\Models\Position;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Spatie\Permission\Models\Role;
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

                SelectColumn::make('position.name')
                    ->label('Position')
                    ->selectablePlaceholder(false)
                    ->options(fn() => Position::query()->pluck('name', 'id')->toArray())
                    ->searchable()
                    ->searchableOptions()
                    ->getStateUsing(fn($record) => $record->position?->id)
                    ->updateStateUsing(function ($record, $state) {
                        if (!$state) return;

                        // ✅ Always work with a fresh record to avoid stale cache issues
                        $freshRecord = \App\Models\User::find($record->id);

                        if (!$freshRecord) return;

                        $newPosition = Position::find($state);

                        if (!$newPosition) return;

                        // ✅ Remove ALL current roles before assigning the new one
                        $freshRecord->syncRoles([]);

                        // ✅ Delete old UserPosition and create new one
                        \App\Models\UserPosition::where('user_id', $freshRecord->id)->delete();
                        \App\Models\UserPosition::create([
                            'user_id'     => $freshRecord->id,
                            'position_id' => $state,
                        ]);

                        // ✅ Find or create the role matching the new position's slug
                        $role = Role::firstOrCreate(
                            ['name' => $newPosition->slug],
                            ['guard_name' => 'web']
                        );

                        $freshRecord->assignRole($role);

                        // ✅ Refresh the original $record so Filament re-renders correctly
                        $record->refresh();

                        Notification::make()
                            ->title('Position has been updated')
                            ->body("{$newPosition->name} has been assigned to {$freshRecord->name}")
                            ->success()
                            ->sendToDatabase(User::find($freshRecord->id))
                            ->icon(Heroicon::CheckBadge)
                            ->send();
                    }),

                SelectColumn::make('role')
                    ->label('Role')
                    ->selectablePlaceholder(false)
                    ->options(fn() => Role::query()->pluck('name', 'id')->toArray())
                    ->searchable()
                    ->getStateUsing(fn($record) => $record->roles->first()?->id)
                    ->updateStateUsing(function ($record, $state) {
                        $role = Role::find($state);
                        if ($role) {
                            $record->syncRoles([$role]);
                            Notification::make()
                                ->title('Role has been updated')
                                ->body('User role has been updated successfully')
                                ->success()
                                ->send();
                        }
                    }),

                ToggleColumn::make('is_active')
                    ->afterStateUpdated(function ($record, $state) {
                        $newState = $state ? 'activated' : 'deactivated';
                        Notification::make('account_active_status')
                            ->title('Account Status')
                            ->body("{$record->name} account is now $newState")
                            ->iconColor($state ? 'success' : 'warning')
                            ->icon($state ? Heroicon::CheckCircle : Heroicon::ExclamationTriangle)
                            ->sendToDatabase($record)
                            ->send();
                    }),
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
