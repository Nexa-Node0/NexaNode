<?php
namespace App\Enums;

enum ApprovedStatus: string {
    //
    case Approved = 'approved';
    case Pending  = 'pending';
    case Rejected = 'rejected';

    public function icon(){
        return match($this){
            self::Approved => 'heroicon-m-check-circle',
            self::Pending  => 'heroicon-m-clock',
            self::Rejected => 'heroicon-m-x-circle'
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Approved => 'success',
            self::Pending  => 'info',
            self::Rejected => 'danger'
        };
    }

}
