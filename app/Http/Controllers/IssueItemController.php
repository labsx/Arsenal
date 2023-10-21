<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\Issue;
use App\Models\History;
use App\Models\Employee;
use App\Models\FieldGroup;
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

    public function store(Request $request, Issue $issue, Item $item)
    {
        $formFields = $request->validate([
            'item_id' => ['required', 'max:50'],
            'employee_id' => ['required', 'max:100'],
            'issued_at' => ['required', 'date'],
            'remarks' => ['nullable', 'min:3', 'max:50'],
        ], [
            'employee_id.required' => 'The employee name is required.',
        ]);

        $issuedDate = Carbon::parse($formFields['issued_at']);
        $currentDate = Carbon::now();
        if ($issuedDate->gt($currentDate)) {
            return response()->json(['error' => 'Issued date cannot be in the future'], 400);
        }

        $issue = History::create([
            'item_id' => $formFields['item_id'],
            'employee_id' => $formFields['employee_id'],
            'issued_at' => $formFields['issued_at'],
            'remarks' => $formFields['remarks'],
            'status' => 'issued',
        ]);

        $item = Item::where('id', $formFields['item_id'])->first();
        if ($item) {
            $item->update(['status' => 'issued']);
        }

        return response()->json($issue);
    }
}
