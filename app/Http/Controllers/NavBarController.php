<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Note;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class NavBarController extends Controller
{
    public function index()
    {
        $notes = Note::latest()->get();

        return $notes;
    }

    public function notification()
    {
        $totalCount = Notification::count('name');
        $itemNames = Notification::latest()->get();

        return response()->json([
            'totalCount' => $totalCount,
            'itemNames' => $itemNames,
        ]);
    }

    public function notes(Request $request)
    {
        $formFields = $request->validate([
            'notes' => ['required', 'min:5', 'max:255'],
        ]);

        $user = Auth::user();
        $note = new Note([
            'user_id' => $user->id,
            'notes' => $formFields['notes'],
            'date' => Carbon::now(),
        ]);

        $note->save();

        return response()->json(['message' => 'Note created successfully']);
    }

    public function getUser($id)
    {
        try {
            $user = User::findOrFail($id);

            return response()->json(['name' => $user->name, 'avatar' => $user->avatar]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    public function destroy(Note $note)
    {
        $noteId = $note->id;
        Note::where('id', $noteId)->delete();
        $note->delete();

        return response()->json(['success' => true]);
    }

    public function clear()
    {
        $itemCount = Item::firstOrNew(['id' => 1]);
        $itemCount->count = 0;
        $itemCount->save();

        return response()->json(['success' => true]);
    }

    public function deleteNotification($id)
    {
        try {
            $notification = Notification::findOrFail($id);
            $notification->delete();

            return response()->json(['success' => true, 'message' => 'Notification deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Notification not found'], 404);
        }
    }
}
