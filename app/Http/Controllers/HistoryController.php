<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $itemId = $request->query('item_id');
        $histories = History::where('item_id', $itemId)->latest()->get();

        return response()->json($histories);
    }

    public function show($employeeId)
    {
        $employee = Employee::findOrFail($employeeId);

        return response()->json($employee);
    }
}
