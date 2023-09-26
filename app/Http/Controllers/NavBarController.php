<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Note;
use Illuminate\Http\Request;

class NavBarController extends Controller
{
    public function notification (){
        $items = Item::latest()->get();
        $itemCounts = $items->pluck('count')->toArray(); // Convert to array
        $itemNames = $items->pluck('name')->toArray();   // Convert to array
    
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
}
