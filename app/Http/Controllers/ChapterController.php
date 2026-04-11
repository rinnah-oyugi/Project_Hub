<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChapterController extends Controller
{
    /**
     * Handle the student's chapter submission.
     */
    public function store(Request $request)
    {
        // 1. Validate the incoming request
        $request->validate([
            'chapter_file' => 'required|mimes:pdf,doc,docx|max:5120', // Max 5MB
            'chapter_name' => 'required|string|max:255',
            'student_comment' => 'nullable|string|max:1000',
        ]);

        // 2. Handle the file upload
        if ($request->hasFile('chapter_file')) {
            $file = $request->file('chapter_file');
            
            // Create a clean filename: student_id_timestamp.extension
            $fileName = Auth::id() . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Store in 'public/chapters' folder
            $path = $file->storeAs('chapters', $fileName, 'public');

            // 3. Save to Database
            Chapter::create([
                'user_id' => Auth::id(),
                'chapter_name' => $request->chapter_name,
                'file_path' => $path,
                'student_comment' => $request->student_comment,
                'status' => 'pending', // Default status for new uploads
            ]);

            return back()->with('success', 'Chapter submitted successfully! Your supervisor has been notified.');
        }

        return back()->with('error', 'File upload failed. Please try again.');
    }

    /**
     * Handle the supervisor's feedback on a submitted chapter.
     */
    public function updateFeedback(Request $request, $id)
    {
        // 1. Validate the feedback request
        $request->validate([
            'comment' => 'required|string|max:2000',
            'status' => 'required|in:approved,needs revision,pending',
        ]);

        // 2. Find the specific chapter
        $chapter = Chapter::findOrFail($id);

        // 3. Update with supervisor feedback
        $chapter->update([
            'supervisor_comment' => $request->comment,
            'status' => $request->status, // This changes the badge color on the student's end
        ]);

        return redirect()->back()->with('success', 'Feedback sent to student successfully!');
    }
}