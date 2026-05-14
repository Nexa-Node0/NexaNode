<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Database\Factories\BlogSubscriberFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogSubscriber extends Model
{
       /** @use HasFactory<BlogSubscriberFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'can_receive_updates'
    ];

    protected $casts = [
        'can_receive_updates' => 'boolean',
    ];
}
