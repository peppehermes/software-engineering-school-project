<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class Teachers
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
        if(auth()->user()->roleId == User::roleTeacher || auth()->user()->roleId == User::roleClasscoordinator){
            return $next($request);
        }
        return redirect('home')->with('error','You dont have parent access');
    }
}
