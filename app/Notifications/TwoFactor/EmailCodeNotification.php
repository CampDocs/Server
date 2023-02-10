<?php

namespace App\Notifications\TwoFactor;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Crypt;

class EmailCodeNotification extends Notification
{
    use Queueable;

    /**
     * Get the notification's channels.
     */
    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        $code = Crypt::decrypt($notifiable->two_factor_secret);

        return (new MailMessage)
            ->subject(trans('Two Factor Authentication Code'))
            ->markdown('mail.two-factor.email-code', compact('code'));
    }
}
