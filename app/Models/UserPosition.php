<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserPosition extends Model
{
    /** @use HasFactory<\Database\Factories\UserPositionFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'position_id',
    ];

    // public function myPosition(): HasMany{
    //     return $this->hasMany()
    // }
}
