@php
    $livewire ??= null;
@endphp

<x-filament-panels::layout.base :livewire="$livewire">
    <div class="auth-canvas">
        
        <!-- Ambient Atmospheric Glow Orbs (Design DNA) -->
        <div class="auth-glow-orb-1"></div>
        <div class="auth-glow-orb-2"></div>
        <div class="auth-glow-mesh"></div>

        <!-- Top Header Navigation Bar -->
        <header class="auth-top-bar">
            <a href="/" class="auth-back-btn" title="Return to website">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <span>Back to Website</span>
            </a>

            <div class="auth-status-pill">
                <span class="auth-pulse-dot"></span>
                <span>Live Secure Auth</span>
            </div>
        </header>

        <!-- Main Card Section (Mobile-First Ergonomic Centering) -->
        <main class="auth-main-section">
            <div class="auth-card-shell">
                <div class="auth-card-inner">
                    <div class="auth-card-highlight"></div>
                    {{ $slot }}
                </div>
            </div>

            <!-- Bottom Security Reassurance Pill -->
            <div class="auth-security-badge">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
                <span>Bank-Grade 256-bit SSL · Passkey Biometrics · Zero Tracking</span>
            </div>
        </main>

        <!-- Minimal Footer -->
        <footer class="auth-footer">
            &copy; {{ date('Y') }} Dainik Arthiki OS. All rights reserved.
        </footer>

    </div>

    <!-- Self-Contained Complete Aeris & Design DNA Stylesheet -->
    <style>
        /* Base Viewport & Reset */
        *, *::before, *::after {
            box-sizing: border-box;
        }

        .auth-canvas {
            min-height: 100vh;
            min-height: 100dvh;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            background-color: #090d16;
            color: #f8fafc;
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            position: relative;
            overflow-x: hidden;
            padding: 16px;
            box-sizing: border-box;
        }

        /* Ambient Glow Orbs */
        .auth-glow-orb-1 {
            position: fixed;
            top: -120px;
            left: -120px;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.22) 0%, rgba(16, 185, 129, 0) 70%);
            filter: blur(80px);
            pointer-events: none;
            z-index: 0;
        }

        .auth-glow-orb-2 {
            position: fixed;
            bottom: -120px;
            right: -120px;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(20, 184, 166, 0.16) 0%, rgba(20, 184, 166, 0) 70%);
            filter: blur(90px);
            pointer-events: none;
            z-index: 0;
        }

        .auth-glow-mesh {
            position: fixed;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px);
            background-size: 24px 24px;
            pointer-events: none;
            z-index: 0;
        }

        /* Top Navigation Bar */
        .auth-top-bar {
            width: 100%;
            max-width: 440px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 8px;
            padding-bottom: 16px;
            z-index: 10;
            position: relative;
            box-sizing: border-box;
        }

        .auth-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #94a3b8;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .auth-back-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #34d399;
            border-color: rgba(16, 185, 129, 0.35);
            transform: translateX(-2px);
        }

        .auth-status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 9999px;
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.25);
            color: #34d399;
            font-size: 11px;
            font-weight: 600;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .auth-pulse-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #10b981;
            animation: authPulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes authPulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(0.85); }
        }

        /* Main Section & Bounded Card Shell */
        .auth-main-section {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 10;
            position: relative;
            margin: auto 0;
            padding: 12px 0;
            box-sizing: border-box;
        }

        /* Aeris Gradient Border Shell */
        .auth-card-shell {
            width: 100%;
            max-width: 440px;
            padding: 1.5px;
            border-radius: 28px;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.45) 0%, rgba(20, 184, 166, 0.2) 50%, rgba(255, 255, 255, 0.1) 100%);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.8), 0 0 40px -10px rgba(16, 185, 129, 0.18);
            box-sizing: border-box;
        }

        .auth-card-inner {
            background: rgba(13, 19, 33, 0.92);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            border-radius: 26.5px;
            padding: 32px 28px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-sizing: border-box;
            position: relative;
            overflow: hidden;
        }

        .auth-card-highlight {
            position: absolute;
            top: -60px;
            left: -60px;
            width: 140px;
            height: 140px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.25) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Brand Emblem Header */
        .auth-emblem-wrap {
            display: flex;
            justify-content: center;
            margin-bottom: 12px;
        }

        .auth-emblem {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: linear-gradient(135deg, #059669 0%, #14b8a6 50%, #06b6d4 100%);
            padding: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.35);
            transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
        }

        .auth-emblem:hover {
            transform: scale(1.05);
        }

        .auth-emblem-inner {
            width: 100%;
            height: 100%;
            background: #090d16;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #10b981;
        }

        .auth-header-text {
            text-align: center;
            margin-bottom: 22px;
        }

        .auth-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 9999px;
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.25);
            color: #34d399;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .auth-title {
            font-size: 24px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.025em;
            margin: 0 0 6px 0;
            line-height: 1.2;
        }

        .auth-subtitle {
            font-size: 13px;
            color: #94a3b8;
            margin: 0;
            line-height: 1.5;
        }

        .auth-subtitle a {
            color: #34d399;
            font-weight: 600;
            text-decoration: underline;
            text-decoration-color: rgba(16, 185, 129, 0.35);
            text-underline-offset: 3px;
            transition: color 0.15s ease;
        }

        .auth-subtitle a:hover {
            color: #6ee7b7;
        }

        /* Filament Form Controls Override */
        .auth-card-inner .fi-form,
        .auth-card-inner form {
            display: flex !important;
            flex-direction: column !important;
            gap: 16px !important;
            width: 100% !important;
        }

        .auth-card-inner .fi-sc {
            display: flex !important;
            flex-direction: column !important;
            gap: 16px !important;
            width: 100% !important;
        }

        .auth-card-inner .fi-input-wrp {
            background-color: rgba(3, 7, 18, 0.7) !important;
            border: 1px solid rgba(255, 255, 255, 0.14) !important;
            border-radius: 14px !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3) !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
            min-height: 46px !important;
            width: 100% !important;
        }

        .auth-card-inner .fi-input-wrp:hover {
            border-color: rgba(16, 185, 129, 0.45) !important;
        }

        .auth-card-inner .fi-input-wrp:focus-within {
            border-color: #10b981 !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.22), 0 4px 12px rgba(0, 0, 0, 0.4) !important;
        }

        .auth-card-inner .fi-input {
            color: #ffffff !important;
            font-size: 14px !important;
            padding: 10px 14px !important;
            background: transparent !important;
        }

        .auth-card-inner .fi-input::placeholder {
            color: #64748b !important;
        }

        .auth-card-inner .fi-fo-field-wrp-label label {
            color: #cbd5e1 !important;
            font-size: 11.5px !important;
            font-weight: 600 !important;
            letter-spacing: 0.03em !important;
            text-transform: uppercase !important;
            margin-bottom: 5px !important;
            display: inline-block !important;
        }

        .auth-card-inner .fi-fo-field-wrp-label sup {
            color: #10b981 !important;
        }

        .auth-card-inner .fi-checkbox-input {
            border-radius: 5px !important;
            background-color: rgba(3, 7, 18, 0.7) !important;
            border-color: rgba(255, 255, 255, 0.2) !important;
            color: #10b981 !important;
            width: 18px !important;
            height: 18px !important;
        }

        .auth-card-inner .fi-checkbox-input:checked {
            background-color: #10b981 !important;
            border-color: #10b981 !important;
        }

        .auth-card-inner .fi-btn-color-primary,
        .auth-card-inner button[type="submit"] {
            background: linear-gradient(135deg, #10b981 0%, #0d9488 100%) !important;
            color: #022c22 !important;
            font-weight: 700 !important;
            font-size: 14px !important;
            border-radius: 14px !important;
            padding: 12px 20px !important;
            min-height: 46px !important;
            border: none !important;
            width: 100% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            box-shadow: 0 8px 20px -4px rgba(16, 185, 129, 0.45) !important;
            cursor: pointer !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
            margin-top: 6px !important;
        }

        .auth-card-inner .fi-btn-color-primary:hover,
        .auth-card-inner button[type="submit"]:hover {
            background: linear-gradient(135deg, #34d399 0%, #14b8a6 100%) !important;
            box-shadow: 0 10px 25px -4px rgba(16, 185, 129, 0.55) !important;
            transform: translateY(-1px) !important;
        }

        .auth-card-inner .fi-btn-color-primary:active,
        .auth-card-inner button[type="submit"]:active {
            transform: scale(0.98) !important;
        }

        .auth-card-inner .fi-link {
            color: #34d399 !important;
            font-weight: 600 !important;
            font-size: 12px !important;
            text-decoration: none !important;
            transition: color 0.15s ease !important;
        }

        .auth-card-inner .fi-link:hover {
            color: #6ee7b7 !important;
        }

        /* Biometric Passkey Section - Styled STRICTLY to the direct container */
        .auth-card-inner .flex:has(> #passkey-login-form) {
            display: flex !important;
            flex-direction: column !important;
            align-items: stretch !important;
            width: 100% !important;
            margin-top: 22px !important;
            padding-top: 20px !important;
            border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
            position: relative !important;
        }

        .auth-card-inner .flex:has(> #passkey-login-form)::before {
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

        .auth-card-inner div[onclick="authenticateWithPasskey()"] {
            width: 100% !important;
        }

        .auth-card-inner div[onclick="authenticateWithPasskey()"] a,
        .auth-card-inner div[onclick="authenticateWithPasskey()"] .fi-link {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px !important;
            width: 100% !important;
            min-height: 44px !important;
            padding: 10px 16px !important;
            border-radius: 14px !important;
            background: rgba(16, 185, 129, 0.08) !important;
            border: 1px solid rgba(16, 185, 129, 0.25) !important;
            color: #34d399 !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25) !important;
            cursor: pointer !important;
            text-decoration: none !important;
            box-sizing: border-box !important;
        }

        .auth-card-inner div[onclick="authenticateWithPasskey()"] a:hover,
        .auth-card-inner div[onclick="authenticateWithPasskey()"] .fi-link:hover {
            background: rgba(16, 185, 129, 0.16) !important;
            border-color: rgba(16, 185, 129, 0.45) !important;
            color: #6ee7b7 !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 6px 18px rgba(16, 185, 129, 0.2) !important;
        }

        .auth-card-inner div[onclick="authenticateWithPasskey()"] svg {
            width: 18px !important;
            height: 18px !important;
            color: #10b981 !important;
        }

        /* Footer & Security Badge */
        .auth-security-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            color: #64748b;
            font-size: 11px;
            font-weight: 500;
            text-align: center;
            margin-top: 18px;
        }

        .auth-footer {
            color: #475569;
            font-size: 11px;
            padding: 12px 0 4px 0;
            text-align: center;
            z-index: 10;
        }

        /* Mobile Optimization */
        @media (max-width: 480px) {
            .auth-canvas {
                padding: 12px;
            }

            .auth-card-inner {
                padding: 24px 18px;
                border-radius: 24px;
            }

            .auth-card-shell {
                border-radius: 25.5px;
            }

            .auth-title {
                font-size: 21px;
            }
        }
    </style>
</x-filament-panels::layout.base>
