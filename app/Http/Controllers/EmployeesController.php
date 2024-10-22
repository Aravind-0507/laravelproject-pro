<?php

namespace App\Http\Controllers;
use App\Jobs\SendUserWelcomeEmail;
use Illuminate\Http\Request;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Stock;
use Illuminate\Support\Facades\Log;

class EmployeesController extends Controller
{
    public function index()
    {

        $employees = Employee::all();

        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $stocks = Stock::where('quantity', '<=', 50)->get();
        return view('employees.create', compact('stocks'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees',
            'phone' => 'required|numeric',
            'joining_date' => 'required|date',
            'password' => 'required|numeric|min:8',
            'is_active' => 'nullable|boolean',
            'assigned_quantities' => 'required|array',
            'assigned_quantities.*' => 'required|numeric',
        ]);

        $employee = Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'joining_date' => $request->joining_date,
            'is_active' => $request->is_active == '1' ? 1 : 0,
            'password' => Hash::make($request->password),
        ]);


        foreach ($request->stocks as $index => $stockId) {
            if (Stock::find($stockId)) {
                $employee->stocks()->attach($stockId, ['assigned_quantity' => $request->assigned_quantities[$index]]);
            } else {
                Log::error("Stock ID {$stockId} does not exist.");
            }
        }
        SendUserWelcomeEmail::dispatch($employee);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully!');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $id,
            'phone' => 'required|numeric',
            'joining_date' => 'required|date',
            'is_active' => 'nullable|boolean',
            'assigned_quantities' => 'required|array',
            'assigned_quantities.*' => 'required|numeric|min:0',
        ]);

        $employee = Employee::findOrFail($id);
        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'joining_date' => $request->joining_date,
            'is_active' => $request->is_active == '1' ? 1 : 0,
        ]);
        foreach ($request->assigned_quantities as $stockId => $quantity) {
            $employee->stocks()->updateExistingPivot($stockId, ['assigned_quantity' => $quantity]);
        }

        return redirect()->route('employees.index')->with('success', 'User  Details updated successfully!');
    }

    public function show($id)
    {
        $employee = Employee::with('stocks')->findOrFail($id);
        return view('employees.show', compact('employee'));
    }

    public function edit($id)
    {
        $employee = Employee::with('stocks')->findOrFail($id);
        $stocks = Stock::all();
        $assignedQuantities = $employee->stocks->pluck('pivot.assigned_quantity', 'id')->toArray();
        $filteredStocks = $stocks->filter(function ($stock) use ($assignedQuantities) {
            return isset($assignedQuantities[$stock->id]) && $assignedQuantities[$stock->id] > 0;
        });
        return view('employees.edit', compact('employee', 'filteredStocks', 'assignedQuantities', 'stocks'));
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