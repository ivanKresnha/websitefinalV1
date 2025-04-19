<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Gate;

class AuthGates
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()) {
            $roles = Role::with('permissions')->get();
            $permissions = [];
    
            foreach ($roles as $role) {
                foreach ($role->permissions as $permission) {
                    $permissions[$permission->name][] = $role->id;
                }
            }
    
            foreach ($permissions as $name => $roles) {
                Gate::define($name, function ($user) use ($roles) {
                    return in_array($user->role_id, $roles);
                });
            }
        }
    
        return $next($request);
    }
    
}
