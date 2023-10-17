<?php

namespace MHMartinez\TwoFactorAuth\app\Notifications;

use Closure;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class ResetTwoFactorAuth extends Notification
{
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
            ->action(__('two_factor_auth::messages.email_btn_action'), route('two_factor_auth.setup', ['token' => $this->token]));
    }

    public static function toMailUsing($callback): void
    {
        static::$toMailCallback = $callback;
    }
}
