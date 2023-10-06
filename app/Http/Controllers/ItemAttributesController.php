<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\ItemAttributes;

class ItemAttributesController extends Controller
{
    public function store(Request $request)
    {
        try {
            $formData = $request->validate([
                'item_id' => 'required|numeric',
                'value' => 'required|array',
                'value.*.label' => 'required|string',
                'value.*.value' => 'string',
            ]);

            $items = [];

            foreach ($formData['value'] as $fieldData) {
                $item = ItemAttributes::create([
                    'item_id' => $formData['item_id'],
                    'name' => $fieldData['label'],
                    'value' => $fieldData['value'],
                ]);

                $items[] = $item;
            }

            return response()->json($items, 201);
        } catch (\Exception $e) {
            return response()->json($item, 500);
        }
    }
    //     try {
    //         $formData = $request->validate([
    //             'item_id' => 'required|numeric',
    //             'value' => 'required|array',
    //             'value.*.label' => 'required|string',
    //             'value.*.value' => 'string',
    //         ]);

    //         $items = [];

    //         foreach ($formData['value'] as $fieldData) {

    //             $item = ItemAttributes::create([
    //               //  'item_id' => $formData['item_id'],
    //                 'name' => $fieldData['label'],
    //                 'value' => $fieldData['value'],
    //             ]);

    //             $items[] = $item;
    //         }


    //         return response()->json($items, 201);
    //     } catch (\Exception $e) {

    //         return response()->json(['error' => 'An error occurred while saving the items.'], 500);
    //     }
    // }
}
