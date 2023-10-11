<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\ItemAttribute;
use Illuminate\Validation\Rule;

class ItemAttributesController extends Controller
{
    public function store(Request $request)
    {
        $formData = $request->validate([
            'category_id' => 'required|numeric',
            'parent_id' => 'required|numeric',
            'item_name' => 'required|string',
            'serial' => 'required|unique:items,serial',
            'status' => 'required',
            'value' => 'required|array',
            'value.*.label' => 'required|string',
            'value.*.value' => 'required|string',
        ], [
            'category_id.required' => 'Select category name is required !',
            'parent_id.required' => 'Select sub category name is required !',
        ]);

        $number = mt_rand(1000000000, 9999999999);
        $request['barcode'] = $number;

        $item = Item::create([
            'category_id' => $formData['category_id'],
            'name' => $formData['item_name'],
            'parent_id' => $formData['parent_id'],
            'serial' => $formData['serial'],
            'status' => $formData['status'],
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
