<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = User::latest()->paginate(10);
        return $users;
    }

    public function search()
    {
        $searchQuery = request('query');
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
}
