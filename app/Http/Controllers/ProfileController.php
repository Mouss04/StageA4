<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
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
    public function update(Request $request): RedirectResponse
    {
        // Validate input
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => ['required', 'email', Rule::unique('users')->ignore($request->user()->id)],
            'phone'     => 'nullable|string|max:20',
            'address'   => 'nullable|string|max:255',
            'state'     => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', // Ensure valid image
        ]);

        $user = $request->user();
        $user->fill($validated);

        // Reset email verification if email changes
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Handle profile picture upload
        if ($request->hasFile('profile_picture') && $request->file('profile_picture')->isValid()) {
            $user->clearMediaCollection('profile_pictures');
            $user->addMediaFromRequest('profile_picture')->toMediaCollection('profile_pictures');
        }

        return Redirect::route('profile.edit')->with('status', 'Profile updated successfully.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        // Delete profile picture before deleting the user
        $user->clearMediaCollection('profile_pictures');
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
