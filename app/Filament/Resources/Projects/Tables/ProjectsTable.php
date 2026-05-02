<?php
namespace App\Filament\Resources\Projects\Tables;

use App\Enums\ApprovedStatus;
use App\Enums\Priority;
use App\Enums\ProjectStatus;
use App\Models\User;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectsTable
{

    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query): Builder {
                $user = auth()->user();
                if (! $user?->hasRole('super_admin')) {
                    $query->where(function ($q) use ($user) {
                        $q->where('supervisor_id', $user->id)
                            ->orWhereHas('users', function ($q) use ($user) {
                                $q->where('users.id', $user->id);
                            });
                    });
                } else {
                    $query->withoutGlobalScopes([
                        SoftDeletingScope::class,
                    ]);
                }
                return $query->orderByDesc('id');
            })
            ->columns([
                //
                TextColumn::make('supervisor.name')
                    ->label('Supervisor')
                    ->searchable()
                    ->sortable()
                    ->color(fn($state) => $state == auth()->user()->name ? 'success' : 'info')
                    ->formatStateUsing(fn($state) => $state == auth()->user()->name ? 'You: ' . $state : $state)
                    ->toggleable(),

                TextColumn::make('users_count')
                    ->label('Number of Users')
                    ->getStateUsing(fn($record) => $record->usersCount())
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(true),

                ImageColumn::make('table_display')
                    ->disk('public'),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('client.name')
                    ->placeholder('No Client Specified'),

                TextColumn::make('slug')
                    ->badge()
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault(true),

                TextColumn::make('status')
                    ->icon(fn($state) => $state->icon())
                    ->badge()
                    ->formatStateUsing(fn($state) => $state->label()) //fixed to get the label
                    ->color(fn($state) => $state->color())
                    ->tooltip(fn($state, $record) => $state == ProjectStatus::Completed ? $record->completed_at->format('D - M d, Y') : 'Project ' . $state->label()),

                TextColumn::make('priority')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state->label()) //fixed to get the label
                    ->color(fn($state) => $state->color()),

                TextColumn::make('start_date')
                    ->date('M d,Y')
                    ->sortable(),

                TextColumn::make('budget_amount')
                    ->label('Budget')
                    ->money('PHP')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('actual_cost')
                    ->label('Actual Cost')
                    ->money('PHP')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('approved_status')
                    ->badge()
                    ->tooltip(function ($state, $record) {
                        if ($state == ApprovedStatus::Approved) {
                            return 'Approved at: ' . Carbon::parse($record->approved_at)->format('D, M d Y - h:i A');
                        } elseif ($state == ApprovedStatus::Rejected) {
                            return 'Project Rejected';
                        } else {
                            return 'Waiting to be Approved';
                        }
                    })
                    ->formatStateUsing(fn($state) => $state->label()) //fixed to get the label
                    ->color(fn($state) => $state->color())
                    ->icon(fn($state) => $state->icon()),
            ])
            ->filters([
                //filter for trash
                TrashedFilter::make()
                    ->visible(function (): bool {
                        $user = auth()->user();

                        return $user->can('ForceDelete:Project') || $user->can('Restore:Project');
                    }),

                //filter for statuses
                SelectFilter::make('status')
                    ->multiple()
                    ->options(ProjectStatus::options()),
                SelectFilter::make('approved_status')
                    ->multiple()
                    ->options(ApprovedStatus::options()),
                SelectFilter::make('priority')
                    ->multiple()
                    ->options(Priority::options()),

                Filter::make('budget_amount')
                    ->form([
                        TextInput::make('min_budget')
                            ->label('Minimum Budget')
                            ->numeric()
                            ->prefix('₱')
                            ->placeholder('10000')
                            ->minValue(10000)
                            ->maxValue(999999999999.99),

                        TextInput::make('max_budget')
                            ->label('Maximum Budget')
                            ->numeric()
                            ->prefix('₱')
                            ->placeholder('999999999999.99')
                            ->minValue(10000)
                            ->maxValue(999999999999.99),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['min_budget'], fn(Builder $query, $amount): Builder => $query->where('budget_amount', '>=', $amount)
                            )
                            ->when(
                                $data['max_budget'], fn(Builder $query, $amount): Builder => $query->where('budget_amount', '<=', $amount)
                            );
                    }),

                Filter::make('started_at')
                    ->form([
                        DatePicker::make('min_date')
                            ->label('Date Onwards'),

                        DatePicker::make('max_date')
                            ->label('Date Before'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['min_date'], fn(Builder $query, $min_date): Builder => $query->where('start_date', '>=', $min_date))
                            ->when($data['max_date'], fn(Builder $query, $max_date): Builder => $query->where('start_date', '<=', $max_date));
                    }),

                Filter::make('Supervisors')
                    ->form([
                        Select::make('supervisors')
                            ->multiple()
                            ->options(function () {
                                return User::query()->whereHas('project')->pluck('name', 'id');
                            }),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['supervisors'],
                            fn(Builder $query, $supervisors): Builder => $query->whereIn('supervisor_id', $supervisors)
                        );
                    })
                    ->visible(fn(): bool => auth()->user()->hasRole('super_admin')),

            ])
            ->groups([
                Group::make('status')
                    ->getTitleFromRecordUsing(fn($record) => $record->status->name),
                Group::make('priority')
                    ->getTitleFromRecordUsing(fn($record) => $record->priority->name),
                Group::make('approved_status')
                    ->label('Approval Status')
                    ->getTitleFromRecordUsing(fn($record) => $record->approved_status->name),
                Group::make('supervisor')
                    ->label('Supervisor')
                    ->getTitleFromRecordUsing(fn($record) => $record->supervisor->name),
            ])
            ->recordActions([

                ForceDeleteAction::make()
                    ->requiresConfirmation(),
                RestoreAction::make()
                    ->requiresConfirmation(),

                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make()
                        ->requiresConfirmation(),
                    Action::make('approve_status')
                        ->label('Approve Project')
                        ->action(function ($record) {
                            $notif  = Notification::make();
                            $status = $record->approved_status;
                            if ($status == ApprovedStatus::Approved) {
                                $notif->warning()
                                    ->title('This Project is already approved')
                                    ->send();

                                return;
                            }

                            $record->approved_status = ApprovedStatus::Approved;
                            $record->save();

                            $notif->success()
                                ->title('Project has been approved!!')
                                ->send();
                        })
                        ->color(fn($record) => $record->approved_status == ApprovedStatus::Approved ? 'danger' : 'info'),
                    // ->hidden(fn($record): bool => $record->approved_status !== ApprovedStatus::Approved),
                    Action::make('change_status')
                        ->label('Change Status')
                        ->requiresConfirmation()
                        ->form([
                            Select::make('status')
                                ->options(ProjectStatus::options())
                                ->default(fn($record) => $record->status)
                                ->selectablePlaceholder(false),
                        ])
                        ->action(function ($record, array $data) {
                            $old = $record->status;
                            $new = $data['status'];

                            $notif = Notification::make();

                            if ($old->value == $new) {
                                $notif->warning()
                                    ->title('Unchanged')
                                    ->body('Please pick a different status from before')
                                    ->send();
                                return;
                            }

                            $record->status = $new;
                            $record->save();

                            $notif->success()
                                ->title('Status Updated')
                                ->body('Staus changed from ' . $old->value . ' to ' . $new)
                                ->send();
                        }),

                    Action::make('change_priority')
                        ->label('Change Priority')
                        ->requiresConfirmation()
                        ->form([
                            Select::make('priority')
                                ->options(Priority::options())
                                ->default(fn($record) => $record->priority)
                                ->selectablePlaceholder(false),
                        ])
                        ->action(function ($record, array $data) {
                            $old = $record->priority;
                            $new = $data['priority'];

                            $notif = Notification::make();
                            if ($old->value == $new) {
                                $notif->warning()
                                    ->title('Please select another priority')
                                    ->send();

                                return;
                            }

                            $record->priority = $new;
                            $record->save();

                            $notif->success()
                                ->title('Priority successfully changed')
                                ->body('Priority changed from ' . $old->value . ' to ' . $new)
                                ->send();
                        }),

                    Action::make('change_approved_status')
                        ->label('Change Approved Status')
                        ->requiresConfirmation()
                        ->form([
                            Select::make('approved_status')
                                ->options(ApprovedStatus::options())
                                ->default(fn($record) => $record->approved_status)
                                ->selectablePlaceholder(false),
                        ])
                        ->action(function ($record, array $data) {
                            $old = $record->approved_status;
                            $new = $data['approved_status'];

                            $notif = Notification::make();
                            if ($old->value == $new) {
                                $notif->warning()
                                    ->title('Please select another status')
                                    ->send();

                                return;
                            }

                            $record->approved_status = $new;
                            $record->save();

                            $notif->success()
                                ->title('Approved status successfully changed')
                                ->body('Approved status changed from ' . $old->value . ' to ' . $new)
                                ->send();
                        }),
                ])
                    ->icon('heroicon-m-cog')
                    ->visible(fn($record): bool => $record->deleted_at == null)
                    ->tooltip('Additional Actions'),

                ViewAction::make()
                    ->color('info'),
            ], position: RecordActionsPosition::BeforeColumns)
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make()
                        ->requiresConfirmation(),
                    RestoreBulkAction::make()
                        ->requiresConfirmation(),
                ]),
            ]);
    }
}
