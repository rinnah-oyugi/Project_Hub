<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use App\Jobs\SendPasswordResetNotification;
use App\Jobs\SendUserStatusNotification;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    /**
     * Admin home: account review queue (amber = pending, indigo = governance actions).
     */
    public function adminDashboard()
    {
        try {
            \Log::info('Admin dashboard method called - User: ' . Auth::user()->email . ', Role: ' . Auth::user()->role);
            
            // Debug: Check if user is actually admin
            if (Auth::user()->role !== 'admin') {
                \Log::error('Non-admin user tried to access admin dashboard: ' . Auth::user()->email . ', Role: ' . Auth::user()->role);
                abort(403, 'Access denied. User role: ' . Auth::user()->role);
            }

            \Log::info('Loading directory users...');
            try {
                // Simplify query to isolate the issue
                $directoryUsers = User::query()
                    ->where('role', '!=', 'admin')
                    ->orderByDesc('created_at')
                    ->get(['id', 'name', 'email', 'role', 'university_id', 'department', 'is_approved', 'created_at', 'supervisor_id']);

                \Log::info('Directory users loaded: ' . $directoryUsers->count() . ' users');
                
                // Try to load relationships separately
                foreach ($directoryUsers as $user) {
                    if ($user->role === 'supervisor') {
                        try {
                            $user->students = User::where('supervisor_id', $user->id)->get(['id', 'name']);
                        } catch (\Exception $e) {
                            \Log::error('Error loading students for supervisor ' . $user->id . ': ' . $e->getMessage());
                            $user->students = collect([]);
                        }
                    }
                }
                
                $pendingSupervisors = $directoryUsers->where('role', 'supervisor')->where('is_approved', false)->count();
                $totalUsers = User::count();
            } catch (\Exception $e) {
                \Log::error('Error loading directory users: ' . $e->getMessage());
                // Fallback to empty data
                $directoryUsers = collect([]);
                $pendingSupervisors = 0;
                $totalUsers = 0;
            }

            \Log::info('Returning admin dashboard view...');
            return view('admin.dashboard', [
                'directoryUsers' => $directoryUsers,
                'pendingCount' => $pendingSupervisors,
                'pendingSupervisors' => $pendingSupervisors,
                'totalUsers' => $totalUsers,
            ]);
        } catch (\Exception $e) {
            \Log::error('Admin dashboard error: ' . $e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine());
            return redirect()->route('login')->with('error', 'Admin dashboard error: ' . $e->getMessage());
        }
    }

    /**
     * Supervisor Hub: Only accessible if Admin has approved the Supervisor account.
     */
    public function supervisorDashboard()
    {
        $user = Auth::user();

        $students = User::query()
            ->where('role', 'student')
            ->where('supervisor_id', $user->id)
            ->select(['id', 'name', 'email', 'project_title', 'request_status', 'supervisor_id'])
            ->with(['chapters' => fn ($q) => $q->orderByDesc('id')])
            ->orderBy('name')
            ->get();

        return view('supervisor.dashboard', compact('students'));
    }

    /**
     * Supervisor Action: Approve or Decline a Student's Project Proposal
     */
    public function updateStatus(Request $request, $id)
    {
        $student = User::query()
            ->where('role', 'student')
            ->where('supervisor_id', Auth::id())
            ->findOrFail($id);

        $request->validate([
            'status' => 'required|in:approved,declined,pending',
        ]);

        $student->request_status = $request->status;
        $student->save();

        return redirect()->back()->with('success', 'Project status updated successfully!');
    }

    /**
     * Admin Action: Approve supervisor accounts only (students are active by default).
     */
    public function approveUser($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $user = User::findOrFail($id);

        if ($user->role !== 'supervisor') {
            return redirect()->back()->with('error', 'Only supervisor accounts require admin approval.');
        }

        if ($user->is_approved) {
            return redirect()->back()->with('success', "{$user->name} is already approved.");
        }

        $user->is_approved = true;
        $user->save();

        return redirect()->back()->with('success', "Supervisor access granted for {$user->name}.");
    }

    /**
     * Admin Action: Suspend a user account
     */
    public function suspendUser($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $user = User::findOrFail($id);
        
        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Cannot suspend admin accounts.');
        }

        if ($user->is_approved === false) {
            return redirect()->back()->with('error', 'User is already suspended.');
        }

        $user->is_approved = false;
        $user->save();

        // Send suspension notification
        SendUserStatusNotification::dispatch($user, 'suspend');

        return redirect()->back()->with('success', "User {$user->name} has been suspended.");
    }

    /**
     * Admin Action: Delete a user account (with safety checks)
     */
    public function deleteUser($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $user = User::findOrFail($id);
        
        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Cannot delete admin accounts.');
        }

        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Cannot delete your own account.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->back()->with('success', "User {$userName} has been permanently deleted.");
    }

    /**
     * Admin Action: Export user list to CSV
     */
    public function exportUsers()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        try {
            $users = User::where('role', '!=', 'admin')
                ->orderBy('role')
                ->orderBy('name')
                ->get(['id', 'name', 'email', 'role', 'university_id', 'department', 'is_approved', 'created_at']);

            $filename = "projecthub_users_" . date('Y-m-d_H-i-s') . ".csv";
            
            // Create CSV content in memory first
            $csvContent = '';
            
            // Add CSV header
            $csvContent .= "ID,Name,Email,Role,University ID,Department,Status,Registration Date\n";
            
            // Add CSV data
            foreach ($users as $user) {
                $status = $user->role === 'student' ? 'Active' : ($user->is_approved ? 'Active' : 'Suspended');
                
                $csvContent .= implode(',', [
                    $user->id,
                    '"' . str_replace('"', '""', $user->name) . '"',
                    '"' . str_replace('"', '""', $user->email) . '"',
                    ucfirst($user->role),
                    '"' . ($user->university_id ?? 'N/A') . '"',
                    '"' . ($user->department ?? 'N/A') . '"',
                    $status,
                    $user->created_at->format('Y-m-d H:i:s')
                ]) . "\n";
            }
            
            return response($csvContent)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
                
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Export failed: ' . $e->getMessage());
        }
    }

    /**
     * Admin Action: Debug users - show all non-admin users
     */
    public function debugUsers()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $users = User::where('role', '!=', 'admin')
            ->orderBy('role')
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'role', 'university_id', 'department', 'is_approved', 'created_at']);

        $output = "<h2>All Non-Admin Users (" . $users->count() . " total)</h2><table border='1' style='border-collapse: collapse; width: 100%;'>";
        $output .= "<tr style='background: #f0f0f0;'><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>University ID</th><th>Department</th><th>Approved</th><th>Created</th><th>Action</th></tr>";
        
        foreach ($users as $user) {
            $output .= "<tr>";
            $output .= "<td>" . $user->id . "</td>";
            $output .= "<td>" . $user->name . "</td>";
            $output .= "<td>" . $user->email . "</td>";
            $output .= "<td>" . ucfirst($user->role) . "</td>";
            $output .= "<td>" . ($user->university_id ?? 'N/A') . "</td>";
            $output .= "<td>" . ($user->department ?? 'N/A') . "</td>";
            $output .= "<td>" . ($user->is_approved ? 'Yes' : 'No') . "</td>";
            $output .= "<td>" . $user->created_at->format('Y-m-d') . "</td>";
            $output .= "<td><a href='/admin/delete-user/" . $user->id . "' onclick='return confirm(\"Delete " . $user->name . "?\")'>Delete</a></td>";
            $output .= "</tr>";
        }
        
        $output .= "</table>";
        $output .= "<br><a href='/admin/dashboard'>← Back to Dashboard</a>";
        
        return $output;
    }

    /**
     * Admin Action: Trigger password reset for a user
     */
    public function triggerPasswordReset($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $user = User::findOrFail($id);
        
        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Cannot trigger password reset for admin accounts.');
        }

        // Dispatch password reset notification job (asynchronous)
        SendPasswordResetNotification::dispatch($user);

        return redirect()->back()->with('success', "Password reset link sent to {$user->name}'s email ({$user->email}).");
    }

    /**
     * Admin Action: Readmit/Reactivate a suspended user
     */
    public function readmitUser($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $user = User::findOrFail($id);
        
        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Cannot readmit admin accounts.');
        }

        if ($user->is_approved) {
            return redirect()->back()->with('error', 'User is already active.');
        }

        $user->is_approved = true;
        $user->save();

        // Send readmit notification
        SendUserStatusNotification::dispatch($user, 'readmit');

        return redirect()->back()->with('success', "User {$user->name} has been readmitted and can now access the system.");
    }
}