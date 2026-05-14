<?php

namespace App\Filament\Pages\Settings;

use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\Select;
use Outerweb\FilamentSettings\Pages\Settings;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use App\Enums\NavigationOptions;
use App\Enums\NavigationLabelSettings;
use Filament\Forms\Components\Toggle;
use Illuminate\Contracts\Support\Htmlable;
use Override;
use UnitEnum;

class GeneralSettings extends Settings
{
    protected static ?string $navigationLabel =  NavigationLabelSettings::General->value;  
    protected static string|UnitEnum|null $navigationGroup = NavigationOptions::Settings;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGlobeAmericas;

    #[Override]
    public function getTitle(): string|Htmlable
    {
        return NavigationLabelSettings::General->getLabel();
    }

    #[Override]
    public function getSubheading(): string|Htmlable|null
    {
        return NavigationLabelSettings::General->getSubHeader();
    }

    public function form(Schema $schema): Schema
       {
        return $schema
            ->components([
                Tabs::make()
                    ->columnSpanFull()
                    ->tabs([

                        Tab::make('Identity')
                            ->icon('heroicon-o-identification')
                            ->schema([
                                Section::make('Site Identity')
                                    ->description('Basic information about your brand and site.')
                                    ->columns(3)
                                    ->schema([
                                        TextInput::make('general.tagline')
                                            ->label('Tagline')
                                            ->hint('A short catchy phrase for your brand')
                                            ->placeholder('Building the future, one line at a time.')
                                            ->columnSpan(2),

                                        TextInput::make('general.copyright_text')
                                            ->label('Copyright Text')
                                            ->placeholder('© 2025 My App. All rights reserved.')
                                            ->hint('Displayed in your site footer')
                                            ->columnSpan(1),

                                        Textarea::make('general.site_description')
                                            ->label('Site Description')
                                            ->rows(3)
                                            ->hint('Brief description of what your site is about')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('Contact')
                            ->icon('heroicon-o-envelope')
                            ->schema([
                                Section::make('Contact Information')
                                    ->description('Public-facing contact details for your site.')
                                    ->columns(3)
                                    ->schema([
                                        TextInput::make('general.phone')
                                            ->label('Phone Number')
                                            ->tel()
                                            ->hint('Primary contact number')
                                            ->placeholder('+1 (555) 000-0000')
                                            ->columnSpan(1),

                                        TextInput::make('general.support_email')
                                            ->label('Support Email')
                                            ->email()
                                            ->hint('Dedicated support email address')
                                            ->placeholder('support@yourdomain.com')
                                            ->columnSpan(1),

                                        TextInput::make('general.website_url')
                                            ->label('Website URL')
                                            ->url()
                                            ->hint('Your public-facing website')
                                            ->placeholder('https://yourdomain.com')
                                            ->columnSpan(1),

                                        Textarea::make('general.address')
                                            ->label('Business Address')
                                            ->rows(3)
                                            ->hint('Your physical or mailing address')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('Preferences')
                            ->icon('heroicon-o-adjustments-horizontal')
                            ->schema([
                                Section::make('Regional')
                                    ->description('Configure your timezone, formats, and locale.')
                                    ->columns(3)
                                    ->schema([
                                        Select::make('general.timezone')
                                            ->label('Timezone')
                                            ->options(
                                                collect(timezone_identifiers_list())
                                                    ->mapWithKeys(fn($tz) => [$tz => $tz])
                                            )
                                            ->searchable()
                                            ->default('UTC')
                                            ->columnSpan(1),

                                        Select::make('general.date_format')
                                            ->label('Date Format')
                                            ->options([
                                                'Y-m-d'  => '2025-01-31',
                                                'd/m/Y'  => '31/01/2025',
                                                'm/d/Y'  => '01/31/2025',
                                                'F j, Y' => 'January 31, 2025',
                                            ])
                                            ->default('Y-m-d')
                                            ->columnSpan(1),

                                        Select::make('general.time_format')
                                            ->label('Time Format')
                                            ->options([
                                                'H:i'   => '24-hour (14:30)',
                                                'h:i A' => '12-hour (02:30 PM)',
                                            ])
                                            ->default('H:i')
                                            ->columnSpan(1),
                                    ]),

                                Section::make('Locale')
                                    ->description('Set your default language and currency.')
                                    ->columns(3)
                                    ->schema([
                                        Select::make('general.language')
                                            ->label('Default Language')
                                            ->options([
                                                'en'  => 'English',
                                                'es'  => 'Spanish',
                                                'fr'  => 'French',
                                                'de'  => 'German',
                                                'fil' => 'Filipino',
                                                'ja'  => 'Japanese',
                                                'zh'  => 'Chinese',
                                                'ar'  => 'Arabic',
                                            ])
                                            ->searchable()
                                            ->default('en')
                                            ->columnSpan(1),

                                        Select::make('general.currency')
                                            ->label('Default Currency')
                                            ->options([
                                                'USD' => 'US Dollar (USD)',
                                                'EUR' => 'Euro (EUR)',
                                                'GBP' => 'British Pound (GBP)',
                                                'PHP' => 'Philippine Peso (PHP)',
                                                'JPY' => 'Japanese Yen (JPY)',
                                                'AUD' => 'Australian Dollar (AUD)',
                                                'CAD' => 'Canadian Dollar (CAD)',
                                                'SGD' => 'Singapore Dollar (SGD)',
                                            ])
                                            ->searchable()
                                            ->default('USD')
                                            ->columnSpan(1),

                                        Select::make('general.currency_position')
                                            ->label('Currency Symbol Position')
                                            ->options([
                                                'before' => 'Before amount ($ 100)',
                                                'after'  => 'After amount (100 $)',
                                            ])
                                            ->default('before')
                                            ->columnSpan(1),
                                    ]),
                            ]),

                        Tab::make('Features')
                            ->icon('heroicon-o-rocket-launch')
                            ->schema([
                                Section::make('Site Features')
                                    ->description('Enable or disable features across your site.')
                                    ->columns(3)
                                    ->schema([
                                        Toggle::make('general.maintenance_mode')
                                            ->label('Maintenance Mode')
                                            ->hint('Temporarily disable your site for visitors')
                                            ->columnSpan(1),

                                        Toggle::make('general.registration_enabled')
                                            ->label('Allow User Registration')
                                            ->hint('Let visitors create an account')
                                            ->default(true)
                                            ->columnSpan(1),

                                        Toggle::make('general.dark_mode_enabled')
                                            ->label('Enable Dark Mode Toggle')
                                            ->hint('Show dark/light mode switcher to users')
                                            ->default(true)
                                            ->columnSpan(1),

                                        Toggle::make('general.cookie_consent_enabled')
                                            ->label('Show Cookie Consent Banner')
                                            ->hint('Display a cookie notice to new visitors')
                                            ->default(true)
                                            ->columnSpan(1),

                                        Toggle::make('general.newsletter_enabled')
                                            ->label('Enable Newsletter Signup')
                                            ->hint('Allow visitors to subscribe to your newsletter')
                                            ->columnSpan(1),

                                        Toggle::make('general.blog_enabled')
                                            ->label('Enable Blog')
                                            ->hint('Show or hide the blog section')
                                            ->default(true)
                                            ->columnSpan(1),
                                    ]),
                            ]),

                    ]),
            ]);
    }
}
