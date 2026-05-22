<?php
namespace App\Enums;

enum ProductStatusEnum: string {
    case Active    = 'active';
    case Returned  = 'returned';
    case Lost      = 'lost';
    case Destroyed = 'destroyed';

    public function color(): ?string
    {
        foreach ($this->getColors() as $color => $cases) {
            if (in_array($this, $cases)) {
                return $color;
            }
        }

        return 'primary';
    }

    public function label(): string
    {
        return ucwords(implode(' ', preg_split('/(?=[A-Z])/', $this->name)));
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(
            fn($item) => [$item->value => $item->label()]
        )->toArray();
    }

    private function getColors(): array// register your colors here
    {
        return [
            'success' => [
                self::Active,
            ],
            'danger'  => [
                self::Lost,
            ],
            'warning' => [
                self::Destroyed,
            ],
            'info'    => [
                self::Returned,
            ],
            'grey'    => [],
            'primary' => [],
        ];
    }
}
