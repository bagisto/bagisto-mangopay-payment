<?php

namespace Webkul\MangoPay\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Mangopay
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! core()->getConfigData('sales.payment_methods.mangopay_standard.active')) {
            abort(404);
        }

        return $next($request);
    }
}
