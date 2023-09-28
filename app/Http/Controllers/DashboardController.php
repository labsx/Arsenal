<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function itemsCount(Request $request)
    {   
        $status = $request->query('status', 'TODAY');
        $serial = $request->query('serial'); 
        $query = Item::query();
        
        if ($status !== 'TODAY') {
            $query->where('status', $status);
        }
        
        if ($serial) {
            $query->where('serial', $serial);
        }

        $query->whereNotNull('serial');   
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
        $uniqueItems = Item::whereNotNull('serial')
            ->select('name')
            ->distinct()
            ->get();

        return response()->json(['items' => $uniqueItems]);
    }

    public function itemsCountByName(Request $request)
    {
        $itemName = $request->query('name');
        $count = Item::where('name', $itemName)
            ->whereNotNull('serial')
            ->count();

        return response()->json(['count' => $count]);
    }

    public function itemsCountAll(Request $request){
        $count = Item::whereNotNull('serial')
            ->select('name')
            ->distinct()
            ->count();

        return response()->json(['count' => $count]);
    }

    public function countNotes()
    {
        $count = Note::count();
        return response()->json(['count' => $count]);
    }

    public function countAll()
    {   
        $totalItemCount = Item::count();
        $goodItemCountPercent = ($totalItemCount > 0) ? (Item::where('status', 'Good')->count() / $totalItemCount) * 100 : 0;
        $badItemCountPercent = ($totalItemCount > 0) ? (Item::where('status', 'Bad')->count() / $totalItemCount) * 100 : 0;
        $issuedItemCountPercent = ($totalItemCount > 0) ? (Item::where('status', 'issued')->count() / $totalItemCount) * 100 : 0;
    
        return [
            'goodItemCountPercent' => $goodItemCountPercent,
            'badItemCountPercent' => $badItemCountPercent,
            'issuedItemCountPercent' => $issuedItemCountPercent,
        ];
    }

   public function itemWithoutSerialCount(Request $request)
   {
        $status = $request->query('status', 'TODAY');
        $query = Item::query();
        
        if ($status !== 'TODAY') {
            $query->where('status', $status);
        }
        
        $query->whereNull('serial');
        $count = $query->count();
        
        return response()->json(['count' => $count]);

    }

    public function AvailWithoutSerialCount()
    {
        $itemsWithoutSerialCount = Item::whereNull('serial')->get();
        
        return response()->json([
            'items' => $itemsWithoutSerialCount
        ]);
    }

}
