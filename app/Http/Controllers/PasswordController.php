<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
class PasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $token = Str::random(60);
            $user->expires_at = Carbon::now()->addMinutes(3);
            $user->save();
            Mail::send('emails.password_reset', [
                'user' => $user,
                'name' => $user->name,
                'token' => $token,
            ], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Reset Password');
            });

            return back()->with('status', 'If your email is registered, we have sent you a password reset link.');
        }

        return back()->withErrors(['email' => 'The provided email address is not registered.']);
    }
    public function showResetForm($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('password.request')->withErrors(['email' => 'User not found.']);
        }

        if (is_null($user->expires_at)) {
            return redirect()->route('password.request')->withErrors(['token' => 'Invalid reset request.']);
        }

        if (Carbon::now()->greaterThan(Carbon::parse($user->expires_at))) {

            return redirect()->route('password.request')->withErrors(['token' => 'This password reset link has expired.']);
        }

        return view('auth.passwords.reset')->with(['id' => $id]);
    }
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {

            if (is_null($user->expires_at)) {
                return redirect()->route('password.request')->withErrors(['token' => 'Invalid reset request.']);
            }

            if (Carbon::now()->greaterThan(Carbon::parse($user->expires_at))) {

                return redirect()->route('password.request')->withErrors(['token' => 'This password reset link has expired.']);
            }

            $user->forceFill([
                'password' => Hash::make($request->password),
                'expires_at' => null,
            ])->save();

            event(new PasswordReset($user));

            return redirect()->route('home')->with('status', __('Your password has been reset successfully.'));
        }
        return redirect()->route('password.request')->withErrors(['email' => 'User not found.']);
    }
}