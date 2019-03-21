<?php

namespace App\Http\Middleware;

use Closure;

class RefreshSpaceRelations {
    public function handle($request, Closure $next) {
        if ($request->session()->has('space')) {
            $request->session()->get('space')->load('recurrings');
        }

        return $next($request);
    }
}
