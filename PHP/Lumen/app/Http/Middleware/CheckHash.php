<?php

namespace App\Http\Middleware;

use Closure;
use App\DataForSeoCache;

class CheckHash
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $hash = $request->query('hash_id');
        if (!$hash) {
            return response('no hash', 301);
        }
        return $next($request);
    }

}
