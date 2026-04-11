<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProposalController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'project_title'       => 'required|string|max:255',
            'supervisor_id'       => 'required|exists:users,id',
            'project_description' => 'required|string',
        ]);

        // We use the Model directly to find the user. 
        // This stops the "Undefined Method" error 100% of the time.
        $student = User::where('id', Auth::id())->first();

        if ($student) {
            $student->update([
                'project_title'       => $request->project_title,
                'project_description' => $request->project_description,
                'supervisor_id'       => $request->supervisor_id,
                'request_status'      => 'pending',
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Proposal submitted successfully!');
    }
}