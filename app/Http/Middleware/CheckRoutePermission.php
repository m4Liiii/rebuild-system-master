<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRoutePermission
{
    public function handle(Request $request, Closure $next)
    {
        
        $routeName = $request->route()->getName();

    
        $permissions = config('permission_routes.routes');
      
        if (isset($permissions[$routeName])) {
            $requiredPermission = $permissions[$routeName];

          
            if (! Auth::user()->can($requiredPermission)) {
                return back();
            }
        }

        return $next($request);
    }
}