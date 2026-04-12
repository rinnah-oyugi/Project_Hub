<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\ChapterController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes - Project_Hub
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Pending approval (must stay outside `approved` middleware to avoid redirect loops)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/account/pending', function () {
        $user = Auth::user();

        if ($user->role === 'admin' || $user->role === 'student' || $user->is_approved) {
            return redirect()->route('dashboard');
        }

        return view('auth.pending');
    })->name('account.pending');
});

// --- AUTHENTICATED & APPROVED ROUTES ---
Route::middleware(['auth', 'verified', 'approved'])->group(function () {

    Route::get('/dashboard', function () {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'supervisor') {
            return redirect()->route('supervisor.dashboard');
        }

        if ($user->role === 'student') {
            $user->load(['chapters' => fn ($q) => $q->orderByDesc('id')]);
            $supervisors = User::query()
                ->where('role', 'supervisor')
                ->where('is_approved', true)
                ->orderBy('name')
                ->get(['id', 'name', 'email']);

            return view('dashboard', compact('supervisors'));
        }

        return redirect()->route('login');
    })->name('dashboard');

    // ADMIN ROUTES (isolated middleware keeps heavy work scoped and avoids accidental access)
    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', [UserController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::post('/admin/approve-user/{id}', [UserController::class, 'approveUser'])->name('admin.approve.user');
    });

    // SUPERVISOR ROUTES
    Route::get('/supervisor/dashboard', [UserController::class, 'supervisorDashboard'])->name('supervisor.dashboard');
    Route::post('/status/update/{id}', [UserController::class, 'updateStatus'])->name('status.update');
    Route::post('/chapter/feedback/{chapter}', [ChapterController::class, 'updateFeedback'])->name('chapter.feedback');
    Route::post('/chapter/{chapter}/reopen', [ChapterController::class, 'reopenChapter'])->name('chapter.reopen');
    Route::get('/chapter/download/{chapter}', [ChapterController::class, 'download'])->name('chapter.download');

    // STUDENT ROUTES
    Route::get('/proposal', function () {
        $supervisors = User::query()
            ->where('role', 'supervisor')
            ->where('is_approved', true)
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        return view('student.proposal', compact('supervisors'));
    })->name('proposal.create');

    Route::post('/proposal/store', [ProposalController::class, 'store'])->name('proposal.store');
    Route::post('/chapter/store', [ChapterController::class, 'store'])->name('chapter.store');
    Route::patch('/chapter/{chapter}/revise', [ChapterController::class, 'updateStudentChapter'])->name('chapter.update');
});

// --- SHARED PROFILE & SYSTEM ROUTES ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
});

require __DIR__.'/auth.php';
