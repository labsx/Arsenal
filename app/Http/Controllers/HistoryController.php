<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Issue;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        $formFields = $request->validate([
            'item_name' => ['required', 'min:3', 'max:50'],
            'issued_date' => ['required'],
            'model' => ['required', 'min:3', 'max:30'],
            'status' => ['required', 'in:Good,Bad'],
            'issued_to' => ['required', 'min:3', 'max:50'],
            'return_date' => ['required', 'min:3', 'max:50'],
        ]);
    
        $formFields['serial'] = $request->input('serial');
        $issue = History::create($formFields);
    
        Item::where('serial', $issue->serial)->update([
            'status' => $formFields['status'],
            'date' => $formFields['return_date'],
        ]);

        Issue::where('serial', $issue->serial)->delete();
    
        return response()->json(['success' => true]);
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
    public function destroy(History $history)
    {
        $history->delete();
        return response()->json(['success' => true]);
    }

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
}
