<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectAuthenticatedUsers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Log the redirect attempt
            \Log::info('Authenticated user trying to access guest page - User: ' . $user->email . ', Role: ' . $user->role . ', Requested: ' . $request->path());
            
            // Redirect based on user role to prevent sticky session loop
            if ($user->role === 'admin') {
                \Log::info('Redirecting authenticated admin to admin.dashboard (sticky session fix)');
                return redirect()->intended(route('admin.dashboard'));
            }
            
            if ($user->role === 'supervisor') {
                \Log::info('Redirecting authenticated supervisor to supervisor.dashboard (sticky session fix)');
                return redirect()->intended(route('supervisor.dashboard'));
            }
            
            \Log::info('Redirecting authenticated student to dashboard (sticky session fix)');
            return redirect()->intended(route('dashboard'));
        }

        return $next($request);
    }
}
