<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemAttribute;

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
}
