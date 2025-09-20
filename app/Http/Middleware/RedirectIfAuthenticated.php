<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string $guard = null)
    {
        // if (Auth::guard($guard)->check()) {
        //     return redirect('/attendance-dashboard'); // redirect logged-in users
        // }

        // return $next($request);
    }

    // protected function redirectTo(Request $request): ?string
    // {
    //     return $request->expectsJson() ? null : route('login'); // Example: always redirect to 'login' route
    // }
}
