<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FieldGroup;
use App\Models\History;
use App\Models\Item;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function categoryCount(Request $request)
    {
        $categories = Category::count();

        return response()->json(['categories' => $categories]);
    }

    public function usersCount()
    {
        $count = User::count();

        return response()->json(['count' => $count]);
    }

    public function fieldsCount()
    {
        $fields = FieldGroup::count();

        return response()->json(['fields' => $fields]);
    }

    public function itemsCount()
    {
        $items = Item::count();

        return response()->json(['items' => $items]);
    }

    public function historyCount()
    {
        $histories = History::count();

        return response()->json(['histories' => $histories]);
    }

    public function countNotes()
    {
        $count = Note::count();

        return response()->json(['count' => $count]);
    }

    public function progressBar()
    {
        $totalItemCount = Item::count();
        $goodItemCountPercent = ($totalItemCount > 0) ? (Item::where('status', 'operating')->count() / $totalItemCount) * 100 : 0;
        $badItemCountPercent = ($totalItemCount > 0) ? (Item::where('status', 'decommissioned')->count() / $totalItemCount) * 100 : 0;
        $issuedItemCountPercent = ($totalItemCount > 0) ? (Item::where('status', 'issue')->count() / $totalItemCount) * 100 : 0;
        $underRepairItemCountPercent = ($totalItemCount > 0) ? (Item::where('status', 'under repair')->count() / $totalItemCount) * 100 : 0;

        return [
            'goodItemCountPercent' => $goodItemCountPercent,
            'badItemCountPercent' => $badItemCountPercent,
            'issuedItemCountPercent' => $issuedItemCountPercent,
            'underRepairItemCountPercent' => $underRepairItemCountPercent,
        ];
    }

    public function usersGet()
    {
        $users = User::latest()->get();

        return $users;
    }
}
