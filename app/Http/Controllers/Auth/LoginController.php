<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\StockService;

class LoginController extends Controller
{

    protected $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }
    public function showLoginForm()
    {
        return view('users.index'); 
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role == 1) {
                return redirect()->route('users.index');
            } 
            else{
                return redirect()->route(route: 'users.menu');
            }
        }
        return back()->withErrors(['email' => 'Invalid credentials']);
    }
    public function home()
    {
        return view('home');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/home');
    }
}