<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::latest()->paginate(10);

        return response()->json($employees);
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'first_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
            'position' => ['required', 'max:50'],
        ]);

        $employees = Employee::create($formFields);

        return response()->json($employees);
    }

    public function search(Request $request)
    {
        $searchQuery = $request->input('query');
        $employees = Employee::where(function ($query) use ($searchQuery) {
            $query->where('first_name', 'like', "%{$searchQuery}%")
                ->orWhere('last_name', 'like', "%{$searchQuery}%")
                ->orWhere('position', 'like', "%{$searchQuery}%");
        })->paginate(10);

        return response()->json($employees);
    }
}
