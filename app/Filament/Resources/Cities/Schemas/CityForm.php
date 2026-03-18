<?php
namespace App\Filament\Resources\Cities\Schemas;

use App\Models\Country;
use App\Models\State;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class CityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('country_id')
                    ->label('Country')
                    ->prefixIcon(Heroicon::GlobeAsiaAustralia)
                    ->options(Country::pluck('name', 'id'))
                    ->reactive()
                    ->afterStateHydrated(function ($state, callable $set, $record) {
                        if ($record && $record->state) {
                            $set('country_id', $record->state->country_id);
                        }
                    })
                    ->afterStateUpdated(fn($state, callable $set) => $set('state_id', null))
                    ->searchable()
                    ->noOptionsMessage('No Available Country'),

                Select::make('state_id')
                    ->label('State')
                    ->prefixIcon(Heroicon::BuildingOffice2)
                    ->options(fn(callable $get) => State::where('country_id', $get('country_id'))->pluck('name', 'id'))
                    ->reactive()
                    ->searchable()
                    ->searchingMessage('Fetching available cities...')
                    ->noOptionsMessage('No Available Cities'),

                TextInput::make('name')
                    ->prefixIcon(Heroicon::HomeModern)
                    ->required(),
                TextInput::make('psgc_code'),
            ]);
    }
}
