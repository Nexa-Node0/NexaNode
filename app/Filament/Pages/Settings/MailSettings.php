<?php

namespace App\Filament\Pages\Settings;

use Outerweb\FilamentSettings\Pages\Settings;
use App\Enums\NavigationOptions;
use App\Enums\NavigationLabelSettings;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;

use Illuminate\Contracts\Support\Htmlable;
use Override;
use UnitEnum;

class MailSettings extends Settings
{
    protected static ?string $navigationLabel = NavigationLabelSettings::Mail->value;
    protected static string|UnitEnum|null $navigationGroup = NavigationOptions::Settings;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Envelope;

    #[Override]
    public function getTitle(): string|Htmlable
    {
        return NavigationLabelSettings::Mail->getLabel();
    }

    #[Override]
    public function getSubheading(): string|Htmlable|null
    {
        return NavigationLabelSettings::Mail->getSubHeader();
    }

    #[Override]
    public static function canAccess(): bool
    {
        $user = filament()->auth()->user();
        return $user instanceof \App\Models\User && $user->can('view_settings');
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make()->columnSpanFull()->tabs([
                Tabs\Tab::make('SMTP')->schema([
                    Select::make('mail.mailer')
                        ->label('Mail Driver')
                        ->options([
                            'smtp'     => 'SMTP',
                            'mailgun'  => 'Mailgun',
                            'ses'      => 'Amazon SES',
                            'postmark' => 'Postmark',
                            'log'      => 'Log (Dev)',
                        ])
                        ->required(),
                    TextInput::make('mail.host')
                        ->label('SMTP Host')
                        ->placeholder('smtp.mailprovider.com'),
                    TextInput::make('mail.port')
                        ->label('SMTP Port')
                        ->numeric()
                        ->placeholder('587'),
                    Select::make('mail.encryption')
                        ->label('Encryption')
                        ->options([
                            'tls' => 'TLS',
                            'ssl' => 'SSL',
                            ''    => 'None',
                        ]),
                    TextInput::make('mail.username')
                        ->label('Username'),
                    TextInput::make('mail.password')
                        ->label('Password')
                        ->password()
                        ->revealable(),
                ]),
                Tabs\Tab::make('Sender')->schema([
                    TextInput::make('mail.from_address')
                        ->label('From Address')
                        ->email()
                        ->required(),
                    TextInput::make('mail.from_name')
                        ->label('From Name')
                        ->required(),
                    Toggle::make('mail.reply_to_enabled')
                        ->label('Enable Reply-To'),
                    TextInput::make('mail.reply_to_address')
                        ->label('Reply-To Address')
                        ->email(),
                ]),
            ]),
        ]);
    }
}
