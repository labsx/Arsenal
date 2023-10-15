<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Employee;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $itemId = $request->query('item_id');

        // Fetch histories based on the item ID
        $histories = History::where('item_id', $itemId)->get();

        return response()->json($histories);
    }

    public function show($employeeId)
    {
        $employee = Employee::findOrFail($employeeId);

        return response()->json($employee);
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
