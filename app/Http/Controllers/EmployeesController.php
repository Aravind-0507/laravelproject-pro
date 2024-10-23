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
        'stocks' => 'required|array',
        'assigned_quantities' => 'required|array',
        'password' => 'required|string|min:8',
        'is_active' => 'required|boolean',
    ]);
    $employee = Employee::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'joining_date' => $request->joining_date,
        'password' => Hash::make($request->password),
        'is_active' => $request->is_active,
    ]);
    
    foreach ($request->stocks as $index => $stockId) {
        $assignedQuantity = $request->assigned_quantities[$index];
        $stock = Stock::find($stockId);
        if ($stock && $stock->quantity >= $assignedQuantity) {
            $employee->stocks()->attach($stockId, ['assigned_quantity' => $assignedQuantity]);
            $stock->decrement('quantity', $assignedQuantity);
        } else {
            return redirect()->back()->withErrors([
                'stocks' => 'Insufficient stock for ' . $stock->name
            ])->withInput();
        }
    }

    SendUserWelcomeEmail::dispatch($employee);

    return redirect()->route('employees.index')->with('success', 'User created successfully.');
}
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $id,
            'phone' => 'required|numeric',
            'joining_date' => 'required|date',
            'is_active' => 'nullable|boolean',
            'stocks' => 'required|array',
            'stocks.*' => 'exists:stocks,id',
            'assigned_quantities' => 'required|array',
            'assigned_quantities.*' => 'required|numeric|min:0',
        ]);
        $employee = Employee::findOrFail($id);
        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'joining_date' => $request->joining_date,
            'is_active' => $request->is_active ?? 0,
        ]);
        $syncData = [];
        foreach ($data['stocks'] as $key => $stockId) {
            $stock = Stock::findOrFail($stockId);
            $assignedQuantity = $data['assigned_quantities'][$key];
            $newQuantity = $stock->quantity - $assignedQuantity;
            if ($newQuantity < 0) {
            return redirect()->back()->withErrors(['error' => 'Not enough stock available for ' . $stock->name]);
            }
            $stock->quantity = $newQuantity;
            $stock->save();
            $syncData[$stockId] = ['assigned_quantity' => $assignedQuantity];
        }
        $employee->stocks()->sync($syncData);
        return redirect()->route('employees.index')->with('success', 'Employee and stock details updated successfully!');
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