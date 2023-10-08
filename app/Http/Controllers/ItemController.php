<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::latest()->paginate(10);

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

    public function search()
    {
        $searchQuery = request('query');
        $fields = Item::where(function ($query) use ($searchQuery) {
            $query->where('name', 'like', "%{$searchQuery}%")
                ->orWhere('serial', 'like', "%{$searchQuery}%")
                ->orWhere('status', 'like', "%{$searchQuery}%");
        })->paginate(10);

        return response()->json($fields);
    }

    public function destroy($id)
    {
        $items = Item::findOrFail($id);
        $items->delete();

        return response()->json($items);
    }

    public function getItems(Item $item)
    {
        return $item;
    }

    public function getAttributes($id)
    {
        $item = Item::find($id);

        if (!$item) {
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
        try {
            $formData = $request->validate([
                'name' => 'required|string',
                'serial' => 'required',
                'status' => 'required',
                'value' => 'required|array',
                'value.*.name' => 'required|string',
                'value.*.value' => 'string',
            ]);

            $item = Item::find($id);

            if (!$item) {
                return response()->json(['message' => 'Item not found'], 404);
            }

            $item->name = $formData['name'];
            $item->serial = $formData['serial'];
            $item->status = $formData['status'];
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
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating the item.'], 500);
        }
    }
}
