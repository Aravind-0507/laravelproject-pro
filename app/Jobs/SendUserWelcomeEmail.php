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

    public $employee;

    /**
     * Create a new job instance.
     *
     * @param $employee
     */
    public function __construct($employee)
    {
        $this->employee = $employee;
    }

    public function handle()
    {
        try {
            if (!empty($this->employee->email)) {
                Log::info('Sending welcome email to ' . $this->employee->email);
                Mail::to(users: $this->employee->email)->send(new WelcomeEmail($this->employee));
                Log::info('Welcome email sent successfully to ' . $this->employee->email);
            } else {
                Log::error('Failed to send welcome email: No email address provided for employee.');
            }
        } catch (\Exception $e) {
            Log::error('Failed to send welcome email: ' . $e->getMessage());
        }
    }
}