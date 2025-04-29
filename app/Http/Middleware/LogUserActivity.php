<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogUserActivity
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (Auth::check()) {
            Log::info('User Activity', [
                'user_id' => Auth::id(),
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
            ]);
        }

        return $response;
    }
}
