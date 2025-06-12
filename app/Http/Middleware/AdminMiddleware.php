<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('adminId')) {
            return redirect()->route('admin.auth')->withErrors(['message' => 'Please login first!']);
        }

        if (Session::has('last_activity') && time() - Session::get('last_activity') > config('session.lifetime') * 60) {
            // Session has expired, flush it and redirect to login page
            Session::flush(); // Clear the session
            return redirect()->route('admin.auth')->withErrors(['message' => 'Your session has expired, please log in again.']);
        }

        Session::put('last_activity', time());

        return $next($request);
    }
}
