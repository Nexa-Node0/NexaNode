<?php
namespace App\Enums;

enum ProductStatusEnum: string {
    case Active        = 'active';
    case Returned      = 'returned';
    case Lost          = 'lost';
    case DestroyedDame = 'destroyed';

    public function label(): string
    {
        return ucwords(implode(' ', preg_split('/(?=[A-Z])/', $this->name)));
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(
            fn($item) => [$item->label() => $item->value]
        )->toArray();
    }
}
