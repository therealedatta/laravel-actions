<?php

namespace Therealedatta\LaravelActions\Tests\TestSupport;

use Closure;
use Illuminate\Http\Request;

class IsAuthorizedMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->get('authorized', false)) {
            abort(403, 'Unauthorized from the middleware');
        }

        return $next($request);
    }
}
