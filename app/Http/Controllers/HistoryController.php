<?php

namespace App\Http\Controllers;

use App\Models\History;

class HistoryController extends Controller
{
    public function index()
    {
        $histories = History::latest()->paginate(10);

        return $histories;
    }

    // public function show($id)
    // {
    //     // Assuming History is your model
    //     $history = History::findOrFail($id);

    //     return response()->json(['id' => $history->id]);
    // }

    // public function search()
    // {
    //     $searchQuery = request('query');
    //     $histories = History::where(function ($query) use ($searchQuery) {
    //         $query->where('serial', 'like', "%{$searchQuery}%")
    //             ->orWhere('name', 'like', "%{$searchQuery}%")
    //             ->orWhere('date_issued', 'like', "%{$searchQuery}%")
    //             ->orWhere('status', 'like', "%{$searchQuery}%")
    //             ->orWhere('issued_to', 'like', "%{$searchQuery}%")
    //             ->orWhere('return_date', 'like', "%{$searchQuery}%");
    //     })->paginate(10);

    //     return response()->json($histories);
    // }
}
