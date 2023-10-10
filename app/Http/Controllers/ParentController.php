<?php

namespace App\Http\Controllers;


use App\Models\ParentModel;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    public function index()
    {
        $parents = ParentModel::latest()->paginate(10);

        return response()->json($parents);
    }

    public function store(Request $request)
    {
        $formField = $request->validate([
            'name' => 'required|min:3|max:50|unique:parent_models,name',
            'category_id' => ['required'],
        ]);

        $parent = ParentModel::create($formField);

        return response()->json($parent);
    }

    public function search()
    {
        $searchQuery = request('query');
        $parents = ParentModel::where(function ($query) use ($searchQuery) {
            $query->where('name', 'like', "%{$searchQuery}%");
        })->paginate(10);

        return response()->json($parents);
    }

    public function showData($fieldGroupId)
    {
        $parents = ParentModel::where('category_id', $fieldGroupId)->paginate(10);

        if ($parents->isEmpty()) {
            return response()->json(['error' => 'No parents found for the specified field group'], 404);
        }

        return response()->json($parents);
    }

    public function destroy($id)
    {
        $parent = ParentModel::findOrFail($id);
        $parent->delete();

        return response()->json($parent);
    }

    public function getData()
    {
        $parents = ParentModel::latest()->get(['id', 'name']);

        return response()->json($parents);
    }
}
