<?php

namespace App\Filament\Pages;

use BackedEnum;
use Dom\Text;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Support\Icons\Heroicon;
use Outerweb\FilamentSettings\Pages\Settings;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use App\Enums\NavigationOptions;
use Override;
use UnitEnum;

class GeneralSettings extends Settings
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Cog6Tooth;
    
    #[Override]
    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return NavigationOptions::Settings->getLabel();
    }
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('General')
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        TextInput::make('general.brand_name')
                                                ->required()
                                                ->default('My App')
                                                ->label('Site Name')
                                                ->hint('The name display throughout your site')
                                                ->columnSpan(2),

                                        TextInput::make('general.email_contact')
                                                ->required()
                                                ->email()
                                                ->hint('Contact email for customers/clients')
                                                ->label('Email')
                                                ->columnSpan(1),
                                            
                                        FileUpload::make('general.favicon')
                                                ->required()
                                                ->disk('public')
                                                ->directory('favicon')
                                                ->image()
                                                ->imageEditor()
                                                ->preserveFilenames()
                                                ->maxSize(1024) // 1MB
                                                ->imageEditorAspectRatioOptions([
                                                    null,
                                                    '1:1',
                                                    '16:9',
                                                    '4:3'
                                                ])
                                                ->hint('Displays in browser tabs and address bar'),
                                            
                                            FileUpload::make('general.brand_logo')
                                                ->required()
                                                ->disk('public')
                                                ->directory('logos')
                                                ->image()
                                                ->imageEditor()
                                                ->imageEditorAspectRatioOptions([
                                                    null,
                                                    '1:1',
                                                    '4:4',
                                                    '16:16'
                                                ])
                                                ->label('Logo')
                                                ->hint('Your company or brand logo'),

                                            FileUpload::make('general.dark_mode_brand_logo')
                                                ->required()
                                                ->disk('public')
                                                ->directory('logos')
                                                ->image()
                                                ->imageEditor()
                                                ->imageEditorAspectRatioOptions([
                                                    null,
                                                    '1:1',
                                                    '4:4',
                                                    '16:16'
                                                ])
                                                ->label('Logo for darkmode')
                                                ->hint('Your company or brand logo'),

                                             FileUpload::make('general.admin_empty_panel_background')
                                                ->required()
                                                ->disk('public')
                                                ->directory('panel_background')
                                                ->image()
                                                ->imageEditor()
                                                ->imageEditorAspectRatioOptions([
                                                    null,
                                                    '1:1',
                                                    '4:4',
                                                    '16:16'
                                                ])
                                                ->label('Login Background'),

                                            FileUpload::make('general.brand_logo')
                                                ->required()
                                                ->disk('public')
                                                ->directory('logos')
                                                ->image()
                                                ->imageEditor()
                                                ->imageEditorAspectRatioOptions([
                                                    null,
                                                    '1:1',
                                                    '4:4',
                                                    '16:16'
                                                ])
                                                ->label('Logo')
                                                ->hint('Your company or brand logo'),
                                    ])
                            ]),
                        Tab::make('SEO')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('seo.title')
                                            ->required(),
                                        TextInput::make('seo.description')
                                            ->required()
                                ])
                            ])
                    ])
            ]);
    }
}
