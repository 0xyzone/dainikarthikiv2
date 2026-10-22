@php
    $livewire ??= null;
@endphp

<x-filament-panels::layout.base :livewire="$livewire">
    <div class="min-h-screen w-full bg-slate-950 text-slate-100 flex flex-col justify-between relative overflow-hidden font-sans selection:bg-emerald-500 selection:text-slate-950">
        
        <!-- Ambient Atmospheric Glow Orbs (Design DNA) -->
        <div class="fixed top-[-10%] left-[-10%] w-[550px] h-[550px] rounded-full bg-emerald-500/15 blur-[130px] pointer-events-none"></div>
        <div class="fixed bottom-[-10%] right-[-10%] w-[650px] h-[650px] rounded-full bg-teal-500/10 blur-[150px] pointer-events-none"></div>
        <div class="fixed top-[35%] right-[10%] w-[380px] h-[380px] rounded-full bg-cyan-500/10 blur-[110px] pointer-events-none"></div>
        
        <!-- Fine Subtle Grid Texture Backdrop -->
        <div class="fixed inset-0 bg-[radial-gradient(#ffffff0a_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none"></div>

        <!-- Top Header Navigation Bar -->
        <header class="relative z-20 w-full max-w-7xl mx-auto px-4 sm:px-6 pt-5 flex items-center justify-between">
            <a href="/" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/5 hover:bg-white/10 text-slate-300 hover:text-emerald-400 border border-white/10 text-xs font-semibold backdrop-blur-xl transition group">
                <svg class="w-4 h-4 text-emerald-400 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Back to Website</span>
            </a>

            <div class="flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 text-[11px] text-slate-400 backdrop-blur-xl">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="font-medium text-slate-300">Live Secure Auth</span>
            </div>
        </header>

        <!-- Main Card Section (Mobile-First Ergonomic Centering) -->
        <main class="relative z-20 flex-1 flex items-center justify-center px-4 py-8 sm:py-12">
            <div class="w-full max-w-md">
                
                <!-- Aeris Gradient Hairline Border Shell -->
                <div class="p-[1.5px] rounded-[32px] bg-gradient-to-b from-emerald-500/35 via-teal-500/15 to-white/5 shadow-2xl shadow-black/80">
                    <div class="w-full bg-slate-900/85 backdrop-blur-2xl rounded-[30px] p-6 sm:p-8 border border-white/10 relative overflow-hidden">
                        
                        <!-- Inner ambient card glow -->
                        <div class="absolute -top-24 -left-24 w-48 h-48 bg-emerald-500/20 rounded-full blur-2xl pointer-events-none"></div>

                        {{ $slot }}

                    </div>
                </div>

                <!-- Bottom Security Reassurance Pill -->
                <div class="mt-6 text-center space-y-2">
                    <div class="inline-flex items-center gap-2 text-[11px] text-slate-400 font-medium">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <span>Bank-Grade 256-bit SSL · Passkey Biometrics · Zero Tracking</span>
                    </div>
                </div>

            </div>
        </main>

        <!-- Minimal Footer -->
        <footer class="relative z-20 w-full py-4 text-center text-[11px] text-slate-500">
            &copy; {{ date('Y') }} Dainik Arthiki OS. All rights reserved.
        </footer>

    </div>

    <!-- Scoped Styles for Modern Filament Form Controls & Passkey Section -->
    <style>
        /* Scoped overrides to transform default inputs into sleek Aeris glass inputs */
        .fi-input-wrp {
            background-color: rgba(2, 6, 23, 0.65) !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            border-radius: 1rem !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25) !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        .fi-input-wrp:hover {
            border-color: rgba(16, 185, 129, 0.45) !important;
        }
        .fi-input-wrp:focus-within {
            border-color: #10b981 !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2), 0 4px 12px rgba(0, 0, 0, 0.3) !important;
        }
        .fi-input {
            color: #ffffff !important;
            font-size: 0.875rem !important;
        }
        .fi-input::placeholder {
            color: #64748b !important;
        }

        /* Labels and field text */
        .fi-fo-field-wrp-label label {
            color: #cbd5e1 !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            letter-spacing: 0.025em !important;
        }
        .fi-fo-field-wrp-label sup {
            color: #10b981 !important;
        }

        /* Checkbox styling */
        .fi-checkbox-input {
            border-radius: 0.375rem !important;
            background-color: rgba(2, 6, 23, 0.6) !important;
            border-color: rgba(255, 255, 255, 0.2) !important;
            color: #10b981 !important;
        }
        .fi-checkbox-input:checked {
            background-color: #10b981 !important;
            border-color: #10b981 !important;
        }

        /* Primary Form Action Button */
        .fi-btn-color-primary,
        button[type="submit"] {
            background: linear-gradient(135deg, #10b981 0%, #0d9488 100%) !important;
            color: #042f2e !important;
            font-weight: 700 !important;
            border-radius: 1rem !important;
            padding: 0.75rem 1.25rem !important;
            font-size: 0.875rem !important;
            border: none !important;
            box-shadow: 0 8px 20px -4px rgba(16, 185, 129, 0.4), inset 0 1px 0 0 rgba(255, 255, 255, 0.3) !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
            width: 100% !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            cursor: pointer !important;
        }
        .fi-btn-color-primary:hover,
        button[type="submit"]:hover {
            background: linear-gradient(135deg, #34d399 0%, #14b8a6 100%) !important;
            box-shadow: 0 12px 25px -4px rgba(16, 185, 129, 0.5), inset 0 1px 0 0 rgba(255, 255, 255, 0.4) !important;
            transform: translateY(-1px) !important;
        }
        .fi-btn-color-primary:active,
        button[type="submit"]:active {
            transform: scale(0.98) !important;
        }

        /* Links (e.g. Forgot Password) */
        .fi-link {
            color: #34d399 !important;
            transition: color 0.15s ease !important;
            font-size: 0.75rem !important;
            font-weight: 500 !important;
        }
        .fi-link:hover {
            color: #6ee7b7 !important;
        }

        /* Passkey Biometric Section Elevation */
        div:has(#passkey-login-form) {
            display: flex !important;
            flex-direction: column !important;
            align-items: stretch !important;
            width: 100% !important;
            margin-top: 1.5rem !important;
            padding-top: 1.5rem !important;
            border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
            position: relative !important;
        }
        div:has(#passkey-login-form)::before {
            content: "OR SIGN IN WITH BIOMETRICS";
            display: inline-block;
            position: absolute;
            top: -9px;
            left: 50%;
            transform: translateX(-50%);
            background: #0d1322;
            padding: 0 12px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.08em;
            color: #64748b;
            border-radius: 9999px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            white-space: nowrap;
        }
        div:has(#passkey-login-form) div[onclick="authenticateWithPasskey()"] {
            width: 100% !important;
        }
        div:has(#passkey-login-form) div[onclick="authenticateWithPasskey()"] a,
        div:has(#passkey-login-form) div[onclick="authenticateWithPasskey()"] .fi-link {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 0.625rem !important;
            width: 100% !important;
            padding: 0.75rem 1rem !important;
            border-radius: 1rem !important;
            background: rgba(16, 185, 129, 0.08) !important;
            border: 1px solid rgba(16, 185, 129, 0.25) !important;
            color: #34d399 !important;
            font-weight: 600 !important;
            font-size: 0.8125rem !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.2) !important;
            cursor: pointer !important;
            text-decoration: none !important;
        }
        div:has(#passkey-login-form) div[onclick="authenticateWithPasskey()"] a:hover,
        div:has(#passkey-login-form) div[onclick="authenticateWithPasskey()"] .fi-link:hover {
            background: rgba(16, 185, 129, 0.16) !important;
            border-color: rgba(16, 185, 129, 0.45) !important;
            color: #6ee7b7 !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 8px 24px rgba(16, 185, 129, 0.2) !important;
        }
        div:has(#passkey-login-form) div[onclick="authenticateWithPasskey()"] a:active,
        div:has(#passkey-login-form) div[onclick="authenticateWithPasskey()"] .fi-link:active {
            transform: scale(0.98) !important;
        }
        div:has(#passkey-login-form) svg {
            width: 1.25rem !important;
            height: 1.25rem !important;
            color: #10b981 !important;
        }
    </style>
</x-filament-panels::layout.base>
