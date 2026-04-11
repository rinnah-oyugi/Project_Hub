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
            if ($user->request_status === 'none' && empty($user->project_title)) {
                return redirect()->route('proposal.create');
            }
            return view('dashboard'); 
        }

        return redirect('/');
    })->name('dashboard');

    // ADMIN ROUTES
    Route::get('/admin/dashboard', function () { 
        return view('admin.dashboard'); 
    })->name('admin.dashboard');

    // Updated to use the UserController method as requested
    Route::post('/admin/approve-user/{id}', [UserController::class, 'approveUser'])->name('admin.approve.user');

    // SUPERVISOR ROUTES
    Route::get('/supervisor/dashboard', [UserController::class, 'supervisorDashboard'])->name('supervisor.dashboard');
    Route::post('/status/update/{id}', [UserController::class, 'updateStatus'])->name('status.update');
    Route::post('/chapter/feedback/{id}', [ChapterController::class, 'updateFeedback'])->name('chapter.feedback');

    // STUDENT ROUTES
    Route::get('/proposal', function () {
        $supervisors = User::where('role', 'supervisor')->where('is_approved', true)->get();
        return view('student.proposal', compact('supervisors'));
    })->name('proposal.create');

    Route::post('/proposal/store', [ProposalController::class, 'store'])->name('proposal.store');
    Route::post('/chapter/store', [ChapterController::class, 'store'])->name('chapter.store');
});

// --- SHARED PROFILE & SYSTEM ROUTES ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
});

// Fixed the typo here: removed the "-"
require __DIR__.'/auth.php';