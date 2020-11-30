<?php

namespace App\Http\Middleware;

use Closure;

class DefaultResponse
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (is_int($response->original)) {
            return response()->json('', $response->original);
        }

        return $response;
    }
}
