<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    public function index()
    {

        $employees = Employee::all();

        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:employees,name',
            'email' => 'required|unique:employees,email|email',
            'joining_date' => 'required|date|before:' . Carbon::now()->subYears(18)->toDateString(),
            'phone' => 'required|numeric',
            'password' => 'required|string|min:8',
        ], [
            'joining_date.before' => 'You must be at least 18 years old.',
        ]);
        Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'joining_date' => $request->joining_date,
            'is_active' => $request->is_active ? true : false,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('employees.index')->with('success', 'User created successfully.');
    }

    public function show($id)
    {

        $employee = Employee::findOrFail($id);

        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|unique:employees,name,' . $employee->id,
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'phone' => 'required|numeric|digits:10|unique:employees,phone,' . $employee->id,
            'joining_date' => 'required|date|before:' . Carbon::now()->subYears(18)->toDateString(),
            'is_active' => 'nullable|boolean',
            'password' => 'nullable|string|min:8',
        ]);

        $data = $request->all();

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $employee->update($data);

        return redirect()->route('employees.edit', $employee->id)->with('success', 'User details updated successfully!');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'User deleted successfully.');
    }

    public function getData()
    {
        $employees = Employee::all();
        return response()->json($employees);
    }
}