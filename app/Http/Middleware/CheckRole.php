<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (Auth::user()->role !== $role) {
            return response()->json([
                'message' => 'Accès refusé : rôle insuffisant',
            ], 403);
        }

        return $next($request);
    }
}
