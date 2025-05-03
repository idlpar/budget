<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // Debug: Check if user is admin
        Log::info('Checking if user is admin', [
            'user_id' => $user->id,
            'is_admin' => $user->is_admin
        ]);

        if (! $user) {
            Log::warning('Unauthorized access attempt: User not authenticated', [
                'url' => $request->url(),
                'ip' => $request->ip(),
            ]);
            abort(401, 'Authentication required.');
        }

        if (! $user->isAdmin()) {
            Log::warning('Unauthorized access attempt to admin route', [
                'user_id' => $user->id,
                'url' => $request->url(),
                'ip' => $request->ip(),
            ]);
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }

}
