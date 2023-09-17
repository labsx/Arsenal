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

    public function return(Request $request, History $history)
    {
        $formFields = $request->validate([
            'item_name' => ['required', 'min:3', 'max:50'],
            'issued_date' => ['required', 'date'],
            'model' => ['required', 'min:3', 'max:30'],
            'status' => ['required', 'in:Good,Bad'],
            'issued_to' => ['required', 'min:3', 'max:50'],
            'return_date' => ['required', 'min:3', 'max:50', 'after_or_equal:issued_date'],
        ], [
            'return_date' => 'Error ! Selected date is incorrect !',
        ]);
    
        $formFields['serial'] = $request->input('serial');
        $issue = History::create($formFields);
    
        Item::where('serial', $issue->serial)->update([
            'status' => $formFields['status'],
            'date' => $formFields['return_date'],
        ]);

        Issue::where('serial', $issue->serial)->delete();
    
        return response()->json(['success' => true]);
    }

}
