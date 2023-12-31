<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\FieldGroup;
use Illuminate\Http\Request;

class FieldGroupController extends Controller
{
    public function index(Request $request)
    {
        $searchQuery = $request->input('query');
        $field_groups = FieldGroup::when($searchQuery, function ($query) use ($searchQuery) {
            $query->where('name', 'like', "%{$searchQuery}%")
                ->orWhere('description', 'like', "%{$searchQuery}%");
        })
            ->latest()
            ->paginate(10);

        return response()->json($field_groups);
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

    public function destroy(FieldGroup $fieldGroup)
    {
        $fieldGroup->delete();

        return response()->noContent();
    }

    public function show($id)
    {
        $field_groups = FieldGroup::findOrFail($id);

        return response()->json($field_groups);
    }

    public function update(Request $request, $id)
    {
        $formFields = $request->validate([
            'name' => ['required', 'min:3', 'max:50'],
            'description' => ['nullable', 'max:255'],
        ]);

        $field_groups = FieldGroup::findOrFail($id);
        $field_groups->update($formFields);

        return response()->json($field_groups);
    }

    // public function getFieldsByFieldGroupId($id)
    // {
    //     $fieldsData = Field::where('field_groups_id', $id)->get();

    //     return response()->json($fieldsData);
    // }
}
