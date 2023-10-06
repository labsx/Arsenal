<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\ItemData;
use App\Models\FieldGroup;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;



class FieldGroupController extends Controller
{
    public function index()
    {
        $field_groups = FieldGroup::latest()->get();

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

    // public function fields()
    // {
    //     $fieldnames = FieldGroup::latest()->get();

    //     return $fieldnames;
    // }

    // public function createFields(Request $request)
    // {
    //     $formFields = $request->validate([
    //         'name' => ['required', 'min:3', 'max:50'],
    //         // 'is_required' => ['required', 'min:3', 'max:50'],
    //         'description' => ['required', 'min:5', 'max:30'],
    //         'fields_id' => ['max:255']
    //     ]);

    //     Field::create($formFields);

    //     return response()->json(['success' => true]);
    // }

    // public function fieldsData()
    // {
    //     $fieldnames = FieldGroup::latest()->get();

    //     return $fieldnames;
    // }

    // public function fieldsDatas($fields_id)
    // {
    //     try {
    //         $selectedFieldData = Field::where('fields_id', $fields_id)->get(['name', 'description']);
    //         return response()->json($selectedFieldData);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Error fetching data from the other table'], 500);
    //     }
    // }


    public function categoryData(Request $request)
    {

        // $data = $request->all();
        // $category_id = $data['category_id'];
        // unset($data['_token']);
        // unset($data['category_id']);

        // $newColumns = [];

        // foreach ($data as $label => $inputValue) {
        //     if (!Schema::hasColumn('item_data', $label)) {
        //         Schema::table('item_data', function ($table) use ($label) {
        //             $table->string($label)->nullable();
        //         });

        //         $newColumns[] = $label;
        //     }
        // }

        // $itemData = ItemData::firstOrNew(['category_id' => $category_id]);
        // $itemData->category_id = $category_id;

        // foreach ($data as $label => $inputValue) {
        //     if (in_array($label, $newColumns) || !$itemData->getAttribute($label)) {
        //         // If the column is new or doesn't exist in the database, or the attribute is null
        //         $itemData->{$label} = $inputValue;
        //     }
        // }

        // $itemData->save();

        // return response()->json(['message' => 'Data saved successfully'], 200);


        // $data = $request->all();
        // $category_id = $data['category_id'];
        // unset($data['_token']);
        // unset($data['category_id']);

        // foreach ($data as $label => $inputValue) {
        //     if (!Schema::hasColumn('item_data', $label)) {
        //         Schema::table('item_data', function ($table) use ($label) {
        //             $table->string($label)->nullable();
        //         });
        //     }
        // }

        // $itemData = ItemData::firstOrNew(['category_id' => $category_id]);
        // $itemData->category_id = $category_id;

        // foreach ($data as $label => $inputValue) {
        //     $itemData->{$label} = $inputValue;
        // }

        // $itemData->save();

        // return response()->json(['message' => 'Data saved successfully'], 200);
    }
}
