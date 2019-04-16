<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfNotDataAnalyst
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        if (is_null($request->user())) {
            return redirect('login');
        }

        if (!$request->user()->isDataAnalyst()) {

            return redirect('login');
        }

        return $next($request);
    }
}
