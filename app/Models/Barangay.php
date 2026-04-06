<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    //
    protected $fillable = [
        'name',
        'city_id',
        'pscg_code',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
