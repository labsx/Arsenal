<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\History;
use App\Models\Issue;
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
            'created_at' => ['required', 'date'],
            'remarks' => ['required', 'min:3', 'max:50'],
        ]);

        $issuedDate = Carbon::parse($formFields['created_at']);
        $currentDate = Carbon::now();
        if ($issuedDate->gt($currentDate)) {
            return response()->json(['error' => 'Issued date cannot be in the future'], 400);
        }

        $issue = History::create([
            'item_id' => $formFields['item_id'],
            'employee_id' => $formFields['employee_id'],
            'created_at' => $formFields['created_at'],
            'remarks' => $formFields['remarks'],
            'status' => 'issued',
        ]);
        $item = Item::where('id', $formFields['item_id'])->first();
        if ($item) {
            $item->update(['status' => 'issued']);
        }

        return response()->json($issue);
    }

    public function update(Request $request, $item_id)
    {
        $formFields = $request->validate([
            'remarks' => ['required', 'max:50'],
            'updated_at' => ['required'],
            'status' => ['required'],
            'history_id' => ['required'],
        ]);

        $issuedDate = Carbon::parse($formFields['updated_at']);
        $currentDate = Carbon::now();
        if ($issuedDate->gt($currentDate)) {
            return response()->json(['error' => 'Return date cannot be in the future'], 400);
        }

        $history = History::findOrFail($formFields['history_id']);

        $history->update(['status' => $formFields['status']]);    

        $item = Item::find($history->item_id);

        $item = Item::where('id', $history->item_id)->first();
        if ($item) {
            $item->update(['status' => $formFields['status']]);
        }

        return response()->json(['success' => true, 'history' => $history]);
    }
}
