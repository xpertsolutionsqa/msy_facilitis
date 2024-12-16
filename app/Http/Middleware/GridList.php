<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GridList
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $view = $request->input('v');

        if ($view) {    
            $request->session()->put('view', $view);
        } else {
           
            $view = $request->session()->get('view', 'grid');  
        }
        $gridactive = $view == 'grid' ? 'active' : ' ';
        $listactive = $view == 'grid' ? ' ' : 'active';

        $request->merge([
            'gridactive' => $gridactive,
            'listactive' => $listactive,
        ]);

        return $next($request);
    }
}
