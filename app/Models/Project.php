<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;
    //
    protected $fillable = [
        'title',
        'code',
        'slug',
        'description',
        'status',
        'priority',
        'start_date',
        'budget_amount',
        'actual_cost',
        'requires_approval',
        'approved_status',
        'approved_at',
        'supervisor_id',
    ];

    protected $casts = [
        'status'            => 'string',
        'priority'          => 'string',
        'start_date'        => 'datetime',
        'budget_amount'     => 'decimal:2',
        'actual_cost'       => 'decimal:2',
        'requires_approval' => 'boolean',
        'approved_status'   => 'string',
        'approved_at'       => 'datetime',
    ];

    //Model attributes
    public function getRouteKeyName()
    {
        return 'slug';
    }

    //booted functions
    public static function booted()
    {
        static::creating(function ($project) {
            if ($project->approved_status === 'approved' && $project->approved_at === null) {
                $project->approved_at = now();
            }
        });

        static::updating(function ($project) {
            if ($project->approved_status === 'approved') {
                if ($project->approved_at === null) {
                    $project->approved_at = now();
                }
            } else {
                $project->approved_at = null;
            }
        });
    }


    // relationships

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function supervisor(){
        return $this->belongsTo(User::class);
    }
}
