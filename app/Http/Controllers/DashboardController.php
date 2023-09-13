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
}
