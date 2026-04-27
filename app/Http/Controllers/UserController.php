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
        $directoryUsers = User::query()
            ->where('role', '!=', 'admin')
            ->orderByDesc('created_at')
            ->with(['students' => function($query) {
                $query->select('id', 'supervisor_id', 'name');
            }])
            ->with(['supervisor' => function($query) {
                $query->select('id', 'name');
            }])
            ->get(['id', 'name', 'email', 'role', 'university_id', 'department', 'is_approved', 'created_at', 'supervisor_id']);

        $pendingSupervisors = $directoryUsers->where('role', 'supervisor')->where('is_approved', false)->count();

        return view('admin.dashboard', [
            'directoryUsers' => $directoryUsers,
            'pendingCount' => $pendingSupervisors,
            'pendingSupervisors' => $pendingSupervisors,
            'totalUsers' => User::count(),
        ]);
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

        $users = User::where('role', '!=', 'admin')
            ->orderBy('role')
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'role', 'university_id', 'department', 'is_approved', 'created_at']);

        $filename = "projecthub_users_" . date('Y-m-d_H-i-s') . ".csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            
            // CSV Header
            fputcsv($file, [
                'ID', 'Name', 'Email', 'Role', 'University ID', 
                'Department', 'Status', 'Registration Date'
            ]);
            
            // CSV Data
            foreach ($users as $user) {
                $status = $user->role === 'student' ? 'Active' : ($user->is_approved ? 'Active' : 'Suspended');
                
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    ucfirst($user->role),
                    $user->university_id ?? 'N/A',
                    $user->department ?? 'N/A',
                    $status,
                    $user->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
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