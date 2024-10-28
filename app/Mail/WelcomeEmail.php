<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user; // Changed from $employee to $user

    public function __construct($user) // Changed parameter name from $employee to $user
    {
        $this->user = $user; // Updated property assignment
    }

    public function build() 
    {
        return $this->view('emails.Welcome')->with('user', $this->user); // Changed from 'employee' to 'user'
    }
}
