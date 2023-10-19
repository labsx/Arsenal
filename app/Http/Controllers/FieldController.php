<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\FieldGroup;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function showFilterFileds($id) //field table
    {
        $fields = Field::where('field_groups_id', $id)->paginate(10);

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

    public function index()
    {
        $field_groups = FieldGroup::latest()->get();

        return response()->json($field_groups);
    }

    // public function getFieldsDetails()
    // {
    //     $fields_groups = FieldGroup::latest()->select('id', 'name')->get(); //fields for edit category

    //     return $fields_groups;
    // }
}
