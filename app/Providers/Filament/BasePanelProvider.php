<?php

namespace App\Providers\Filament;

use App\Services\BrandSettingsService;
use Filament\Panel;
use Filament\PanelProvider;

abstract class BasePanelProvider extends PanelProvider 
{

    protected function applyBrandSettings(Panel $panel): Panel 
    {
        $settings = app(BrandSettingsService::class)->resolve();

        if($settings['brand_name']){
            $panel->brandName($settings['brand_name']);
        }

         if ($settings['brand_logo']) {
            $panel->brandLogo($settings['brand_logo']);
        }
 
        if ($settings['dark_mode_logo']) {
            $panel->darkModeBrandLogo($settings['dark_mode_logo']);
        }
 
        if ($settings['favicon']) {
            $panel->favicon($settings['favicon']);
        }

        return $panel;

    }

}