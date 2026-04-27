<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
            'proposal_student_comment' => 'nullable|string|max:1000',
            'proposal_file' => 'nullable|file|mimes:pdf,docx|max:10240', // 10MB max
        ]);

        $student = User::query()->whereKey(Auth::id())->firstOrFail();

        if ($student->request_status === 'approved') {
            return redirect()->route('dashboard')->with('error', 'Your proposal is already approved. Supervisor assignment is locked.');
        }

        $updateData = [
            'project_title' => $request->project_title,
            'project_description' => $request->project_description,
            'proposal_student_comment' => $request->proposal_student_comment,
            'supervisor_id' => $request->supervisor_id,
            'request_status' => 'pending',
            'proposal_status' => 'pending', // Reset proposal status on resubmission
            'proposal_supervisor_comment' => null, // Clear previous supervisor comment
        ];

        // Handle file upload if present
        if ($request->hasFile('proposal_file')) {
            $file = $request->file('proposal_file');
            $fileName = 'proposal_' . $student->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('proposals', $fileName, 'public');
            $updateData['proposal_file_path'] = $filePath;
        }

        $student->update($updateData);

        return redirect()->route('dashboard')->with('success', 'Proposal submitted successfully. Your supervisor will review it soon.');
    }

    public function updateProposalFeedback(Request $request, $studentId)
    {
        if (Auth::user()->role !== 'supervisor') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'proposal_status' => 'required|in:pending,approved,rejected',
            'proposal_supervisor_comment' => 'nullable|string|max:1000',
        ]);

        $student = User::findOrFail($studentId);

        // Ensure this supervisor is assigned to this student
        if ($student->supervisor_id !== Auth::id()) {
            abort(403, 'You are not assigned to this student.');
        }

        $student->update([
            'proposal_status' => $request->proposal_status,
            'proposal_supervisor_comment' => $request->proposal_supervisor_comment,
        ]);

        $statusMessage = match($request->proposal_status) {
            'approved' => 'Proposal approved successfully.',
            'rejected' => 'Proposal rejected.',
            'pending' => 'Proposal marked as pending.',
        };

        return redirect()->route('supervisor.dashboard')->with('success', $statusMessage);
    }
}
