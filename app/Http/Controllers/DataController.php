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
        $datass = Data::latest()->paginate(10);
        return $datass;
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

    public function show(Data $data)
    {
        return $data;
    }

    public function update(Request $request, Data $data)
    {
        $formFields = $request->validate([
            'name' => ['required', 'min:3', 'max:50',Rule::unique('data', 'name')->ignore($data->id)],
            'count' => ['required', 'max:255'],
            'date' => ['required', 'date'],
            'status' => ['required'],
            'description' => ['required', 'min:3', 'max:255'],
        ]);

        $data->update($formFields);
        
        return response()->json(['success' => true]);
    }

    public function search()
    {
        $searchQuery = request('query');
        $datas = Data::where(function ($query) use ($searchQuery) {
            $query->where('name', 'like', "%{$searchQuery}%")
                ->orWhere('description', 'like', "%{$searchQuery}%")
                ->orWhere('status', 'like', "%{$searchQuery}%");
        })->paginate(10);
        return response()->json($datas);
    }
}
