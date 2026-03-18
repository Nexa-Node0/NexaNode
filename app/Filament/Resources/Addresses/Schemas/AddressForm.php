<?php
namespace App\Filament\Resources\Addresses\Schemas;

use App\Models\Barangay;
use App\Models\City;
use App\Models\State;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
// use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class AddressForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Toggle::make('is_default')
                //     ->label('Default Address')
                //     ->inline(false)
                //     ->onIcon(Heroicon::Check)
                //     ->offIcon(Heroicon::XMark)
                //     ->columnSpanFull(),

                Select::make('user_id')
                    ->label('User')
                    ->prefixIcon(Heroicon::User)
                    ->relationship('user',
                        'name',
                        modifyQueryUsing: function ($query, $record) {
                            $query->whereDoesntHave('address');
                            if($record != null){
                                $query->orWhere('id', $record?->user_id);
                            }

                            $query->orderBy('name');
                        })
                    ->searchable()
                    ->preload()
                    ->required()
                    ->disabled(fn($record) => $record !== null)
                    ->columnSpanFull(),

                Group::make()
                    ->schema([
                        Select::make('country_id')
                            ->label('Country')
                            ->prefixIcon(Heroicon::GlobeAsiaAustralia)
                            ->relationship(
                                'country',
                                'name',
                                modifyQueryUsing: fn($query) => $query->orderBy('name'))
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('state_id', null);
                                $set('city_id', null);
                            })
                            ->preload()
                            ->required()
                            ->columnSpan(3),

                        TextInput::make('postal_code')
                            ->label('Postal Code')
                            ->required()
                            ->maxLength('100')
                            ->columnSpan(1),
                    ])
                    ->columnSpanFull()
                    ->columns(4),

                Select::make('state_id')
                    ->label('State / Province')
                    ->prefixIcon(Heroicon::BuildingOffice2)
                    ->reactive()
                    ->searchable()
                    ->options(function ($get) {
                        $countryId = $get('country_id');
                        return $countryId ? State::whereCountryId($countryId)->orderBy('name')->pluck('name', 'id') : [];
                    })
                    ->afterStateUpdated(function ($state, callable $get, $set) {
                        $set('city_id', null);
                    })
                    ->required(),

                Select::make('city_id')
                    ->label('City / Municipality')
                    ->prefixIcon(Heroicon::HomeModern)
                    ->reactive()
                    ->options(function ($get) {
                        $stateId = $get('state_id');
                        return $stateId ? City::whereStateId($stateId)->orderBy('name')->pluck('name', 'id') : [];
                    })
                    ->required(),

                TextInput::make('line1')
                    ->prefixIcon(Heroicon::Home)
                    ->required()
                    ->reactive()
                    ->datalist(fn($get) => $get('city_id')
                            ? Barangay::where('city_id', $get('city_id'))->orderBy('name')->pluck('name')->toArray()
                            : []),

                TextInput::make('line2')
                    ->prefixIcon(Heroicon::Plus)
                    ->reactive()
                    ->datalist(fn($get) => $get('city_id')
                            ? Barangay::where('city_id', $get('city_id'))->orderBy('name')->pluck('name')->toArray()
                            : []),
            ]);
    }
}
