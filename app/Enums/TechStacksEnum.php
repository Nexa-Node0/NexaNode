<?php
namespace App\Enums;

enum TechStacksEnum: string {
    //
    case TAILWIND   = 'tailwind';
    case LARAVEL    = 'laravel';
    case JAVASCRIPT = 'javascript';
    case HTML       = 'html';
    case PHP        = 'php';
    case FILAMENT   = 'filament';
    case BOOTSTRAP  = 'bootstrap';

    public function label(): string
    {
        return match ($this) {

            self::TAILWIND   => 'Tailwind',
            self::LARAVEL    => 'Laravel',
            self::JAVASCRIPT => 'JavaScript',
            self::HTML       => 'HTML',
            self::PHP        => 'PHP',
            self::FILAMENT   => 'Filament',
            self::BOOTSTRAP  => 'Bootstrap',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
