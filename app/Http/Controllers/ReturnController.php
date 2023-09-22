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

    public function return(Request $request, Item $data)
    {
        $formFields = $request->validate([
            'name' => ['required', 'min:3', 'max:50'],
            'issued_date' => ['required', 'date'],
            'model' => ['max:30'],
            'status' => ['required', 'in:Good,Bad'],
            'issued_to' => ['required', 'min:3', 'max:50'],
            'return_date' => ['required', 'date', 'after_or_equal:issued_date'],
            'count' => ['max:255'],
            'serial' => ['max:255'],
        ], [
            'return_date.after_or_equal' => 'Error! Selected date is incorrect!',
        ]);
        
        $data = Item::where('name', $formFields['name'])->first();
        if ($data) {
            $totalIssuedItem = (int) $data->count + (int) $formFields['count'];
            $data->update([
                'count' => $totalIssuedItem,
                'issued_item' => $data->issued_item - (int) $formFields['count'],
                'status' => 'Good'
            ]);
            Issue::where('name', $formFields['name'])
                // ->where('serial', $formFields['serial'])
                ->where('count', $formFields['count'])
                ->delete();

                History::create($formFields);
        
            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'Item not found'], 404);
        }
    }               
}
