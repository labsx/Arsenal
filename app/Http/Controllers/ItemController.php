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
    
}