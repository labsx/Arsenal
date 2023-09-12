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
    public function index()
    {
        $history = History::latest()->get();
        return $history;
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
            'status' => ['required', 'min:3', 'max:10'],
            'issued_to' => ['required', 'min:3', 'max:50'],
            'return_date' => ['required', 'min:3', 'max:50'],
        ]);
        $formFields['serial'] = $request->input('serial');
        $issue = History::create($formFields);
        Item::where('serial', $issue->serial)->update(['status' => 'Good']);
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
        //
    }
}