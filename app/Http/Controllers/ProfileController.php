<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 
class ProfileController extends Controller
{
    public function edit()
{
    return view('profile.edit');
}
public function update(Request $request)
{
    $user = Auth::user();
    $validatedData = $request->validate([
        'name' => 'required|string|max:100',
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        'password' => 'nullable|string|min:8|confirmed',
    ]);
    $user->name = $validatedData['name'];
    $user->email = $validatedData['email'];
    if ($request->filled('password')) {
        $user->password = Hash::make($validatedData['password']);
    }
    $user->save();

    return redirect()->back()->with('success', 'Profile updated successfully!');
}
}