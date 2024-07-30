<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'users';

    protected $guarded = [];

    // public function roles(): BelongsToMany
    // {
    //     return $this->belongsToMany(Role::class, 'user_role');
    // }

    // public function hasPermission($permission): bool
    // {
    //     foreach ($this->roles as $role) {
    //         if ($role->hasPermission($permission)) {
    //             return true;
    //         }
    //     }

    //     return false;
    // }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    public function hasRole($role): bool
    {
        return $this->roles->contains('name', $role);
    }

    public function commissionBonus()
    {
        return $this->hasMany(CommissionBonus::class, 'user_id');
    }
    public function commission()
    {
        return $this->hasOne(Commission::class, 'id');
    }
}
