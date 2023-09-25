<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::latest()->paginate(10);
        return $items;
    }

    public function create(Request $request)
    {
        $formFields = $request->validate([
            'name' => ['required', 'min:3', 'max:50'],
            'serial' => [
                'nullable',
                'max:100',
                Rule::unique('items', 'serial')->where(function ($query) use ($request) {
                    return $query->where('count', null)->orWhere('name', $request->input('name'));
                }),
                function ($attribute, $value, $fail) use ($request) {
                    if ($value && $request->input('count') !== '1') {
                        $fail('Error. count input is invalid !');
                    }
                },
                function ($attribute, $value, $fail) {
                    if (empty($value)) {
                        $fail('Serial is required when count is 1.');
                    }
                }
            ],
            'date' => ['required', 'date'],
            'model' => ['max:30'],
            'status' => ['required', 'min:3', 'max:10'],
            'description' => ['required', 'min:3', 'max:255'],
            'count' => ['max:255'],
        ], [
            'serial.unique' => 'Item with this serial already added',
            'date.required' => 'Date is required',
            'date.date' => 'Invalid date format',
        ]);
        
        if ($formFields['count'] == 1 && empty($formFields['serial'])) {
            return response()->json(['error' => 'Error. Serial is required when count is 1.'], 400);
        }
        
        $providedDate = Carbon::parse($formFields['date']);
        $currentDate = Carbon::now();
        
        if ($providedDate->isAfter($currentDate) || $providedDate->isSameDay($currentDate)) {
            Item::create($formFields);
            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'Error! Date selected is incorrect!'], 400);
        }
    }

    public function destroy(Item $item)
    {
        $serial = $item->serial;
        History::where('serial', $serial)->delete();
        $item->delete();
    
        return response()->json(['success' => true]);
    }

    public function edit(Item $item)
    {
        return $item;
    }

    public function update(Request $request, Item $item)
    {
        $formFields = $request->validate([
            'name' => ['required', 'min:3', 'max:50'],
            'serial' => ['max:255'],
            'date' => ['required', 'date'],
            'model' => ['max:30'],
            'status' => ['required', 'min:3', 'max:10'],
            'description' => ['required', 'min:3', 'max:255'],
            'count' => ['max:255'],
        ]);
        $item->update($formFields);
        
        return response()->json(['success' => true]);
    }

    public function search()
    {
        $searchQuery = request('query');
        $items = Item::where(function ($query) use ($searchQuery) {
            $query->where('serial', 'like', "%{$searchQuery}%")
                ->orWhere('name', 'like', "%{$searchQuery}%")
                ->orWhere('model', 'like', "%{$searchQuery}%")
                ->orWhere('status', 'like', "%{$searchQuery}%");
        })->paginate(10);
        return response()->json($items);
    }

    public function bulkDelete()
    {
        Item::whereIn('id', request('ids'))->delete();
        return response()->json(['message' => 'Items deleted successfully']);
    }
}
