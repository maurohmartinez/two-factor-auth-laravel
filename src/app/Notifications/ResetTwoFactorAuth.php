<?php

namespace MHMartinez\TwoFactorAuth\app\Notifications;

use Closure;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class ResetTwoFactorAuth extends Notification implements ShouldQueue
{
    use \Illuminate\Bus\Queueable;

    public static ?Closure $toMailCallback;

    public function __construct(private readonly string $token)
    {
    }

    public function via(): array
    {
        return ['mail'];
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->subject('2FA ' . config('app.name'))
            ->greeting(__('two_factor_auth::messages.email_hi'))
            ->line(__('two_factor_auth::messages.email_text'))
            ->action(__('two_factor_auth::messages.email_btn_action'), $this->verificationUrl());
    }

    public static function toMailUsing($callback): void
    {
        static::$toMailCallback = $callback;
    }

    protected function verificationUrl(): string
    {
        return URL::temporarySignedRoute(
            name: 'two_factor_auth.setup',
            expiration: Carbon::now()->addMinutes(30),
            parameters: [
                'token' => encrypt($this->token),
            ],
        );
    }
}
