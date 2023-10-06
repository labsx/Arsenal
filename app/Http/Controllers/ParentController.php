<?php

namespace App\Http\Controllers;


use App\Models\ParentModel;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    public function index()
    {
        $parents = ParentModel::latest()->get();

        return $parents;
    }

    public function store(Request $request)
    {
        $formField = $request->validate ([
            'name' => ['required'],
        ]);

        $parent = ParentModel::create($formField);

        return response()->json($parent);
    }
}
