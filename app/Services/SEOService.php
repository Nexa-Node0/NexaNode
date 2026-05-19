<?php

namespace App\Services;

use App\Enums\Settings\SEOEnum;

class SEOService
{
    public function metaTitle(): string
    {
        return setting(SEOEnum::MetaTitle->value, config('app.name'));
    }
    public function metaDescription(): ?string
    {
        return setting(SEOEnum::MetaDescription->value);
    }

    public function ogImage(): ?string
    {
        return setting(SEOEnum::OGImage->value);
    }

    public function googleAnalyticsId(): ?string
    {
        return setting(SEOEnum::GoogleAnalyticsID->value);
    }

    public function isIndexingEnabled(): bool
    {
        return (bool) setting(SEOEnum::Index->value, true);
    }

    // Return all as an array at once (useful for passing to views)
    public function all(): array
    {
        return [
            'meta_title'       => $this->metaTitle(),
            'meta_description' => $this->metaDescription(),
            'og_image'         => $this->ogImage(),
            'analytics_id'     => $this->googleAnalyticsId(),
            'indexing'         => $this->isIndexingEnabled(),
        ];
    }
}
