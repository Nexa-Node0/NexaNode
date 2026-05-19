<?php

namespace App\Helper;

use App\Enums\Settings\MediaEnum;
use App\Enums\Settings\Puppeteer\FileFormatEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Slider;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

class FilamentBrowsershotModalHelper
{
    
    //form schema
    public static function getModal(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()
                    ->schema([
                        Tab::make('Information')
                            ->schema([
                                Group::make()
                                    ->schema([
                                        Grid::make([
                                            'md' => 1,
                                            'lg' => 3,
                                        ])
                                            ->schema([
                                                Group::make()
                                                    ->schema([
                                                        Placeholder::make('logo_preview')
                                                            ->label('Logo')
                                                            ->content(fn() => new \Illuminate\Support\HtmlString(
                                                                '<img src="' . Storage::disk('public')->url(setting(MediaEnum::LightmodeLogo->value)) . '" class="max-h-32 object-contain" />'
                                                            )),
                                                        TextInput::make('brand_name')
                                                            ->Label('Brand')
                                                            ->disabled()
                                                            ->formatStateUsing(fn() => setting(MediaEnum::Name->value)),
                                                    ]),
                                                Tabs::make()
                                                    ->schema([
                                                        Tab::make('Invoice Details')
                                                            ->schema([
                                                                TextInput::make('invoice_number')
                                                                    ->required()
                                                                    ->suffixAction(
                                                                        Action::make('randomize')
                                                                            ->icon('heroicon-o-arrow-path')
                                                                            ->action(function ($set) {
                                                                                $set('invoice_number', strtoupper(uniqid('INV-')));
                                                                            })
                                                                    ),

                                                                DatePicker::make('invoice_date')
                                                                    ->required()
                                                                    ->default(now()),

                                                                DatePicker::make('invoice_due')
                                                                    ->required()
                                                                    ->default(now()->subWeek())
                                                                    ->minDate(now()),

                                                                TextInput::make('due_penalty')
                                                                    ->required()
                                                                    ->prefix('₱')
                                                                    ->numeric()
                                                                    ->step(0.01)
                                                                    ->minValue(0)
                                                                    ->default(0)
                                                                    ->inputMode('decimal'),
                                                            ]),

                                                        Tab::make('Company Details')
                                                            ->schema([
                                                                TextInput::make('company_email')
                                                                    ->required()
                                                                    ->email()
                                                                    ->default(setting('general.support_email')),

                                                                TextInput::make('company_phone')
                                                                    ->required()
                                                                    ->tel()
                                                                    ->default(setting('general.phone')),

                                                                TextInput::make('company_website')
                                                                    ->required()
                                                                    ->default(setting('general.website_url')),

                                                                TextInput::make('company_address')
                                                                    ->required()
                                                                    ->default(setting('general.address')),
                                                            ]),

                                                        Tab::make('Client Details')
                                                            ->schema([
                                                                TextInput::make('client_name')
                                                                    ->required()
                                                                    ->placeholder('Juan Dela Cruz'),
                                                                TextInput::make('client_email')
                                                                    ->required()
                                                                    ->email()
                                                                    ->placeholder('juandelacruz@example.com'),

                                                                TextInput::make('client_phone')
                                                                    ->required()
                                                                    ->tel()
                                                                    ->placeholder('+1 (555) 000-0000'),

                                                                TextInput::make('client_website')
                                                                    ->placeholder('https://client.domain.com/'),

                                                                TextInput::make('client_address')
                                                                    ->required(),
                                                            ]),

                                                        Tab::make('Shipment')
                                                            ->schema([
                                                                TextInput::make('shipment_address')
                                                                    ->required(),
                                                                TextInput::make('shipment_tracking_number')
                                                                    ->required()
                                                                    ->suffixAction(
                                                                        Action::make('randomize')
                                                                            ->icon('heroicon-o-arrow-path')
                                                                            ->action(function ($set) {
                                                                                $set('shipment_tracking_number', strtoupper(uniqid('TN-')));
                                                                            })
                                                                    ),
                                                            ]),
                                                    ])
                                                    ->columnSpan(2),
                                            ]),
                                    ]),
                            ]),
                        Tab::make('Options')
                            ->schema([
                                Grid::make([
                                    'md' => 1,
                                    'lg' => 2,
                                ])
                                    ->schema(self::getFileFormatModalArray()),
                            ]),
                    ]),

            ]);
    }

    public static function getFileFormatModalArray()
    {
        return [
            Group::make()
                ->schema([

                    Select::make('format')
                        ->options(FileFormatEnum::options())
                        ->default(FileFormatEnum::A4)
                        ->placeholder('Custom')
                        ->noOptionsMessage('Custom')
                        ->live()
                        ->columnSpan(2),

                    TextInput::make('format_width')
                        ->label('Width')
                        ->numeric()
                        ->minValue(10)
                        ->default(210)
                        ->columnSpan(1)
                        ->disabled(fn($get) => $get('format') !== null)
                        ->required(fn($get) => $get('format') == null),

                    TextInput::make('format_height')
                        ->label('Height')
                        ->numeric()
                        ->minValue(10)
                        ->default(297)
                        ->columnSpan(1)
                        ->disabled(fn($get) => $get('format') !== null)
                        ->required(fn($get) => $get('format') == null),

                    Checkbox::make('show_background')
                        ->label('Show Background')
                        ->default(true)
                        ->required()
                        ->columnSpanFull(),

                    Checkbox::make('landscape')
                        ->label('Ladscape')
                        ->hint('Orientation')
                        ->default(false)
                        ->columnSpanFull(),
                ])
                ->columns(2),

            Group::make()
                ->schema([
                    Section::make('margins')
                        ->schema([
                            TextInput::make('m_top')
                                ->label('Top')
                                ->numeric()
                                ->minValue(0)
                                ->default(0),

                            TextInput::make('m_right')
                                ->label('Right')
                                ->numeric()
                                ->minValue(0)
                                ->default(0),

                            TextInput::make('m_bottom')
                                ->label('Bottom')
                                ->numeric()
                                ->minValue(0)
                                ->default(0),

                            TextInput::make('m_left')
                                ->label('Left')
                                ->numeric()
                                ->minValue(0)
                                ->default(0),
                        ])
                        ->columns(2),

                    Slider::make('Scale')
                        ->hint('Zoom')
                        ->range(minValue: 0.1, maxValue: 2)
                        ->default(1)
                        ->decimalPlaces(1)
                        ->pips()
                        ->step(0.1),

                    Checkbox::make('eager')
                        ->label('Eager to load')
                        ->default(true)
                        ->hint('May take Longer to Process(for rendering Images and fonts)'),
                ]),
        ];
    }
}
