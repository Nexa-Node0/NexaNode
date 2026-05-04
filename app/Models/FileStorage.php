<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileStorage extends Model
{
    /** @use HasFactory<\Database\Factories\FileStorageFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'file_storages';

    protected $fillable = [
        'fileable_name',
        'fileable_id',
        'disk',
        'path',
        'type',
        'original_name',
        'mime_type',
        'size',
        'title',
        'description',
        'visibility',
        'order_column',
    ];

    //relationship  morph relation
    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }
}
