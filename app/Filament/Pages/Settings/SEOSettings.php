<?php

namespace App\Filament\Pages\Settings;

use Outerweb\FilamentSettings\Pages\Settings;
use App\Enums\NavigationOptions;
use App\Enums\NavigationLabelSettings;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use App\Enums\Settings\SEOEnum;
use BackedEnum;
use Filament\Forms\Components\TagsInput;
use Override;
use UnitEnum;

class SEOSettings extends Settings
{
    protected static ?string $navigationLabel = NavigationLabelSettings::SEO->value;
    protected static string|UnitEnum|null $navigationGroup = NavigationOptions::Settings;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::MagnifyingGlass;


    #[Override]
    public static function canAccess(): bool
    {
        $user = filament()->auth()->user();
        return $user instanceof \App\Models\User && $user->can('view_settings');
    }

    #[Override]
    public function getTitle(): string|Htmlable
    {
        return NavigationLabelSettings::SEO->getLabel();
    }

    #[Override]
    public function getSubheading(): string|Htmlable|null
    {
        return NavigationLabelSettings::SEO->getSubHeader();
    }
    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make()->columnSpanFull()->tabs([

                Tabs\Tab::make('Meta')
                    ->icon(Heroicon::Tag)
                    ->schema([
                        Section::make('Basic Meta Tags')
                            ->description('These are the core meta tags that appear in search engine results.')
                            ->columns(3)
                            ->schema([
                                TextInput::make(SEOEnum::MetaTitle->value)
                                    ->label('Meta Title')
                                    ->required()
                                    ->maxLength(60)
                                    ->helperText('Recommended: 50–60 characters')
                                    ->columnSpan(2),

                                TagsInput::make(SEOEnum::MetaKeywords->value)
                                    ->label('Meta Keywords')
                                    ->helperText('Comma-separated keywords')
                                    ->columnSpan(1),

                                Textarea::make(SEOEnum::MetaDescription->value)
                                    ->label('Meta Description')
                                    ->rows(3)
                                    ->maxLength(160)
                                    ->helperText('Recommended: 150–160 characters')
                                    ->columnSpanFull(),
                            ]),

                        Section::make('Indexing')
                            ->description('Control how search engines crawl and index your site.')
                            ->columns(3)
                            ->schema([
                                Toggle::make(SEOEnum::Index->value)
                                    ->label('Allow Search Engine Indexing')
                                    ->default(true),

                                Toggle::make(SEOEnum::Follow->value)
                                    ->label('Allow Link Following')
                                    ->default(true),

                                Toggle::make(SEOEnum::SiteMapEnabled->value)
                                    ->label('Enable Sitemap'),

                                TextInput::make(SEOEnum::SiteMapURL->value)
                                    ->label('Sitemap URL')
                                    ->url()
                                    ->placeholder('https://yourdomain.com/sitemap.xml')
                                    ->columnSpan(2),

                                TextInput::make(SEOEnum::CanonicalURL->value)
                                    ->label('Canonical URL')
                                    ->url()
                                    ->placeholder('https://yourdomain.com')
                                    ->columnSpanFull(),
                            ]),
                    ]),

                Tabs\Tab::make('Open Graph')
                    ->icon(Heroicon::Share)
                    ->schema([
                        Section::make('Open Graph Tags')
                            ->description('Controls how your site appears when shared on Facebook, LinkedIn, and others.')
                            ->columns(3)
                            ->schema([
                                TextInput::make(SEOEnum::OGTitle->value)
                                    ->label('OG Title')
                                    ->maxLength(95)
                                    ->columnSpan(2),

                                Select::make(SEOEnum::OGType->value)
                                    ->label('OG Type')
                                    ->options([
                                        'website' => 'Website',
                                        'article' => 'Article',
                                        'product' => 'Product',
                                        'profile' => 'Profile',
                                    ])
                                    ->default('website')
                                    ->columnSpan(1),

                                Textarea::make(SEOEnum::OGDescription->value)
                                    ->label('OG Description')
                                    ->rows(3)
                                    ->maxLength(200)
                                    ->columnSpanFull(),

                                TextInput::make(SEOEnum::OGURL->value)
                                    ->label('OG URL')
                                    ->url()
                                    ->placeholder('https://yourdomain.com')
                                    ->columnSpan(2),

                                TextInput::make(SEOEnum::OGSiteName->value)
                                    ->label('OG Site Name')
                                    ->columnSpan(1),

                                FileUpload::make(SEOEnum::OGImage->value)
                                    ->label('OG Image')
                                    ->image()
                                    ->directory('settings/seo')
                                    ->visibility('public')
                                    ->helperText('Recommended size: 1200x630px')
                                    ->columnSpanFull(),
                            ]),
                    ]),

                Tabs\Tab::make('Twitter / X Card')
                    ->icon(Heroicon::ChatBubbleOvalLeft)
                    ->schema([
                        Section::make('Twitter Card Tags')
                            ->description('Controls how your site appears when shared on Twitter / X.')
                            ->columns(3)
                            ->schema([
                                Select::make(SEOEnum::TwitterCard->value)
                                    ->label('Card Type')
                                    ->options([
                                        'summary'             => 'Summary',
                                        'summary_large_image' => 'Summary with Large Image',
                                        'app'                 => 'App',
                                        'player'              => 'Player',
                                    ])
                                    ->default('summary_large_image')
                                    ->columnSpan(1),

                                TextInput::make(SEOEnum::TwitterSite->value)
                                    ->label('Twitter Site Handle')
                                    ->placeholder('@yourhandle')
                                    ->columnSpan(1),

                                TextInput::make(SEOEnum::TwitterCreator->value)
                                    ->label('Twitter Creator Handle')
                                    ->placeholder('@yourhandle')
                                    ->columnSpan(1),

                                TextInput::make(SEOEnum::TwitterTitle->value)
                                    ->label('Twitter Title')
                                    ->maxLength(70)
                                    ->columnSpan(2),

                                Textarea::make(SEOEnum::TwitterDescription->value)
                                    ->label('Twitter Description')
                                    ->rows(3)
                                    ->maxLength(200)
                                    ->columnSpanFull(),

                                FileUpload::make(SEOEnum::TwitterImage->value)
                                    ->label('Twitter Image')
                                    ->image()
                                    ->directory('settings/seo')
                                    ->visibility('public')
                                    ->helperText('Recommended size: 1200x600px')
                                    ->columnSpanFull(),
                            ]),
                    ]),

                Tabs\Tab::make('Analytics')
                    ->icon(Heroicon::ChartBar)
                    ->schema([
                        Section::make('Google')
                            ->description('Connect your Google tracking and verification tools.')
                            ->columns(3)
                            ->schema([
                                TextInput::make(SEOEnum::GoogleAnalyticsID->value)
                                    ->label('Google Analytics ID')
                                    ->placeholder('G-XXXXXXXXXX')
                                    ->columnSpan(1),

                                TextInput::make(SEOEnum::GoogleTagManagerID->value)
                                    ->label('Google Tag Manager ID')
                                    ->placeholder('GTM-XXXXXXX')
                                    ->columnSpan(1),

                                TextInput::make(SEOEnum::GoogleSiteVerification->value)
                                    ->label('Google Site Verification')
                                    ->placeholder('Google verification meta value')
                                    ->columnSpan(1),
                            ]),

                        Section::make('Other Platforms')
                            ->description('Additional tracking and verification codes.')
                            ->columns(3)
                            ->schema([
                                TextInput::make(SEOEnum::FacebookPixelID->value)
                                    ->label('Facebook Pixel ID')
                                    ->placeholder('XXXXXXXXXXXXXXXXXX')
                                    ->columnSpan(1),

                                TextInput::make(SEOEnum::BingSiteVerification->value)
                                    ->label('Bing Site Verification')
                                    ->columnSpan(1),

                                TextInput::make(SEOEnum::TikTokPixelID->value)
                                    ->label('TikTok Pixel ID')
                                    ->columnSpan(1),
                            ]),
                    ]),

                Tabs\Tab::make('Structured Data')
                    ->icon(Heroicon::CodeBracket)
                    ->schema([
                        Section::make('Schema.org')
                            ->description('Help search engines better understand your site content.')
                            ->columns(3)
                            ->schema([
                                Select::make(SEOEnum::SchemaType->value)
                                    ->label('Schema Type')
                                    ->options([
                                        'Organization'    => 'Organization',
                                        'LocalBusiness'   => 'Local Business',
                                        'Person'          => 'Person',
                                        'WebSite'         => 'Website',
                                        'Article'         => 'Article',
                                    ])
                                    ->default('Organization')
                                    ->columnSpan(1),

                                TextInput::make(SEOEnum::SchemaName->value)
                                    ->label('Organization / Site Name')
                                    ->columnSpan(2),

                                TextInput::make(SEOEnum::SchemaURL->value)
                                    ->label('Site URL')
                                    ->url()
                                    ->placeholder('https://yourdomain.com')
                                    ->columnSpan(1),

                                TextInput::make(SEOEnum::SchemaEmail->value)
                                    ->label('Contact Email')
                                    ->email()
                                    ->columnSpan(1),

                                TextInput::make(SEOEnum::SchemaPhone->value)
                                    ->label('Phone Number')
                                    ->columnSpan(1),

                                Textarea::make(SEOEnum::SchemaAddress->value)
                                    ->label('Address')
                                    ->rows(2)
                                    ->columnSpanFull(),

                                FileUpload::make(SEOEnum::SchemaLogo->value)
                                    ->label('Organization Logo')
                                    ->image()
                                    ->directory('settings/seo')
                                    ->visibility('public')
                                    ->columnSpanFull(),
                            ]),
                    ]),

            ]),
        ]);
    }
}
