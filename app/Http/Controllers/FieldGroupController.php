<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Field;
use App\Models\FieldGroup;
use Illuminate\Http\Request;

class FieldGroupController extends Controller
{
    public function index()
    {
        $field_groups = FieldGroup::latest()->paginate(10);

        return $field_groups;
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => ['required', 'min:3', 'max:50', 'unique:field_groups'],
            'description' => ['max:255'],
        ]);

        $fieldGroups = FieldGroup::create($formFields);

        return response()->json($fieldGroups);
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

    public function getFields()
    {
        $field_groups = FieldGroup::latest()->select('id', 'name')->get();

        return $field_groups;
    }

    public function show($id)
    {
        $field_groups = FieldGroup::findOrFail($id);

        return $field_groups;
    }

    public function update(Request $request, $id)
    {
        $formFields = $request->validate([
            'name' => ['required', 'min:3', 'max:50'],
            'description' => ['nullable', 'max:255'],
        ]);

        $field_groups = FieldGroup::findOrFail($id);
        $field_groups->update($formFields);

        return response()->json(['message' => 'Field groups updated successfully', 'field_groups' => $field_groups]);
    }

    public function getFieldGroupName($id)
    {
        try {
            $fieldGroup = FieldGroup::findOrFail($id);

            return response()->json(['name' => $fieldGroup->name]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Field group not found'], 404);
        }
    }

    public function getFieldsByFieldGroupId($id)
    {
        $fieldsData = Field::where('field_groups_id', $id)->get();

        return response()->json($fieldsData);
    }

    public function fieldShow()
    {
        $field_groups = FieldGroup::latest()->select('id', 'name')->get();

        return $field_groups;
    }

    public function getList()
    {
        $categories = Category::latest()->get();

        return $categories;
    }
}
