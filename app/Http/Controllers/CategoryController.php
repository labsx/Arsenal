<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\CategoryList;
use App\Models\FieldGroup;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        // if ($request->has('children')) {
        //     $categories = Category::whereNotNull('parent_id')
        //         ->latest()
        //         ->get();
        // } else {
        //     $categories = Category::latest()->get();
        // }

        // return Category::when($request->input('children') === 'true', function($query) {
        //         $query->whereNotNull('parent_id');
        //     })
        //     ->latest()
        //     ->get();
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
            'name' => ['required', 'min:3', 'max:50'],
            'parent_id' => ['nullable', Rule::exists('parent_models', 'id')],
            'field_group_id' => ['nullable', Rule::exists('field_groups', 'id')],
            // 'field_group_id' => [Rule::exists(FieldGroup::class)],
        ]);

        $category = Category::create($formField);

        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $formField = $request->validate([
            'name' => ['required', 'min:3', 'max:50'],
            'parents_id' => ['required', 'min:3', 'max:50'],
            'field_groups_id' => ['required', 'min:3', 'max:50'],
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

    // public function create(Request $request)
    // {
    //     $formFields = $request->validate([
    //         'name' => ['required', 'min:3', 'max:50', 'unique:categories'],
    //         'parent_id' => ['max:255'],
    //         'field_group_id' => ['required', 'max:30'],
    //     ]);

    //     Category::create($formFields);

    //     return response()->json(['success' => true]);
    // }
    public function fetchCategory()
    {
        $categories = Category::latest()->get();

        return $categories;
    }

    public function createItems(Request $request)
    {
        //     $formFields = $request->validate([
        //         'name' => ['required', 'min:3', 'max:50', Rule::unique('category_lists')],
        //         'parent_id' => ['max:255'],
        //         'category_id' => ['max:255']
        //     ]);

        //     CategoryList::create($formFields);

        //     return response()->json(['success' => true]);
        // }

        // public function fetchCategorySub()
        // {
        //     $subnames = CategoryList::latest()->get();
        //     return $subnames;
    }
}


    // public function createItems(Request $request)
    // {
    //     $formFields = $request->validate([
    //         'name' => ['required', 'min:3', 'max:50', Rule::unique('categories')],
    //         'serial' => ['required', 'min:3', 'max:50'],
    //         'processor' => ['required', 'min:3', 'max:50'],
    //         'date' => ['required'],
    //         'model' => ['required', 'min:3', 'max:50'],
    //         'size' => ['required', 'max:255'],
    //         'description' => ['required', 'min:5', 'max:30'],
    //         'ram' => ['required', 'min:1', 'max:255'],
    //         'category_id' => ['max:255']
    //     ]);

    //     // Create the item
    //     Item::create($formFields);

    //     return response()->json(['success' => true]);
    // }
