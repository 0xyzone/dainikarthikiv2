<?php

namespace App\Filament\App\Pages\Auth;

use Filament\Auth\Pages\Register as BaseRegister;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class Register extends BaseRegister
{
    protected string $view = 'filament.app.pages.auth.register';

    protected static string $layout = 'filament.app.layouts.auth';

    protected static bool $shouldRegisterNavigation = false;

    public function getTitle(): string | Htmlable
    {
        return 'Create Account — Dainik Arthiki';
    }

    public function getHeading(): string | Htmlable
    {
        return 'Create Free Account';
    }

    public function getSubheading(): string | Htmlable | null
    {
        if (! filament()->hasLogin()) {
            return null;
        }

        return new HtmlString(
            'Already registered? <a href="' . e(filament()->getLoginUrl()) . '" class="text-emerald-400 hover:text-emerald-300 font-semibold underline decoration-emerald-500/30 underline-offset-4 transition">Sign in to your account →</a>'
        );
    }
}
