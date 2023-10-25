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

    public function update(Request $request, History $history, Item $item, $history_id)
    {
        $currentDate = Carbon::now();
        $formFields = $request->validate([
            'remarks' => ['required', 'max:50'],
            'return_at' => ['required', 'date', 'after_or_equal:'.$currentDate->toDateString()],
            'status' => ['required'],
        ]);

        $history = History::findOrFail($history_id);
        $history->update($formFields);
        $item = Item::find($history->item_id);

        if ($item) {
            $item->update(['status' => $formFields['status']]);
        }

        return response()->json($history);
    }
}
