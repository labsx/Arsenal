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

    public function return(Request $request, History $history, Issue $issue)
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
        
        if (($request->filled('name') && $request->filled('count')) || ($request->filled('name') && $request->filled('serial'))) {
            if ($request->filled('serial')) {
                Issue::where('name', $request->input('name'))
                    ->where('serial', $request->input('serial'))
                    ->delete();
        
                Item::where('serial', $request->input('serial'))->update(['status' => 'Good']);
                return response()->json(['success' => true]);
            } elseif ($request->filled('count')) {
                Issue::where('name', $request->input('name'))
                    ->where('count', $request->input('count'))
                    ->delete();
        
                Item::where('name', $request->input('name'))->update(['status' => 'Good']);
                return response()->json(['success' => true]);
            }
        }
        
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
