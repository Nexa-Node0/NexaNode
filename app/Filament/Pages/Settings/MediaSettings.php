<?php

namespace App\Filament\Pages\Settings;

use Outerweb\FilamentSettings\Pages\Settings;
use App\Enums\NavigationOptions;
use App\Enums\NavigationLabelSettings;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;
use App\Enums\Settings\MediaEnum;
use Override;
use UnitEnum;

class MediaSettings extends Settings
{

    protected static ?string $navigationLabel = NavigationLabelSettings::Media->value;
    protected static string|UnitEnum|null $navigationGroup = NavigationOptions::Settings;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Photo;

    #[Override]
    public function getTitle(): string|Htmlable
    {
        return NavigationLabelSettings::Media->getLabel();
    }

    #[Override]
    public function getSubheading(): string|Htmlable|null
    {
        return NavigationLabelSettings::Media->getSubHeader();
    }
    #[Override]
    public static function canAccess(): bool
    {
        $user = filament()->auth()->user();
        return $user instanceof \App\Models\User && $user->can('view_settings');
    }

    #[Override]
    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make()->columnSpanFull()->tabs([
                Tabs\Tab::make('Basic Details')
                    ->icon(Heroicon::Bars3CenterLeft)
                    ->schema([
                        TextInput::make(MediaEnum::Name->value)
                            ->label('Brand')
                            ->required()
                            ->default('My App')
                            ->columnSpan(2)
                            ->placeholder('My Application'),

                        TextInput::make(MediaEnum::Tagline->value)
                            ->label('Tagline')
                            ->columnSpan(1),

                        RichEditor::make(MediaEnum::Description->value)
                            ->label('Description')
                            ->columnSpanFull(),

                        FileUpload::make(MediaEnum::Favicon->value)
                            ->label('Favicon')
                            ->required()
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('favicon')
                            ->imageEditorAspectRatioOptions([
                                null,
                                '1:1',
                                '4:4',
                                '16:16'
                            ]),

                        FileUpload::make(MediaEnum::LightmodeLogo->value)
                            ->label('Light mode logo')
                            ->required()
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('logos')
                            ->imageEditorAspectRatioOptions([
                                null,
                                '1:1',
                                '4:4',
                                '16:16'
                            ]),

                        FileUpload::make(MediaEnum::DarkmodeLogo->value)
                            ->label('Darkmode mode logo')
                            ->required()
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('logos')
                            ->imageEditorAspectRatioOptions([
                                null,
                                '1:1',
                                '4:4',
                                '16:16'
                            ]),
                    ])->columns(3),

                Tabs\Tab::make('Upload Rules')
                    ->icon(Heroicon::ExclamationTriangle)
                    ->schema([
                        TextInput::make(MediaEnum::MaxFileSize->value)
                            ->label('Max File Size (KB)')
                            ->numeric(),
                        TextInput::make(MediaEnum::MaxFiles->value)
                            ->label('Max File Upload')
                            ->numeric(),
                        Select::make(MediaEnum::AllowMediaTypes->value)
                            ->label('Allowed Types')
                            ->multiple()
                            ->options([
                                'images/jpeg'     => 'JPEG',
                                'image/png'       => 'PNG',
                                'image/webp'      => 'WebP',
                                'image/gif'       => 'GIF',
                                'image/svg+xml'   => 'SVG',
                                'application/pdf' => 'PDF',
                            ])
                    ])->columns(3),

                Tabs\Tab::make('Watermark')
                    ->icon(Heroicon::Camera)
                    ->schema([
                        Toggle::make(MediaEnum::WatermarkEnabled->value)
                            ->label('Enable Watermark'),

                        FileUpload::make(MediaEnum::WatermarkImage->value)
                            ->label('Watermark Image')
                            ->image()
                            ->imageEditor()
                            ->directory('watermark')
                            ->disk('public'),

                        Select::make(MediaEnum::WatermarkPosition->value)
                            ->label('Watermark Position')
                            ->options([
                                'top-left'     => 'Top Left',
                                'top-right'    => 'Top Right',
                                'center'       => 'Center',
                                'bottom-left'  => 'Bottom Left',
                                'bottom-right' => 'Bottom Right',
                            ])
                            ->default('bottom-right'),

                        TextInput::make(MediaEnum::WatermarkOpacity->value)
                            ->label('Opacity')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(100)
                            ->default(50)
                    ])->columns(2)
            ])
        ]);
    }
}
