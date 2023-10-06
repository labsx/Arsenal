<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class FieldController extends Controller
{
    public function filterFields( Request $request)
    {
        $fieldGroupId = $request->query('field_groups_id');
        $filteredFields = Field::where('field_groups_id', $fieldGroupId)->get();

        return response()->json($filteredFields);
    }

    public function show($fieldGroupId)
    {
        $fields = Field::where('field_groups_id', $fieldGroupId)->get();

        if ($fields->isEmpty()) {   
            return response()->json(['error' => 'No fields found for the specified field group'], 404);
        }

        return response()->json($fields);
    }

    public function index()
    {
        $fields = Field::latest()->get();

        return $fields;
    }

    public function store(Request $request)
    {
        $formField = $request->validate([
            'field_groups_id' => ['nullable'],
            'label' => ['required', 'max:50'],
            'description' => ['max:255'],
            'is_required' => ['required'],
        ]);

        $category = Field::create($formField);

        return response()->json($category);
    }
}
