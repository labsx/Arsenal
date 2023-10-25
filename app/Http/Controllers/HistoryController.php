<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\History;
use App\Models\Item;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $histories = History::latest()->get();

        return response()->json($histories);
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);

        return response()->json($employee);
    }

    public function itemDetails(Request $request)
    {
        $itemId = $request->query('item_id');
        $histories = History::where('item_id', $itemId)->latest()->get();

        return response()->json($histories);
    }

    public function getHistory($id)
    {
        $histories = History::where('employee_id', $id)->get();

        return response()->json($histories);
    }

    public function getItems()
    {
        // $items = Item::all(['id', 'name']);
        $items = Item::latest()->get();

        return response()->json($items);
    }
}
