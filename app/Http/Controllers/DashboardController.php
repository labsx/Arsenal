<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function itemsCount(Request $request)
    {
        $status = $request->query('status', 'TODAY'); 
        $query = Item::query();
        if ($status !== 'TODAY') {
            $query->where('status', $status);
        }
        $count = $query->count();
    
        return response()->json(['count' => $count]);
    }

    public function usersCount(Request $request )
    {
        $count = User::count();
        return response()->json(['count' => $count]);
    }

    public function itemsList(Request $request )
    {
        $uniqueItems = Item::select('name')->distinct()->get();
        return response()->json(['items' => $uniqueItems]);
    }
    public function itemsCountByName(Request $request)
    {
        $itemName = $request->query('name');
        $count = Item::where('name', $itemName)->count();
        
        return response()->json(['count' => $count]);
    }

    public function itemsCountAll(Request $request){
        $count = Item::count();
        return response()->json(['count' => $count]);
    }
}
