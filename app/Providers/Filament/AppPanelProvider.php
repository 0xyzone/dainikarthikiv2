<?php

namespace App\Providers\Filament;

use EightCedars\FilamentInactivityGuard\FilamentInactivityGuardPlugin;
use Filament\Actions\Action;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;
use Stephenjude\FilamentTwoFactorAuthentication\TwoFactorAuthenticationPlugin;

class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('app')
            ->path('app')
            ->login()
            ->registration()
            ->passwordReset()
            ->colors([
                'primary' => Color::Emerald,
            ])
            ->userMenuItems([
                'profile' => Action::make('profile')
                    ->label(fn() => auth()->user()->name)
                    ->url(fn(): string => EditProfilePage::getUrl())
                    ->icon('heroicon-m-user-circle'),
            ])
            ->databaseNotifications()
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Incomes')
                    ->icon(Heroicon::OutlinedBanknotes)
                    ->collapsed(),
                NavigationGroup::make()
                    ->label('Expenses')
                    ->icon(Heroicon::OutlinedCreditCard),
            ])
            ->discoverResources(in: app_path('Filament/App/Resources'), for: 'App\Filament\App\Resources')
            ->discoverPages(in: app_path('Filament/App/Pages'), for: 'App\Filament\App\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/App/Widgets'), for: 'App\Filament\App\Widgets')
            ->widgets([
                // AccountWidget::class,
                // FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                FilamentApexChartsPlugin::make(),
                FilamentInactivityGuardPlugin::make(),
                FilamentEditProfilePlugin::make()
                    ->slug('my-profile')
                    ->setTitle('My Profile')
                    // ->setNavigationLabel('My Profile')
                    // ->setNavigationGroup('Group Profile')
                    ->setIcon('heroicon-o-user')
                    ->setSort(10)
                    // ->canAccess(fn() => auth()->user()->id === 1)
                    ->shouldRegisterNavigation()
                    ->shouldShowEmailForm()
                    ->shouldShowDeleteAccountForm(false)
                    ->shouldShowSanctumTokens()
                    ->shouldShowMultiFactorAuthentication()
                    ->shouldShowBrowserSessionsForm()
                    ->shouldShowAvatarForm(),
                TwoFactorAuthenticationPlugin::make()
                    ->enableTwoFactorAuthentication() // Enable Google 2FA
                    ->enablePasskeyAuthentication() // Enable Passkey
                    ->addTwoFactorMenuItem() // Add 2FA menu item,
            ])
            ->renderHook(
                'panels::scripts.after',
                fn(): string => Blade::render('@passkeysScripts'),
            );
    }
}
