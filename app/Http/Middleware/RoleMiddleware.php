<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403, 'Akses ditolak.');
        }

        $allowedRoles = array_map('strtoupper', $roles);
        $userRole = strtoupper((string) $user->role);

        if (! in_array($userRole, $allowedRoles, true)) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
