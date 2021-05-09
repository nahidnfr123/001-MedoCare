<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CheckOnlineDoctor
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
        if(Auth::check() && Auth::user()->role()->pluck('name')->first() === 'Doctor'){
                $expiresAt = Carbon::now()->addMinutes(1);
                /*Cache::put('(user-is-online))', 'value', 1440);*/
                Cache::put('doctor-is-online-'. Auth::user()->doctor->id, true, $expiresAt);
            }
        return $next($request);
    }
}
