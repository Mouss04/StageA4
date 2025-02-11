<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, $role)
    {
        if (!auth()->check() || !in_array(auth()->user()->role, explode('|', $role))) {
            return redirect('/')->with('error', 'Accès refusé');
        }


        return $next($request);
    }

}

