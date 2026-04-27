<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UserSuspended extends Notification
{
    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('ProjectHub - Account Suspended')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your ProjectHub account has been suspended by an administrator.')
            ->line('This action has been taken due to policy violations or administrative review.')
            ->line('While suspended, you will not be able to access the system.')
            ->line('If you believe this is an error, please contact your system administrator.')
            ->action('Contact Administrator', route('login'))
            ->line('Your account can be reactivated by an administrator when appropriate.')
            ->salutation('Regards, ProjectHub Administration');
    }
}
