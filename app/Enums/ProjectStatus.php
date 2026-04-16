<?php
namespace App\Enums;

use App\Helpers\EnumHelper;

enum ProjectStatus: string {
    case Completed  = 'completed';
    case OnProgress = 'on_progress';
    case Archived   = 'archived';
    case Pending    = 'pending';
    case Cancelled  = 'cancelled';
    case Failed     = 'failed';
    case Draft      = 'draft';

    public function icon(): string
    {
        return match ($this) {
            self::Completed  => 'heroicon-m-check-circle',
            self::OnProgress => 'heroicon-m-arrow-path',
            self::Archived   => 'heroicon-m-archive-box',
            self::Pending    => 'heroicon-m-clock',
            self::Cancelled  => 'heroicon-m-x-circle',
            self::Failed     => 'heroicon-m-exclamation-triangle',
            self::Draft      => 'heroicon-m-pencil-square',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Completed  => 'success',
            self::OnProgress => 'info',
            self::Archived   => 'gray',
            self::Pending    => 'warning',
            self::Cancelled  => 'danger',
            self::Failed     => 'danger',
            self::Draft      => 'secondary',
        };
    }

    public static function toArray(): array
    {
        return EnumHelper::toArray(self::class);
    }
}
