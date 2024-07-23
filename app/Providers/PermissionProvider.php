<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class PermissionProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        Blade::if('permission', function ($department, $permission = null) {
            $user = Auth::user();

            if ($user->department->type === $department) {
                return true;
            }
            
            if ($permission) {
                return $user->department->type === $department &&
                    $user->roles->first(function ($value) use ($permission) {
                        return $value->permissions->contains('name', $permission);
                    });
            }

            return Auth::user()->can($department);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        
    }
}
