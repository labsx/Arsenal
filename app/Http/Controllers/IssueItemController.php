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

    public function create(Request $request, Issue $issue, Item $data)
    {
        $formFields = $request->validate([
            'name' => ['required', 'max:50'],
            'serial' => ['required', 'max:100'],
            'date_issued' => ['required', 'date'],
            'status' => ['required', 'min:3', 'max:10'],
            'issued_to' => ['required', 'min:3', 'max:50'],
        ]);

        $issue = Issue::create($formFields);

        return response()->json($issue);
    }


    // public function show(Issue $issue)
    // {
    //     return $issue;
    // }

    // public function update(Request $request,Issue $issue)
    // {
    //     $formFields = $request->validate([
    //         'name' => ['max:50'],
    //         'serial' => ['max:100'],
    //         'issued_date' => ['required'],
    //         'model' => ['max:30'],
    //         'status' => ['required', 'min:3', 'max:10'],
    //         'issued_to' => ['required', 'min:3', 'max:50'],
    //         'count' => ['max:255'],
    //     ]);

    //     $providedDate = Carbon::parse($formFields['issued_date']);
    //     $currentDate = Carbon::now();

    //     if ($providedDate->isAfter($currentDate) || $providedDate->isSameDay($currentDate)) {
    //         $issue->update($formFields);
    //         return response()->json(['success' => true]);
    //     } else {
    //         return response()->json(['error' => 'Error! Date selected is incorrect !    '], 400);
    //     }

    // }

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
    
    // public function destroyIssue($id)
    // {
    //     $issue = Issue::find($id);

    //     if ($issue) {
    //     $returnDate = now(); 
    //     $issue->return_date = $returnDate;
    //     $issueData = [
    //         'name' => $issue->name,
    //         'issued_date' => $issue->issued_date,
    //         'model' => $issue->model,
    //         'status' => $issue->status,
    //         'issued_to' => $issue->issued_to,
    //         'return_date' => $returnDate,  
    //         'count' => $issue->count,
    //     ];

    //     $issue->delete();  
    //     History::create($issueData);

    //     return response()->json(['message' => 'Issue deleted and saved to history']);
    //     } else {
    //         return response()->json(['message' => 'Issue not found'], 404);
    //     }
    // }
        
//}
