<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class DataController extends Controller
{
    public function index()
    {
        $datas = Data::latest()->get();
        return $datas;
    }

    public function create(Request $request)
    {
        $formFields = $request->validate([
            'name' => ['required', 'min:3', 'max:50',Rule::unique('data', 'name')],
            'count' => ['required', 'max:255'],
            'date' => ['required', 'date'],
            'status' => ['required'],
            'description' => ['required', 'min:3', 'max:255'],
        ], [
            'date.required' => 'Date is required',
            'date.date' => 'Invalid date format',
        ]);

        $providedDate = Carbon::parse($formFields['date']);
        $currentDate = Carbon::now();
        if ($providedDate->isAfter($currentDate) || $providedDate->isSameDay($currentDate)) {
            Data::create($formFields);
            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'Error! Date selected is incorrect !'], 400);
        }
    }

    public function destroy($id)
    {
        $data = Data::findOrFail($id);
        $data->delete();
        return response()->json(['success' => true]);
    }
}
