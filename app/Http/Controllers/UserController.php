<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
            ->get(['id', 'name', 'email', 'role', 'university_id', 'department', 'is_approved', 'created_at']);

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
}