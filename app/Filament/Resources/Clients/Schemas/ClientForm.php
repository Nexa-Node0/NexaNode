<?php
namespace App\Filament\Resources\Clients\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                Section::make('Client Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->prefixIcon('heroicon-m-language'),

                        TextInput::make('email')
                            ->required()
                            ->email()
                            ->prefixIcon('heroicon-m-envelope'),

                        TextInput::make('contact_number')
                            ->tel()
                            ->prefixIcon('heroicon-m-phone'),

                        TextInput::make('address')
                            ->prefixIcon('heroicon-m-map-pin'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
