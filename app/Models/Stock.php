<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'quantity', 'status'];

    public function users()
    {
        return $this->belongsToMany(User::class,'stock_user')->withPivot('assigned_quantity','is_active');
    }

    public function stocks()
    {
        return $this->belongsToMany(Stock::class, 'stock_user')->withPivot('assigned_quantity');
    }
}