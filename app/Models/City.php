<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
    protected $fillable = [
        'name',
        'state_id',
        'psgc_code'
    ];

    public function state(){
        return $this->belongsTo(State::class);
    }

    public function barangays(){
        return $this->hasMany(Barangay::class);
    }
}
