<?php

namespace App\Filament\Resources\HR\Positions\Schemas;

use Filament\Forms\Components\Slider;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Set;


class PositionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->heading('Basic Details')
                    ->icon(Heroicon::DocumentChartBar)
                    ->description('Common details of the position')
                    ->collapsible()
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->columnSpan(2)
                            ->label('Position Name')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, string $state) {
                                $code = collect(explode(' ', $state))
                                    ->filter()
                                    ->map(fn($word) => strtoupper($word[0]))
                                    ->implode('');
                                $set('code', $code);
                            }),
                        TextInput::make('code')
                            ->required()
                            ->dehydrated()
                            ->hintIcon('heroicon-m-question-mark-circle')
                            ->hintIconTooltip('This code is automatically generated from the position name.')
                            ->unique(ignoreRecord: true),

                        TextInput::make('max_headcount')
                            ->required()
                            ->default(1)
                            ->columnSpan(1)
                            ->numeric(),

                        Select::make('type')
                            ->required()
                            ->options(\App\Enums\PositionEnum::options())
                            ->columnSpan(2)
                            ->native(false),

                        Slider::make('level')
                            ->required()
                            ->minValue(1)
                            ->maxValue(3)
                            ->step(1)
                            ->columnSpan(2)
                            ->helperText('Level of this position')
                            ->helperText(
                                'Defines the hierarchy level of the position. 
                                Example: 1 = Staff, 3 = Supervisor, 5 = Executive.'
                            ),
                        Toggle::make('is_active')
                            ->label('Active Position')
                            ->default(true)
                    ])
                    ->columns(3),

                Section::make('Organization Details')
                    ->icon(Heroicon::BuildingOffice2)
                    ->description('Department and reporting structure')
                    ->collapsible()
                    ->schema([
                        Select::make('department_id')
                            ->label('Department')
                            ->relationship('department', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('reports_to')
                            ->label('Reports to')
                            ->relationship('supervisor', 'name')
                            ->searchable()
                            ->preload()
                            ->helperText('Select the position this role directly reports to.'),

                        Textarea::make('description')
                            ->rows(5)
                            ->columnSpanFull()
                            ->placeholder('Desribe the responsibilities and scope of this position')


                    ])
                    ->columns(2)
            ]);
    }
}
