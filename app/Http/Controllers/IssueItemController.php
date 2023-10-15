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
            'issued_date' => ['required', 'date'],
            'remarks' => ['required', 'min:3', 'max:50'],
        ]);

        $issuedDate = Carbon::parse($formFields['issued_date']);
        $currentDate = Carbon::now();
        if ($issuedDate->gt($currentDate)) {
            return response()->json(['error' => 'Issued date cannot be in the future'], 400);
        }

        $formFields['status'] = 'issued';
        $issue = History::create($formFields);

        History::query()->where('item_id', $formFields['item_id'])->update(['status' => 'issued']);
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
            'return_date' => ['required'],
            'status' => ['required'],
            'issued_date' => ['required'],
            'employee_id' => ['required'],
        ]);

        $issuedDate = Carbon::parse($formFields['return_date']);
        $currentDate = Carbon::now();
        if ($issuedDate->gt($currentDate)) {
            return response()->json(['error' => 'Issued date cannot be in the future'], 400);
        }

        $history = History::where('id', $item_id)->first();
        if (! $history) {
            return response()->json(['error' => 'History not found'], 404);
        }

        $history->update($formFields);

        $item = Item::where('id', $history->item_id)->first();
        if ($item) {
            $item->update(['status' => $formFields['status']]);
        }

        return response()->json(['success' => true, 'history' => $history]);
    }
}
