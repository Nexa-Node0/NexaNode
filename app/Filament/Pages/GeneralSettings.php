<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Outerweb\FilamentSettings\Pages\Settings;
class GeneralSettings extends Settings
{
    protected string $view = 'filament.pages.general-settings';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Cog6Tooth;
    protected static ?string $navigationLabel = 'Settings';

    public function form(Schema $schema): Schema
    {
        return parent::form($schema);
    }
}
