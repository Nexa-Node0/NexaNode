<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Position extends Model
{
    /** @use HasFactory<\Database\Factories\PositionFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'code',
        'level',
        'type',
        'max_headcount',
        'department_id',
        'reports_to',
        'is_active',
        'description',
        'permissions',
    ];

    protected $casts = [
        'permissions' => 'array'
    ];


    public function users(): void {}

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'reports_to');
    }

    public function vacancies(): void {}
}
