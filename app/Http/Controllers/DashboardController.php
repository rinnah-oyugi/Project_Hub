<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            \Log::info('Dashboard accessed - User: ' . $user->email . ', Role: ' . $user->role);

            // Handle students
            if ($user->role === 'student') {
                \Log::info('Processing student dashboard');
                
                $user->load(['chapters' => fn ($q) => $q->orderByDesc('id')]);
                $supervisors = User::query()
                    ->where('role', 'supervisor')
                    ->where('is_approved', true)
                    ->orderBy('name')
                    ->get(['id', 'name', 'email']);

                return view('dashboard', compact('supervisors'));
            }

            // Handle supervisors
            if ($user->role === 'supervisor') {
                \Log::info('Redirecting supervisor to supervisor.dashboard');
                return redirect()->route('supervisor.dashboard');
            }

            // Handle admins
            if ($user->role === 'admin') {
                \Log::info('Redirecting admin to admin.dashboard');
                return redirect()->route('admin.dashboard');
            }

            \Log::info('Redirecting to login (fallback)');
            return redirect()->route('login');

        } catch (\Exception $e) {
            \Log::error('Dashboard error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Dashboard error: ' . $e->getMessage());
        }
    }
}
