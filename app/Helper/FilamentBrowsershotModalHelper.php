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
use Filament\Forms\Components\Textarea;
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
    public static function getModal(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()
                    ->schema([

                        // ── Tab 1: Invoice Details ──────────────────────────────
                        Tab::make('Invoice')
                            ->schema([
                                Grid::make(['md' => 1, 'lg' => 2])
                                    ->schema([
                                        Placeholder::make('logo_preview')
                                            ->label('Logo')
                                            ->content(fn() => new \Illuminate\Support\HtmlString(
                                                '<img src="' . Storage::disk('public')->url(setting(MediaEnum::LightmodeLogo->value)) . '" class="max-h-32 object-contain" />'
                                            )),

                                        TextInput::make('brand_name')
                                            ->label('Brand')
                                            ->disabled()
                                            ->formatStateUsing(fn() => setting(MediaEnum::Name->value)),
                                    ]),

                                Grid::make(['md' => 1, 'lg' => 2])
                                    ->schema([
                                        TextInput::make('invoice_number')
                                            ->label('Invoice Number')
                                            ->suffixAction(
                                                Action::make('randomize_invoice')
                                                    ->icon('heroicon-o-arrow-path')
                                                    ->action(fn($set) => $set('invoice_number', strtoupper(uniqid('INV-'))))
                                            ),

                                        TextInput::make('due_penalty')
                                            ->label('Due Penalty')
                                            ->prefix('₱')
                                            ->numeric()
                                            ->step(0.01)
                                            ->minValue(0)
                                            ->default(0)
                                            ->inputMode('decimal'),

                                        DatePicker::make('invoice_date')
                                            ->label('Invoice Date')
                                            ->default(now()),

                                        DatePicker::make('invoice_due')
                                            ->label('Due Date')
                                            ->default(now()->addWeek())
                                            ->minDate(now()),
                                    ]),

                                    TextArea::make('note')
                                        ->label('Notes'),
                            ]),

                        // ── Tab 2: Company Details ──────────────────────────────
                        Tab::make('Company')
                            ->schema([
                                Grid::make(['md' => 1, 'lg' => 2])
                                    ->schema([
                                        TextInput::make('company_email')
                                            ->label('Email')
                                            ->email()
                                            ->default(setting('general.support_email')),

                                        TextInput::make('company_phone')
                                            ->label('Phone')
                                            ->tel()
                                            ->default(setting('general.phone')),

                                        TextInput::make('company_website')
                                            ->label('Website')
                                            ->default(setting('general.website_url')),

                                        TextInput::make('company_address')
                                            ->label('Address')
                                            ->default(setting('general.address')),
                                    ]),
                            ]),

                        // ── Tab 3: Client Details ───────────────────────────────
                        Tab::make('Client')
                            ->schema([
                                Grid::make(['md' => 1, 'lg' => 2])
                                    ->schema([
                                        TextInput::make('client_name')
                                            ->label('Name')
                                            ->placeholder('Juan Dela Cruz'),

                                        TextInput::make('client_email')
                                            ->label('Email')
                                            ->email()
                                            ->placeholder('juandelacruz@example.com'),

                                        TextInput::make('client_phone')
                                            ->label('Phone')
                                            ->tel()
                                            ->placeholder('+63 (555) 000-0000'),

                                        TextInput::make('client_website')
                                            ->label('Website')
                                            ->placeholder('https://client.domain.com/'),

                                        TextInput::make('client_address')
                                            ->label('Address')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        // ── Tab 4: Shipment ─────────────────────────────────────
                        Tab::make('Shipment')
                            ->schema([
                                Grid::make(['md' => 1, 'lg' => 2])
                                    ->schema([
                                        TextInput::make('shipment_address')
                                            ->label('Ship To Address')
                                            ->columnSpanFull(),

                                        TextInput::make('shipment_tracking_number')
                                            ->label('Tracking Number')
                                            ->columnSpanFull()
                                            ->suffixAction(
                                                Action::make('randomize_tracking')
                                                    ->icon('heroicon-o-arrow-path')
                                                    ->action(fn($set) => $set('shipment_tracking_number', strtoupper(uniqid('TN-'))))
                                            ),
                                    ]),
                            ]),

                        // ── Tab 5: PDF Options ──────────────────────────────────
                        Tab::make('Options')
                            ->schema([
                                Grid::make(['md' => 1, 'lg' => 2])
                                    ->schema([

                                        // Left column
                                        Group::make()
                                            ->schema([
                                                Select::make('format')
                                                    ->label('Paper Format')
                                                    ->options(FileFormatEnum::options())
                                                    ->default(FileFormatEnum::A4->value)
                                                    ->placeholder('Custom Size')
                                                    ->live(),

                                                Grid::make(2)
                                                    ->schema([
                                                        TextInput::make('format_width')
                                                            ->label('Width (mm)')
                                                            ->numeric()
                                                            ->minValue(10)
                                                            ->default(210)
                                                            ->disabled(fn($get) => $get('format') !== null),

                                                        TextInput::make('format_height')
                                                            ->label('Height (mm)')
                                                            ->numeric()
                                                            ->minValue(10)
                                                            ->default(297)
                                                            ->disabled(fn($get) => $get('format') !== null),
                                                    ]),

                                                Checkbox::make('show_background')
                                                    ->label('Show Background Colors')
                                                    ->default(true),

                                                Checkbox::make('landscape')
                                                    ->label('Landscape Orientation')
                                                    ->default(false),
                                            ]),

                                        // Right column
                                        Group::make()
                                            ->schema([
                                                Section::make('Margins (mm)')
                                                    ->schema([
                                                        Grid::make(2)
                                                            ->schema([
                                                                TextInput::make('m_top')
                                                                    ->label('Top')
                                                                    ->numeric()
                                                                    ->minValue(0)
                                                                    ->default(5),

                                                                TextInput::make('m_right')
                                                                    ->label('Right')
                                                                    ->numeric()
                                                                    ->minValue(0)
                                                                    ->default(5),

                                                                TextInput::make('m_bottom')
                                                                    ->label('Bottom')
                                                                    ->numeric()
                                                                    ->minValue(0)
                                                                    ->default(5),

                                                                TextInput::make('m_left')
                                                                    ->label('Left')
                                                                    ->numeric()
                                                                    ->minValue(0)
                                                                    ->default(5),
                                                            ]),
                                                    ]),

                                                Slider::make('scale')
                                                    ->label('Scale')
                                                    ->hint('Zoom')
                                                    ->range(minValue: 0.1, maxValue: 2)
                                                    ->default(1)
                                                    ->decimalPlaces(1)
                                                    ->pips()
                                                    ->step(0.1),

                                                Checkbox::make('eager')
                                                    ->label('Wait for Network Idle')
                                                    ->hint('Waits for fonts & images — may be slower')
                                                    ->default(true),
                                            ]),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
