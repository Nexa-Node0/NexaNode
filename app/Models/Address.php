<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //
    protected $fillable = [
        'user_id',
        'country_id',
        'state_id',
        'city_id',
        'postal_code',
        'line1',
        'line2',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    protected static function booted()
    {
        static::saving(function ($address) {
            if ($address->is_default) {
                Address::where('user_id', $address->user_id)
                    ->where('id', '!=', $address->id)
                    ->update(['is_default' => false]);
            }
        });
    }

    //relation
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employee()
    {
        return $this->hasOneThrough(
            Employee::class, // final model
            User::class,     // intermediate
            'id',            // Foreign key on users table...
            'user_id',       // Foreign key on employees table...
            'user_id',       // Local key on addresses table...
            'id'             // Local key on users table...
        );
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
