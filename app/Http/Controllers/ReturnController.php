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

    public function return(Request $request, Item $item)
    {
        $formFields = $request->validate([
            'name' => ['required', 'min:3', 'max:50'],
            'date_issued' => ['required', 'date'],
            'status' => ['required', 'in:operating,decommissioned,under repair'],
            'issued_to' => ['required', 'min:3', 'max:50'],
            'return_date' => ['required', 'date', 'after_or_equal:date_issued'],
            'serial' => ['max:255'],
        ], [
            'return_date' => 'Error date selection !',
        ]);

        History::create($formFields);
        Issue::where('serial', $formFields['serial'])->delete();

        $item = Item::where('serial', $formFields['serial'])->first();
        if ($item) {
            $item->update(['status' => $formFields['status']]);
        }
    }
}
