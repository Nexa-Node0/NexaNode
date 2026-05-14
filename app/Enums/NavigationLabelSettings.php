<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;
use Override;

enum NavigationLabelSettings : string implements HasLabel {

    case General = 'General';
    case Social  = 'Social Links';
    case Mail    = 'Mail';
    case SEO     = 'SEO';
    case Media   = 'Media';

    #[Override]
    public function getLabel(): string
    {
        return match ($this) {
            self::General   => 'General',
            self::Social    => 'Social',
            self::Mail      => 'Mail',
            self::SEO       => 'SEO',
            self::Media     => 'Media'
        };
    }

    public function getSubHeader(): string {
        return match ($this){
            self::General  => 'Manage your brand identity, contact details, and system preferences.',
            self::Social   => 'Connect your social media profiles to your site.',
            self::Mail     => 'Configure your outgoing mail server and sender details.',
            self::SEO      => 'Optimize your site visibility for search engines and social sharing.',
            self::Media    => 'Manage your branding assets and file upload rules.'
        };
    }
}
