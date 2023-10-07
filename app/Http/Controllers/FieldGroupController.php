<?php

namespace App\Http\Controllers;

use App\Models\FieldGroup;
use Illuminate\Http\Request;

class FieldGroupController extends Controller
{
    public function index()
    {
        $field_groups = FieldGroup::latest()->paginate(10);

        return $field_groups;
    }

    public function create(Request $request)
    {
        $formFields = $request->validate([
            'name' => ['required', 'min:3', 'max:50', 'unique:field_groups'],
            'description' => ['max:255']
        ]);

        FieldGroup::create($formFields);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $delete = FieldGroup::findOrfail($id);
        $delete->delete();

        return response()->json($delete);
    }

    public function search()
    {
        $searchQuery = request('query');
        $field_groups = FieldGroup::where(function ($query) use ($searchQuery) {
            $query->where('name', 'like', "%{$searchQuery}%")
                ->orWhere('description', 'like', "%{$searchQuery}%");
        })->paginate(10);

        return response()->json($field_groups);
    }

    public function getName()
    {
        $categories = FieldGroup::latest()->select('id', 'name')->get();

        return $categories;
    }
}
