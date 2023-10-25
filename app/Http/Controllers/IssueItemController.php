<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\History;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IssueItemController extends Controller
{
    public function show($id)
    {
        $item = Item::findOrFail($id);

        return response()->json($item);
    }

    public function index()
    {
        $employees = Employee::latest()->get();

        return response()->json($employees);
    }

    public function store(Request $request)
    {
        $formData = $request->validate([
            'item_id' => 'required',
            'employee_id' => 'required',
            'issued_at' => ['required', 'date', 'before:now'],
            'remarks' => ['nullable'],
        ], [
            'employee_id.required' => 'The employee name is required.',
        ]);

        $historyData = array_merge($formData, ['status' => 'issue']);
        $history = History::create($historyData);

        Item::where('id', $formData['item_id'])->update(['status' => 'issue']);

        return response()->json($history);
    }
}
