<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <title>{{ config('app.name', 'Dainik Arthiki') }} - Mobile Finance App</title>
    
    @include('filament.pwa-head')
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN for instant styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        emerald: {
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            900: '#064e3b',
                            950: '#022c22',
                        },
                        slate: {
                            850: '#111827',
                            900: '#0b0f19',
                            950: '#060911',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    }
                }
            }
        }
    </script>

    <!-- Three.js for 3D Interactive Coin / Centerpiece -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <!-- GSAP for Smooth Fluid Motion -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

    <style>
        :root {
            --app-max-width: 440px;
            --safe-bottom: env(safe-area-inset-bottom, 16px);
            --safe-top: env(safe-area-inset-top, 16px);
        }

        * {
            -webkit-tap-highlight-color: transparent;
            user-select: none;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #060911;
            color: #f1f5f9;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            min-height: -webkit-fill-available;
        }

        /* Glassmorphism Utilities */
        .glass-panel {
            background: rgba(15, 23, 42, 0.72);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .glass-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.07) 0%, rgba(255, 255, 255, 0.02) 100%);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.09);
        }

        .glass-card-emerald {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.16) 0%, rgba(6, 78, 59, 0.25) 100%);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(52, 211, 153, 0.22);
        }

        /* Ambient Glow Background */
        .glow-orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(90px);
            pointer-events: none;
            z-index: 0;
            opacity: 0.35;
        }

        /* Native App Scroll Container */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Tactile Press Feedback */
        .btn-touch {
            transition: transform 0.12s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.12s ease;
        }
        .btn-touch:active {
            transform: scale(0.96);
            opacity: 0.88;
        }

        /* 3D Canvas Box */
        #coin-canvas-container {
            width: 100%;
            height: 200px;
            position: relative;
            cursor: grab;
        }
        #coin-canvas-container:active {
            cursor: grabbing;
        }

        /* Bottom Nav Safe Padding */
        .pb-safe {
            padding-bottom: calc(var(--safe-bottom) + 5rem);
        }

        /* Card Deck Stack Transitions */
        .deck-card {
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            transform-origin: center top;
        }
        .deck-card.is-active {
            transform: translateY(0) scale(1) !important;
            border-color: rgba(52, 211, 153, 0.4) !important;
            box-shadow: 0 15px 35px -5px rgba(16, 185, 129, 0.25);
        }

        /* SPA Tab Fade & Slide */
        .spa-tab-content {
            display: none;
            opacity: 0;
            transform: translateY(12px);
        }
        .spa-tab-content.active {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        /* Balance Hide Blur */
        .blurred-amount {
            filter: blur(8px);
            transition: filter 0.25s ease;
        }
    </style>
</head>

<body class="flex justify-center bg-slate-950 text-slate-100">

    <!-- Ambient Glow Orbs -->
    <div class="glow-orb w-72 h-72 bg-emerald-500 top-[-60px] left-[-60px]"></div>
    <div class="glow-orb w-80 h-80 bg-teal-600 top-[35%] right-[-80px]"></div>
    <div class="glow-orb w-72 h-72 bg-cyan-600 bottom-[80px] left-[-40px]"></div>

    <!-- Main Mobile App Shell Frame -->
    <div class="relative z-10 w-full max-w-[460px] min-h-screen flex flex-col bg-slate-900/90 border-x border-slate-800/60 shadow-2xl pb-safe">

        <!-- ================= TOP APP BAR ================= -->
        <header class="sticky top-0 z-40 px-4 pt-3 pb-3 glass-panel border-b border-white/5 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-400 p-[1.5px] shadow-lg shadow-emerald-500/20">
                    <div class="w-full h-full bg-slate-950 rounded-[10px] flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="1" x2="12" y2="23"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <h1 class="text-sm font-bold tracking-tight text-white flex items-center gap-1.5 leading-none">
                        Dainik Arthiki
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    </h1>
                    <p class="text-[10px] font-medium text-slate-400 mt-0.5">Finance Operating System</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <!-- Install Button in Top Bar (visible when installable) -->
                <button id="top-bar-install-btn" class="hidden items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-lg bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 hover:bg-emerald-500/30 btn-touch">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    <span>Install</span>
                </button>

                <!-- Launch App / Login Button -->
                <a href="/app" class="px-3 py-1.5 text-xs font-bold rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 shadow-md shadow-emerald-500/30 flex items-center gap-1 btn-touch">
                    <span>Open App</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </header>

        <!-- ================= SMART PWA INSTALL BANNER ================= -->
        <div id="smart-install-banner" class="hidden px-4 pt-3 pb-1">
            <div class="glass-card-emerald p-3 rounded-2xl flex items-center justify-between gap-3 shadow-lg">
                <div class="flex items-center gap-2.5">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/30 border border-emerald-400/40 flex items-center justify-center shrink-0">
                        <span class="text-lg">📲</span>
                    </div>
                    <div class="leading-tight">
                        <div class="text-xs font-bold text-white flex items-center gap-1">
                            Install Dainik Arthiki
                        </div>
                        <p class="text-[11px] text-slate-300">Fast 1-tap launch & offline usage</p>
                    </div>
                </div>
                <div class="flex items-center gap-1.5 shrink-0">
                    <button id="banner-install-trigger" class="px-3 py-1.5 text-xs font-bold rounded-xl bg-emerald-400 text-slate-950 hover:bg-emerald-300 shadow-md btn-touch">
                        Install
                    </button>
                    <button id="banner-dismiss-btn" class="p-1.5 text-slate-400 hover:text-white rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>


        <!-- ================= SPA TAB 1: HOME FEED ================= -->
        <main id="tab-home" class="spa-tab-content active px-4 pt-3 space-y-4">

            <!-- Native User / Quick Stats Greeting -->
            <div class="flex items-center justify-between pt-1">
                <div>
                    <span class="text-xs font-medium text-slate-400" id="live-time-greeting">Namaste 🙏</span>
                    <h2 class="text-lg font-bold text-white tracking-tight">Financial Overview</h2>
                </div>
                <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-[11px] font-semibold text-emerald-400">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                    <span>Cloud Synced</span>
                </div>
            </div>

            <!-- Main Wallet / Balance Master Card -->
            <div class="relative overflow-hidden rounded-3xl p-5 bg-gradient-to-br from-slate-800/90 via-slate-900 to-slate-950 border border-white/10 shadow-xl">
                <!-- Card Background Pattern -->
                <div class="absolute -right-8 -top-8 w-36 h-36 rounded-full bg-emerald-500/15 blur-2xl pointer-events-none"></div>
                <div class="absolute right-4 bottom-4 opacity-10">
                    <svg class="w-24 h-24 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="2" y="5" width="20" height="14" rx="3"></rect>
                        <line x1="2" y1="10" x2="22" y2="10"></line>
                    </svg>
                </div>

                <div class="relative z-10 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Net Balance</span>
                        <button id="toggle-balance-btn" class="p-1 rounded-lg text-slate-400 hover:text-white hover:bg-white/5 transition" title="Toggle visibility">
                            <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="flex items-baseline gap-2">
                        <span class="text-sm font-semibold text-emerald-400 font-mono">NPR</span>
                        <h3 id="balance-display" class="text-3xl font-extrabold text-white tracking-tight font-mono">1,84,550.00</h3>
                    </div>

                    <!-- Flow Pill Breakdown -->
                    <div class="grid grid-cols-2 gap-2.5 pt-1">
                        <div class="p-2.5 rounded-2xl bg-white/[0.04] border border-white/5">
                            <div class="flex items-center gap-1.5 text-[11px] text-slate-400 mb-0.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                <span>Monthly Income</span>
                            </div>
                            <p class="text-sm font-bold text-emerald-300 font-mono">+Rs. 95,000</p>
                        </div>
                        <div class="p-2.5 rounded-2xl bg-white/[0.04] border border-white/5">
                            <div class="flex items-center gap-1.5 text-[11px] text-slate-400 mb-0.5">
                                <span class="w-2 h-2 rounded-full bg-rose-400"></span>
                                <span>Monthly Expense</span>
                            </div>
                            <p class="text-sm font-bold text-rose-300 font-mono">-Rs. 38,450</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Action Grid (Tactile Touch Buttons) -->
            <div class="grid grid-cols-4 gap-2 pt-1">
                <a href="/app" class="flex flex-col items-center gap-1.5 p-3 rounded-2xl glass-card text-center btn-touch group">
                    <div class="w-11 h-11 rounded-2xl bg-emerald-500/15 border border-emerald-500/25 flex items-center justify-center text-emerald-400 group-hover:bg-emerald-500 group-hover:text-slate-950 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <span class="text-[11px] font-semibold text-slate-200">Income</span>
                </a>

                <a href="/app" class="flex flex-col items-center gap-1.5 p-3 rounded-2xl glass-card text-center btn-touch group">
                    <div class="w-11 h-11 rounded-2xl bg-rose-500/15 border border-rose-500/25 flex items-center justify-center text-rose-400 group-hover:bg-rose-500 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"></path>
                        </svg>
                    </div>
                    <span class="text-[11px] font-semibold text-slate-200">Expense</span>
                </a>

                <a href="/app" class="flex flex-col items-center gap-1.5 p-3 rounded-2xl glass-card text-center btn-touch group">
                    <div class="w-11 h-11 rounded-2xl bg-teal-500/15 border border-teal-500/25 flex items-center justify-center text-teal-400 group-hover:bg-teal-500 group-hover:text-slate-950 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                    </div>
                    <span class="text-[11px] font-semibold text-slate-200">Credits</span>
                </a>

                <a href="/app" class="flex flex-col items-center gap-1.5 p-3 rounded-2xl glass-card text-center btn-touch group">
                    <div class="w-11 h-11 rounded-2xl bg-amber-500/15 border border-amber-500/25 flex items-center justify-center text-amber-400 group-hover:bg-amber-500 group-hover:text-slate-950 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="text-[11px] font-semibold text-slate-200">EMIs</span>
                </a>
            </div>

            <!-- ================= THREE.JS 3D INTERACTIVE ARTHIKI COIN ================= -->
            <div class="relative glass-card rounded-3xl p-4 overflow-hidden border border-emerald-500/20">
                <div class="flex items-center justify-between mb-1">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-white uppercase tracking-wider">Interactive 3D Emblem</span>
                        <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 font-mono">Touch & Drag</span>
                    </div>
                    <span class="text-xs text-slate-400">WebGL 60FPS</span>
                </div>
                
                <div id="coin-canvas-container" class="rounded-2xl overflow-hidden flex items-center justify-center">
                    <!-- Canvas injected by Three.js -->
                </div>

                <div class="flex items-center justify-between text-xs text-slate-400 pt-2 border-t border-white/5">
                    <span>Gyroscopic Coin Physics</span>
                    <button id="reset-coin-btn" class="text-emerald-400 hover:text-emerald-300 font-medium btn-touch">Reset Position</button>
                </div>
            </div>

            <!-- Ledger Summary Highlights -->
            <div class="space-y-2.5">
                <div class="flex items-center justify-between px-1">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Active Ledger Highlights</h4>
                    <button onclick="switchTab('decks')" class="text-xs font-semibold text-emerald-400 hover:text-emerald-300 flex items-center gap-0.5">
                        <span>View Decks</span>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>

                <!-- Highlight Card 1: Credit Given -->
                <div class="glass-card p-3.5 rounded-2xl flex items-center justify-between hover:border-emerald-500/30 transition btn-touch">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-teal-500/15 border border-teal-500/20 flex items-center justify-center text-teal-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-white">Credits Given (To Collect)</p>
                            <p class="text-[11px] text-slate-400">4 active counterparties</p>
                        </div>
                    </div>
                    <div class="text-right font-mono">
                        <p class="text-sm font-bold text-teal-400">Rs. 42,000</p>
                        <span class="text-[10px] text-slate-400">Receivable</span>
                    </div>
                </div>

                <!-- Highlight Card 2: Upcoming EMI -->
                <div class="glass-card p-3.5 rounded-2xl flex items-center justify-between hover:border-amber-500/30 transition btn-touch">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/15 border border-amber-500/20 flex items-center justify-center text-amber-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-white">Home Loan EMI Due</p>
                            <p class="text-[11px] text-amber-300/80">Due in 5 days (Oct 28)</p>
                        </div>
                    </div>
                    <div class="text-right font-mono">
                        <p class="text-sm font-bold text-amber-400">Rs. 24,500</p>
                        <span class="text-[10px] text-slate-400">Installment #14</span>
                    </div>
                </div>
            </div>

            <!-- Instant PWA Offline & Passkey Alert Card -->
            <div class="glass-card-emerald p-4 rounded-3xl space-y-3">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-500/20 border border-emerald-400/30 flex items-center justify-center shrink-0 text-emerald-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-white">Enterprise Security & Offline Ready</h4>
                        <p class="text-[11px] text-slate-300 leading-snug mt-0.5">Protected with WebAuthn Passkeys, 2-Factor Authentication, and full offline caching.</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 pt-1">
                    <a href="/app/register" class="flex-1 py-2 px-3 text-center text-xs font-bold rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 shadow-md btn-touch">
                        Create Free Account
                    </a>
                    <button onclick="switchTab('install')" class="py-2 px-3 text-xs font-semibold rounded-xl bg-white/10 hover:bg-white/15 text-white border border-white/10 btn-touch">
                        Install Guide
                    </button>
                </div>
            </div>

        </main>


        <!-- ================= SPA TAB 2: CARDS & DECKS ================= -->
        <section id="tab-decks" class="spa-tab-content px-4 pt-3 space-y-4">
            <div>
                <span class="text-xs font-medium text-emerald-400">Tactile Modular Decks</span>
                <h2 class="text-lg font-bold text-white">Your Financial Stacks</h2>
                <p class="text-xs text-slate-400">Tap any deck to expand ledger details and transactions</p>
            </div>

            <!-- Deck Stack Interface Container -->
            <div class="space-y-3" id="decks-container">

                <!-- DECK 1: INCOME SOURCES DECK -->
                <div class="deck-card glass-card p-4 rounded-3xl border border-emerald-500/30 cursor-pointer" onclick="toggleDeck(this)">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold">
                                📈
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-white">Income Sources Deck</h3>
                                <p class="text-[11px] text-slate-400">Primary Salary, Freelance, Dividends</p>
                            </div>
                        </div>
                        <span class="text-xs font-mono font-bold text-emerald-400">+Rs. 95K/mo</span>
                    </div>

                    <!-- Expandable Details -->
                    <div class="deck-details hidden mt-3 pt-3 border-t border-white/10 space-y-2">
                        <div class="flex justify-between text-xs py-1">
                            <span class="text-slate-400">Tech Job Salary</span>
                            <span class="font-mono text-white">Rs. 75,000</span>
                        </div>
                        <div class="flex justify-between text-xs py-1">
                            <span class="text-slate-400">Freelance Consulting</span>
                            <span class="font-mono text-white">Rs. 15,000</span>
                        </div>
                        <div class="flex justify-between text-xs py-1">
                            <span class="text-slate-400">Stock Dividends</span>
                            <span class="font-mono text-white">Rs. 5,000</span>
                        </div>
                        <div class="pt-2 flex gap-2">
                            <a href="/app" class="flex-1 py-1.5 text-center text-xs font-semibold rounded-lg bg-emerald-500 text-slate-950 btn-touch">Manage Sources</a>
                        </div>
                    </div>
                </div>

                <!-- DECK 2: EXPENSES DECK -->
                <div class="deck-card glass-card p-4 rounded-3xl border border-rose-500/30 cursor-pointer" onclick="toggleDeck(this)">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-rose-500/20 text-rose-400 flex items-center justify-center font-bold">
                                🛒
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-white">Expense Control Deck</h3>
                                <p class="text-[11px] text-slate-400">Groceries, Fuel, Utilities, Rent</p>
                            </div>
                        </div>
                        <span class="text-xs font-mono font-bold text-rose-400">-Rs. 38.4K/mo</span>
                    </div>

                    <div class="deck-details hidden mt-3 pt-3 border-t border-white/10 space-y-2">
                        <div class="flex justify-between text-xs py-1">
                            <span class="text-slate-400">Apartment Rent & Bills</span>
                            <span class="font-mono text-white">Rs. 20,000</span>
                        </div>
                        <div class="flex justify-between text-xs py-1">
                            <span class="text-slate-400">Groceries & Market</span>
                            <span class="font-mono text-white">Rs. 11,200</span>
                        </div>
                        <div class="flex justify-between text-xs py-1">
                            <span class="text-slate-400">Fuel & Transit</span>
                            <span class="font-mono text-white">Rs. 7,250</span>
                        </div>
                        <div class="pt-2 flex gap-2">
                            <a href="/app" class="flex-1 py-1.5 text-center text-xs font-semibold rounded-lg bg-rose-500 text-white btn-touch">Add Expense</a>
                        </div>
                    </div>
                </div>

                <!-- DECK 3: CREDITS & BORROWINGS DECK -->
                <div class="deck-card glass-card p-4 rounded-3xl border border-teal-500/30 cursor-pointer" onclick="toggleDeck(this)">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-teal-500/20 text-teal-400 flex items-center justify-center font-bold">
                                🤝
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-white">Personal Credits Deck</h3>
                                <p class="text-[11px] text-slate-400">Money lent to friends & counter-parties</p>
                            </div>
                        </div>
                        <span class="text-xs font-mono font-bold text-teal-400">Rs. 42,000</span>
                    </div>

                    <div class="deck-details hidden mt-3 pt-3 border-t border-white/10 space-y-2">
                        <div class="flex justify-between text-xs py-1">
                            <span class="text-slate-400">Ram Shrestha</span>
                            <span class="font-mono text-emerald-400">Rs. 25,000 (To Receive)</span>
                        </div>
                        <div class="flex justify-between text-xs py-1">
                            <span class="text-slate-400">Sunil KC</span>
                            <span class="font-mono text-emerald-400">Rs. 17,000 (To Receive)</span>
                        </div>
                        <div class="pt-2 flex gap-2">
                            <a href="/app" class="flex-1 py-1.5 text-center text-xs font-semibold rounded-lg bg-teal-500 text-slate-950 btn-touch">Log Payment</a>
                        </div>
                    </div>
                </div>

                <!-- DECK 4: LOAN EMIS DECK -->
                <div class="deck-card glass-card p-4 rounded-3xl border border-amber-500/30 cursor-pointer" onclick="toggleDeck(this)">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold">
                                🏦
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-white">Bank Loans & EMIs</h3>
                                <p class="text-[11px] text-slate-400">Auto-calculated amortization</p>
                            </div>
                        </div>
                        <span class="text-xs font-mono font-bold text-amber-400">2 Active</span>
                    </div>

                    <div class="deck-details hidden mt-3 pt-3 border-t border-white/10 space-y-2">
                        <div class="flex justify-between text-xs py-1">
                            <span class="text-slate-400">Home Mortgage (Nabil)</span>
                            <span class="font-mono text-white">Rs. 24,500 / mo</span>
                        </div>
                        <div class="flex justify-between text-xs py-1">
                            <span class="text-slate-400">Vehicle Loan (Global IME)</span>
                            <span class="font-mono text-white">Rs. 12,300 / mo</span>
                        </div>
                        <div class="pt-2 flex gap-2">
                            <a href="/app" class="flex-1 py-1.5 text-center text-xs font-semibold rounded-lg bg-amber-500 text-slate-950 btn-touch">View Schedule</a>
                        </div>
                    </div>
                </div>

            </div>
        </section>


        <!-- ================= SPA TAB 3: ANALYTICS ================= -->
        <section id="tab-analytics" class="spa-tab-content px-4 pt-3 space-y-4">
            <div>
                <span class="text-xs font-medium text-emerald-400">Intelligent Insights</span>
                <h2 class="text-lg font-bold text-white">Cashflow Analytics</h2>
                <p class="text-xs text-slate-400">Monthly budget consumption and savings pace</p>
            </div>

            <!-- Savings Ratio Meter -->
            <div class="glass-card p-4 rounded-3xl space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-white">Savings Efficiency Ratio</span>
                    <span class="text-xs font-mono font-bold text-emerald-400">59.5%</span>
                </div>
                <div class="w-full h-3 rounded-full bg-slate-800 overflow-hidden flex">
                    <div class="bg-emerald-400 h-full" style="width: 59.5%"></div>
                    <div class="bg-rose-400 h-full" style="width: 40.5%"></div>
                </div>
                <div class="flex justify-between text-[11px] text-slate-400 font-mono">
                    <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-emerald-400"></span> Saved (NPR 56.5K)</span>
                    <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-rose-400"></span> Spent (NPR 38.4K)</span>
                </div>
            </div>

            <!-- Visual Bar Metrics -->
            <div class="glass-card p-4 rounded-3xl space-y-3">
                <span class="text-xs font-bold text-white">Weekly Spend Velocity</span>
                <div class="h-28 flex items-end justify-between gap-2 pt-2 px-1">
                    <div class="flex-1 flex flex-col items-center gap-1">
                        <div class="w-full bg-emerald-500/40 rounded-t-lg transition-all duration-500" style="height: 60%"></div>
                        <span class="text-[10px] text-slate-400">W1</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center gap-1">
                        <div class="w-full bg-emerald-500/60 rounded-t-lg transition-all duration-500" style="height: 85%"></div>
                        <span class="text-[10px] text-slate-400">W2</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center gap-1">
                        <div class="w-full bg-emerald-400 rounded-t-lg transition-all duration-500" style="height: 45%"></div>
                        <span class="text-[10px] text-slate-400">W3</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center gap-1">
                        <div class="w-full bg-teal-400 rounded-t-lg transition-all duration-500" style="height: 70%"></div>
                        <span class="text-[10px] text-slate-400">W4</span>
                    </div>
                </div>
            </div>

            <!-- Deep Metric Cards -->
            <div class="grid grid-cols-2 gap-2.5">
                <div class="glass-panel p-3.5 rounded-2xl space-y-1">
                    <span class="text-[11px] text-slate-400">Annual Projected</span>
                    <p class="text-base font-bold text-emerald-400 font-mono">Rs. 1.14M</p>
                    <span class="text-[10px] text-slate-400">Gross Inflow</span>
                </div>
                <div class="glass-panel p-3.5 rounded-2xl space-y-1">
                    <span class="text-[11px] text-slate-400">Debt-To-Income</span>
                    <p class="text-base font-bold text-cyan-400 font-mono">25.7%</p>
                    <span class="text-[10px] text-emerald-400">Healthy Margin</span>
                </div>
            </div>

            <a href="/app" class="block w-full py-3 text-center text-xs font-bold rounded-2xl bg-emerald-500 text-slate-950 shadow-lg btn-touch">
                Open Full Analytics in App →
            </a>
        </section>


        <!-- ================= SPA TAB 4: INSTALL & APP CENTER ================= -->
        <section id="tab-install" class="spa-tab-content px-4 pt-3 space-y-4">
            <div>
                <span class="text-xs font-medium text-emerald-400">Progressive Web App</span>
                <h2 class="text-lg font-bold text-white">Install Mobile App</h2>
                <p class="text-xs text-slate-400">Install Dainik Arthiki directly on your phone home screen</p>
            </div>

            <!-- App Installation Status Card -->
            <div class="glass-card-emerald p-5 rounded-3xl text-center space-y-3">
                <div class="w-16 h-16 mx-auto rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-400 p-0.5 shadow-xl shadow-emerald-500/25">
                    <div class="w-full h-full bg-slate-950 rounded-[14px] flex items-center justify-center">
                        <svg class="w-8 h-8 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <line x1="12" y1="1" x2="12" y2="23"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                    </div>
                </div>

                <div>
                    <h3 class="text-base font-bold text-white">Dainik Arthiki</h3>
                    <p class="text-xs text-slate-300 font-mono">Version 2.4.0 • Native Web App</p>
                </div>

                <div id="pwa-status-badge" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-medium">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span id="pwa-status-text">Available for 1-Tap Installation</span>
                </div>

                <!-- Main Install Button -->
                <button id="pwa-page-install-btn" class="w-full py-3.5 px-4 rounded-2xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-sm shadow-xl shadow-emerald-500/30 flex items-center justify-center gap-2 btn-touch">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    <span id="pwa-btn-text">Install App on Phone</span>
                </button>

                <a href="/app" class="block text-xs font-semibold text-slate-400 hover:text-white pt-1">
                    Or launch in browser dashboard →
                </a>
            </div>

            <!-- Features Checklist -->
            <div class="glass-card p-4 rounded-3xl space-y-2.5">
                <span class="text-xs font-bold text-white uppercase tracking-wider">Installed App Advantages</span>
                
                <div class="flex items-center gap-3 text-xs text-slate-300">
                    <span class="w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">✓</span>
                    <span>Full-screen standalone interface without browser bars</span>
                </div>
                <div class="flex items-center gap-3 text-xs text-slate-300">
                    <span class="w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">✓</span>
                    <span>Instant offline access to ledger records & calculator</span>
                </div>
                <div class="flex items-center gap-3 text-xs text-slate-300">
                    <span class="w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">✓</span>
                    <span>Biometric FaceID / Fingerprint unlock via Passkeys</span>
                </div>
                <div class="flex items-center gap-3 text-xs text-slate-300">
                    <span class="w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">✓</span>
                    <span>Zero app store downloads, ultra-low storage usage</span>
                </div>
            </div>

            <!-- iOS Safari Instructions Accordion/Card -->
            <div class="glass-card p-4 rounded-3xl space-y-2">
                <div class="flex items-center gap-2">
                    <span class="text-sm">🍎</span>
                    <h4 class="text-xs font-bold text-white">Apple iPhone / iPad (Safari) Instructions</h4>
                </div>
                <p class="text-xs text-slate-400 leading-relaxed">
                    1. Tap the <strong class="text-emerald-400">Share icon</strong> (box with arrow <span class="font-mono">[↑]</span>) at the bottom of Safari.<br>
                    2. Scroll down and tap <strong class="text-emerald-400">"Add to Home Screen"</strong>.<br>
                    3. Tap <strong class="text-emerald-400">"Add"</strong> in the top-right corner.
                </p>
            </div>
        </section>


        <!-- ================= BOTTOM SPA MOBILE NAVIGATION BAR ================= -->
        <nav class="fixed bottom-0 left-0 right-0 z-50 flex justify-center px-3 pb-safe pointer-events-none">
            <div class="w-full max-w-[440px] glass-panel px-3 py-2 rounded-3xl border border-white/10 shadow-2xl flex items-center justify-around pointer-events-auto backdrop-blur-2xl">
                
                <!-- Tab: Home -->
                <button onclick="switchTab('home')" class="nav-tab-btn flex flex-col items-center gap-1 py-1 px-3 rounded-2xl text-emerald-400 transition-all btn-touch" data-tab="home">
                    <div class="relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="nav-indicator absolute -bottom-1 left-1/2 -translate-x-1/2 w-1 h-1 rounded-full bg-emerald-400"></span>
                    </div>
                    <span class="text-[10px] font-bold">Home</span>
                </button>

                <!-- Tab: Decks -->
                <button onclick="switchTab('decks')" class="nav-tab-btn flex flex-col items-center gap-1 py-1 px-3 rounded-2xl text-slate-400 transition-all btn-touch" data-tab="decks">
                    <div class="relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span class="nav-indicator hidden absolute -bottom-1 left-1/2 -translate-x-1/2 w-1 h-1 rounded-full bg-emerald-400"></span>
                    </div>
                    <span class="text-[10px] font-bold">Decks</span>
                </button>

                <!-- Tab: Analytics -->
                <button onclick="switchTab('analytics')" class="nav-tab-btn flex flex-col items-center gap-1 py-1 px-3 rounded-2xl text-slate-400 transition-all btn-touch" data-tab="analytics">
                    <div class="relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span class="nav-indicator hidden absolute -bottom-1 left-1/2 -translate-x-1/2 w-1 h-1 rounded-full bg-emerald-400"></span>
                    </div>
                    <span class="text-[10px] font-bold">Insights</span>
                </button>

                <!-- Tab: Install -->
                <button onclick="switchTab('install')" class="nav-tab-btn flex flex-col items-center gap-1 py-1 px-3 rounded-2xl text-slate-400 transition-all btn-touch" data-tab="install">
                    <div class="relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        <span class="nav-indicator hidden absolute -bottom-1 left-1/2 -translate-x-1/2 w-1 h-1 rounded-full bg-emerald-400"></span>
                    </div>
                    <span class="text-[10px] font-bold">Install</span>
                </button>

            </div>
        </nav>

    </div>

    <!-- ================= JAVASCRIPT: SPA + THREE.JS + PWA LOGIC ================= -->
    <script>
        // ----------------------------------------------------
        // 1. SPA Bottom Tab Navigation
        // ----------------------------------------------------
        function switchTab(tabId) {
            // Hide all tabs
            const allTabs = document.querySelectorAll('.spa-tab-content');
            allTabs.forEach(tab => {
                tab.classList.remove('active');
            });

            // Show active tab
            const targetTab = document.getElementById('tab-' + tabId);
            if (targetTab) {
                targetTab.classList.add('active');
                gsap.fromTo(targetTab, { opacity: 0, y: 15 }, { opacity: 1, y: 0, duration: 0.28, ease: "power2.out" });
            }

            // Update bottom navigation buttons
            const navButtons = document.querySelectorAll('.nav-tab-btn');
            navButtons.forEach(btn => {
                const isSelected = btn.getAttribute('data-tab') === tabId;
                const indicator = btn.querySelector('.nav-indicator');

                if (isSelected) {
                    btn.classList.remove('text-slate-400');
                    btn.classList.add('text-emerald-400');
                    if (indicator) indicator.classList.remove('hidden');
                } else {
                    btn.classList.remove('text-emerald-400');
                    btn.classList.add('text-slate-400');
                    if (indicator) indicator.classList.add('hidden');
                }
            });

            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // ----------------------------------------------------
        // 2. Interactive Deck Accordion Toggle
        // ----------------------------------------------------
        function toggleDeck(deckElement) {
            const details = deckElement.querySelector('.deck-details');
            const isOpened = !details.classList.contains('hidden');

            // Close all details first
            document.querySelectorAll('.deck-details').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.deck-card').forEach(el => el.classList.remove('is-active'));

            if (!isOpened) {
                details.classList.remove('hidden');
                deckElement.classList.add('is-active');
                gsap.from(details, { opacity: 0, height: 0, duration: 0.25, ease: "power2.out" });
            }
        }

        // ----------------------------------------------------
        // 3. Balance Visibility Eye Toggle
        // ----------------------------------------------------
        let isBalanceHidden = false;
        const toggleBtn = document.getElementById('toggle-balance-btn');
        const balanceDisplay = document.getElementById('balance-display');
        if (toggleBtn && balanceDisplay) {
            toggleBtn.addEventListener('click', () => {
                isBalanceHidden = !isBalanceHidden;
                if (isBalanceHidden) {
                    balanceDisplay.classList.add('blurred-amount');
                } else {
                    balanceDisplay.classList.remove('blurred-amount');
                }
            });
        }

        // ----------------------------------------------------
        // 4. Three.js 3D Interactive Emerald Emblem Coin
        // ----------------------------------------------------
        let scene, camera, renderer, coinMesh, particlesMesh;
        let isDragging = false;
        let previousMousePosition = { x: 0, y: 0 };

        function initThreeCoin() {
            const container = document.getElementById('coin-canvas-container');
            if (!container) return;

            const width = container.clientWidth || 380;
            const height = 200;

            scene = new THREE.Scene();
            camera = new THREE.PerspectiveCamera(45, width / height, 0.1, 1000);
            camera.position.z = 5;

            renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
            renderer.setSize(width, height);
            renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
            container.appendChild(renderer.domElement);

            // Coin Geometry (Cylinder with bevel)
            const geometry = new THREE.CylinderGeometry(1.6, 1.6, 0.22, 48);
            
            // Materials: Emerald gold metallic
            const coinMaterial = new THREE.MeshStandardMaterial({
                color: 0x10b981,
                metalness: 0.85,
                roughness: 0.22,
                wireframe: false,
            });

            coinMesh = new THREE.Mesh(geometry, coinMaterial);
            coinMesh.rotation.x = 0.5;
            coinMesh.rotation.y = 0.3;
            scene.add(coinMesh);

            // Golden / Cyan Inner Core Ring
            const ringGeometry = new THREE.TorusGeometry(1.3, 0.05, 16, 64);
            const ringMaterial = new THREE.MeshStandardMaterial({
                color: 0x34d399,
                metalness: 0.9,
                roughness: 0.15,
                emissive: 0x059669,
                emissiveIntensity: 0.25
            });
            const ring = new THREE.Mesh(ringGeometry, ringMaterial);
            ring.rotation.x = Math.PI / 2;
            coinMesh.add(ring);

            // Floating Light Particles
            const particlesCount = 70;
            const posArray = new Float32Array(particlesCount * 3);
            for (let i = 0; i < particlesCount * 3; i++) {
                posArray[i] = (Math.random() - 0.5) * 8;
            }
            const particlesGeometry = new THREE.BufferGeometry();
            particlesGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
            const particlesMaterial = new THREE.PointsMaterial({
                size: 0.04,
                color: 0x34d399,
                transparent: true,
                opacity: 0.7
            });
            particlesMesh = new THREE.Points(particlesGeometry, particlesMaterial);
            scene.add(particlesMesh);

            // Lighting Setup
            const ambientLight = new THREE.AmbientLight(0xffffff, 0.9);
            scene.add(ambientLight);

            const pointLight = new THREE.PointLight(0x34d399, 3.5, 50);
            pointLight.position.set(3, 4, 4);
            scene.add(pointLight);

            const rimLight = new THREE.PointLight(0x06b6d4, 2.5, 50);
            rimLight.position.set(-3, -2, 2);
            scene.add(rimLight);

            // Mouse / Touch Interaction
            container.addEventListener('mousedown', (e) => {
                isDragging = true;
                previousMousePosition = { x: e.clientX, y: e.clientY };
            });

            window.addEventListener('mouseup', () => { isDragging = false; });

            container.addEventListener('mousemove', (e) => {
                if (!isDragging || !coinMesh) return;
                const deltaX = e.clientX - previousMousePosition.x;
                const deltaY = e.clientY - previousMousePosition.y;
                coinMesh.rotation.y += deltaX * 0.01;
                coinMesh.rotation.x += deltaY * 0.01;
                previousMousePosition = { x: e.clientX, y: e.clientY };
            });

            // Touch Drag Support for Mobile
            container.addEventListener('touchstart', (e) => {
                if (e.touches.length === 1) {
                    isDragging = true;
                    previousMousePosition = { x: e.touches[0].clientX, y: e.touches[0].clientY };
                }
            }, { passive: true });

            container.addEventListener('touchend', () => { isDragging = false; });

            container.addEventListener('touchmove', (e) => {
                if (!isDragging || !coinMesh || e.touches.length !== 1) return;
                const deltaX = e.touches[0].clientX - previousMousePosition.x;
                const deltaY = e.touches[0].clientY - previousMousePosition.y;
                coinMesh.rotation.y += deltaX * 0.012;
                coinMesh.rotation.x += deltaY * 0.012;
                previousMousePosition = { x: e.touches[0].clientX, y: e.touches[0].clientY };
            }, { passive: true });

            // Reset Button
            const resetBtn = document.getElementById('reset-coin-btn');
            if (resetBtn) {
                resetBtn.addEventListener('click', () => {
                    gsap.to(coinMesh.rotation, { x: 0.5, y: 0.3, z: 0, duration: 0.8, ease: "power2.out" });
                });
            }

            // Animation Loop
            function animate() {
                requestAnimationFrame(animate);
                if (!isDragging && coinMesh) {
                    coinMesh.rotation.y += 0.008;
                    coinMesh.rotation.x += 0.002;
                }
                if (particlesMesh) {
                    particlesMesh.rotation.y += 0.0015;
                }
                renderer.render(scene, camera);
            }
            animate();

            // Resize Observer
            window.addEventListener('resize', () => {
                if (!container || !renderer || !camera) return;
                const newWidth = container.clientWidth;
                camera.aspect = newWidth / height;
                camera.updateProjectionMatrix();
                renderer.setSize(newWidth, height);
            });
        }

        // ----------------------------------------------------
        // 5. PWA Smart Installation Manager
        // ----------------------------------------------------
        let deferredPrompt = null;
        const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
        const isIos = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

        const smartBanner = document.getElementById('smart-install-banner');
        const topBarInstallBtn = document.getElementById('top-bar-install-btn');
        const bannerTrigger = document.getElementById('banner-install-trigger');
        const bannerDismiss = document.getElementById('banner-dismiss-btn');
        const pageInstallBtn = document.getElementById('pwa-page-install-btn');
        const statusText = document.getElementById('pwa-status-text');
        const btnText = document.getElementById('pwa-btn-text');

        // Check standalone status
        if (isStandalone) {
            if (statusText) statusText.textContent = 'Active • Running in Standalone App Mode';
            if (btnText) btnText.textContent = 'App Already Installed (Open Dashboard)';
            if (pageInstallBtn) {
                pageInstallBtn.onclick = () => { window.location.href = '/app'; };
            }
        } else {
            // Listen for beforeinstallprompt event
            window.addEventListener('beforeinstallprompt', (e) => {
                e.preventDefault();
                deferredPrompt = e;

                // Show top banner & button
                if (smartBanner && !sessionStorage.getItem('pwa_banner_dismissed')) {
                    smartBanner.classList.remove('hidden');
                }
                if (topBarInstallBtn) topBarInstallBtn.classList.remove('hidden');
                if (topBarInstallBtn) topBarInstallBtn.classList.add('flex');
            });

            // Trigger prompt on button click
            async function triggerInstallation() {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    const { outcome } = await deferredPrompt.userChoice;
                    if (outcome === 'accepted') {
                        if (smartBanner) smartBanner.classList.add('hidden');
                        if (topBarInstallBtn) topBarInstallBtn.classList.add('hidden');
                    }
                    deferredPrompt = null;
                } else if (isIos) {
                    switchTab('install');
                    alert('To install on iOS:\n1. Tap the Share button [↑] at the bottom of Safari.\n2. Tap "Add to Home Screen".');
                } else {
                    switchTab('install');
                }
            }

            if (bannerTrigger) bannerTrigger.addEventListener('click', triggerInstallation);
            if (topBarInstallBtn) topBarInstallBtn.addEventListener('click', triggerInstallation);
            if (pageInstallBtn) pageInstallBtn.addEventListener('click', triggerInstallation);

            if (bannerDismiss) {
                bannerDismiss.addEventListener('click', () => {
                    if (smartBanner) smartBanner.classList.add('hidden');
                    sessionStorage.setItem('pwa_banner_dismissed', 'true');
                });
            }

            window.addEventListener('appinstalled', () => {
                if (smartBanner) smartBanner.classList.add('hidden');
                if (topBarInstallBtn) topBarInstallBtn.classList.add('hidden');
                if (statusText) statusText.textContent = 'Successfully Installed!';
                deferredPrompt = null;
            });
        }

        // Live Greeting Time
        const greetingEl = document.getElementById('live-time-greeting');
        if (greetingEl) {
            const hour = new Date().getHours();
            let greeting = 'Namaste 🙏';
            if (hour < 12) greeting = 'Subha Bihani (Good Morning) ☀️';
            else if (hour < 17) greeting = 'Good Afternoon 🌤️';
            else greeting = 'Good Evening 🌙';
            greetingEl.textContent = greeting;
        }

        // Initialize Three.js Coin on DOM load
        document.addEventListener('DOMContentLoaded', () => {
            initThreeCoin();
        });
    </script>
</body>
</html>
