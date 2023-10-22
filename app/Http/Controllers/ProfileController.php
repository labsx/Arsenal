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

        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'created_at' => $user->created_at,
        ];

        return response()->json($data);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($request->user()->id)],
        ]);

        $request->user()->update($validated);

        return response()->json($request);
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('profile_picture')) {
            $previousPath = $request->user()->getRawOriginal('avatar');
            $link = Storage::put('/photos', $request->file('profile_picture'));
            $request->user()->update(['avatar' => $link]);

            Storage::delete($previousPath);

            return response()->json(['message' => 'Profile picture uploaded successfully!']);
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
