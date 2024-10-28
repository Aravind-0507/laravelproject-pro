<?php

namespace App\Mail;

use App\Models\User; // Changed 'app' to 'App' for the correct namespace
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user; 
    public $token;

    public function __construct(User $user)
    {
        $this->user = $user; 
    }

    public function build()
    {
        return $this->view('emails.password_reset')
                    ->with([
                        'name' => $this->user->name, 
                        'resetLink' => url('/password/reset', $this->token), 
                    ]);
    }
}
