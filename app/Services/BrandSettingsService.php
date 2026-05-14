<?php

namespace App\Services;
use Illuminate\Support\Facades\Schema;
use Outerweb\Settings\Facades\Setting;
class BrandSettingsService
{
   
    /**
     * Resolve all brand-related settings safely.
     * Falls back to config/defaults if the settings table doesn't exist yet
     * (e.g. on a fresh clone before migrations have run).
     */
    public function resolve(): array
    {
        try {
            // Guard: if the table doesn't exist, skip DB calls entirely.
            if (! Schema::hasTable('settings')) {
                return $this->defaults();
            }
 
            return [
                'brand_logo'       => Setting::get('general.brand_logo'),
                'dark_mode_logo'   => Setting::get('general.dark_mode_brand_logo'),
                'favicon'          => Setting::get('general.favicon'),
                'brand_name'       => Setting::get('general.brand_name', config('app.name')),
                'panel_background' => Setting::get('general.admin_empty_panel_background'),
            ];
        } catch (\Throwable $e) {
            // Catches any unexpected DB/driver errors during boot.
            return $this->defaults();
        }
    }
 
    /**
     * Safe defaults used when the settings table is unavailable.
     */
    private function defaults(): array
    {
        return [
            'brand_logo'       => null,
            'dark_mode_logo'   => null,
            'favicon'          => null,
            'brand_name'       => config('app.name'),
        ];
    }
}
