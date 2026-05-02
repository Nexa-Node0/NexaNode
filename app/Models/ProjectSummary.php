<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectSummary extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectSummaryFactory> */
    use HasFactory;

    protected $table = 'project_summaries';

    protected $fillable = [
        'project_id',
        'description',
        'goals',
    ];

    //relationships
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
