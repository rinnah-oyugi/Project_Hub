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
     * Supervisor Hub: Only accessible if Admin has approved the Supervisor account.
     */
    public function supervisorDashboard()
    {
        $user = Auth::user();

        // 1. Security Check: If admin hasn't approved the supervisor, show waiting room
        if (!$user->is_approved) {
            return view('auth.pending');
        }

        // 2. Fetch all students assigned to this supervisor
        // We EAGER LOAD 'chapters' to ensure the dashboard can show progress immediately
        $students = User::where('role', 'student')
                        ->where('supervisor_id', $user->id)
                        ->with('chapters') 
                        ->get();
        
        return view('supervisor.dashboard', compact('students'));
    }

    /**
     * Supervisor Action: Approve or Decline a Student's Project Proposal
     */
    public function updateStatus(Request $request, $id)
    {
        $student = User::findOrFail($id);
        
        $student->request_status = $request->status; 
        $student->save();

        return redirect()->back()->with('success', 'Project status updated successfully!');
    }

    /**
     * Admin Action: Grant access to a Student or Supervisor account
     */
    public function approveUser($id)
    {
        $user = User::findOrFail($id);
        $user->is_approved = true;
        $user->save();

        return redirect()->back()->with('success', "Access granted for {$user->name}.");
    }
}