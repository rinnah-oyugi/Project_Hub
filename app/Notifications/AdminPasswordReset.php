<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AdminPasswordReset extends Notification
{
    public function __construct(
        public string $token
    ) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $resetUrl = route('password.reset', $this->token) . '?email=' . urlencode($notifiable->getEmailForPasswordReset());

        return (new MailMessage)
            ->subject('ProjectHub - Password Reset Requested by Administrator')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('An administrator has triggered a password reset for your ProjectHub account.')
            ->line('This is a security measure to ensure you have secure access to your account.')
            ->action('Reset Your Password', $resetUrl)
            ->line('This password reset link will expire in ' . config('auth.passwords.'.config('auth.defaults.passwords').'.expire') . ' minutes.')
            ->line('If you did not request this reset, please contact your system administrator immediately.')
            ->salutation('Regards, ProjectHub Administration');
    }
}
