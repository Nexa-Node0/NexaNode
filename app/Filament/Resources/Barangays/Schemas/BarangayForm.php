<?php
namespace App\Filament\Resources\Barangays\Schemas;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class BarangayForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('country_id')
                    ->label('Country')
                    ->prefixIcon(Heroicon::GlobeAsiaAustralia)
                    ->options(fn()=>Country::query()->orderBy('name')->pluck('name','id'))
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(function($state, callable $set){
                        $set('state_id',null);
                        $set('city_id',null);
                    })
                    ->afterStateHydrated(function($state, callable $set, $record){
                        if($record && $record->city){
                            $state = $record->city?->state;

                            $set('country_id',$state?->country?->id);
                        }
                    })
                    ->columnSpanFull(),

                Select::make('state_id')
                    ->label('State / Province')
                    ->prefixIcon(Heroicon::BuildingOffice2)
                    ->options(function(callable $get){
                        $countryId = $get('country_id');
                        return $countryId ? State::whereCountryId($countryId)->orderBy('name')->pluck('name','id') : [];
                    })
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(function($state, callable $set){
                        $set('city_id',null);
                    })
                    ->afterStateHydrated(function($state, callable $set, $record){
                        if($record && $record->city){
                            $set('state_id', $record->city?->state?->id);
                        }
                    })
                    ->noOptionsMessage('Please select a Country'),

                Select::make('city_id')
                    ->label('City / Municipality')
                    ->prefixIcon(Heroicon::HomeModern)
                    ->options(function(callable $get){
                        $stateId = $get('state_id');
                        return $stateId ? City::whereStateId($stateId)->orderBy('name')->pluck('name','id') : [];
                    })
                    ->reactive()
                    ->searchable()
                    ->noOptionsMessage('Please select a State/Province'),

                TextInput::make('name')
                    ->required(),

                TextInput::make('psgc_code'),
            ]);
    }
}
