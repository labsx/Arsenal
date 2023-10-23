<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    public function show($id)
    {
        $issue = History::findOrFail($id);

        return response()->json($issue);
    }

    public function update(Request $request, $item_id)
    {
        $formFields = $request->validate([
            'remarks' => ['required', 'max:50'],
            'return_at' => ['required', 'date'],
            'status' => ['required'],
            'history_id' => ['required'],
        ]);

        $returnDate = Carbon::parse($formFields['return_at']);
        $history = History::findOrFail($formFields['history_id']);

        if ($history->issued_at && $returnDate->lt($history->issued_at)) {
            return response()->json(['error' => 'Issued date is after the return date'], 400);
        }

        $history->remarks = $formFields['remarks'];
        $history->return_at = $formFields['return_at'];
        $history->status = $formFields['status'];
        $history->save();

        $item = Item::find($history->item_id);

        $item = Item::where('id', $history->item_id)->first();
        if ($item) {
            $item->update(['status' => $formFields['status']]);
        }

        return response()->json($history);
    }
}
