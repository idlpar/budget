<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user() || !$request->user()->isAdmin()) {
            Log::info('Unauthorized access to admin route', ['user_id' => $request->user() ? $request->user()->id : null]);
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
