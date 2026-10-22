<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <title>{{ config('app.name', 'Dainik Arthiki') }} - Smart Personal & Business Finance OS</title>
    
    @include('filament.pwa-head')
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
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
                            850: '#0e1424',
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

    <!-- Three.js for 3D Interactive Emblem -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <!-- GSAP for Smooth Motion Transitions -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

    <style>
        :root {
            --safe-bottom: env(safe-area-inset-bottom, 20px);
            --safe-top: env(safe-area-inset-top, 16px);
        }

        * {
            -webkit-tap-highlight-color: transparent;
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
        }

        /* Glassmorphic Layering */
        .glass-panel {
            background: rgba(11, 15, 25, 0.75);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .glass-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0.015) 100%);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .glass-card:hover {
            border-color: rgba(52, 211, 153, 0.3);
            transform: translateY(-2px);
        }

        .glass-card-emerald {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.12) 0%, rgba(6, 78, 59, 0.18) 100%);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(52, 211, 153, 0.25);
        }

        /* Subtle Ambient Glow Orbs */
        .glow-orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(120px);
            pointer-events: none;
            z-index: 0;
            opacity: 0.28;
        }

        /* Tactile Press Physics */
        .btn-touch {
            transition: transform 0.12s cubic-bezier(0.16, 1, 0.3, 1), background-color 0.15s ease, border-color 0.15s ease;
        }
        .btn-touch:active {
            transform: scale(0.97);
        }

        /* 3D Canvas Container */
        #coin-canvas-container {
            width: 100%;
            height: 280px;
            cursor: grab;
        }
        #coin-canvas-container:active {
            cursor: grabbing;
        }

        @media (min-width: 1024px) {
            #coin-canvas-container {
                height: 380px;
            }
        }

        /* Bottom Nav Safe Padding */
        .pb-safe {
            padding-bottom: calc(var(--safe-bottom) + 5.5rem);
        }

        /* SPA Tab Transitions */
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

        /* Feature Card Decks */
        .feature-deck-btn.active {
            border-color: #10b981;
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
        }
    </style>
</head>

