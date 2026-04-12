<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProposalController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'project_title' => 'required|string|max:255',
            'supervisor_id' => [
                'required',
                Rule::exists('users', 'id')->where(fn ($q) => $q->where('role', 'supervisor')->where('is_approved', true)),
            ],
            'project_description' => 'required|string',
        ]);

        $student = User::query()->whereKey(Auth::id())->firstOrFail();

        if ($student->request_status === 'approved') {
            return redirect()->route('dashboard')->with('error', 'Your proposal is already approved. Supervisor assignment is locked.');
        }

        $student->update([
            'project_title' => $request->project_title,
            'project_description' => $request->project_description,
            'supervisor_id' => $request->supervisor_id,
            'request_status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Proposal submitted successfully. Your supervisor will review it soon.');
    }
}
