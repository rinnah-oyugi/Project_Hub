<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAccountIsApproved
{
    /**
     * Supervisors need admin approval; students are active by default.
     * Admins always pass.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return $next($request);
        }

        if ($user->role === 'admin' || $user->role === 'student' || $user->is_approved) {
            return $next($request);
        }

        if ($request->routeIs('account.pending', 'verification.*', 'logout')) {
            return $next($request);
        }

        return redirect()->route('account.pending');
    }
}
