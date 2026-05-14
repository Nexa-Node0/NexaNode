<?php
namespace App\Models;

use App\Enums\TechStacksEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectDetail extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectDetailFactory> */
    use HasFactory, SoftDeletes;

    //defaults
    protected $table = 'project_details';

    protected $fillable = [
        'project_id',
        'client_id',
        'abstract',
        'services',
        'tags',
    ];

    protected $casts = [
        'services' => 'array',
        'tags'     => 'array',
    ];

    //attributes
    public function getConvertTags(): array
    {
        return array_values(array_filter(
            array_map(fn($tag) => TechStacksEnum::tryFrom($tag), $this->tags ?? [])
        ));
    }

    //relationships
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

                                                     //extra
    public static function getCommonServices(): array//register your services here
    {
        return [ //register services here
            'UX Auidit',
            'Product Design',
            'Web Development',
            'Team Extention',
        ];
    }
}
