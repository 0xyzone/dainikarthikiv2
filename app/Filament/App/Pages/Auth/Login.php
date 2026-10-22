<?php

namespace App\Filament\App\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class Login extends BaseLogin
{
    protected string $view = 'filament.app.pages.auth.login';

    protected static string $layout = 'filament.app.layouts.auth';

    protected static bool $shouldRegisterNavigation = false;

    public function getTitle(): string | Htmlable
    {
        return 'Sign In — Dainik Arthiki';
    }

    public function getHeading(): string | Htmlable | null
    {
        if (filled($this->userUndertakingMultiFactorAuthentication)) {
            return 'Two-Factor Verification';
        }

        return 'Welcome Back';
    }

    public function getSubheading(): string | Htmlable | null
    {
        if (filled($this->userUndertakingMultiFactorAuthentication)) {
            return 'Enter the security code to access your account.';
        }

        if (! filament()->hasRegistration()) {
            return null;
        }

        return new HtmlString(
            'New to Dainik Arthiki? <a href="' . e(filament()->getRegistrationUrl()) . '" class="text-emerald-400 hover:text-emerald-300 font-semibold underline decoration-emerald-500/30 underline-offset-4 transition">Create free account →</a>'
        );
    }
}
