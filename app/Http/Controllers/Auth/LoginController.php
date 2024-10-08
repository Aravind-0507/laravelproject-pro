<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;

class LoginController extends Controller
{
    public function showLoginForm()
    {   
        return view('employees.index');
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            // Check for admin role
            if (Auth::user()->role == 1) {
                return redirect()->route('employees.index'); // Redirect to employee page for admin
            }
            return redirect()->route('employees.index'); // Redirect regular users to the dashboard
        } else {
            return back()->withErrors(['email' => 'Invalid credentials']);
        }   
    }    
    public function home(){
        return view('home');
    }
    // public function logout()
    // {
    //     Auth::logout();
    //     return redirect('');
    // }
}