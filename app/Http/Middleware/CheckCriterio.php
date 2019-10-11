<?php

namespace App\Http\Middleware;

use Closure;

class CheckCriterio
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
        $criterios = array_slice(func_get_args(), 2);

        dd(Proyecto()->proyecto()->hasCriterios($criterios));

       if ( Proyecto()->proyecto()->hasCriterios($criterios) ) {
            return $next($request);
        }
        return $next($request);
    }
}
