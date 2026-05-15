<?php

namespace App\Providers\Filament;

use App\Services\MediaSettingsService;
use Filament\Panel;
use Filament\PanelProvider;
use App\Enums\Settings\MediaEnum;
abstract class BasePanelProvider extends PanelProvider 
{


    protected function applySettings(Panel $panel): Panel {
        return $this->appyMediaSetting($panel);
    }

    protected function appyMediaSetting(Panel $panel): Panel 
    {
        $media = app(MediaSettingsService::class)->resolve();   

        $panel->favicon($media[MediaEnum::Favicon->value]);
        $panel->brandName($media[MediaEnum::Name->value]);
        $panel->brandLogo($media[MediaEnum::LightmodeLogo->value]);
        $panel->darkModeBrandLogo($media[MediaEnum::DarkmodeLogo->value]);
        

        return $panel;
    }
}