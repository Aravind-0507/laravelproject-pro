<?php

namespace App\Jobs;

use App\Mail\WelcomeEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendUserWelcomeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user; // Changed from $employee to $user

    /**
     * Create a new job instance.
     *
     * @param $user
     */
    public function __construct($user) // Changed parameter name from $employee to $user
    {
        $this->user = $user; // Updated property assignment
    }

    public function handle()
    {
        try {
            if (!empty($this->user->email)) {
                Log::info('Sending welcome email to ' . $this->user->email);
                Mail::to($this->user->email)->send(new WelcomeEmail($this->user)); 
                Log::info('Welcome email sent successfully to ' . $this->user->email); // Updated log message
            } else {
                Log::error('Failed to send welcome email: No email address provided for user.'); // Updated log message
            }
        } catch (\Exception $e) {
            Log::error('Failed to send welcome email: ' . $e->getMessage());
        }
    }
}
