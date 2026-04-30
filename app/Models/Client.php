<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;
    //
    protected $table = 'clients';

    protected $fillable = [
        'name',
        'email',
        'contact_number',
        'address',
    ];

    public function projectDetails(): HasMany
    {
        return $this->hasMany(ProjectDetail::class);
    }

    public function projects(): HasManyThrough
    {
        return $this->hasManyThrough(
            Project::class,       // final model
            ProjectDetail::class, // intermediate
            'client_id',          // FK on project_details → clients.id
            'id',                 // PK on projects
            'id',                 // PK on clients
            'project_id'          // FK on project_details → projects.id
        );
    }

}
