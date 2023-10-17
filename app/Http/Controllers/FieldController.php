<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\FieldGroup;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    // public function filterFields(Request $request)
    // {
    //     $fieldGroupId = $request->query('field_groups_id');
    //     $filteredFields = Field::where('field_groups_id', $fieldGroupId)->get();

    //     return response()->json($filteredFields);
    // }

    public function showFilterFileds($fieldGroupId)
    {
        $fields = Field::where('field_groups_id', $fieldGroupId)->paginate(10);

        if ($fields->isEmpty()) {
            return response()->json(['error' => 'No fields found for the specified field group'], 404);
        }

        return response()->json($fields);
    }

    public function index(Request $request)
    {
        $searchQuery = $request->input('query');
        $fields = Field::where(function ($query) use ($searchQuery) {
            $query->where('label', 'like', "%{$searchQuery}%")
                ->orWhere('description', 'like', "%{$searchQuery}%")
                ->orWhere('is_required', 'like', "%{$searchQuery}%");
        })->paginate(10);

        return response()->json($fields);
    }

    public function store(Request $request)
    {
        $formField = $request->validate([
            'field_groups_id' => ['nullable'],
            'label' => ['required', 'max:50'],
            'description' => ['max:255'],
            'is_required' => ['required'],
        ]);

        $existingField = Field::where('field_groups_id', $formField['field_groups_id'])
            ->where('label', $formField['label'])
            ->first();

        if ($existingField) {
            return response()->json(['error' => 'Field data already exist !'], 422);
        }

        $category = Field::create($formField);

        return response()->json($category);
    }

    // public function search()
    // {
    //     $searchQuery = request('query');
    //     $fields = Field::where(function ($query) use ($searchQuery) {
    //         $query->where('label', 'like', "%{$searchQuery}%")
    //             ->orWhere('description', 'like', "%{$searchQuery}%")
    //             ->orWhere('is_required', 'like', "%{$searchQuery}%");
    //     })->paginate(10);

    //     return response()->json($fields);
    // }

    public function destroy($id)
    {
        $fields = Field::findOrFail($id);
        $fields->delete();

        return response()->json($fields);
    }

    public function show(Field $field)
    {
        return response()->json($field); //edit fields
    }

    public function update(Request $request, $id)
    {
        $formField = $request->validate([
            'label' => ['required', 'min:3', 'max:50'],
            'is_required' => ['max:50'],
            'description' => ['max:255'],
        ]);

        $category = Field::findOrfail($id);
        $category->update($formField);

        return response()->json($category);
    }

    public function getFieldsDetails()
    {
        $fields_groups = FieldGroup::latest()->select('id', 'name')->get(); //fields for edit category

        return $fields_groups;
    }

    // public function getFieldsId($id)
    // {
    //     $ids = FieldGroup::findOrFail($id);

    //     return response()->json($ids);
    // }
}
