<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['name','email','phone','joining_date','salary','is_active','password'];

    public $timestamps = false;
    use HasFactory;
}