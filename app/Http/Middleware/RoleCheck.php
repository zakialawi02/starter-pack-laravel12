<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleCheck
{
    /**
     * Handle an incoming request and check if the authenticated user's role is authorized.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = Auth::user();

        if (! $user) {
            abort(Response::HTTP_UNAUTHORIZED);
        }

        $allowedRoles = collect($roles)
            ->map(fn (string $role) => UserRole::tryFrom($role))
            ->filter()
            ->all();

        $hasAccess = $user->role instanceof UserRole
            ? in_array($user->role, $allowedRoles, true)
            : in_array($user->role, array_map(static fn (UserRole $role) => $role->value, $allowedRoles), true);

        if (! $hasAccess) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
