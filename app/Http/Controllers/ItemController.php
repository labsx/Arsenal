<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Item;
use App\Models\History;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\ItemAttribute;
use App\Models\ItemAttributes;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::latest()->get();

        return $items;
    }

    public function getItemAttributes()
    {
        try {
            $items = Item::all();
            $itemsWithAttributes = [];
    
            foreach ($items as $item) {
                $attributes = ItemAttribute::where('item_id', $item->id)->get();
                $itemWithAttributes = [
                    'id' => $item->id,
                    'name' => $item->name,
                    'attributes' => $attributes,
                ];
                array_push($itemsWithAttributes, $itemWithAttributes);
            }
    
            return response()->json($itemsWithAttributes, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
    
    // public function store(Request $request)
    // {
    //     try {
    //         $formData = $request->validate([
    //             'item_id' => 'required|numeric',
    //             'item_name' => 'required',
    //             'value' => 'required|array',
    //             'value.*.label' => 'required|string',
    //             'value.*.value' => 'string',
    //         ]);

    //         $items = [];
    //         foreach ($formData['value'] as $fieldData) {
    //             $item = ItemAttributes::create([
    //                 'item_id' => $formData['item_id'],
    //                 'item_name' => $formData['item_name'],
    //                 'name' => $fieldData['label'],
    //                 'value' => $fieldData['value'],
    //             ]);
                

    //             // $item = Item::create([
    //             //     'category_id' => $formData['item_id'],
    //             //     'name' => $formData['item_name'],
    //             // ]);

    //             $items[] = $item;
    //         }

    //         return response()->json($items, 201);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'An error occurred while saving the items.'], 500);
    //     }
    // }
}   
    // public function index()
    // {
    //     $items = Item::latest()->paginate(10);
    //     return $items;
    // }

    // public function create(Request $request)
    // {
    //     $formFields = $request->validate([
    //         'name' => ['required', 'min:3', 'max:50'],
    //         'serial' => [
    //             'nullable',
    //             'max:100',
    //             Rule::unique('items', 'serial')->where(function ($query) use ($request) {
    //                 return $query->where('count', null)->orWhere('name', $request->input('name'));
    //             }),
    //             function ($attribute, $value, $fail) use ($request) {
    //                 if ($value && $request->input('count') !== '1') {
    //                     $fail('Error. count input is invalid !');
    //                 }
    //             },
    //             function ($attribute, $value, $fail) {
    //                 if (empty($value)) {
    //                     $fail('Serial is required when count is 1.');
    //                 }
    //             }
    //         ],
    //         'date' => ['required', 'date'],
    //         'model' => ['max:30'],
    //         'description' => ['required', 'min:3', 'max:255'],
    //         'count' => ['max:255'],
    //     ], [
    //         'serial.unique' => 'Item with this serial already added',
    //         'date.required' => 'Date is required',
    //         'date.date' => 'Invalid date format',
    //     ]);

    //     $itemExists = Item::where('serial', $formFields['serial'])
    //         ->where('name', $formFields['name'])
    //         ->exists();

    //     if ($itemExists) {
    //         return response()->json(['error' => 'Item already register !'], 400);
    //     }

    //     if ($formFields['count'] == 1 && empty($formFields['serial'])) {
    //         return response()->json(['error' => 'Error. Serial is required when count is 1.'], 400);
    //     }

    //     $providedDate = Carbon::parse($formFields['date']);
    //     $currentDate = Carbon::now();

    //     if ($providedDate->isAfter($currentDate) || $providedDate->isSameDay($currentDate)) {
    //         $formFields['status'] = $formFields['status'] ?? 'Good';
    //         Item::create($formFields);
    //         Notification::create($formFields);
    //         return response()->json(['success' => true]);
    //     } else {
    //         return response()->json(['error' => 'Error! Date selected is incorrect!'], 400);
    //     }
    // }

    // public function destroy(Item $item)
    // {
    //     $serial = $item->serial;
    //     History::where('serial', $serial)->delete();
    //     $item->delete();

    //     return response()->json(['success' => true]);
    // }

    // public function edit(Item $item)
    // {
    //     return $item;
    // }

    // public function update(Request $request, Item $item)
    // {
    //     $formFields = $request->validate([
    //         'name' => ['required', 'min:3', 'max:50'],
    //         'serial' => [
    //             'max:255',
    //             function ($attribute, $value, $fail) use ($request) {
    //                 if ($value && $request->input('count') !== 1) {
    //                     $fail('Error. Count input is invalid!');
    //                 }
    //             },
    //             function ($attribute, $value, $fail) use ($request) {
    //                 if (empty($value) && $request->input('count') == 1) {
    //                     $fail('Serial is required when count is 1.');
    //                 }
    //             },
    //         ],
    //         'date' => ['required', 'date'],
    //         'model' => ['max:30'],
    //         'status' => ['required', 'min:3', 'max:20'],
    //         'description' => ['required', 'min:3', 'max:255'],
    //         'count' => ['max:255'],
    //     ]);

    //     if ($formFields['count'] == 1 && empty($formFields['serial'])) {
    //         return response()->json(['error' => 'Error. Serial is required when count is 1.'], 400);
    //     }

    //     $item->update($formFields);

    //     return response()->json(['success' => true]);
    // }

    // public function search()
    // {
    //     $searchQuery = request('query');
    //     $items = Item::where(function ($query) use ($searchQuery) {
    //         $query->where('serial', 'like', "%{$searchQuery}%")
    //             ->orWhere('name', 'like', "%{$searchQuery}%")
    //             ->orWhere('model', 'like', "%{$searchQuery}%")
    //             ->orWhere('status', 'like', "%{$searchQuery}%");
    //     })->paginate(10);
    //     return response()->json($items);
    // }

    // public function bulkDelete()
    // {
    //     $deletedItemIds = request('ids');

    //     Item::whereIn('id', $deletedItemIds)->delete();
    //     Notification::whereIn('id', $deletedItemIds)->delete();

    //     return response()->json(['message' => 'Items and corresponding notifications deleted successfully']);
    // }

    // public function print()
    // {
    //     $items = Item::latest()->get();
    //     return $items;
    // }
