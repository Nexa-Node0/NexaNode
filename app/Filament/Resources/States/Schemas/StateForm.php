<?php

namespace App\Filament\Resources\States\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('country_id')
                    ->label('Country')
                    ->noOptionsMessage('Select A Country')
                    ->relationship('country','name', modifyQueryUsing: function($query){
                        $query->orderBy('name');
                    })
                    ->preload()
                    ->searchable(),
                TextInput::make('psgc_code'),
            ]);
    }
}
