<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Item;
use App\Models\Issue;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class IssueItemController extends Controller
{
    public function index()
    {
        $issues = Issue::latest()->paginate(10);
        return $issues;
    }

    public function edit(Item $item)
    {
        return $item;
    }

    public function create(Request $request, Issue $issue, Item $item)
    {
        $formFields = $request->validate([
            'name' => ['required', 'max:50'],
            'serial' => ['required', 'max:100'],
            'date_issued' => ['required', 'date'],
            'status' => ['required', 'min:3', 'max:10'],
            'issued_to' => ['required', 'min:3', 'max:50'],
        ]);

        $formFields['status'] = 'issued';
        $issue = Issue::create($formFields);
        $item = Item::where('serial', $formFields['serial'])->first();
        if ($item) {
            $item->update(['status' => 'issued']);
        }

        return response()->json($issue);
    }

    public function showUser(Issue $issue)
    {
        return $issue;
    }

    public function update(Request $request, Issue $issue)
    {
        $formFields = $request->validate([
            'name' => ['max:50'],
            'date_issued' => ['required'],
            'issued_to' => ['required', 'min:3', 'max:50'],
        ]);

        $issue->update($formFields);

        return response()->json(['success' => true]);
    }

    public function search()
    {
        $searchQuery = request('query');
        $issues = Issue::where(function ($query) use ($searchQuery) {
            $query->where('serial', 'like', "%{$searchQuery}%")
                ->orWhere('name', 'like', "%{$searchQuery}%")
                ->orWhere('date_issued', 'like', "%{$searchQuery}%")
                ->orWhere('issued_to', 'like', "%{$searchQuery}%")
                ->orWhere('status', 'like', "%{$searchQuery}%");
        })->paginate(10);

        return response()->json($issues);
    }
}
