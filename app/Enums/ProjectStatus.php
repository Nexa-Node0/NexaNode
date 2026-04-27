<?php
namespace App\Enums;

enum ProjectStatus: string {
    //
    case Completed  = 'completed';
    case OnProgress = 'on_progress';
    case Archived   = 'archived';
    case Pending    = 'pending';
    case Cancelled  = 'cancelled';
    case Failed     = 'failed';
    case Draft      = 'draft';

    public function label(): string
    {
        $string = $this->name;

        $re    = '/(?<=[a-z])(?=[A-Z])|(?<=[A-Z])(?=[A-Z][a-z])/';
        $parts = preg_split($re, $string);

        return ucwords(implode(' ', $parts));
    }

    public function icon(): string
    {
        $pre = 'heroicon-m-';

        return $pre . match ($this) {
            self::Completed  => 'check-circle',
            self::OnProgress => 'arrow-path',
            self::Pending    => 'clock',
            self::Cancelled  => 'x-circle',
            self::Failed     => 'exclamation-circle',
            self::Draft      => 'document',
            self::Archived   => 'archive-box',
            default          => 'minus-circle'
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Completed  => 'success',
            self::OnProgress => 'info',
            self::Pending    => 'warning',
            self::Cancelled  => 'danger',
            self::Failed     => 'danger',
            self::Draft      => 'gray',
            self::Archived   => 'gray',
            default          => 'gray'
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }

}
