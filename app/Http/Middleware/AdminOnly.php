<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        // If the user isn't logged in, send them straight to the login screen
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // If logged in but NOT an admin, block access with an explicit warning banner
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Access Denied: Only Sagkahan NHS Administrators can manage records.');
        }

        return $next($request);
    }
}
