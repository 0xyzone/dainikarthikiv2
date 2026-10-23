<?php

namespace App\Filament\App\Pages\Auth\EmailVerification;

use Filament\Auth\Notifications\VerifyEmail;
use Filament\Auth\Pages\EmailVerification\EmailVerificationPrompt as BasePrompt;
use Filament\Facades\Filament;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Support\Htmlable;

class EmailVerificationPrompt extends BasePrompt
{
    protected string $view = 'filament.app.pages.auth.email-verification-prompt';

    protected static string $layout = 'filament.app.layouts.auth';

    protected static bool $shouldRegisterNavigation = false;

    public function getTitle(): string | Htmlable
    {
        return 'Verify Your Email — Dainik Arthiki';
    }

    public function getHeading(): string | Htmlable | null
    {
        return 'Verify Your Email';
    }

    protected function sendEmailVerificationNotification(MustVerifyEmail $user): void
    {
        if ($user->hasVerifiedEmail()) {
            return;
        }

        $notification = app(VerifyEmail::class);
        $notification->url = Filament::getVerifyEmailUrl($user);

        if (method_exists($user, 'notifyNow')) {
            $user->notifyNow($notification);
        } else {
            $user->notify($notification);
        }
    }
}
