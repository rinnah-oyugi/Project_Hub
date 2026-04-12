<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ChapterController extends Controller
{
    /**
     * New chapter upload (only after the student's project proposal is approved).
     */
    public function store(Request $request)
    {
        $student = Auth::user();

        if ($student->role !== 'student' || $student->request_status !== 'approved') {
            return back()->with('error', 'You can only upload chapters after your project proposal is approved.');
        }

        $request->validate([
            'chapter_name' => 'required|string|max:255',
            'chapter_file' => 'required|mimes:pdf,doc,docx|max:5120',
            'student_comment' => 'nullable|string|max:1000',
        ]);

        if (! $request->hasFile('chapter_file')) {
            return back()->with('error', 'File upload failed. Please try again.');
        }

        $file = $request->file('chapter_file');
        $fileName = $student->id.'_'.time().'.'.$file->getClientOriginalExtension();
        $path = $file->storeAs('chapters', $fileName, 'public');

        Chapter::create([
            'user_id' => $student->id,
            'chapter_name' => $request->chapter_name,
            'file_path' => $path,
            'student_comment' => $request->student_comment,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Chapter submitted successfully. Your supervisor has been notified.');
    }

    /**
     * Student revises an existing chapter while status is pending or revision_requested.
     * Approved chapters are immutable (locked).
     */
    public function updateStudentChapter(Request $request, Chapter $chapter)
    {
        $student = Auth::user();

        if ($student->role !== 'student' || $student->request_status !== 'approved') {
            abort(403);
        }

        if ((int) $chapter->user_id !== (int) $student->id) {
            abort(403);
        }

        if ($chapter->status === 'approved') {
            return back()->with('error', 'This chapter is approved and locked. You cannot replace it. Submit a new chapter if you need to add more work.');
        }

        if (! in_array($chapter->status, ['pending', 'revision_requested'], true)) {
            return back()->with('error', 'This chapter cannot be edited in its current state.');
        }

        $request->validate([
            'chapter_name' => 'required|string|max:255',
            'chapter_file' => 'nullable|mimes:pdf,doc,docx|max:5120',
            'student_comment' => 'nullable|string|max:1000',
        ]);

        $disk = Storage::disk('public');

        $data = [
            'chapter_name' => $request->chapter_name,
            'student_comment' => $request->student_comment,
            'status' => 'pending',
        ];

        if ($request->hasFile('chapter_file')) {
            if ($chapter->file_path && $disk->exists($chapter->file_path)) {
                $disk->delete($chapter->file_path);
            }
            $file = $request->file('chapter_file');
            $fileName = $student->id.'_'.time().'.'.$file->getClientOriginalExtension();
            $data['file_path'] = $file->storeAs('chapters', $fileName, 'public');
        }

        $chapter->update($data);

        return redirect()->route('dashboard')->with('success', 'Chapter updated and returned to pending for supervisor review.');
    }

    /**
     * Supervisor feedback: updates supervisor_comment and chapter status.
     */
    public function updateFeedback(Request $request, Chapter $chapter)
    {
        $supervisor = Auth::user();

        $chapter->loadMissing('user:id,supervisor_id,role');

        if ($supervisor->role !== 'supervisor' || (int) $chapter->user->supervisor_id !== (int) $supervisor->id) {
            abort(403);
        }

        $request->validate([
            'comment' => 'nullable|string|max:2000',
            'status' => 'required|in:pending,revision_requested,approved',
        ]);

        $chapter->update([
            'supervisor_comment' => $request->input('comment'),
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Feedback saved. The student will see your comment on their dashboard.');
    }

    /**
     * Supervisor-only: re-open an approved chapter so the student can revise or replace the file.
     */
    public function reopenChapter(Request $request, Chapter $chapter)
    {
        $supervisor = Auth::user();

        $chapter->loadMissing('user:id,supervisor_id,role');

        if ($supervisor->role !== 'supervisor' || (int) $chapter->user->supervisor_id !== (int) $supervisor->id) {
            abort(403);
        }

        if ($chapter->status !== 'approved') {
            return redirect()->back()->with('error', 'Only approved chapters can be re-opened. Use Submit feedback to change other statuses.');
        }

        $request->validate([
            'comment' => 'nullable|string|max:2000',
        ]);

        $note = trim((string) $request->input('comment'));
        $stamp = '['.now()->format('Y-m-d H:i').'] Chapter re-opened for revision by supervisor.';
        $existing = $chapter->supervisor_comment ? trim($chapter->supervisor_comment) : '';
        $merged = $existing === ''
            ? $stamp.($note !== '' ? "\n\n".$note : '')
            : $existing."\n\n".$stamp.($note !== '' ? "\n\n".$note : '');

        $chapter->update([
            'supervisor_comment' => $merged,
            'status' => 'revision_requested',
        ]);

        return redirect()->back()->with('success', 'Chapter re-opened. The student can edit and re-upload this chapter again.');
    }

    /**
     * Download chapter file from the public disk.
     */
    public function download(Chapter $chapter)
    {
        $user = Auth::user();

        $chapter->loadMissing('user:id,supervisor_id,role');

        $ownsChapter = (int) $chapter->user_id === (int) $user->id;
        $isSupervisorOfAuthor = $user->role === 'supervisor'
            && (int) $chapter->user->supervisor_id === (int) $user->id;
        $isAdmin = $user->role === 'admin';

        if (! $ownsChapter && ! $isSupervisorOfAuthor && ! $isAdmin) {
            abort(403);
        }

        $disk = Storage::disk('public');

        if (! $disk->exists($chapter->file_path)) {
            return back()->with('error', 'File not found on server.');
        }

        $extension = pathinfo($chapter->file_path, PATHINFO_EXTENSION) ?: 'bin';
        $downloadName = Str::slug($chapter->chapter_name).'_'.time().'.'.$extension;

        return response()->download(
            $disk->path($chapter->file_path),
            $downloadName
        );
    }
}
