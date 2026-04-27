<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UserReadmitted extends Notification
{
    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('ProjectHub - Account Reactivated')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Good news! Your ProjectHub account has been reactivated by an administrator.')
            ->line('You can now access the system and continue your academic work.')
            ->line('Your previous data and progress have been preserved.')
            ->action('Access Your Account', route('login'))
            ->line('Welcome back to ProjectHub!')
            ->salutation('Regards, ProjectHub Administration');
    }
}
