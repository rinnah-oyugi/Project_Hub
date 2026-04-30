<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAccountIsApproved
{
    /**
     * Supervisors need admin approval; students are active by default.
     * Admins immediately bypass all approval checks.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Admin users bypass all approval checks immediately
        if ($user && $user->role === 'admin') {
            return $next($request);
        }

        if (! $user) {
            return $next($request);
        }

        if ($user->role === 'student' || $user->is_approved) {
            return $next($request);
        }

        if ($request->routeIs('account.pending', 'verification.*', 'logout', 'dashboard', 'supervisor.dashboard', 'admin.dashboard')) {
            return $next($request);
        }

        return redirect()->route('account.pending');
    }
}
