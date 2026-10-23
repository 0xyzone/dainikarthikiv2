<div>
    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SIMPLE_PAGE_START, scopes: $this->getRenderHookScopes()) }}

    <!-- Brand / Envelope Emblem Header -->
    <div class="auth-emblem-wrap">
        <div class="auth-emblem" style="background: linear-gradient(135deg, #10b981 0%, #14b8a6 50%, #06b6d4 100%);">
            <div class="auth-emblem-inner">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Title Section -->
    <div class="auth-header-text">
        <div class="auth-badge">
            <span class="auth-pulse-dot"></span>
            <span>Security Verification</span>
        </div>
        <h1 class="auth-title">
            {{ $this->getHeading() }}
        </h1>
        <p class="auth-subtitle">
            A verification link was sent to:
        </p>
        <p style="margin-top: 4px; font-weight: 700; color: #34d399; font-size: 14px; word-break: break-all;">
            {{ filament()->auth()->user()?->getEmailForVerification() }}
        </p>
    </div>

    <!-- Instructions & Helpful Guidance -->
    <div style="background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.2); border-radius: 14px; padding: 14px 16px; margin-bottom: 20px; font-size: 12.5px; line-height: 1.5; color: #cbd5e1; text-align: left;">
        <div style="display: flex; align-items: flex-start; gap: 10px;">
            <span style="font-size: 16px; line-height: 1;">📬</span>
            <div>
                <strong style="color: #ffffff;">Please check your inbox</strong> and click the link to activate your access.
                <div style="margin-top: 6px; font-size: 11.5px; color: #94a3b8;">
                    <strong style="color: #34d399;">Can't find it?</strong> Be sure to check your <strong style="color: #f1f5f9;">Spam</strong> or <strong style="color: #f1f5f9;">Junk</strong> folder, as automated delivery can sometimes be filtered.
                </div>
            </div>
        </div>
    </div>

    <!-- Resend Action Button -->
    <div style="display: flex; flex-direction: column; gap: 12px; width: 100%;">
        <div style="width: 100%;">
            {{ $this->resendNotificationAction }}
        </div>

        <!-- Sign Out / Switch Account Option -->
        <div style="text-align: center; margin-top: 6px;">
            <form method="POST" action="{{ filament()->getLogoutUrl() }}" style="display: inline;">
                @csrf
                <button type="submit" class="fi-link" style="background: none; border: none; cursor: pointer; font-size: 12px; color: #64748b; transition: color 0.15s ease;">
                    Wrong email? <span style="text-decoration: underline; color: #94a3b8;">Sign out</span>
                </button>
            </form>
        </div>
    </div>

    <x-filament-actions::modals />

    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SIMPLE_PAGE_END, scopes: $this->getRenderHookScopes()) }}
</div>
