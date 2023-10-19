<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FieldGroup;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function listName($id)
    {
        $ids = Category::findOrFail($id);

        return response()->json($ids);
    }

    public function index(Request $request)
    {
        $searchQuery = $request->input('query');
        $categories = Category::where(function ($query) use ($searchQuery) {
            $query->where('name', 'like', "%{$searchQuery}%")
                ->orWhere('parent_id', 'like', "%{$searchQuery}%")
                ->orWhere('field_group_id', 'like', "%{$searchQuery}%");
        })->paginate(10);

        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $formField = $request->validate([
            'name' => ['required', 'min:3', 'max:50', Rule::unique('categories', 'name')],
            'field_group_id' => ['nullable', Rule::exists('field_groups', 'id')],
        ]);

        $category = Category::create($formField);

        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $formField = $request->validate([
            'name' => ['required', 'min:3', 'max:50'],
            'field_group_id' => ['required'],
        ], [
            'name.required' => 'The category name field is required !',
        ]);

        $category = Category::findOrfail($id);
        $category->update($formField);

        return response()->json($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->noContent();
    }

    public function fetchCategory()
    {
        $categories = Category::latest()->get();

        return response()->json($categories);
    }

    public function show(Category $category)
    {
        return $category;
    }

    public function categoryData()
    {
        $categories = Category::latest()->get();

        return response()->json($categories);
    }

    public function getFieldsDetails()
    {
        $fields_groups = FieldGroup::latest()->get(); //fields for edit category

        return $fields_groups;
    }
}
