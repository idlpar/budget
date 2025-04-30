<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogRedirects
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof \Illuminate\Http\RedirectResponse) {
            Log::info('Redirect detected', [
                'from' => $request->fullUrl(),
                'to' => $response->getTargetUrl(),
                'status' => $response->getStatusCode(),
                'user_id' => auth()->id(),
                'intended' => session()->get('url.intended'),
            ]);
        }

        return $response;
    }
}
