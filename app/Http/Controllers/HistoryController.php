<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function itemHistory()
    {
        $items = History::latest()->paginate(10);
        return $items;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, History $history)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(History $history)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(History $history)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, History $history)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function search()
    {
        $searchQuery = request('query');
        $history = History::where(function ($query) use ($searchQuery) {
            $query->where('serial', 'like', "%{$searchQuery}%")
                ->orWhere('item_name', 'like', "%{$searchQuery}%")
                ->orWhere('model', 'like', "%{$searchQuery}%")
                ->orWhere('status', 'like', "%{$searchQuery}%")
                ->orWhere('issued_to', 'like', "%{$searchQuery}%");
        })->paginate(10);
        return response()->json($history);
    }

    public function deleteHistory(History $item)
    {
        $itemId = $item->id; 
        History::where('id', $itemId)->delete(); 
        $item->delete(); 
        
        return response()->json(['success' => true]);
    }
}
