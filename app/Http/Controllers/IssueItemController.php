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
            'name' => ['max:50'],
            'serial' => ['max:100'],
            'issued_date' => ['required', 'date'],
            'model' => ['max:30'],
            'status' => ['required', 'min:3', 'max:10'],
            'issued_to' => ['required', 'min:3', 'max:50'],
            'count' => ['max:255'],
        ], [
            'serial.unique' => 'Item already issued.',
            'issued_date.required' => 'Date is required.',
            'issued_date.date' => 'Invalid date format.',
            'issued_to.required' => 'Name is required.',
            'count.max' => 'Item reaches the maximum limit to release!',
        ]);
        
        $count = $formFields['count'] ?? 0; 
        
        if ($count <= 0) {
            return response()->json(['error' => 'Invalid input in item count !'], 400);
        }
        
        $data = Item::where('name', $formFields['name'])
            ->where('serial', $formFields['serial'])
            ->first();
        
        if ($data && $data->count < $count) {
            return response()->json(['error' => 'Item reaches the maximum limit!'], 400);
        }
        
        $currentDate = now();
        $providedDate = Carbon::parse($formFields['issued_date']);
        
        if ($currentDate->isBefore($providedDate) || $currentDate->isSameDay($providedDate)) {
            if ($data) {
                $totalIssuedItem = (int) $count + (int) $data->issued_item;
                $data->update([
                    'issued_item' => $totalIssuedItem,
                ]);
        
                $data->count -= (int) $count;
                $data->save();
            }
        
            if ($formFields['serial']) {
                $issue = Issue::create($formFields);
                Item::where('serial', $issue->serial)->update(['status' => 'issued']);
            } else {
                Item::where('name', $formFields['name'])->update(['status' => 'issued']);
                $issue = Issue::create($formFields);
            }
            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'Error! Date selected is incorrect!'], 400);
        }
    }

    public function show(Issue $issue)
    {
        return $issue;
    }

    public function update(Request $request,Issue $issue)
    {
        $formFields = $request->validate([
            'name' => ['max:50'],
            'serial' => ['max:100'],
            'issued_date' => ['required'],
            'model' => ['max:30'],
            'status' => ['required', 'min:3', 'max:10'],
            'issued_to' => ['required', 'min:3', 'max:50'],
            'count' => ['max:255'],
        ]);

        $providedDate = Carbon::parse($formFields['issued_date']);
        $currentDate = Carbon::now();
        
        if ($providedDate->isAfter($currentDate) || $providedDate->isSameDay($currentDate)) {
            $issue->update($formFields);
            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'Error! Date selected is incorrect !    '], 400);
        }

    }

    public function search()
    {
        $searchQuery = request('query');
        $issues = Issue::where(function ($query) use ($searchQuery) {
            $query->where('serial', 'like', "%{$searchQuery}%")
                ->orWhere('item_name', 'like', "%{$searchQuery}%")
                ->orWhere('model', 'like', "%{$searchQuery}%")
                ->orWhere('status', 'like', "%{$searchQuery}%");
        })->paginate(10);
        return response()->json($issues);
    }
    
    public function destroyIssue($id)
    {
        $issue = Issue::find($id);

        if ($issue) {
        $returnDate = now(); 
        $issue->return_date = $returnDate;
        $issueData = [
            'name' => $issue->name,
            'issued_date' => $issue->issued_date,
            'model' => $issue->model,
            'status' => $issue->status,
            'issued_to' => $issue->issued_to,
            'return_date' => $returnDate,  
            'count' => $issue->count,
        ];

        $issue->delete();  
        History::create($issueData);

        return response()->json(['message' => 'Issue deleted and saved to history']);
        } else {
            return response()->json(['message' => 'Issue not found'], 404);
        }
    }
        
}

