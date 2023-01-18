<?php

namespace App\Notifications\Auth;

use Closure;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends Notification
{
    use Queueable;

    public static $toMailCallback;

    public static $createUrlCallback;

    /**
     * Get the notification's delivery channels.
     */
    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }

        return $this->buildMailMessage($verificationUrl);
    }

    /**
     * Get the verify email notification mail message for the given URL.
     */
    protected function buildMailMessage(string $url): MailMessage
    {
        return (new MailMessage())
            ->subject(trans('Verify Email Address'))
            ->markdown('mail.auth.verify-email', compact('url'));
    }

    /**
     * Get the verification URL for the given notifiable.
     */
    protected function verificationUrl(mixed $notifiable): string
    {
        if (static::$createUrlCallback) {
            return call_user_func(static::$createUrlCallback, $notifiable);
        }

        $time = Carbon::now()->addMinutes(config('auth.verification.expire', 60));

        $payload = ['uuid' => $notifiable->uuid, 'hash' => sha1($notifiable->getEmailForVerification())];

        return URL::temporarySignedRoute('verification.verify', $time, $payload);
    }

    /**
     * Set a callback that should be used when creating the email verification URL.
     */
    public static function createUrlUsing(Closure $callback): void
    {
        static::$createUrlCallback = $callback;
    }

    /**
     * Set a callback that should be used when building the notification mail message.
     */
    public static function toMailUsing(Closure $callback): void
    {
        static::$toMailCallback = $callback;
    }
}
