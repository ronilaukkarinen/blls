<?php

namespace App\Http\Middleware;

use Closure;

class RefreshSpaceRelations {
    public function handle($request, Closure $next) {
        return $next($request);
    }
}
