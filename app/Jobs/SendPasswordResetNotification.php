<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\AdminPasswordReset;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Password;

class SendPasswordResetNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private User $user
    ) {}

    public function handle(): void
    {
        // Generate password reset token
        $token = Password::createToken($this->user);
        
        // Send custom admin password reset notification
        $this->user->notify(new AdminPasswordReset($token));
    }
}
