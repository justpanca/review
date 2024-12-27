<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Role;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        $roleAdmin = Role::where('name', 'admin')->first();

        if ($user->role_id != $roleAdmin->id) {

            return response ([
                "message" => "anda tidak boleh mengakses ini karena bukan admin",
                "user" => $user,
            ],403);
        }

        return $next($request);
    }
}
