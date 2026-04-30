<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\ChapterController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    $user = Auth::user();
    
    if ($user->role === 'student') {
        $supervisors = User::query()
            ->where('role', 'supervisor')
            ->where('is_approved', true)
            ->orderBy('name')
            ->get(['id', 'name', 'email']);
        
        return view('dashboard', compact('supervisors'));
    }
    
    if ($user->role === 'supervisor') {
        return redirect()->route('supervisor.dashboard');
    }
    
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    
    return redirect()->route('login');
})->name('dashboard');

    // SUPERVISOR ROUTES
    Route::get('/supervisor/dashboard', function () {
        try {
            $user = Auth::user();
            $students = User::query()
                ->where('role', 'student')
                ->where('supervisor_id', $user->id)
                ->get();
            return view('supervisor.dashboard', compact('students'));
        } catch (\Exception $e) {
            return 'Supervisor dashboard error: ' . $e->getMessage();
        }
    })->name('supervisor.dashboard');
    Route::post('/status/update/{id}', [UserController::class, 'updateStatus'])->name('status.update');
    Route::post('/proposal/feedback/{studentId}', [ProposalController::class, 'updateProposalFeedback'])->name('proposal.feedback');
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

// --- ADMIN ROUTES (separate from approved middleware to avoid conflicts) ---
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        try {
            $directoryUsers = User::query()
                ->where('role', '!=', 'admin')
                ->get();
            return view('admin.dashboard', [
                'directoryUsers' => $directoryUsers,
                'pendingCount' => 0,
                'pendingSupervisors' => 0,
                'totalUsers' => User::count(),
            ]);
        } catch (\Exception $e) {
            return 'Admin dashboard error: ' . $e->getMessage();
        }
    })->name('admin.dashboard');
    Route::post('/admin/approve-user/{id}', [UserController::class, 'approveUser'])->name('admin.approve.user');
    Route::post('/admin/suspend-user/{id}', [UserController::class, 'suspendUser'])->name('admin.suspend.user');
    Route::post('/admin/readmit-user/{id}', [UserController::class, 'readmitUser'])->name('admin.readmit.user');
    Route::delete('/admin/delete-user/{id}', [UserController::class, 'deleteUser'])->name('admin.delete.user');
    Route::post('/admin/reset-password/{id}', [UserController::class, 'triggerPasswordReset'])->name('admin.reset.password');
    Route::get('/admin/export-users', [UserController::class, 'exportUsers'])->name('admin.export.users');
    Route::get('/admin/debug-users', [UserController::class, 'debugUsers'])->name('admin.debug.users');
});

// --- DEBUG ROUTES ---
Route::get('/debug-login', function () {
    if (!Auth::check()) {
        return 'Not logged in';
    }
    $user = Auth::user();
    return 'User: ' . $user->name . ', Role: ' . $user->role . ', Email: ' . $user->email;
})->name('debug.login');

Route::get('/test-student', function () {
    return 'This is student test page - if you see this, student routing works';
})->name('test.student');

Route::get('/test-admin', function () {
    return 'This is admin test page - if you see this, admin routing works';
})->name('test.admin');

Route::get('/check-users', function () {
    $users = User::all(['id', 'name', 'email', 'role', 'is_approved']);
    $output = '<h2>All Users in Database:</h2><table border="1"><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Approved</th></tr>';
    foreach ($users as $user) {
        $output .= '<tr><td>' . $user->id . '</td><td>' . $user->name . '</td><td>' . $user->email . '</td><td>' . $user->role . '</td><td>' . ($user->is_approved ? 'Yes' : 'No') . '</td></tr>';
    }
    $output .= '</table>';
    return $output;
})->name('check.users');

Route::get('/test-db', function () {
    try {
        $connection = DB::connection();
        $pdo = $connection->getPdo();
        $database = DB::select('SELECT DATABASE() as current_db');
        return 'Database connection successful: ' . $database[0]->current_db;
    } catch (\Exception $e) {
        return 'Database error: ' . $e->getMessage();
    }
})->name('test.db');

Route::get('/test-simple', function () {
    return 'Simple test route works';
})->name('test.simple');

Route::get('/test-admin-dashboard', function () {
    try {
        \Log::info('Testing admin dashboard view...');
        return view('admin.dashboard', [
            'directoryUsers' => collect([]),
            'pendingCount' => 0,
            'pendingSupervisors' => 0,
            'totalUsers' => 0,
        ]);
    } catch (\Exception $e) {
        \Log::error('Admin dashboard view error: ' . $e->getMessage());
        return 'Admin dashboard view error: ' . $e->getMessage();
    }
})->name('test.admin.dashboard');

Route::get('/test-dashboard-minimal', function () {
    try {
        return '<h1>Minimal Dashboard Test</h1><p>If you see this, routing works.</p>';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
})->name('test.dashboard.minimal');

Route::get('/debug-routes', function () {
    return 'Login route: ' . route('login') . '<br>' .
           'Dashboard route: ' . route('dashboard') . '<br>' .
           'Admin dashboard route: ' . route('admin.dashboard') . '<br>' .
           'Supervisor dashboard route: ' . route('supervisor.dashboard');
})->name('debug.routes');

// --- SHARED PROFILE & SYSTEM ROUTES ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
});

require __DIR__.'/auth.php';
