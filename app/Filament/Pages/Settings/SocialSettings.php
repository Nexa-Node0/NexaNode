<?php

namespace App\Filament\Pages\Settings;

use App\Enums\NavigationLabelSettings;
use BackedEnum;
use Outerweb\FilamentSettings\Pages\Settings;
use Filament\Support\Icons\Heroicon;
use App\Enums\NavigationOptions;
use Illuminate\Contracts\Support\Htmlable;

use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Override;
use UnitEnum;

class SocialSettings extends Settings
{
    protected static ?string $navigationLabel = NavigationLabelSettings::Social->value;
    protected static string|UnitEnum|null $navigationGroup = NavigationOptions::Settings;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Share;

    
    #[Override]
    public function getTitle(): string|Htmlable
    {
        return NavigationLabelSettings::Social->getLabel();
    }

    #[Override]
    public function getSubheading(): string|Htmlable|null
    {
        return NavigationLabelSettings::Social->getSubHeader();
    }


     public function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make()->columnSpanFull()->tabs([

                Tabs\Tab::make('Main Profiles')
                    ->icon('heroicon-o-user-circle')
                    ->schema([
                        Section::make('Main Social Profiles')
                            ->description('Your primary social media presence.')
                            ->columns(3)
                            ->schema([
                                TextInput::make('social.facebook')
                                    ->label('Facebook')
                                    ->url()
                                    ->placeholder('https://facebook.com/yourpage')
                                    ->prefixIcon('heroicon-o-globe-alt'),

                                TextInput::make('social.instagram')
                                    ->label('Instagram')
                                    ->url()
                                    ->placeholder('https://instagram.com/yourhandle')
                                    ->prefixIcon('heroicon-o-camera'),

                                TextInput::make('social.twitter')
                                    ->label('X / Twitter')
                                    ->url()
                                    ->placeholder('https://x.com/yourhandle')
                                    ->prefixIcon('heroicon-o-chat-bubble-oval-left'),
                            ]),
                    ]),

                Tabs\Tab::make('Video Platforms')
                    ->icon('heroicon-o-play-circle')
                    ->schema([
                        Section::make('Video Platforms')
                            ->description('Your video streaming and short-form content channels.')
                            ->columns(3)
                            ->schema([
                                TextInput::make('social.youtube')
                                    ->label('YouTube')
                                    ->url()
                                    ->placeholder('https://youtube.com/@yourchannel')
                                    ->prefixIcon('heroicon-o-play'),

                                TextInput::make('social.tiktok')
                                    ->label('TikTok')
                                    ->url()
                                    ->placeholder('https://tiktok.com/@yourhandle')
                                    ->prefixIcon('heroicon-o-musical-note'),

                                TextInput::make('social.vimeo')
                                    ->label('Vimeo')
                                    ->url()
                                    ->placeholder('https://vimeo.com/yourchannel')
                                    ->prefixIcon('heroicon-o-film'),
                            ]),
                    ]),

                Tabs\Tab::make('Messaging')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->schema([
                        Section::make('Messaging Platforms')
                            ->description('Your direct messaging and community channels.')
                            ->columns(3)
                            ->schema([
                                TextInput::make('social.whatsapp')
                                    ->label('WhatsApp')
                                    ->url()
                                    ->placeholder('https://wa.me/yournumber')
                                    ->prefixIcon('heroicon-o-phone'),

                                TextInput::make('social.telegram')
                                    ->label('Telegram')
                                    ->url()
                                    ->placeholder('https://t.me/yourhandle')
                                    ->prefixIcon('heroicon-o-paper-airplane'),

                                TextInput::make('social.discord')
                                    ->label('Discord')
                                    ->url()
                                    ->placeholder('https://discord.gg/yourinvite')
                                    ->prefixIcon('heroicon-o-megaphone'),
                            ]),
                    ]),

                Tabs\Tab::make('Professional')
                    ->icon('heroicon-o-briefcase')
                    ->schema([
                        Section::make('Professional Networks')
                            ->description('Your professional and developer profiles.')
                            ->columns(3)
                            ->schema([
                                TextInput::make('social.linkedin')
                                    ->label('LinkedIn')
                                    ->url()
                                    ->placeholder('https://linkedin.com/company/yourcompany')
                                    ->prefixIcon('heroicon-o-building-office'),

                                TextInput::make('social.github')
                                    ->label('GitHub')
                                    ->url()
                                    ->placeholder('https://github.com/yourhandle')
                                    ->prefixIcon('heroicon-o-code-bracket'),

                                TextInput::make('social.dribbble')
                                    ->label('Dribbble')
                                    ->url()
                                    ->placeholder('https://dribbble.com/yourhandle')
                                    ->prefixIcon('heroicon-o-paint-brush'),

                                TextInput::make('social.behance')
                                    ->label('Behance')
                                    ->url()
                                    ->placeholder('https://behance.net/yourhandle')
                                    ->prefixIcon('heroicon-o-swatch'),
                            ]),
                    ]),

                Tabs\Tab::make('Other')
                    ->icon('heroicon-o-ellipsis-horizontal-circle')
                    ->schema([
                        Section::make('Other Platforms')
                            ->description('Additional social media and community profiles.')
                            ->columns(3)
                            ->schema([
                                TextInput::make('social.pinterest')
                                    ->label('Pinterest')
                                    ->url()
                                    ->placeholder('https://pinterest.com/yourhandle')
                                    ->prefixIcon('heroicon-o-bookmark'),

                                TextInput::make('social.snapchat')
                                    ->label('Snapchat')
                                    ->url()
                                    ->placeholder('https://snapchat.com/add/yourhandle')
                                    ->prefixIcon('heroicon-o-face-smile'),

                                TextInput::make('social.threads')
                                    ->label('Threads')
                                    ->url()
                                    ->placeholder('https://threads.net/@yourhandle')
                                    ->prefixIcon('heroicon-o-at-symbol'),

                                TextInput::make('social.reddit')
                                    ->label('Reddit')
                                    ->url()
                                    ->placeholder('https://reddit.com/r/yourcommunity')
                                    ->prefixIcon('heroicon-o-chat-bubble-left-right'),
                            ]),
                    ]),

            ]),
        ]);
    }
}
