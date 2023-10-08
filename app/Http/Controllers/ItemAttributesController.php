<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\ItemAttribute;

class ItemAttributesController extends Controller
{
    public function store(Request $request)
    {
        try {
            $formData = $request->validate([
                'category_id' => 'required|numeric',
                'item_name' => 'required|string',
                'serial' => 'required',
                'status' => 'required',
                'value' => 'required|array',
                'value.*.label' => 'required|string',
                'value.*.value' => 'string',
            ]);

            $item = Item::create([
                'category_id' => $formData['category_id'],
                'name' => $formData['item_name'],
                'serial' => $formData['serial'],
                'status' => $formData['status'],
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
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while saving the item.'], 500);
        }
    }
}
