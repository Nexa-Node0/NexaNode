<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostSubscriber extends Model
{
    protected $fillable = [
        'blog_subscriber_id',
        'post_id'
    ];
}
