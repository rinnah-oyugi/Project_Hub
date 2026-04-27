<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Show user profile with visibility controls
     */
    public function show(Request $request, $id): View
    {
        $currentUser = Auth::user();
        $profileUser = User::findOrFail($id);

        // Check if current user can view this profile
        $canView = $this->canViewProfile($currentUser, $profileUser);
        $showContact = $canView && $this->canViewContactInfo($currentUser, $profileUser);
        $isOwnProfile = $currentUser->id === $profileUser->id;

        if (!$canView) {
            abort(403, 'You do not have permission to view this profile.');
        }

        return view('profile.show', [
            'profileUser' => $profileUser,
            'showContact' => $showContact,
            'isOwnProfile' => $isOwnProfile,
        ]);
    }

    /**
     * Check if current user can view the profile
     */
    private function canViewProfile(User $currentUser, User $profileUser): bool
    {
        // Users can always view their own profile
        if ($currentUser->id === $profileUser->id) {
            return true;
        }

        // Admins can view any profile
        if ($currentUser->role === 'admin') {
            return true;
        }

        // Supervisors can view their students' profiles
        if ($currentUser->role === 'supervisor' && $profileUser->role === 'student') {
            return $profileUser->supervisor_id === $currentUser->id;
        }

        // Students can view their supervisor's profile
        if ($currentUser->role === 'student' && $profileUser->role === 'supervisor') {
            return $currentUser->supervisor_id === $profileUser->id;
        }

        return false;
    }

    /**
     * Check if current user can view contact information
     */
    private function canViewContactInfo(User $currentUser, User $profileUser): bool
    {
        // Users can always view their own contact info
        if ($currentUser->id === $profileUser->id) {
            return true;
        }

        // Admins can view any contact info
        if ($currentUser->role === 'admin') {
            return true;
        }

        // Supervisors can view their students' contact info
        if ($currentUser->role === 'supervisor' && $profileUser->role === 'student') {
            return $profileUser->supervisor_id === $currentUser->id;
        }

        return false;
    }
}
