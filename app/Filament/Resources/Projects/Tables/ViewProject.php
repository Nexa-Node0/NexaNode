<?php
namespace App\Filament\Resources\ProjectResource\Pages;

use App\Enums\ApprovedStatus;
use App\Filament\Resources\Projects\ProjectResource;
use Carbon\Carbon;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;

class ViewProject extends ViewRecord
{
    protected static string $resource = ProjectResource::class;
    protected function getHeaderActions(): array
    {
        return [
            'edit'   => EditAction::make(),
            'delete' => DeleteAction::make(),
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([

                // Description card — full width, markdown enabled
                Section::make()
                    ->schema([
                        TextEntry::make('description')
                        // ->hiddenLabel()
                            ->markdown()
                            ->columnSpanFull(),
                    ]),

                // Status row
                Section::make('Status & Approval')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('status')
                            ->badge()
                            ->icon(fn($state) => $state->icon())
                            ->color(fn($state) => $state->color()),
                        TextEntry::make('priority')
                            ->badge()
                            ->color(fn($state) => $state->color()),
                        TextEntry::make('approved_status')
                            ->label('Approval')
                            ->icon(fn($state) => $state->icon())
                            ->formatStateUsing(fn($state, $record) => $state == ApprovedStatus::Approved
                                    ? $state->name . ' · ' . Carbon::parse($record->approved_at)->format('D M d, Y')
                                    : $state->name)
                            ->badge()
                            ->color(fn($state) => $state->color()),
                    ]),

                // Project details row
                Section::make('Project Details')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('start_date')
                            ->date(),
                        TextEntry::make('supervisor')
                            ->label('Supervisor')
                            ->formatStateUsing(fn($state) => $state->name)
                            ->url(fn($state) => \App\Filament\Resources\Users\UserResource::getUrl('edit', ['record' => $state->id])),
                        TextEntry::make('users_count')
                            ->label('Team Members')
                            ->state(fn($record) => $record->users->count() . ' members')
                            ->tooltip(function ($record) {
                                return $record->users
                                    ->pluck('name')
                                    ->map(fn ($name) => "• $name")
                                    ->implode("\n");
                            }),
                    ]),

                // Financials row
                Section::make('Financials')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('budget_amount')
                            ->label('Budget')
                            ->money('PHP')
                            ->color('success')
                            ->size(TextSize::Large),
                        TextEntry::make('actual_cost')
                            ->label('Actual Cost')
                            ->money('PHP')
                            ->color('danger')
                            ->size(TextSize::Large),
                    ]),

            ])
            ->columns(1);
    }
}
