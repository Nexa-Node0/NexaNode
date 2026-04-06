<?php

namespace App\Filament\Project\Resources\Projects\Schemas;

use App\Models\Project;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProjectInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('code'),
                TextEntry::make('slug'),
                TextEntry::make('description')
                    ->columnSpanFull(),
                TextEntry::make('status'),
                TextEntry::make('priority'),
                TextEntry::make('start_date')
                    ->dateTime(),
                TextEntry::make('budget_amount')
                    ->numeric(),
                TextEntry::make('actual_cost')
                    ->money(),
                IconEntry::make('requires_approval')
                    ->boolean(),
                TextEntry::make('approved_status'),
                TextEntry::make('approved_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('supervisor_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Project $record): bool => $record->trashed()),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
