<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    protected $fillable = [
        "title",
        "slug",
        "content",
        "thumbnail",
        "is_headline",
        "tags",
        "status",
        "published_date",
        "user_id",
        "post_category_id",
    ];


    protected $casts = [
        "tags"           => "array",
        "published_date" => "date",
        "status"         => \App\Enums\PostStatus::class,
    ];


    public function adminBasePath(): string
    {
        return 'blog/posts';
    }

    public function user()
    {
        return $this->belongsTo(User::class)->role('author');
    }

    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }

    public function published()
    {
        return $this->where('status', '=', 'Published')->all();
    }

    public function un_published()
    {
        return $this->where('status', '=', 'Unpublished')->all();
    }

    public function drafts()
    {
        return $this->where('status', '=', 'draft')->all();
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
