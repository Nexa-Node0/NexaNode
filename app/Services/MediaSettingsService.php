<?php

namespace App\Services;
use Illuminate\Support\Facades\Schema;
use Outerweb\Settings\Facades\Setting;
use App\Enums\Settings\MediaEnum;
use Illuminate\Support\Facades\Storage;

class MediaSettingsService
{
   
    /**
     * Resolve all media-related settings safely.
     * Falls back to config/defaults if the settings table doesn't exist yet
     * (e.g. on a fresh clone before migrations have run).
     */
    public string $favicon           = MediaEnum::Favicon->value;
    public string $name              = MediaEnum::Name->value;
    public string $description       = MediaEnum::Description->value;
    public string $tagline           = MediaEnum::Description->value;
    public string $lightmodeLogo     = MediaEnum::LightmodeLogo->value;
    public string $darkmodeLogo      = MediaEnum::DarkmodeLogo->value;
    
    public string $maxFileSize       = MediaEnum::MaxFileSize->value;
    public string $maxFiles          = MediaEnum::MaxFiles->value;
    public string $allowedMediaTypes = MediaEnum::AllowMediaTypes->value;
    
    public string $watermarkEnabled  = MediaEnum::WatermarkEnabled->value;
    public string $watermarkImage    = MediaEnum::WatermarkImage->value;
    public string $watermarkPosition = MediaEnum::WatermarkPosition->value;
    public string $watermarkOpacity  = MediaEnum::WatermarkOpacity->value;

    public function resolve(): array
    {
        try {
            // Guard: if the table doesn't exist, skip DB calls entirely.
            if (! Schema::hasTable('settings')) {
                return $this->defaults();
            }
            return [
                    $this->favicon           => Storage::url(Setting::get($this->favicon)),
                    $this->name              => Setting::get($this->name),
                    $this->description       => Setting::get($this->description),
                    $this->tagline           => Setting::get($this->tagline),
                    $this->lightmodeLogo     => Storage::url(Setting::get($this->lightmodeLogo)),
                    $this->darkmodeLogo      => Storage::url(Setting::get($this->darkmodeLogo)),

                    $this->maxFileSize       => Setting::get($this->maxFileSize),
                    $this->maxFiles          => Setting::get($this->maxFiles),
                    $this->allowedMediaTypes => Setting::get($this->allowedMediaTypes),
                    
                    $this->watermarkEnabled  => Setting::get($this->watermarkEnabled),
                    $this->watermarkImage    => Storage::url($this->watermarkImage),
                    $this->watermarkOpacity  => Setting::get($this->watermarkOpacity),
                    $this->watermarkPosition => Setting::get($this->watermarkPosition)
                    
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
           $this->favicon           => null,
           $this->name              => config('app.name'),
           $this->description       => null,
           $this->tagline           => null,
           $this->lightmodeLogo     => null,
           $this->darkmodeLogo      => null,
           
           $this->maxFileSize       => null,
           $this->maxFiles          => null,
           $this->allowedMediaTypes => null,
           
           $this->watermarkEnabled  => null,
           $this->watermarkImage    => null,
           $this->watermarkOpacity  => null,
           $this->watermarkPosition => null
        ];
    }
}
