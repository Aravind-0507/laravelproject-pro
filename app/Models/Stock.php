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
}