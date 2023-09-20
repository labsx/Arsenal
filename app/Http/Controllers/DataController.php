<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class DataController extends Controller
{
    public function create(Request $request)
    {
        $formFields = $request->validate([
            'name' => ['required', 'min:3', 'max:50'],
            'count' => ['required', 'max:255'],
            'date' => ['required', 'date'],
            'description' => ['required', 'min:3', 'max:255'],
        ], [
            'date.required' => 'Date is required',
            'date.date' => 'Invalid date format',
        ]);

        $providedDate = Carbon::parse($formFields['date']);
        $currentDate = Carbon::now();

        if ($providedDate->isAfter($currentDate) || $providedDate->isSameDay($currentDate)) {
            Data::where('name', $formFields['name'])->update(['status' => 'Good']);

            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'Error! Date selected is incorrect !'], 400);
        }
    }
}
