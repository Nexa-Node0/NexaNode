<?php
namespace App\Models;

use App\Enums\Priority;
use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'slug',
        'due_date',
        'completed_at',
        'assigned_to',
        'project_id',
        'status',
        'priority',
    ];

    protected $casts = [
        'due_date'     => 'datetime',
        'completed_at' => 'datetime',
        'status'       => ProjectStatus::class,
        'priority'     => Priority::class,
    ];

    //inclusion
    public $with = [
        'project',
        'user',
    ];

    //before database
    protected static function booted()
    {
        static::creating(function ($task) {
            $task->slug = self::generateSlug($task->title, $task->project_id);

            if ($task->status === ProjectStatus::Completed) {
                $task->completed_at = now();
            }
        });

        static::updating(function ($task) {
            if ($task->isDirty('title')) {
                $task->slug = self::generateSlug($task->title, $task->project_id, $task->id);
            }

            if ($task->status === ProjectStatus::Completed) {
                    if ($task->isDirty('status')) {
                        $task->completed_at = now();
                    }
            } else {
                $task->completed_at = null;
            }
        });
    }

    private static function generateSlug(string $title, int $projectId, ?int $ignoredId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug     = $baseSlug;
        $count    = 1;

        while (
            Task::where(function ($query) use ($projectId, $slug) {
                $query->where('project_id', $projectId)
                ->where('slug', $slug);
            })
            ->when($ignoredId, fn($q) => $q->where('id', '!=', $ignoredId))
            ->exists()
        ) {
            $slug = $baseSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    //relation
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
