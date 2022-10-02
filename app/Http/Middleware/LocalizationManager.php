<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocalizationManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->hasSession('local')) {
           App::setLocale(session()->get('local'));
           return $next($request);

        }
      if (isset($request->local)) {
       App::setLocale($request->local);
       return $next($request);

      }
      App::setLocale(config('app.fallback_locale'));
        return $next($request);
    }
}
