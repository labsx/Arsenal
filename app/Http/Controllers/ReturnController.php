<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Issue;
use App\Models\History;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    public function showReturn(Issue $issue)
    {
        return $issue;
    }

    public function return(Request $request, Item $data, Issue $issue)
    {
        $formFields = $request->validate([
            'name' => ['required', 'min:3', 'max:50'],
            'issued_date' => ['required', 'date'],
            'model' => ['max:30'],
            'status' => ['required', 'in:Good,Bad'],
            'issued_to' => ['required', 'min:3', 'max:50'],
            'return_date' => ['required', 'date', 'after_or_equal:issued_date'],
            'count' => [
                'max:255',
                function ($attribute, $value, $fail) {
                    if ($value !== null && $value <= 0) {
                        $fail('Count cannot be zero.');
                    }
                }
            ],
            'serial' => ['max:255'],
        ], [
            'return_date.after_or_equal' => 'Error! Selected date is incorrect!',
            'count' => 'Invalid input please try again !..'
        ]);
        
        if ($formFields['count'] > 0) {
            $issue = Issue::where('name', $formFields['name'])->first();
              
            if ($issue && $issue->count < $formFields['count']) {
                return response()->json(['error' => 'Item exceed the current item !.'], 400);
            }
        
            $data = Item::where('name', $formFields['name'])->first();
        
            if ($data) {
                $totalIssuedItem = (int) $data->count + (int) $formFields['count'];
                $data->update([
                    'count' => $totalIssuedItem,
                    'issued_item' => $data->issued_item - (int) $formFields['count'],
                    'status' => $formFields['status'],
                ]);
        
                Issue::where('name', $formFields['name'])
                    ->where('issued_date', $formFields['issued_date'])
                    ->delete();
        
                History::create($formFields);
        
                return response()->json(['success' => true]);
            } else {
                return response()->json(['error' => 'Item not found'], 404);
            }
        }
    }                    
}
