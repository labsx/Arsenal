<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Issue;
use App\Models\History;
use App\Models\Employee;
use Illuminate\Http\Request;

class IssueItemController extends Controller
{
    public function show($id)
    {
        $item = Item::findOrFail($id);

        return response()->json($item);
    }

    public function employee()
    {
        $employees = Employee::latest()->get();

        return response()->json($employees);
    }

    public function store(Request $request, Issue $issue, Item $item)
    {
        $formFields = $request->validate([
            'item_id' => ['required', 'max:50'],
            'employee_id' => ['required', 'max:100'],
            'issued_date' => ['required', 'date'],
            'remarks' => ['required', 'min:3', 'max:50'],
        ]);

        $formFields['status'] = 'issued';
        $issue = History::create($formFields);

        History::query()->where('item_id', $formFields['item_id'])->update(['status' => 'issued']);
        $item = Item::where('id', $formFields['item_id'])->first();
        if ($item) {
            $item->update(['status' => 'issued']);
        }

        return response()->json($issue);
    }

    public function update(Request $request, History $history, Item $item)
    {
        $formFields = $request->validate([
            'item_id' => ['required'],
            'remarks' => ['required', 'max:50'],
            'return_date' => ['required'],
            'status' => ['required'],
            'issued_date' => ['required'],
            'employee_id' => ['required']
        ]);

        $history = History::where('item_id', $formFields['item_id'])
            ->where('issued_date', $formFields['issued_date'])
            ->where('employee_id', $formFields['employee_id'])
            ->update($formFields);

        Item::where('id', $formFields['item_id'])
            ->update(['status' => $formFields['status']]);

        return response()->json($history);
    }
}
