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
        $items = Item::latest()->get();
        $itemCounts = $items->pluck('count')->toArray(); 
        $itemNames = $items->pluck('name')->toArray();   
    
        return response()->json([
            'itemCounts' => $itemCounts,
            'itemNames' => $itemNames,
        ]);
    }
    
    public function notes(Request $request)
    {
        $formFields = $request->validate([
            'notes' => ['required', 'min:5', 'max:50'],
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
}
