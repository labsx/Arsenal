<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function profile(Request $request)
    {
        return $request->user()->only(['name', 'email', 'avatar']);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'email' =>  ['required', 'email', Rule::unique('users')->ignore($request->user()->id)],
        ]);
        $request->user()->update($validated);

        return response()->json(['success' => true]);
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
}
