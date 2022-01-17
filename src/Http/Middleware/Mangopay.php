<?php

namespace Webkul\MangoPay\Http\Middleware;

use Closure;

class Mangopay
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
        $themes = app('themes');
        $channel = core()->getCurrentChannel();

        if (! core()->getConfigData('mangopay.general.general.active')) {
            abort(404);
        } 

        return $next($request);
    }
}