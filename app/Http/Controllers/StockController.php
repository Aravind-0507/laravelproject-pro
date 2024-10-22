<?php
namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $users = User::all();
        $stocks = Stock::all();
        return view('stocks.index', compact('users', 'stocks'));
    }

    public function create()
    {
        $stocks = Stock::where('quantity', '<=', 50)->get();
        return view('stocks.create', compact('stocks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        Stock::create($request->all());

        return redirect()->route('stocks.index')->with('success', 'Stock created successfully.');
    }

    public function edit($id)
    {
        $stock = Stock::findOrFail($id);
        return view('stocks.edit', compact('stock'));

    }

    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();

        return redirect()->route('stocks.index')->with('success', 'Stock deleted successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        $stock = Stock::findOrFail($id);
        $stock->update($request->all());
        return redirect()->route('stocks.index')->with('success', 'Stock updated successfully!');
    }

    public function assignStocksToUser($userId)
    {
        $user = User::findOrFail($userId);
        $stocks = Stock::where('quantity', '<=', 50)->get();;
        $outOfStockStocks = Stock::where('quantity', '>', 50)->get(); 
        return view('stocks.assign', compact('user', 'stocks', 'outOfStockStocks'));
        }

        public function storeAssignedStocks(Request $request, $userId)
        {
            $request->validate([
                'stocks' => 'required|array',
                'assigned_quantity' => 'required|integer|min:1',
                'is_active' => 'required|boolean',
            ]);
            $user = User::findOrFail($userId);
            foreach ($request->stocks as $stockId) {
                $stock = Stock::find($stockId);
                if ($stock && $stock->quantity >= $request->assigned_quantity) {
                    $user->stocks()->attach($stockId, [
                        'assigned_quantity' => $request->input('assigned_quantity'),
                        'is_active' => $request->input('is_active'),
                    ]);
                    $stock->decrement('quantity', $request->assigned_quantity);
                } else {
                    return redirect()->back()->withErrors(['stocks' => "Stock quantity exceeded or stock ID {$stockId} is unavailable."]);
                }
            }
            return redirect()->route('stocks.index')->with('success', 'Stocks assigned successfully.');
        }    
    public function showAssignStocks($userId)
    {
        $user = User::findOrFail($userId);
        $stocks = Stock::where('quantity', '<=', 50)->get();
        $outOfStockStocks = Stock::where('quantity', '>', 50)->get();
        return view('stocks.assign', compact('user', 'stocks', 'outOfStockStocks'));
    }
}