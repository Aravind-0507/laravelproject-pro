<?php

namespace App\Http\Controllers;

use App\Jobs\SendUserWelcomeEmail;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Stock;
use Illuminate\Support\Facades\Log;
use App\Services\StockService;
use Illuminate\Support\Facades\Auth;
class UsersController extends Controller
{
    protected $stockService;
    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }
    public function create()
    {
        $stocks = Stock::where('quantity', '<=', 50)->get();
        return view('users.create', compact('stocks'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|numeric',
            'joining_date' => 'required|date',
            'stocks' => 'required|array',
            'assigned_quantities' => 'required|array',
            'password' => 'required|string|min:8',
            'is_active' => 'required|boolean',
        ]);
        $user = User::create([
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
                $user->stocks()->attach($stockId, ['assigned_quantity' => $assignedQuantity]);
                $stock->decrement('quantity', $assignedQuantity);
            } else {
                return redirect()->back()->withErrors([
                    'stocks' => 'Insufficient stock for ' . $stock->name
                ])->withInput();
            }
        }
        SendUserWelcomeEmail::dispatch($user);
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|numeric',
            'joining_date' => 'required|date',
            'is_active' => 'nullable|boolean',
            'stocks' => 'required|array',
            'stocks.*' => 'exists:stocks,id',
            'assigned_quantities' => 'required|array',
            'assigned_quantities.*' => 'required|numeric|min:0',
        ]);
        $user = User::findOrFail($id);
        $user->update([
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
        $user->stocks()->sync($syncData);
        return redirect()->route('users.index')->with('success', 'User and stock details updated successfully!');
    }
    public function show($id)
    {
        $user = User::with('stocks')->findOrFail($id);
        return view('users.show', compact('user'));
    }
    public function edit($id)
    {
        $user = User::with('stocks')->findOrFail($id);
        $stocks = Stock::all();
        $assignedQuantities = $user->stocks->pluck('pivot.assigned_quantity', 'id')->toArray();
        $filteredStocks = $stocks->filter(function ($stock) use ($assignedQuantities) {
            return isset($assignedQuantities[$stock->id]) && $assignedQuantities[$stock->id] > 0;
        });
        return view('users.edit', compact('user', 'filteredStocks', 'assignedQuantities', 'stocks'));
    }
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    // public function menu()
    // {
    //     $stocks = $this->stockService->getAssignedStocks();
    //     return view('users.menu', compact('stocks'));
    // }

    public function assignStocks(User $user, $stockId)
    {
        $stocks = Stock::where('quantity', '<', 50)->get();
        $stocks = Stock::all();
        $selectedStock = Stock::findOrFail($stockId); 
        return view('users.assign_stocks', compact('stocks', 'selectedStock','user'));
    }
    public function storeStock(Request $request)
    {
        $request->validate([
            'stock_id' => 'required|exists:stocks,id',
            'assigned_quantity' => 'required|integer|min:1',
        ]);
        $stock = Stock::findOrFail($request->stock_id);
        $user = auth()->user(); 
        if ($stock->quantity >= $request->assigned_quantity) {
            $stock->quantity -= $request->assigned_quantity;
            $stock->save();
            $user->stocks()->attach($stock->id, ['assigned_quantity' => $request->assigned_quantity]);

            return redirect()->route('users.menu')->with('success', 'Stock assigned successfully!');
        } else {
            return back()->withErrors(['assigned_quantity' => 'Not enough stock available.']);
        }
    }
    public function menu()
{
    $user = auth()->user();
    if (!$user) {
        return redirect()->route('login')->withErrors(['You must be logged in to view this page.']);
    }
    $stocks = $user->stocks;
    return view('user_menu', compact('stocks', 'user'));
}

    public function showAssignStockForm()
    {
        $stocks = Stock::where('quantity', '<=', 50)->get();
        return view('users.assign_stocks', compact('stocks'));
    }
    public function getData()
    {
        $users = User::all();
        return response()->json($users);
    }
}