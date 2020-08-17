<?php

namespace App\Http\Middleware;

use Closure;

class CheckRequestFields
{
    public $attributes;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $website = $request->query('website');
        $email = $request->query('email');

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            return response('Invalid email format' , 404);
        }

        if (filter_var($website, FILTER_VALIDATE_URL) === false) {;
            return response('Invalid url format' , 404);
        }

        return $next($request);
    }
}
