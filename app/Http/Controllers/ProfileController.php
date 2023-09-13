<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function profile(Request $request)
    {
        return $request->user()->only(['name', 'email']);
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
}
