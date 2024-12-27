<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // $roleAdmin = Role::where('name', 'admin')->first();

        if (!$user->email_verified_at) {

            return response ([
                "message" => "user belum verifikasi",
                "user" => $user,
            ],403);
        }

        return $next($request);
    }
}
