<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
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
        return view('pages.dashboard.profile.edit', [
            'title' => "My Profile",
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

        return Redirect::route('admin.profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the user's profile photo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePhoto(Request $request): RedirectResponse
    {
        $request->validate([
            'photo_profile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Mengambil file yang diupload
        $file = $request->file('photo_profile');
        $timestamp = now()->timestamp;
        $randomString = uniqid();
        $extension = $file->getClientOriginalExtension();
        $newFileName = $timestamp . '_' . $randomString . '.' . $extension;

        // Cek jika pengguna sudah memiliki foto profil yang lama
        $user = $request->user();
        if ($user->profile_photo_path && $user->profile_photo_path != '/assets/img/profile/user.png' && $user->profile_photo_path != '/assets/img/profile/admin.png') {
            // Cek apakah file foto lama ada di direktori penyimpanan publik dan hapus
            $oldPhotoPath = public_path($user->profile_photo_path);
            if (file_exists($oldPhotoPath)) {
                unlink($oldPhotoPath); // Hapus foto lama
            }
        }

        // Menyimpan file ke storage publik dengan nama baru
        $file->storeAs('profile_photos', $newFileName, 'public');
        $path = '/storage/profile_photos/' . $newFileName;
        // Memperbarui foto profil pengguna
        $user = $request->user();
        $user->update([
            'profile_photo_path' => $path, // Menyimpan path file di database
        ]);

        return Redirect::route('admin.profile.edit')->with([
            'status' => 'profile-updated',
            'success' => 'Profile updated successfully'
        ]);
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
}
