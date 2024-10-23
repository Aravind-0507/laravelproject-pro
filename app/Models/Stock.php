<?php

namespace App\Models;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'quantity', 'status'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function stocks()
    {
        return $this->belongsToMany(Stock::class)->withPivot('assigned_quantity');
    }
}