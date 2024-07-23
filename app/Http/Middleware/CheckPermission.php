<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle($request, Closure $next, $department, $permission)
    {
        $user = Auth::user();

        if (
            $user->department->type === $department &&
            $user->roles->first(function ($value) use ($permission) {
                return $value->permissions->contains('name', $permission);
            })
        ) {
            return $next($request);
        }

        return back()->with(['status_failed' => trans('message.not_permission')]);
    }
}
