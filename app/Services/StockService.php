<?php

namespace App\Services;
use App\Models\User;
use App\Models\Stock; 
use Illuminate\Support\Facades\Auth;

class StockService
{
    public function getAssignedStocks()
    {
        $user = Auth::user();
        if (!$user) {
            throw new \Exception("User not authenticated.");
        }
        return $user->stocks;
    }

    public function assignstock(User $user,$stockId,  $assignedQuantities)
    {
        $user = Auth::user();
        $stock = Stock::find($stockId);
        dd($stock);
        $user->stocks()->attach($stockId,['quantity'=>$assignedQuantities]);
    }
    public function assignStockToUser($userId, $stockId, $quantity)
{
    $user = User::findOrFail($userId);
    $user->stocks()->attach($stockId, ['assigned_quantity' => $quantity]);
}

}