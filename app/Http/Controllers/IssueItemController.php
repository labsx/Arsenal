<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Issue;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class IssueItemController extends Controller
{
    public function index()
    {
        $issues = Issue::latest()->get();
        return $issues;
    }

    public function edit(Item $item)
    {
        return $item;
    }

    public function create(Request $request) 
    {
        $formFields = $request->validate([
            'item_name' => ['required', 'min:3', 'max:50'],
            'serial' => ['required', 'min:3', 'max:100', Rule::unique('issues', 'serial')],
            'issued_date' => ['required'],
            'model' => ['required', 'min:3', 'max:30'],
            'status' => ['required', 'min:3', 'max:10'],
            'issued_to' => ['required', 'min:3', 'max:50'],
        ], [
            'serial.unique' => 'Item already issued !.',
            'issued_date' => 'Date is required !.',
            'issued_to' => 'Name is required !.'
        ]);
    
        $issue = Issue::create($formFields);
        Item::where('serial', $issue->serial)->update(['status' => 'issued']);
    
        return response()->json(['success' => true]);
    }

    public function show(Issue $issue)
    {
        return $issue;
    }

    public function update(Request $request,Issue $issue)
    {
        $formFields = $request->validate([
            'item_name' => ['required', 'min:3', 'max:50'],
            'serial' => ['required', 'min:3', 'max:100', Rule::unique('issues', 'serial')->ignore($issue->id)],
            'issued_date' => ['required'],
            'model' => ['required', 'min:3', 'max:30'],
            'status' => ['required', 'min:3', 'max:10'],
            'issued_to' => ['required', 'min:3', 'max:50'],
        ]);
        $issue->update($formFields);
    
        return response()->json(['success' => true]);
    }
}

