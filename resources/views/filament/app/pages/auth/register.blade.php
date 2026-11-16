<div>
    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SIMPLE_PAGE_START, scopes: $this->getRenderHookScopes()) }}

    <!-- Brand Emblem Header -->
    <div class="auth-emblem-wrap">
        <a href="/" class="auth-emblem" title="Return to Dainik Arthiki">
            <img src="{{ asset('images/sp-mark.svg') }}" alt="SP Logo" style="width: 100%; height: 100%; border-radius: 14px; display: block;">
        </a>
    </div>

    <!-- Title & Subtitle Section -->
    <div class="auth-header-text">
        <div class="auth-badge">
            <span class="auth-pulse-dot"></span>
            <span>Get Started</span>
        </div>
        <h1 class="auth-title">
            {{ $this->getHeading() }}
        </h1>
        <p class="auth-subtitle">
            {{ $this->getSubheading() }}
        </p>
    </div>

    <!-- Livewire / Filament Registration Form Schema -->
    {{ $this->content }}

    <x-filament-actions::modals />

    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SIMPLE_PAGE_END, scopes: $this->getRenderHookScopes()) }}
</div>
