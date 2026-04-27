<?php
namespace App\Filament\Resources\Projects\RelationManagers;

use App\Enums\Priority;
use App\Enums\ProjectStatus;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TasksRelationManager extends RelationManager
{
    protected static string $relationship = 'tasks';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                MarkdownEditor::make('description')
                    ->required()
                    ->columnSpanFull(),

                DateTimePicker::make('due_date')
                    ->required()
                    ->default(now()->addWeeks(1)),

                Select::make('assigned_to')
                    ->required()
                    ->relationship(
                        'user',
                        'name',
                        modifyQueryUsing: function ($query, $livewire) {
                            $project = $livewire->getOwnerRecord();

                            $query->whereIn(
                                'id',
                                $project->users()->pluck('id')
                            );
                        }
                    )
                    ->selectablePlaceholder(false),

                Select::make('status')
                    ->required()
                    ->options(fn() => ProjectStatus::options())
                    ->default(fn() => ProjectStatus::Draft)
                    ->selectablePlaceholder(false),

                Select::make('priority')
                    ->required()
                    ->options(fn() => Priority::options())
                    ->default(Priority::Medium)
                    ->selectablePlaceholder(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->searchable(),

                TextColumn::make('user.name')
                    ->label('Assigned to')
                    ->formatStateUsing(fn($state) => $state == auth()->user()->name ? 'You: ' . $state : $state)
                    ->color(fn($state) => $state == auth()->user()->name ? 'success' : 'info')
                    ->sortable(),

                TextColumn::make('due_date')
                    ->dateTime()
                    ->sortable()
                    ->description(function ($record) {
                        $hoursLeft = now()->diffInHours($record->due_date, false);

                        if ($hoursLeft < 0) {
                            return 'Overdue by ' . abs($hoursLeft) . ' hours';
                        }

                        if ($hoursLeft < 24) {
                            return 'Due in ' . $hoursLeft . ' hours';
                        }

                        $daysLeft = round($hoursLeft / 24, 1);
                        return $daysLeft . ' days left';
                    })
                    ->color(function ($record) {
                        $daysLeft = now()->diffInDays($record->due_date, false);

                        return match (true) {
                            $daysLeft > 7  => 'success',
                            $daysLeft > 5  => 'gray',
                            $daysLeft > 3  => 'warning',
                            $daysLeft > 2  => 'orange',
                            $daysLeft >= 0 => 'danger',
                            default        => 'danger',
                        };
                    }),

                IconColumn::make('status')
                    ->icon(fn($state) => $state->icon())
                    ->tooltip(fn($state) => $state->name)
                    ->color(fn($state) => $state->color()),

                TextColumn::make('priority')
                    ->searchable()
                    ->badge()
                    ->color(fn($state) => $state->color()),

                TextColumn::make('completed_at')
                    ->date()
                    ->placeholder('Not Completed'),
            ])
            ->filters([
                TrashedFilter::make()
                    ->visible(function (): bool {
                        $user = auth()->user();

                        return $user->can('ForceDelete:Task') || $user->can('Restore:Task');
                    }),
                Filter::make('priority')
                    ->schema([
                        Select::make('priority')
                            ->multiple()
                            ->options(fn() => Priority::options())
                            ->selectablePlaceholder(false),
                    ])
                    ->query(function ($query, array $data) {
                        return $query->when(
                            $data['priority'] ?? null,
                            fn($query, $priorities) => $query->whereIn('priority', $priorities)
                        );
                    }),

                Filter::make('status')
                    ->schema([
                        Select::make('status')
                            ->searchable()
                            ->multiple()
                            ->options(fn() => ProjectStatus::options())
                        // ->live()
                            ->selectablePlaceholder(false),
                    ])
                    ->query(function ($query, array $data) {
                        $query->when(
                            $data['status'] ?? null,
                            fn($query, $statuses) => $query->whereIn('status', $statuses)
                        );

                        return $query;
                    }),
            ])
            ->headerActions([
                CreateAction::make(),
                // AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make()
                    ->hiddenLabel(true)
                    ->tooltip('Edit'),
                // DissociateAction::make(),
                DeleteAction::make()
                    ->hiddenLabel(true)
                    ->tooltip('Delete'),
                ForceDeleteAction::make()
                    ->hiddenLabel(true)
                    ->tooltip('Permanent Delete'),
                RestoreAction::make()
                    ->hiddenLabel(true)
                    ->tooltip('Restore'),

                //change status
                ActionGroup::make([
                    Action::make('status')
                        ->label('Change Status')
                        ->requiresConfirmation()
                        ->schema([
                            Select::make('status')
                                ->label('Choose Status')
                                ->options(fn() => ProjectStatus::options())
                                ->default(fn($record) => $record->status)
                                ->selectablePlaceholder(false),
                        ])
                        ->action(function ($record, array $data) {
                            $status         = $data['status'];
                            $record->status = $status;
                            if (! $record->isDirty('status')) {
                                Notification::make()
                                    ->warning()
                                    ->title('Status unchanged, please choose another one')
                                    ->send();
                                return;
                            }

                            $record->save();
                            Notification::make()
                                ->success()
                                ->title('Status Changed')
                                ->body('Your status has been set to ' . $status)
                                ->send();
                        }),
                ])
                    ->icon('heroicon-m-cog')
                    ->tooltip('Additional Actions'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(function (Builder $query, $livewire) {
                $user    = auth()->user();
                $project = $livewire->getOwnerRecord();

                if (! $user?->hasRole('super_admin') && $user->id != $project->supervisor_id) {
                    $query->where('assigned_to', $user->id);
                }

                if ($user->hasRole('super_admin')) {
                    $query->withoutGlobalScopes([
                        SoftDeletingScope::class,
                    ]);
                }
            });
    }
    public function isReadOnly(): bool
    {
        return false;
    }
}
