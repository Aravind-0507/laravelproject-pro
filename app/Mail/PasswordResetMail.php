<?php

namespace App\Mail;
use app\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $employee;
    public $token;

    public function __construct(Employee $employee)
    {
        $this->employee= $employee;
        
    }

    public function build()
    {
        return $this->view('emails.password_reset')
                    ->with([
                        'name' => $this->employee->name,
                        'resetLink' => url('/password/reset', $this->token), // Send the reset token in the URL
                    ]);
    }
}
