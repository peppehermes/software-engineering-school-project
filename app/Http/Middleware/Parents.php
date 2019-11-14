<?php

namespace App\Http\Middleware;

use Closure;

class Parents
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
        if(auth()->user()->roleId == 3){
            return $next($request);
        }
        return redirect('home')->with('error','You dont have parent access');
    }
}
