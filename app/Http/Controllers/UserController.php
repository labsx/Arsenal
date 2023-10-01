<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $users = User::latest()->paginate(10);
        return $users;
    }

    public function searchUser()
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

    public function test_it_deletes_users()
    {
        $user = User::factory()->create();
    
        $response = $this->delete("/users/{$user->id}");
    
        $response->assertStatus(302); // Update this line to expect a 302 status code
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
    
}
