<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Facades\Storage;
use Jeffgreco13\FilamentBreezy\Concerns\Plugin\HasPasskeys;
use Jeffgreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Override;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasAvatar, MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;
    use TwoFactorAuthenticatable;
    use HasApiTokens;
    use HasPasskeys;
    use HasRoles;
    use HasPanelShield;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'avatar_url',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'gender'            => 'enum',
            'salary'            => 'decimal',
            'type'              => 'enum',
            'hire_date'         => 'datetime',
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return match ($panel->getId()) {
            'admin' => $this->hasAnyRole(Role::all()->pluck('name')->toArray()),

            default => false
        };
    }

    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class);
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function project(): HasMany //same as handledproject
    {
        return $this->hasMany(Project::class, 'supervisor_id');
    }

    public function handledProjects(): HasMany //same as project better naming
    {
        return $this->hasMany(Project::class, 'supervisor_id');
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    public function position(): HasOneThrough
    {
        return $this->hasOneThrough(
            \App\Models\Position::class,
            \App\Models\UserPosition::class,
            'user_id',
            'id',
            'id',
            'position_id'
        );
    }

    public function isSupervisor(): bool
    {
        return $this->supervisedProjects()->exists();
    }

    public function supervisedProjects(): HasMany
    {
        return $this->hasMany(Project::class, 'supervisor_id');
    }

    #[Override]
    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ? Storage::url($this->avatar_url) : null;
    }

    public function possessions(): HasMany
    {
        return $this->hasMany(ProductPossession::class, 'current_owner');
    }
}
