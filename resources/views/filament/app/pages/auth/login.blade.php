<div>
    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SIMPLE_PAGE_START, scopes: $this->getRenderHookScopes()) }}

    <!-- Brand Emblem Header -->
    <div class="auth-emblem-wrap">
        <a href="/" class="auth-emblem" title="Return to Dainik Arthiki">
            <div class="auth-emblem-inner">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="1" x2="12" y2="23"></line>
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                </svg>
            </div>
        </a>
    </div>

    <!-- Title & Subtitle Section -->
    <div class="auth-header-text">
        <div class="auth-badge">
            <span class="auth-pulse-dot"></span>
            <span>Dainik Arthiki OS</span>
        </div>
        <h1 class="auth-title">
            {{ $this->getHeading() }}
        </h1>
        <p class="auth-subtitle">
            {{ $this->getSubheading() }}
        </p>
    </div>

    <!-- Livewire / Filament Login Form Schema -->
    {{ $this->content }}

    <x-filament-actions::modals />

    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SIMPLE_PAGE_END, scopes: $this->getRenderHookScopes()) }}
</div>
