<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;
use Override;

enum NavigationOptions : string implements HasLabel
{
    case FilamentShield   = 'Filament Shield';
    case HR               = 'HR';
    case Inventory        = 'Inventory';
    case Blog             = 'Blog';
    case Location         = 'Location';
    case Settings         = 'Settings';

 
    public static function getNavigations(): array{
        return array_map(fn($case) => $case->getLabel(), self::cases());
    }

    #[Override]
    public function getLabel(): string|Htmlable|null
    {
        return match ($this){
            self::FilamentShield => 'Filament Shield',
            self::HR             => 'Work Management',
            self::Inventory      => 'Products Inventory',
            self::Blog           => 'Blogs Management',
            self::Location       => 'Location Registration',
            self::Settings       => 'Settings'
        };
    }
}