<body class="relative min-h-screen bg-slate-950 text-slate-100 flex flex-col justify-between">

    <!-- Ambient Ambient Glow Backdrop -->
    <div class="glow-orb w-[500px] h-[500px] bg-emerald-500 top-[-100px] left-[-100px]"></div>
    <div class="glow-orb w-[600px] h-[600px] bg-teal-600 top-[30%] right-[-150px]"></div>
    <div class="glow-orb w-[500px] h-[500px] bg-cyan-600 bottom-[-100px] left-[20%]"></div>

    <!-- Main Full-Width App Shell -->
    <div class="relative z-10 w-full flex flex-col flex-1 pb-safe">

        <!-- ================= INLINE BRAND BAR ================= -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-5 pb-1 w-full flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-400 p-[1.5px] shadow-lg shadow-emerald-500/20">
                    <div class="w-full h-full bg-slate-950 rounded-[14px] flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="1" x2="12" y2="23"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <span class="text-base font-bold tracking-tight text-white flex items-center gap-1.5 leading-none">
                        Dainik Arthiki
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    </span>
                    <p class="text-[11px] font-medium text-slate-400 mt-0.5">Finance Operating System</p>
                </div>
            </div>

            <!-- Combined Sign In / Sign Up Trigger -->
            <button onclick="toggleAccountSheet(true)" class="flex items-center gap-2 px-3.5 py-1.5 text-xs font-bold rounded-2xl bg-emerald-500/15 hover:bg-emerald-500/25 text-emerald-400 border border-emerald-500/30 btn-touch">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span>Account</span>
            </button>
        </div>

        <!-- ================= SMART PWA INSTALL BANNER ================= -->
        <div id="smart-install-banner" class="hidden max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 w-full">
            <div class="glass-card-emerald p-4 rounded-3xl flex flex-col sm:flex-row items-center justify-between gap-3 shadow-xl">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-emerald-500/30 border border-emerald-400/40 flex items-center justify-center shrink-0 text-xl">
                        📲
                    </div>
                    <div>
                        <h4 class="text-xs sm:text-sm font-bold text-white flex items-center gap-1.5">
                            Install Dainik Arthiki on Your Device
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-400/20 text-emerald-300 font-mono">PWA Offline</span>
                        </h4>
                        <p class="text-[11px] sm:text-xs text-slate-300">Enjoy instant 1-tap launch, offline entry, and zero app store clutter.</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button id="banner-install-trigger" class="flex-1 sm:flex-none px-4 py-2 text-xs font-bold rounded-xl bg-emerald-400 text-slate-950 hover:bg-emerald-300 shadow-md btn-touch">
                        Install Now
                    </button>
                    <button id="banner-dismiss-btn" class="p-2 text-slate-400 hover:text-white rounded-xl hover:bg-white/5 transition" title="Dismiss">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>


        <!-- ================= CONTENT AREA (SPA TABS) ================= -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pt-4 lg:pt-8 flex-1">

            <!-- ================= SPA TAB 1: OVERVIEW & HERO ================= -->
            <div id="tab-overview" class="spa-tab-content active space-y-12 lg:space-y-16">
                
                <!-- Hero Section: Split Desktop / Mobile Stack -->
                <section class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                    
                    <!-- Left Column: Copy & Value Proposition -->
                    <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                        
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-xs font-semibold text-emerald-400">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                            <span>Smart Daily Ledger & Loan Manager</span>
                        </div>

                        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-[1.15]">
                            Take Complete Control of Your
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-cyan-400">
                                Incomes, Debts & EMIs
                            </span>
                        </h2>

                        <p class="text-sm sm:text-base text-slate-300 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                            Dainik Arthiki is your daily financial companion designed to track every income stream, control expenses, manage personal credits lent and borrowed, and calculate amortization for bank loan EMIs — with bank-grade privacy and full offline PWA support.
                        </p>

                        <!-- High-Converting Signup Prompts -->
                        <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3 pt-2">
                            <a href="/app/register" class="w-full sm:w-auto px-7 py-3.5 text-sm font-bold rounded-2xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 shadow-xl shadow-emerald-500/30 flex items-center justify-center gap-2 btn-touch">
                                <span>Create Free Account</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                            <button onclick="switchTab('modules')" class="w-full sm:w-auto px-6 py-3.5 text-sm font-semibold rounded-2xl bg-white/5 hover:bg-white/10 text-white border border-white/10 flex items-center justify-center gap-2 btn-touch">
                                <span>Explore Core Modules</span>
                                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Trust / Benefit Badges -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 pt-4 border-t border-white/10 text-left">
                            <div class="flex items-center gap-2 text-xs text-slate-300">
                                <span class="w-4 h-4 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-[10px] font-bold">✓</span>
                                <span>No Subscription Required</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-slate-300">
                                <span class="w-4 h-4 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-[10px] font-bold">✓</span>
                                <span>Passkeys & 2FA Protected</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-slate-300">
                                <span class="w-4 h-4 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-[10px] font-bold">✓</span>
                                <span>Works 100% Offline (PWA)</span>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column: Interactive Three.js 3D Emblem Stage -->
                    <div class="lg:col-span-5 flex flex-col items-center">
                        <div class="relative w-full glass-card p-6 rounded-3xl border border-emerald-500/20 shadow-2xl">
                            
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold text-white uppercase tracking-wider">Arthiki 3D Emblem</span>
                                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 font-mono">Touch & Drag</span>
                                </div>
                                <button id="reset-coin-btn" class="text-xs text-emerald-400 hover:text-emerald-300 font-medium btn-touch">Reset</button>
                            </div>

                            <!-- 3D Canvas Injection -->
                            <div id="coin-canvas-container" class="rounded-2xl overflow-hidden flex items-center justify-center"></div>

                            <div class="pt-3 border-t border-white/5 flex items-center justify-between text-xs text-slate-400">
                                <span>Gyroscopic Real-Time Physics</span>
                                <span class="text-emerald-400 font-semibold">WebGL 60FPS</span>
                            </div>
                        </div>
                    </div>

                </section>

                <!-- Value Pillars Grid (Explaining What the System Does) -->
                <section class="space-y-6">
                    <div class="text-center max-w-2xl mx-auto space-y-2">
                        <span class="text-xs font-bold text-emerald-400 uppercase tracking-widest">Why Dainik Arthiki?</span>
                        <h3 class="text-2xl sm:text-3xl font-extrabold text-white">Built for Everyday Clarity</h3>
                        <p class="text-xs sm:text-sm text-slate-400">A clean, dedicated operating system designed to eliminate financial anxiety and manual calculation mistakes.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 lg:gap-6">
                        <!-- Pillar 1 -->
                        <div class="glass-card p-6 rounded-3xl space-y-3">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-500/15 text-emerald-400 border border-emerald-500/20 flex items-center justify-center text-xl">
                                📊
                            </div>
                            <h4 class="text-base font-bold text-white">Income & Expense Balance</h4>
                            <p class="text-xs text-slate-400 leading-relaxed">
                                Record daily expenses by custom categories and track your salary, dividends, and business profits with receipt image uploads.
                            </p>
                        </div>

                        <!-- Pillar 2 -->
                        <div class="glass-card p-6 rounded-3xl space-y-3">
                            <div class="w-12 h-12 rounded-2xl bg-teal-500/15 text-teal-400 border border-teal-500/20 flex items-center justify-center text-xl">
                                🤝
                            </div>
                            <h4 class="text-base font-bold text-white">Peer Credits & Borrowings</h4>
                            <p class="text-xs text-slate-400 leading-relaxed">
                                Never forget who borrowed money from you or when a payment is due. Track partial repayments and settle accounts seamlessly.
                            </p>
                        </div>

                        <!-- Pillar 3 -->
                        <div class="glass-card p-6 rounded-3xl space-y-3">
                            <div class="w-12 h-12 rounded-2xl bg-amber-500/15 text-amber-400 border border-amber-500/20 flex items-center justify-center text-xl">
                                🏦
                            </div>
                            <h4 class="text-base font-bold text-white">Bank Loans & Auto-EMIs</h4>
                            <p class="text-xs text-slate-400 leading-relaxed">
                                Enter loan amount, interest rate, and tenure. Dainik Arthiki automatically calculates your monthly EMI schedule and tracks installments.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Call to Action Banner -->
                <section class="glass-card-emerald p-8 lg:p-12 rounded-3xl text-center space-y-5">
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                        Ready to Take Control of Your Finances?
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-300 max-w-xl mx-auto">
                        Sign up in less than 30 seconds. No credit card required. Experience passwordless biometric login and full offline access.
                    </p>
                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3">
                        <a href="/app/register" class="w-full sm:w-auto px-8 py-3.5 text-sm font-bold rounded-2xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 shadow-xl shadow-emerald-500/30 btn-touch">
                            Register Your Account
                        </a>
                        <a href="/app/login" class="w-full sm:w-auto px-6 py-3.5 text-sm font-semibold rounded-2xl bg-white/10 hover:bg-white/15 text-white border border-white/10 btn-touch">
                            Existing User Login
                        </a>
                    </div>
                </section>

            </div>


            <!-- ================= SPA TAB 2: CORE MODULES & DECKS ================= -->
            <div id="tab-modules" class="spa-tab-content space-y-8">
                
                <div class="text-center max-w-2xl mx-auto space-y-2">
                    <span class="text-xs font-bold text-emerald-400 uppercase tracking-widest">System Architecture</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-white">Interactive Module Decks</h2>
                    <p class="text-xs sm:text-sm text-slate-400">Click any deck below to examine how Dainik Arthiki powers each area of your financial journey.</p>
                </div>

                <!-- Module Selector Tabs -->
                <div class="flex flex-wrap items-center justify-center gap-2">
                    <button onclick="selectModuleDeck('income')" class="feature-deck-btn active px-4 py-2 rounded-2xl text-xs font-bold glass-card border border-white/10 transition btn-touch" data-deck="income">
                        💵 Income Streams
                    </button>
                    <button onclick="selectModuleDeck('expenses')" class="feature-deck-btn px-4 py-2 rounded-2xl text-xs font-bold glass-card border border-white/10 transition btn-touch" data-deck="expenses">
                        🛒 Expense Control
                    </button>
                    <button onclick="selectModuleDeck('credits')" class="feature-deck-btn px-4 py-2 rounded-2xl text-xs font-bold glass-card border border-white/10 transition btn-touch" data-deck="credits">
                        🤝 Credits & Debts
                    </button>
                    <button onclick="selectModuleDeck('loans')" class="feature-deck-btn px-4 py-2 rounded-2xl text-xs font-bold glass-card border border-white/10 transition btn-touch" data-deck="loans">
                        🏦 Loans & EMIs
                    </button>
                </div>

                <!-- Deck Card Display Area -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
                    
                    <!-- Dynamic Deck Details Card -->
                    <div id="module-deck-card" class="lg:col-span-8 glass-card p-6 sm:p-8 rounded-3xl border border-emerald-500/30 space-y-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span id="module-icon" class="text-3xl">💵</span>
                                <div>
                                    <h3 id="module-title" class="text-lg sm:text-xl font-bold text-white">Multi-Source Income Management</h3>
                                    <p id="module-subtitle" class="text-xs text-emerald-400">Aggregate all cashflow channels in one verified ledger</p>
                                </div>
                            </div>
                            <span id="module-badge" class="hidden sm:inline-block text-[11px] font-mono px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300">
                                Real-Time Inflow
                            </span>
                        </div>

                        <p id="module-description" class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                            Organize multiple income sources including monthly salary, freelance contracts, investment returns, and rental incomes. Attach transaction slips and date records to generate historical income trends and annual forecasting.
                        </p>

                        <!-- Key Capabilities List -->
                        <div class="space-y-2.5 pt-2 border-t border-white/10">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Key Capabilities</span>
                            <div id="module-capabilities" class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs text-slate-200">
                                <div class="flex items-center gap-2"><span class="text-emerald-400 font-bold">✓</span> Multiple custom income sources</div>
                                <div class="flex items-center gap-2"><span class="text-emerald-400 font-bold">✓</span> Receipt image storage disk</div>
                                <div class="flex items-center gap-2"><span class="text-emerald-400 font-bold">✓</span> Filter by source & date ranges</div>
                                <div class="flex items-center gap-2"><span class="text-emerald-400 font-bold">✓</span> Exportable monthly cashflow reports</div>
                            </div>
                        </div>

                        <!-- CTA to register -->
                        <div class="pt-4 flex flex-col sm:flex-row items-center gap-3">
                            <a href="/app/register" class="w-full sm:w-auto px-6 py-2.5 text-xs font-bold rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 shadow-md btn-touch text-center">
                                Start Tracking with This Module →
                            </a>
                            <a href="/app/login" class="text-xs font-semibold text-slate-400 hover:text-white">
                                Sign In to existing dashboard
                            </a>
                        </div>
                    </div>

                    <!-- Right Quick Summary Column -->
                    <div class="lg:col-span-4 space-y-4">
                        <div class="glass-panel p-5 rounded-3xl space-y-3">
                            <h4 class="text-xs font-bold text-white uppercase tracking-wider">All 4 Pillars Connected</h4>
                            <p class="text-xs text-slate-400 leading-relaxed">
                                Unlike fragmented spreadsheets, your incomes, expenses, credit settlements, and loan installments talk to each other in one unified database.
                            </p>
                            <div class="pt-1">
                                <a href="/app/register" class="text-xs font-bold text-emerald-400 hover:text-emerald-300 flex items-center gap-1">
                                    <span>Experience the integration</span>
                                    <span>→</span>
                                </a>
                            </div>
                        </div>

                        <div class="glass-panel p-5 rounded-3xl space-y-2">
                            <div class="flex items-center gap-2 text-xs font-bold text-white">
                                <span>⚡</span>
                                <span>Instant Calculator</span>
                            </div>
                            <p class="text-xs text-slate-400 leading-relaxed">
                                Built-in amortized financial math automatically computes exact EMI installments based on decreasing balance formulas.
                            </p>
                        </div>
                    </div>

                </div>

            </div>


            <!-- ================= SPA TAB 3: SECURITY & PRIVACY ================= -->
            <div id="tab-security" class="spa-tab-content space-y-8">
                
                <div class="text-center max-w-2xl mx-auto space-y-2">
                    <span class="text-xs font-bold text-emerald-400 uppercase tracking-widest">Privacy By Design</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-white">Bank-Grade Protection & Privacy</h2>
                    <p class="text-xs sm:text-sm text-slate-400">Your financial records belong solely to you. We do not sell data, track ads, or compromise privacy.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    
                    <div class="glass-card p-6 rounded-3xl space-y-3">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-500/15 text-emerald-400 flex items-center justify-center text-xl">
                            🔑
                        </div>
                        <h3 class="text-base font-bold text-white">WebAuthn Passkeys</h3>
                        <p class="text-xs text-slate-400 leading-relaxed">
                            Sign in securely using Apple TouchID, FaceID, or Windows Hello. Zero passwords to remember and complete immunity against credential leaks.
                        </p>
                    </div>

                    <div class="glass-card p-6 rounded-3xl space-y-3">
                        <div class="w-12 h-12 rounded-2xl bg-teal-500/15 text-teal-400 flex items-center justify-center text-xl">
                            🛡️
                        </div>
                        <h3 class="text-base font-bold text-white">Two-Factor Authentication</h3>
                        <p class="text-xs text-slate-400 leading-relaxed">
                            Reinforce your account with TOTP authenticator app support (Google Authenticator, Authy, Apple Passwords) and emergency recovery keys.
                        </p>
                    </div>

                    <div class="glass-card p-6 rounded-3xl space-y-3">
                        <div class="w-12 h-12 rounded-2xl bg-cyan-500/15 text-cyan-400 flex items-center justify-center text-xl">
                            🔒
                        </div>
                        <h3 class="text-base font-bold text-white">Strict Row-Level Isolation</h3>
                        <p class="text-xs text-slate-400 leading-relaxed">
                            Every single ledger entry is strictly query-scoped to your authenticated user account. Nobody else can ever see your balances or transactions.
                        </p>
                    </div>

                </div>

                <!-- Registration Promotion Card -->
                <div class="glass-card-emerald p-8 rounded-3xl text-center space-y-4 max-w-3xl mx-auto">
                    <h3 class="text-xl sm:text-2xl font-bold text-white">Your Financial Privacy is Non-Negotiable</h3>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                        Start keeping clean, organized records without worrying about telemetry or intrusive ad algorithms.
                    </p>
                    <a href="/app/register" class="inline-block px-7 py-3 text-xs font-bold rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 shadow-lg btn-touch">
                        Sign Up with Passkey Biometrics →
                    </a>
                </div>

            </div>


            <!-- ================= SPA TAB 4: PWA MOBILE APP & INSTALL ================= -->
            <div id="tab-install" class="spa-tab-content space-y-8">
                
                <div class="text-center max-w-2xl mx-auto space-y-2">
                    <span class="text-xs font-bold text-emerald-400 uppercase tracking-widest">Progressive Web App</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-white">Install Dainik Arthiki App</h2>
                    <p class="text-xs sm:text-sm text-slate-400">Install directly onto your iPhone, Android, iPad, Mac, or Windows PC without using an app store.</p>
                </div>

                <div class="max-w-xl mx-auto glass-card-emerald p-6 sm:p-8 rounded-3xl text-center space-y-5 shadow-2xl">
                    
                    <div class="w-20 h-20 mx-auto rounded-3xl bg-gradient-to-tr from-emerald-600 to-teal-400 p-0.5 shadow-xl shadow-emerald-500/30">
                        <div class="w-full h-full bg-slate-950 rounded-[22px] flex items-center justify-center">
                            <svg class="w-10 h-10 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <line x1="12" y1="1" x2="12" y2="23"></line>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-white">Dainik Arthiki</h3>
                        <p class="text-xs text-slate-300 font-mono">PWA Native Web App • Version 2.4.0</p>
                    </div>

                    <div id="pwa-status-badge" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-semibold">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span id="pwa-status-text">Available for 1-Tap Installation</span>
                    </div>

                    <!-- Main Install Trigger Button -->
                    <button id="pwa-page-install-btn" class="w-full py-4 px-6 rounded-2xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold text-sm shadow-xl shadow-emerald-500/30 flex items-center justify-center gap-2.5 btn-touch">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        <span id="pwa-btn-text">Install App on This Device</span>
                    </button>

                    <div class="pt-2 border-t border-white/10 flex items-center justify-center gap-4 text-xs">
                        <a href="/app/register" class="text-emerald-400 font-bold hover:underline">Create Account</a>
                        <span class="text-slate-500">•</span>
                        <a href="/app/login" class="text-slate-300 hover:underline">Existing User Login</a>
                    </div>
                </div>

                <!-- Installation Walkthroughs Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                    
                    <!-- Android & Chrome Walkthrough -->
                    <div class="glass-card p-6 rounded-3xl space-y-3">
                        <div class="flex items-center gap-2.5 text-emerald-400 font-bold text-sm">
                            <span>🤖</span>
                            <span>Android / Chrome / Edge</span>
                        </div>
                        <ol class="text-xs text-slate-300 space-y-2 list-decimal list-inside leading-relaxed">
                            <li>Tap the <strong class="text-white">"Install App on This Device"</strong> button above.</li>
                            <li>When the browser asks to install, tap <strong class="text-white">"Install"</strong> or <strong class="text-white">"Add"</strong>.</li>
                            <li>The app icon will immediately appear on your home screen or app drawer.</li>
                        </ol>
                    </div>

                    <!-- iOS Safari Walkthrough -->
                    <div class="glass-card p-6 rounded-3xl space-y-3">
                        <div class="flex items-center gap-2.5 text-cyan-400 font-bold text-sm">
                            <span>🍎</span>
                            <span>Apple iPhone & iPad (Safari)</span>
                        </div>
                        <ol class="text-xs text-slate-300 space-y-2 list-decimal list-inside leading-relaxed">
                            <li>Tap the <strong class="text-white">Share button</strong> <span class="font-mono text-emerald-400">[↑]</span> at the bottom of Safari.</li>
                            <li>Scroll down the share sheet and tap <strong class="text-white">"Add to Home Screen"</strong>.</li>
                            <li>Tap <strong class="text-white">"Add"</strong> in the top-right corner to launch in standalone mode.</li>
                        </ol>
                    </div>

                </div>

            </div>

        </main>

        <!-- ================= BOTTOM SPA MOBILE & DESKTOP DOCK NAVIGATION ================= -->
        <nav class="fixed bottom-0 left-0 right-0 z-50 flex justify-center px-4 pb-safe pointer-events-none">
            <div class="glass-panel px-4 py-2.5 rounded-3xl border border-white/10 shadow-2xl flex items-center justify-between sm:justify-center gap-2 sm:gap-6 pointer-events-auto backdrop-blur-2xl">
                
                <!-- Tab: Overview -->
                <button onclick="switchTab('overview')" class="nav-tab-btn flex flex-col items-center gap-1 py-1 px-3 sm:px-4 rounded-2xl text-emerald-400 transition-all btn-touch" data-tab="overview">
                    <div class="relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="nav-indicator absolute -bottom-1 left-1/2 -translate-x-1/2 w-1 h-1 rounded-full bg-emerald-400"></span>
                    </div>
                    <span class="text-[10px] font-bold">Overview</span>
                </button>

                <!-- Tab: Modules / Decks -->
                <button onclick="switchTab('modules')" class="nav-tab-btn flex flex-col items-center gap-1 py-1 px-3 sm:px-4 rounded-2xl text-slate-400 transition-all btn-touch" data-tab="modules">
                    <div class="relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span class="nav-indicator hidden absolute -bottom-1 left-1/2 -translate-x-1/2 w-1 h-1 rounded-full bg-emerald-400"></span>
                    </div>
                    <span class="text-[10px] font-bold">Modules</span>
                </button>

                <!-- Tab: Security -->
                <button onclick="switchTab('security')" class="nav-tab-btn flex flex-col items-center gap-1 py-1 px-3 sm:px-4 rounded-2xl text-slate-400 transition-all btn-touch" data-tab="security">
                    <div class="relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <span class="nav-indicator hidden absolute -bottom-1 left-1/2 -translate-x-1/2 w-1 h-1 rounded-full bg-emerald-400"></span>
                    </div>
                    <span class="text-[10px] font-bold">Security</span>
                </button>

                <!-- Tab: Install / App -->
                <button onclick="switchTab('install')" class="nav-tab-btn flex flex-col items-center gap-1 py-1 px-3 sm:px-4 rounded-2xl text-slate-400 transition-all btn-touch" data-tab="install">
                    <div class="relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        <span class="nav-indicator hidden absolute -bottom-1 left-1/2 -translate-x-1/2 w-1 h-1 rounded-full bg-emerald-400"></span>
                    </div>
                    <span class="text-[10px] font-bold">Install</span>
                </button>

                <!-- Tab: Account (Single Icon for Sign In / Sign Up) -->
                <button onclick="toggleAccountSheet(true)" class="nav-tab-btn flex flex-col items-center gap-1 py-1 px-3 sm:px-4 rounded-2xl text-slate-400 hover:text-emerald-400 transition-all btn-touch" data-tab="account">
                    <div class="relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <span class="text-[10px] font-bold">Account</span>
                </button>

            </div>
        </nav>

    </div>

    <!-- ================= JAVASCRIPT: SPA + THREE.JS + PWA LOGIC ================= -->
    <script>
        // ----------------------------------------------------
        // 1. Module Decks Data & Switching
        // ----------------------------------------------------
        const moduleData = {
            income: {
                icon: "💵",
                title: "Multi-Source Income Management",
                subtitle: "Aggregate all cashflow channels in one verified ledger",
                badge: "Real-Time Inflow",
                description: "Organize multiple income sources including monthly salary, freelance contracts, investment returns, and rental incomes. Attach transaction slips and date records to generate historical income trends and annual forecasting.",
                capabilities: [
                    "Multiple custom income sources",
                    "Receipt image storage disk",
                    "Filter by source & date ranges",
                    "Exportable monthly cashflow reports"
                ]
            },
            expenses: {
                icon: "🛒",
                title: "Disciplined Expense Control",
                subtitle: "Category-level tracking with intelligent budgets",
                badge: "Outflow Sentinel",
                description: "Categorize every expense from groceries and housing to vehicle maintenance. Establish category ceilings and receive visual warnings before you exceed your monthly limits.",
                capabilities: [
                    "Categorized expenditure logs",
                    "Automatic daily expense sorting",
                    "Expense receipt attachment",
                    "Income-to-Expense ratio metrics"
                ]
            },
            credits: {
                icon: "🤝",
                title: "Peer-to-Peer Credits & Debts",
                subtitle: "Track money lent to and borrowed from counterparties",
                badge: "Zero Unpaid Debts",
                description: "Keep dedicated ledgers for money lent to friends, relatives, or business associates (receivables) and personal borrowings (payables). Record partial repayments with settlement history.",
                capabilities: [
                    "Individual counterparty profiles",
                    "Partial payment installment logging",
                    "Due date alerts & pending summaries",
                    "One-tap account balance settlement"
                ]
            },
            loans: {
                icon: "🏦",
                title: "Bank Loans & Amortization Scheduler",
                subtitle: "Decreasing balance EMI math and payment calendar",
                badge: "Smart Amortization",
                description: "Input bank loans with principal, interest rate, and tenure in months. The system automatically calculates your monthly EMI and tracks pending vs. paid installments.",
                capabilities: [
                    "Auto-calculated decreasing balance EMI",
                    "Upcoming installment reminders",
                    "Active vs. closed loan archives",
                    "Lender bank and reference tracking"
                ]
            }
        };

        function selectModuleDeck(key) {
            const data = moduleData[key];
            if (!data) return;

            // Update button styles
            document.querySelectorAll('.feature-deck-btn').forEach(btn => {
                if (btn.getAttribute('data-deck') === key) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });

            // Update details
            document.getElementById('module-icon').textContent = data.icon;
            document.getElementById('module-title').textContent = data.title;
            document.getElementById('module-subtitle').textContent = data.subtitle;
            document.getElementById('module-badge').textContent = data.badge;
            document.getElementById('module-description').textContent = data.description;

            const capsEl = document.getElementById('module-capabilities');
            capsEl.innerHTML = data.capabilities.map(cap => `
                <div class="flex items-center gap-2">
                    <span class="text-emerald-400 font-bold">✓</span> ${cap}
                </div>
            `).join('');

            // Animate card entrance
            gsap.fromTo('#module-deck-card', { opacity: 0.8, y: 8 }, { opacity: 1, y: 0, duration: 0.25, ease: "power2.out" });
        }

        // ----------------------------------------------------
        // 2. SPA Tab Navigation
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
                gsap.fromTo(targetTab, { opacity: 0, y: 12 }, { opacity: 1, y: 0, duration: 0.28, ease: "power2.out" });
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

            // Update desktop top navigation
            const desktopButtons = document.querySelectorAll('.nav-tab-desktop');
            desktopButtons.forEach(btn => {
                if (btn.getAttribute('data-tab') === tabId) {
                    btn.classList.remove('text-slate-400');
                    btn.classList.add('text-emerald-400');
                } else {
                    btn.classList.remove('text-emerald-400');
                    btn.classList.add('text-slate-400');
                }
            });

            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // ----------------------------------------------------
        // 3. Three.js 3D Interactive Emblem
        // ----------------------------------------------------
        let scene, camera, renderer, coinMesh, particlesMesh;
        let isDragging = false;
        let previousMousePosition = { x: 0, y: 0 };

        function initThreeEmblem() {
            const container = document.getElementById('coin-canvas-container');
            if (!container) return;

            const width = container.clientWidth || 380;
            const height = container.clientHeight || 280;

            scene = new THREE.Scene();
            camera = new THREE.PerspectiveCamera(45, width / height, 0.1, 1000);
            camera.position.z = 5.2;

            renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
            renderer.setSize(width, height);
            renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
            container.appendChild(renderer.domElement);

            // Coin Mesh (Metallic Emerald Emblem)
            const geometry = new THREE.CylinderGeometry(1.65, 1.65, 0.22, 64);
            const coinMaterial = new THREE.MeshStandardMaterial({
                color: 0x10b981,
                metalness: 0.88,
                roughness: 0.20,
            });

            coinMesh = new THREE.Mesh(geometry, coinMaterial);
            coinMesh.rotation.x = 0.45;
            coinMesh.rotation.y = 0.35;
            scene.add(coinMesh);

            // Inner Holographic Torus Ring
            const ringGeometry = new THREE.TorusGeometry(1.35, 0.05, 16, 64);
            const ringMaterial = new THREE.MeshStandardMaterial({
                color: 0x34d399,
                metalness: 0.95,
                roughness: 0.12,
                emissive: 0x059669,
                emissiveIntensity: 0.35
            });
            const ring = new THREE.Mesh(ringGeometry, ringMaterial);
            ring.rotation.x = Math.PI / 2;
            coinMesh.add(ring);

            // Floating Ambient Particles
            const particlesCount = 80;
            const posArray = new Float32Array(particlesCount * 3);
            for (let i = 0; i < particlesCount * 3; i++) {
                posArray[i] = (Math.random() - 0.5) * 10;
            }
            const particlesGeometry = new THREE.BufferGeometry();
            particlesGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
            const particlesMaterial = new THREE.PointsMaterial({
                size: 0.045,
                color: 0x34d399,
                transparent: true,
                opacity: 0.65
            });
            particlesMesh = new THREE.Points(particlesGeometry, particlesMaterial);
            scene.add(particlesMesh);

            // Lighting
            const ambientLight = new THREE.AmbientLight(0xffffff, 0.85);
            scene.add(ambientLight);

            const pointLight = new THREE.PointLight(0x34d399, 3.5, 60);
            pointLight.position.set(4, 5, 5);
            scene.add(pointLight);

            const rimLight = new THREE.PointLight(0x06b6d4, 2.8, 60);
            rimLight.position.set(-4, -3, 3);
            scene.add(rimLight);

            // Mouse / Drag Controls
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

            // Touch Drag Support
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
                    gsap.to(coinMesh.rotation, { x: 0.45, y: 0.35, z: 0, duration: 0.8, ease: "power2.out" });
                });
            }

            // Animation Loop
            function animate() {
                requestAnimationFrame(animate);
                if (!isDragging && coinMesh) {
                    coinMesh.rotation.y += 0.007;
                    coinMesh.rotation.x += 0.0015;
                }
                if (particlesMesh) {
                    particlesMesh.rotation.y += 0.0012;
                }
                renderer.render(scene, camera);
            }
            animate();

            // Resize Observer
            window.addEventListener('resize', () => {
                if (!container || !renderer || !camera) return;
                const newWidth = container.clientWidth;
                const newHeight = container.clientHeight;
                camera.aspect = newWidth / newHeight;
                camera.updateProjectionMatrix();
                renderer.setSize(newWidth, newHeight);
            });
        }

        // ----------------------------------------------------
        // 4. PWA Smart Installation Manager
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

        if (isStandalone) {
            if (statusText) statusText.textContent = 'Active • Running in Native Standalone App Mode';
            if (btnText) btnText.textContent = 'App Already Installed (Open Dashboard)';
            if (pageInstallBtn) {
                pageInstallBtn.onclick = () => { window.location.href = '/app'; };
            }
        } else {
            window.addEventListener('beforeinstallprompt', (e) => {
                e.preventDefault();
                deferredPrompt = e;

                if (smartBanner && !sessionStorage.getItem('pwa_banner_dismissed')) {
                    smartBanner.classList.remove('hidden');
                }
                if (topBarInstallBtn) {
                    topBarInstallBtn.classList.remove('hidden');
                    topBarInstallBtn.classList.add('flex');
                }
            });

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
                    alert('To install on Apple iOS:\n1. Tap the Share button [↑] at the bottom of Safari.\n2. Tap "Add to Home Screen".');
                } else {
                    switchTab('install');
                }
            }

            if (bannerTrigger) bannerTrigger.addEventListener('click', triggerInstallation);
            if (pageInstallBtn) pageInstallBtn.addEventListener('click', triggerInstallation);

            if (bannerDismiss) {
                bannerDismiss.addEventListener('click', () => {
                    if (smartBanner) smartBanner.classList.add('hidden');
                    sessionStorage.setItem('pwa_banner_dismissed', 'true');
                });
            }

            window.addEventListener('appinstalled', () => {
                if (smartBanner) smartBanner.classList.add('hidden');
                if (statusText) statusText.textContent = 'Successfully Installed!';
                deferredPrompt = null;
            });
        }

        // ----------------------------------------------------
        // 5. Account Action Sheet (Sign In / Sign Up Modal)
        // ----------------------------------------------------
        function toggleAccountSheet(show) {
            const sheet = document.getElementById('account-action-sheet');
            if (!sheet) return;
            if (show) {
                sheet.classList.remove('hidden');
            } else {
                sheet.classList.add('hidden');
            }
        }

        function handleSheetBackdropClick(e) {
            if (e.target.id === 'account-action-sheet') {
                toggleAccountSheet(false);
            }
        }

        // Initialize Three.js on DOM ready
        document.addEventListener('DOMContentLoaded', () => {
            initThreeEmblem();
        });
    </script>

    <!-- ================= NATIVE ACCOUNT / AUTH ACTION SHEET ================= -->
    <div id="account-action-sheet" class="hidden fixed inset-0 z-50 flex items-end sm:items-center justify-center p-4 bg-black/60 backdrop-blur-md" onclick="handleSheetBackdropClick(event)">
        <div class="w-full max-w-sm glass-panel p-6 rounded-3xl border border-white/10 shadow-2xl space-y-4 text-center">
            <div class="w-12 h-12 mx-auto rounded-2xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xl shadow-lg border border-emerald-500/30">
                👤
            </div>
            <div>
                <h3 class="text-base font-bold text-white">Access Your Account</h3>
                <p class="text-xs text-slate-400 mt-0.5">Manage your personal and business financial ledgers</p>
            </div>
            <div class="space-y-2.5 pt-1">
                <a href="/app/register" class="block w-full py-3 px-4 text-xs font-bold rounded-2xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 shadow-lg shadow-emerald-500/25 btn-touch">
                    Create Free Account (Sign Up)
                </a>
                <a href="/app/login" class="block w-full py-3 px-4 text-xs font-semibold rounded-2xl bg-white/5 hover:bg-white/10 text-white border border-white/10 btn-touch">
                    Sign In to Existing Account
                </a>
                <a href="/app" class="block text-xs font-semibold text-slate-400 hover:text-emerald-400 pt-1">
                    Open Web Dashboard Directly →
                </a>
            </div>
            <button onclick="toggleAccountSheet(false)" class="w-full py-2 text-xs text-slate-500 hover:text-slate-300 transition">
                Close
            </button>
        </div>
    </div>
</body>
</html>
