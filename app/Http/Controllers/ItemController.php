<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemAttribute;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $searchQuery = $request->input('query');
        $itemsQuery = Item::query();
    
        if ($searchQuery) {
            $itemsQuery->where(function ($query) use ($searchQuery) {
                $query->where('name', 'like', "%{$searchQuery}%")
                    ->orWhere('serial', 'like', "%{$searchQuery}%")
                    ->orWhere('status', 'like', "%{$searchQuery}%")
                    ->orWhere('model', 'like', "%{$searchQuery}%")
                    ->orWhere('manufacturer', 'like', "%{$searchQuery}%")
                    ->orWhere('price', 'like', "%{$searchQuery}%")
                    ->orWhere('mfg_date', 'like', "%{$searchQuery}%")
                    ->orWhere('location', 'like', "%{$searchQuery}%");
            });
        }
    
        $items = $itemsQuery->paginate(10);
    
        return response()->json($items);
        // $searchQuery = $request->input('query');
        // $items = Item::where(function ($query) use ($searchQuery) {
        //     $query->where('name', 'like', "%{$searchQuery}%")
        //         ->orWhere('serial', 'like', "%{$searchQuery}%")
        //         ->orWhere('status', 'like', "%{$searchQuery}%")
        //         ->orWhere('model', 'like', "%{$searchQuery}%")
        //         ->orWhere('manufacturer', 'like', "%{$searchQuery}%")
        //         ->orWhere('price', 'like', "%{$searchQuery}%")
        //         ->orWhere('mfg_date', 'like', "%{$searchQuery}%")
        //         ->orWhere('location', 'like', "%{$searchQuery}%");
        // })->paginate(10);

        // return response()->json($items);
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return response()->noContent();
    }

    public function show($id)
    {
        $items = Item::findOrFail($id);

        return response($items);
    }

    public function getAttributes($id)
    {
        $item = Item::find($id);

        if (! $item) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        $attributes = $item->attributes()->get(['name', 'value']);

        $formattedAttributes = $attributes->map(function ($attribute) {
            return [
                'name' => $attribute->name,
                'value' => $attribute->value,
            ];
        });

        return response()->json($formattedAttributes, 200);
    }

    public function update(Request $request, $id)
    {
        $formData = $request->validate([
            'name' => ['required'],
            'parent_id' => ['required'],
            'model' => ['required'],
            'price' => ['nullable','numeric'],
            'mfg_date' => ['nullable','before_or_equal:' . now()->toDateString()],
            'serial' => ['required'],
            'status' => ['required'],
            'manufacturer' => ['nullable'],
            'location' => ['nullable'],
            'warranty' => ['nullable'],
            'insurance' => ['nullable'],
            'net_weight' => ['nullable','numeric'],
            'value' => ['nullable','array'],
            'value.*.name' => ['required','string'],
            'value.*.value' => ['required','string'],
        ], [
            'price.numeric' => 'Input only number w/ out comma, space, letter !',
            'net_weight.numeric' => 'Input only number in kg w/ out comma, space, letter !',
        ]);

        $item = Item::find($id);

        if (! $item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $duplicateNames = collect($formData['value'])
            ->groupBy('name')
            ->filter(function ($group) {
                return $group->count() > 1;
            })
            ->keys();

        if (! $duplicateNames->isEmpty()) {
            return response()->json(['error' => 'Duplicate attribute name  '.$duplicateNames->implode(', ')], 400);
        }

        $item->name = $formData['name'];
        $item->serial = $formData['serial'];
        $item->status = $formData['status'];
        $item->model = $formData['model'];
        $item->price = $formData['price'];
        $item->mfg_date = $formData['mfg_date'];
        $item->parent_id = $formData['parent_id'];
        $item->manufacturer = $formData['manufacturer'];
        $item->location = $formData['location'];
        $item->warranty = $formData['warranty'];
        $item->net_weight = $formData['net_weight'];
        $item->insurance = $formData['insurance'];

        $item->save();

        $existingAttributeNames = $item->attributes()->pluck('name')->toArray();

        foreach ($formData['value'] as $fieldData) {
            $attribute = $item->attributes()->updateOrCreate(
                ['name' => $fieldData['name']],
                ['value' => $fieldData['value']]
            );

            $key = array_search($fieldData['name'], $existingAttributeNames);
            if ($key !== false) {
                unset($existingAttributeNames[$key]);
            }
        }

        $item->attributes()->whereIn('name', $existingAttributeNames)->delete();

        return response()->json(['success' => true]);
    }

    public function store(Request $request)
    {
        $currentDate = Carbon::now();
        $formData = $request->validate([
            'item_name' => ['required'],
            'parent_id' => ['required'],
            'model' => ['required'],
            'price' => ['nullable', 'numeric'],
            'mfg_date' => ['nullable', 'date', 'before_or_equal:' . now()->toDateString()],
            'serial' => ['required'],
            'status' => ['required'],
            'manufacturer' => ['nullable'],
            'location' => ['nullable'],
            'warranty' => ['nullable'],
            'insurance' => ['nullable'],
            'net_weight' => ['nullable', 'numeric'],
            'value' => ['nullable', 'array'],
            'value.*.label' => ['nullable', 'string'],
            'value.*.value' => ['nullable', 'string'],
        ], [
            'parent_id.required' => 'The category name is required.',
            'price.numeric' => 'Input only number w/ out comma, space, letter !',
            'net_weight.numeric' => 'Input only number in kg w/ out comma, space, letter !',
        ]);

        $issuedDate = Carbon::parse($formData['mfg_date']);
        $currentDate = Carbon::now();
        if ($issuedDate->gt($currentDate)) {
            return response()->json(['error' => 'Manufacture date cannot be in the future'], 400);
        }

        $number = mt_rand(1000000000, 9999999999);
        $request['barcode'] = $number;

        $item = Item::create([
            'name' => $formData['item_name'],
            'parent_id' => $formData['parent_id'],
            'model' => $formData['model'],
            'price' => $formData['price'],
            'mfg_date' => $formData['mfg_date'],
            'serial' => $formData['serial'],
            'status' => $formData['status'],
            'manufacturer' => $formData['manufacturer'],
            'location' => $formData['location'],
            'warranty' => $formData['warranty'],
            'insurance' => $formData['insurance'],
            'net_weight' => $formData['net_weight'],
            'barcode' => $number,
        ]);

        $itemAttributes = [];

        foreach ($formData['value'] as $fieldData) {
            $itemAttribute = ItemAttribute::create([
                'item_id' => $item->id,
                'name' => $fieldData['label'],
                'value' => $fieldData['value'],
            ]);

            $itemAttributes[] = $itemAttribute;
        }

        return response()->json(['item' => $item, 'attributes' => $itemAttributes], 201);
    }
}
