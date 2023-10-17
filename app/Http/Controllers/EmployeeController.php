<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $searchQuery = $request->input('query');
        $employees = Employee::where(function ($query) use ($searchQuery) {
            $query->where('first_name', 'like', "%{$searchQuery}%")
                ->orWhere('last_name', 'like', "%{$searchQuery}%")
                ->orWhere('position', 'like', "%{$searchQuery}%");
        })
        ->latest() 
        ->paginate(10); 

        return response()->json($employees);
    }
    
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'first_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
            'position' => ['required', 'max:50'],
        ]);

        $existEmployee = Employee::where('first_name', $formFields['first_name'])
            ->where('last_name', $formFields['last_name'])
            ->first();

        if ($existEmployee) {
            return response()->json(['error' => 'Employee already registered !'], 400);
        }

        $employees = Employee::create($formFields);

        return response()->json($employees);
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response()->noContent();
    }

    public function show($id)
    {
        $employees = Employee::findOrFail($id);

        return response()->json($employees);
    }

    public function update(Request $request, Employee $employee)
    {
        $formFields = $request->validate([
            'first_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
            'position' => ['required', 'max:50'],
        ]);

        $employee->update($formFields);

        return response()->json($employee);
    }
}
