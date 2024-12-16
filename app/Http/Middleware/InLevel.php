<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class InLevel
{

    protected $route;

    public function __construct(Route $route)
    {
        $this->route = $route;
    }



    public function handle(Request $request, Closure $next, $levels)
    {
        if (!Auth::check()) {
            return redirect()->route('403');
        }

       
        $user = Auth::user();

        if (in_array($user->level, explode('.', $levels))) {
           
            return $next($request);
        }
       
        return redirect()->route('403');
    }
}
