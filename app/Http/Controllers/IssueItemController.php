<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Item;
use App\Models\Issue;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

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
        ]);
    
        $currentDate = now();
    
        $providedDate = Carbon::parse($formFields['issued_date']);
        if ($currentDate->isBefore($providedDate) || $currentDate->isSameDay($providedDate)) {
            
            $data = Item::where('name', $formFields['name'])->first();
            if ($data) {
                $totalIssuedItem = (int) $formFields['count'] + (int) $data->issued_item;
                $data->update([
                    'issued_item' => $totalIssuedItem,
                ]);

                $data->count -= (int) $formFields['count'];
                $data->save();
            }

            $issue = Issue::create($formFields);
            Item::where('serial', $issue->serial)->update(['status' => 'issued']);
    
            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'Error! Date selected is incorrect !'], 400);
        }
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
}

