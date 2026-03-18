<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    //
    protected $table = 'employees';

    protected $fillable = [
        // 'user_id',
        'avatar',
        'firstname',
        'lastname',
        'extension',
        'gender',
        'phone',
        'last_seen',
        'is_supervisor',
        'salary',
        'type',
        'hire_date',
    ];

    protected $casts = [
        'last_seen'     => 'datetime',
        'is_supervisor' => 'boolean',
        'salary'        => 'decimal:2',
        'hire_date'     => 'datetime',
    ];

    //connections

    //belong
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Attribute functions
    public function getIsActiveAttribute()
    {
        return $this->last_seen?->diffInMinutes(now()) < 5;
    }

    public function getFullnameAttribute(){
        $fname = $this->firstname;
        $lname = $this->lastname;

        $fullname = $fname . ' ' . $lname;
        if($this->suffix !== null)
            $fullname = $fullname . ' ' . $this->suffix;

        return ucwords($fullname);
    }
}
