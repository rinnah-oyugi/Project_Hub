<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Check if user is logged in
        // 2. Check if they have the 'supervisor' role
        // 3. Check if their 'is_approved' status is 0 (false)
        if (Auth::check() && Auth::user()->role === 'supervisor' && !Auth::user()->is_approved) {
            
            // Log them out immediately so they can't bypass the check
            Auth::logout();

            // Invalidate their session for security
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Send them back to login with a clear message
            return redirect()->route('login')->with('error', 'Your account is currently awaiting administrative approval. Please try again later.');
        }

        return $next($request);
    }
}