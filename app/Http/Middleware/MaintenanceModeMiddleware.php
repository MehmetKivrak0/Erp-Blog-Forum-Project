<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;

class MaintenanceModeMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Cache::get('maintenance_mode_active', false)) {
            // Let administrators, developers, and moderators bypass maintenance mode
            if (auth()->check()) {
                $user = auth()->user();
                $userRole = is_object($user->role) ? $user->role->value : $user->role;
                if (in_array($userRole, ['admin', 'developer', 'moderator'])) {
                    return $next($request);
                }
            }

            abort(503, 'Sistemimiz şu anda bakım modundadır. Lütfen daha sonra tekrar deneyiniz.');
        }

        return $next($request);
    }
}
