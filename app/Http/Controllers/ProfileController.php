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
            'email' => 'required|string|email|max:255|unique:employees,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $changes = false;


        if ($user->name !== $request->name) {
            $user->name = $request->name;
            $changes = true;
        }


        if ($user->email !== $request->email) {
            $user->email = $request->email;
            $changes = true;
        }


        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $changes = true;
        }


        if (!$changes) {
            return redirect()->back()->withErrors(['error' => 'No changes were made.']);
        }


        try {
            $user->save();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update profile.']);
        }
        return redirect()->route('employees.index')->with('success', 'Profile updated successfully!');
    }


}
