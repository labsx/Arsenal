<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Note;
use Illuminate\Http\Request;

class NavBarController extends Controller
{
    public function index()
    {
        $notes = Note::latest()->get();
        return $notes;
    }

    public function notification (){
        $totalCount = Item::count('name');
        $itemNames = Item::latest()->get();  
    
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

        Note::create([
            'notes' => $formFields['notes'],
        ]);

        return response()->json(['message' => true]);
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
}
