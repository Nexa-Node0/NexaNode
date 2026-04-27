<?php
namespace App\Models;

use App\Enums\ApprovedStatus;
use App\Enums\Priority;
use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Project extends Model
{
    use SoftDeletes, HasFactory;

    //default
    protected $table = 'projects';

    protected $fillable = [
        'title',
        'slug',
        'code',
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
        'status'          => ProjectStatus::class,
        'priority'        => Priority::class,
        'start_date'      => 'datetime',
        'budget_amount'   => 'decimal:2',
        'actual_cost'     => 'decimal:2',
        'approved_status' => ApprovedStatus::class,
        'approved_at'     => 'datetime',
    ];

    //booted functions, for slug and approved date
    protected static function booted()
    {
        static::creating(function ($project) {
            $project->slug = self::generateSlug($project->title);

            if ($project->approved_status === ApprovedStatus::Approved) {
                $project->approved_at = now();
            }
        });

        static::updating(function ($project) {

            if ($project->isDirty('title')) {
                $project->slug = self::generateSlug($project->title, $project->id);
            }

            if ($project->approved_status === ApprovedStatus::Approved) {
                if ($project->isDirty('status')) {
                    $project->approved_at = now();
                }
            } else {
                $project->approved_at = null;
            }
        });
    }

    private static function generateSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug     = $baseSlug;
        $count    = 1;

        while (
            Project::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = $baseSlug . '-' . $count++;
        }

        return $slug;
    }

    //relationships
    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
