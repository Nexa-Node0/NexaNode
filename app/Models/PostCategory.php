<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostCategory extends Model
{
    /** @use HasFactory<\Database\Factories\PostCategoryFactory> */
    use HasFactory;
    
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_visible'    
    ];


    protected $casts = [
        'is_visible' => 'boolean'
    ];
    
    public function posts(): HasMany{
        return $this->hasMany(Post::class);
    }
}
