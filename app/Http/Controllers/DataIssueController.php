<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\DataIssue;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class DataIssueController extends Controller
{
    public function index($id)
    {
        $data = Data::findOrFail($id);
        return [
            'name' => $data->name,
            'count' => $data->count
        ];
    }

    public function create(Request $request, DataIssue $dataissue )
    {

        $formFields = $request->validate([
            'name' => ['required', 'min:3', 'max:50'],
            'count' => ['required', 'numeric', 'max:255'], // Ensure count is numeric
            'issued_date' => ['required', 'date'],
            'status' => ['required'],
            'issued_to' => ['required', 'min:3', 'max:255'],
        ], [
            'date.required' => 'Date is required',
            'date.date' => 'Invalid date format',
        ]);
    
        $providedDate = Carbon::parse($formFields['issued_date']);
        $currentDate = Carbon::now();
    
        if ($providedDate->isAfter($currentDate) || $providedDate->isSameDay($currentDate)) {
            $data = Data::where('name', $formFields['name'])->first();
            if ($data) {
                $totalIssuedItem = (int) $formFields['count'] + (int) $data->issued_item;
                $data->update([
                    'issued_item' => $totalIssuedItem,
                ]);

                $data->count -= (int) $formFields['count'];
                $data->save();
            }
    
            DataIssue::create($formFields);
            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'Error! Date selected is incorrect!'], 400);
        }
    }
}

