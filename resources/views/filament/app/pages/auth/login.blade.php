<div class="space-y-6">
    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SIMPLE_PAGE_START, scopes: $this->getRenderHookScopes()) }}

    <!-- Brand Emblem & Title Header -->
    <div class="text-center space-y-3">
        <a href="/" class="inline-flex items-center justify-center group" title="Return to Dainik Arthiki">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-emerald-600 via-teal-500 to-cyan-400 p-[2px] shadow-xl shadow-emerald-500/25 group-hover:shadow-emerald-500/40 group-hover:scale-105 transition-all duration-300">
                <div class="w-full h-full bg-slate-950 rounded-[14px] flex items-center justify-center">
                    <svg class="w-7 h-7 text-emerald-400 group-hover:scale-110 transition-transform duration-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="1" x2="12" y2="23"></line>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                </div>
            </div>
        </a>

        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[11px] font-semibold tracking-wide">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                Dainik Arthiki OS
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight mt-2">
                {{ $this->getHeading() }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-400 mt-1">
                {{ $this->getSubheading() }}
            </p>
        </div>
    </div>

    <!-- Livewire / Filament Form & Content -->
    <div class="pt-1">
        {{ $this->content }}
    </div>

    <x-filament-actions::modals />

    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SIMPLE_PAGE_END, scopes: $this->getRenderHookScopes()) }}
</div>
