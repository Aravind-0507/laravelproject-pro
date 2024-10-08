<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    
    public function index()
    {
        // This will return the welcome view
        return view('employees.index');
    }
    
    public function logout()
    {
        return redirect('home');
    }
}