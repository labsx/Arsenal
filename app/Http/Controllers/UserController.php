<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $searchQuery = $request->input('query');
        $users = User::where(function ($query) use ($searchQuery) {
            $query->where('name', 'like', "%{$searchQuery}%")
                ->orWhere('email', 'like', "%{$searchQuery}%");
        })->paginate(10);

        return response()->json($users);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['success' => true]);
    }

    public function store(Request $request, User $users)
    {
        $formFields = $request->validate([
            'name' => ['required', 'min:3', 'max:50'],
            'email' => ['required', 'min:5', 'max:100', Rule::unique('users', 'email')],
            'password' => ['required', 'min:5', 'max:30'],
        ]);

        $formFields['password'] = Hash::make($formFields['password']);
        $users = User::create($formFields);

        return response()->json(['success' => true]);
    }
}
