<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class Localization
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
        $locale = $request->header('Localization');
        if (!$locale) {
            // take the default local language
            $locale = Config::get('app.locale');
        }
        App::setLocale($locale);
        return $next($request);
    }
}
