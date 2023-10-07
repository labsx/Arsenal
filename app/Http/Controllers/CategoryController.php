<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function listName()
    {
        $categories = Category::latest()->get();

        return $categories;
    }

    public function index()
    {
        $categories = Category::latest()->paginate(10);
        
        return $categories;
    }

    public function search()
    {
        $searchQuery = request('query');
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
            'name' => ['required', 'min:3', 'max:50', 'unique:categories'],
            'parent_id' => ['nullable', Rule::exists('parent_models', 'id')],
            'field_group_id' => ['nullable', Rule::exists('field_groups', 'id')],
        ]);

        $category = Category::create($formField);

        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $formField = $request->validate([
            'name' => ['required', 'min:3', 'max:50'],
        ]);

        $category = Category::findOrfail($id);
        $category->update($formField);

        return response()->json($category);
    }

    public function destroy($id)
    {
        $delete = Category::findOrfail($id);
        $delete->delete();

        return response()->json(['success' => true]);
    }

    public function fetchCategory()
    {
        $categories = Category::latest()->get();

        return $categories;
    }

    public function show(Category $category)
    {
        return $category;
    }
}
