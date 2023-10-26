<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return response()->json($user);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($request->user()->id)],
        ]);

        $request->user()->update($validated);

        return response()->json($request->user);
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');

            if ($file->isValid()) {
                $user = $request->user();
                $previousPath = $user->avatar;

                if ($previousPath !== 'noimageavailable.jpg' && Storage::exists($previousPath)) {
                    Storage::delete($previousPath);
                }

                $link = Storage::put('/photos', $file);
                $user->update(['avatar' => $link]);

                return response()->json(['message' => 'Profile picture uploaded successfully!']);
            } else {
                return response()->json(['message' => 'The uploaded file is empty or invalid.']);
            }
        } else {
            return response()->json(['message' => 'No file was uploaded.']);
        }
    }

    public function store(Request $request, UpdateUserPassword $updater)
    {
        $updater->update(auth()->user(), [
            'current_password' => $request->currentPassword,
            'password' => $request->password,
            'password_confirmation' => $request->passwordConfirmation,
        ]);

        return response()->json(['message' => 'Password change successfully!']);
    }
}
