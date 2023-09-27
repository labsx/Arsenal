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
            'status' => ['required', 'in:Good,Bad,issued'],
            'issued_to' => ['required', 'min:3', 'max:50'],
            'return_date' => ['required', 'date', 'after_or_equal:issued_date'],
            'count' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) {
                    if ($value <= 0) {
                        $fail('Return item must be 1.');
                    }
                }
            ],
            'serial' => ['max:255'],
        ]);
        
        if ($formFields['count'] > 0) {
            $issue = Issue::where('name', $formFields['name'])
                ->where('issued_date', $formFields['issued_date'])
                ->first();
        
            if ($issue && $issue->count < $formFields['count']) {
                return response()->json(['error' => 'Item count exceeds the available count.'], 400);
            }
        
            $deletedCount = $formFields['count'];  
            if ($issue) {
                $deletedCount  -=  $issue->count ;
                $issue->save();
            }
        
            History::create([
                'name' => $formFields['name'],
                'issued_date' => $formFields['issued_date'],
                'model' => $formFields['model'],
                'status' => $formFields['status'],
                'issued_to' => $formFields['issued_to'],
                'return_date' => $formFields['return_date'],
                'count' => -$deletedCount,  
                'serial' => $formFields['serial'],
            ]);
        
            $data = Item::where('name', $formFields['name'])->first();
            $totalIssuedItem = $data->count + $formFields['count'];
            $data->update([
                'count' => $totalIssuedItem,
                'issued_item' => $data->issued_item - $formFields['count'],
                'status' => $formFields['status'],
            ]);
        
            Issue::where('name', $formFields['name'])
                ->where('issued_date', $formFields['issued_date'])
                ->delete();
        
            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'Invalid count'], 400);
        }
    }                    
}
