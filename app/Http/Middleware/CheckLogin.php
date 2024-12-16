<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class CheckLogin
{

    protected $route;

    public function __construct(Route $route)
    {
        $this->route = $route;
    }



    public function handle(Request $request, Closure $next, $model, $url = '403')
    {
        switch ($model) {
            case 'any':
                if (Auth::guard('client')->check() || Auth::check()) {
                    return $next($request);
                }
                break;
            case 'client':
                if (!Auth::guard('client')->check()) {
                    return redirect()->route('403');
                } else {
                    return $next($request);
                }
                break;
            case 'user':
                if (!Auth::check()) {
                    return redirect()->route($url);
                } else {
                    return $next($request);
                }
                break;

            default:
                if (Auth::guard('client')->check() || Auth::check()) {
                    return $next($request);
                }
                break;
        }


        return redirect('/login')->withInput(['url' => $this->route->getName()]);
    }
}
