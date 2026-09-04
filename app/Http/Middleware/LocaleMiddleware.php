<?php

namespace App\Http\Middleware;

use Closure;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $targetLocale = config('app.locale', 'pt_BR');

        if ($request->user() && ! empty($request->user()->locale) && $request->user()->locale !== 'en') {
            $targetLocale = $request->user()->locale;
        }

        app()->setLocale($targetLocale);

        return $next($request);
    }
}
