<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
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
            'serial' => ['required', 'min:3','max:100', Rule::unique('items', 'serial')],
            'date' => ['required'],
            'model' => ['required', 'min:3', 'max:30'],
            'status' => ['required', 'min:3', 'max:10'],
            'description' => ['required', 'min:3', 'max:255'],
        ], [
            'serial' => 'Item already added'
        ]);
        Item::create($formFields);
        
        return response()->json(['success' => true]);
    }

    public function destroy(Item $item)
    {
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
            'serial' => ['required', 'min:3','max:100', Rule::unique('items', 'serial')->ignore($item->id)],
            'date' => ['required'],
            'model' => ['required', 'min:3', 'max:30'],
            'status' => ['required', 'min:3', 'max:10'],
            'description' => ['required', 'min:3', 'max:255'],
        ], [
            'serial' => 'Item already added'
        ]);
        $item->update($formFields);
        
        return response()->json(['success' => true]);
    }

    public function search()
    {
        $searchQuery = request('query');
        
        $items = Item::where('serial', 'like', "%{$searchQuery}%")->paginate(10);
        return response()->json($items);
    }
}
