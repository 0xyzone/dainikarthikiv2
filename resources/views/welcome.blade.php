<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'DainikArthiki') }} - Smart Finance Management</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&family=inter:300,400,500,600,700" rel="stylesheet" />
    
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link href="https://cdn.tailwindcss.com" rel="stylesheet">
    @endif

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        :root {
            --primary-green: #10b981;
            --primary-dark: #059669;
            --primary-light: #d1fae5;
            --secondary-green: #14b8a6;
            --accent-cyan: #06b6d4;
            --accent-teal: #0d9488;
            --dark-bg: #0f172a;
            --light-bg: #f8fafc;
            --dark-card: #1e293b;
            --light-card: #ffffff;
        }

        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            position: relative;
        }

        body.dark-mode {
            background: linear-gradient(135deg, #0a0e27 0%, #0f172a 50%, #0f1930 100%);
            color: #f1f5f9;
        }

        body.light-mode {
            background: linear-gradient(135deg, #f0fdf4 0%, #f8fafc 50%, #ecf9ff 100%);
            color: #334155;
        }

        /* Animated Particles Background */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.6;
            pointer-events: none;
        }

        .floating-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.25;
            mix-blend-mode: screen;
        }

        .orb-1 {
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, #10b981, #14b8a6);
            top: -100px;
            left: -150px;
            animation: float 25s infinite ease-in-out, glow-pulse 8s infinite;
            filter: blur(80px) drop-shadow(0 0 80px rgba(16, 185, 129, 0.3));
        }

        .orb-2 {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, #14b8a6, #06b6d4);
            top: 30%;
            right: -120px;
            animation: float 30s infinite ease-in-out reverse, glow-pulse 7s infinite 1s;
            filter: blur(80px) drop-shadow(0 0 60px rgba(20, 184, 166, 0.3));
        }

        .orb-3 {
            width: 450px;
            height: 450px;
            background: linear-gradient(135deg, #06b6d4, #10b981);
            bottom: -150px;
            left: 15%;
            animation: float 35s infinite ease-in-out, glow-pulse 9s infinite 2s;
            filter: blur(80px) drop-shadow(0 0 70px rgba(6, 182, 212, 0.25));
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) translateX(0px) scale(1); }
            33% { transform: translateY(-40px) translateX(30px) scale(1.05); }
            66% { transform: translateY(40px) translateX(-30px) scale(0.95); }
        }

        @keyframes glow-pulse {
            0%, 100% { opacity: 0.25; }
            50% { opacity: 0.45; }
        }

        /* Floating Particles */
        .particle {
            position: fixed;
            pointer-events: none;
            border-radius: 50%;
            z-index: 1;
        }

        .particle-small {
            width: 4px;
            height: 4px;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.6), rgba(20, 184, 166, 0.4));
            animation: float-particle 15s infinite;
        }

        .particle-medium {
            width: 8px;
            height: 8px;
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.5), rgba(16, 185, 129, 0.3));
            animation: float-particle 20s infinite;
        }

        @keyframes float-particle {
            0% { transform: translateY(0) translateX(0) scale(1); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100vh) translateX(100px) scale(0); opacity: 0; }
        }
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            padding: 2rem;
            margin-top: 60px;
        }

        .hero-content {
            text-align: center;
            z-index: 10;
            animation: slideInUp 1s ease-out;
            position: relative;
        }

        .hero-content::before {
            content: '';
            position: absolute;
            top: -200px;
            left: 50%;
            transform: translateX(-50%);
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.15), transparent);
            border-radius: 50%;
            animation: pulse-glow 4s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes pulse-glow {
            0%, 100% { transform: translateX(-50%) scale(1); opacity: 0.5; }
            50% { transform: translateX(-50%) scale(1.2); opacity: 0.8; }
        }

        .hero-title {
            font-size: clamp(2.5rem, 8vw, 5rem);
            font-weight: 800;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green), var(--accent-cyan), var(--accent-teal));
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
            animation: gradient-shift 8s ease infinite, slide-down 1.2s ease-out;
            text-shadow: 0 0 30px rgba(16, 185, 129, 0.2);
        }

        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes slide-down {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-subtitle {
            font-size: clamp(1rem, 4vw, 1.5rem);
            opacity: 0.85;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            animation: slideInUp 1.2s ease-out 0.2s both;
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Button Enhancements */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1.1rem 2.2rem;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            border: none;
            border-radius: 0.85rem;
            font-size: 1.05rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
            text-decoration: none;
            box-shadow: 0 8px 32px rgba(16, 185, 129, 0.25), 
                        0 0 20px rgba(20, 184, 166, 0.15),
                        inset 0 1px 0 rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
            animation: slideInUp 1.4s ease-out 0.4s both;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.3), transparent);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-primary:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-primary:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 16px 48px rgba(16, 185, 129, 0.35),
                        0 0 30px rgba(20, 184, 166, 0.25),
                        inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }

        .btn-primary:active {
            transform: translateY(-2px) scale(1.02);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1.1rem 2.2rem;
            background: transparent;
            color: var(--primary-green);
            border: 2.5px solid var(--primary-green);
            border-radius: 0.85rem;
            font-size: 1.05rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s ease;
            text-decoration: none;
            position: relative;
            overflow: hidden;
            animation: slideInUp 1.4s ease-out 0.5s both;
        }

        .btn-secondary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--primary-green);
            transition: left 0.4s ease;
            z-index: -1;
        }

        .btn-secondary:hover::before {
            left: 0;
        }

        .btn-secondary:hover {
            color: white;
            box-shadow: 0 8px 32px rgba(16, 185, 129, 0.3);
            transform: translateY(-3px);
        }

        /* Scroll Animation */
        .scroll-reveal {
            opacity: 0;
            transform: translateY(60px);
            transition: all 1s cubic-bezier(0.23, 1, 0.320, 1);
        }

        .scroll-reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Features Section */
        .features-section {
            position: relative;
            z-index: 5;
            padding: 8rem 2rem;
            text-align: center;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            max-width: 1300px;
            margin: 0 auto;
            perspective: 1200px;
        }

        .interactive-card {
            position: relative;
            height: 320px;
            border-radius: 1.5rem;
            cursor: pointer;
            transform-style: preserve-3d;
            transition: transform 0.1s ease-out;
        }

        .card-glow {
            position: absolute;
            inset: -2px;
            border-radius: 1.5rem;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.3), rgba(20, 184, 166, 0.1));
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: 0;
        }

        .interactive-card:hover .card-glow {
            opacity: 1;
        }

        .card-border {
            position: absolute;
            inset: 0;
            border-radius: 1.5rem;
            border: 2px solid rgba(16, 185, 129, 0.2);
            transition: border-color 0.4s ease;
            z-index: 1;
            pointer-events: none;
        }

        .interactive-card:hover .card-border {
            border-color: var(--primary-green);
        }

        .card-content {
            position: absolute;
            inset: 0;
            padding: 2.5rem 2rem;
            border-radius: 1.5rem;
            backdrop-filter: blur(20px);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            z-index: 2;
            transition: all 0.4s ease;
        }

        body.light-mode .card-content {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.92), rgba(240, 253, 244, 0.85));
        }

        body.dark-mode .card-content {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.95), rgba(15, 23, 42, 0.8));
        }

        .card-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
            transition: transform 0.4s ease;
        }

        .interactive-card:hover .card-icon {
            transform: scale(1.2);
        }

        .card-title {
            font-size: 1.4rem;
            font-weight: 900;
            margin-bottom: 0.8rem;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            transition: all 0.4s ease;
        }

        .interactive-card:hover .card-title {
            background: linear-gradient(135deg, var(--secondary-green), var(--accent-cyan));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .card-text {
            font-size: 0.95rem;
            line-height: 1.6;
            opacity: 0.75;
            font-weight: 500;
            transition: opacity 0.4s ease;
        }

        .interactive-card:hover .card-text {
            opacity: 0.9;
        }

        .features-header {
            text-align: center;
            margin-bottom: 6rem;
        }

        .features-heading {
            font-size: clamp(2rem, 6vw, 3rem);
            font-weight: 900;
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green), var(--accent-cyan));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .features-subheading {
            font-size: 1.1rem;
            opacity: 0.7;
            max-width: 600px;
            margin: 0 auto;
            font-weight: 500;
        }

        .interactive-features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            max-width: 1300px;
            margin: 0 auto;
            perspective: 1200px;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-15px) scale(1.1); }
        }

        @keyframes bounce-fast {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-10px) scale(1.15); }
        }

        /* Theme Toggle */
        .theme-toggle {
            position: fixed;
            top: 2rem;
            right: 2rem;
            z-index: 1000;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.2);
            width: 55px;
            height: 55px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
            box-shadow: 0 8px 32px rgba(16, 185, 129, 0.3),
                        0 0 20px rgba(20, 184, 166, 0.15);
        }

        .theme-toggle:hover {
            transform: scale(1.15) rotate(15deg);
            box-shadow: 0 12px 48px rgba(16, 185, 129, 0.4),
                        0 0 30px rgba(20, 184, 166, 0.25);
        }

        .theme-toggle:active {
            transform: scale(1.1) rotate(15deg);
        }

        /* Navigation */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 999;
            padding: 1.5rem 2rem;
            backdrop-filter: blur(12px);
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(16, 185, 129, 0.15);
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.05);
        }

        body.light-mode nav {
            background: linear-gradient(135deg, rgba(248, 250, 252, 0.95), rgba(240, 253, 244, 0.9));
        }

        body.dark-mode nav {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.95), rgba(10, 14, 39, 0.9));
        }

        .nav-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-logo {
            font-size: 1.6rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green), var(--accent-cyan));
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradient-shift 6s ease infinite;
            letter-spacing: 0.5px;
        }

        /* Stats Section */
        .stats-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            padding: 4rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .stat-card {
            text-align: center;
            padding: 2.5rem;
            border-radius: 1.2rem;
            backdrop-filter: blur(12px);
            border: 1.5px solid rgba(16, 185, 129, 0.15);
            transition: all 0.5s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.05), transparent);
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        body.light-mode .stat-card {
            background: rgba(255, 255, 255, 0.7);
            box-shadow: 0 8px 32px rgba(16, 185, 129, 0.08);
        }

        body.dark-mode .stat-card {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.8), rgba(15, 23, 42, 0.6));
            box-shadow: 0 8px 32px rgba(16, 185, 129, 0.05);
        }

        .stat-card:hover {
            transform: translateY(-10px) scale(1.03);
            border-color: var(--primary-green);
            box-shadow: 0 16px 48px rgba(16, 185, 129, 0.2);
        }

        .stat-card:hover::after {
            opacity: 1;
        }

        .stat-number {
            font-size: 3.5rem;
            font-weight: 900;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green), var(--accent-cyan));
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
            animation: gradient-shift 8s ease infinite;
        }

        .stat-label {
            opacity: 0.8;
            font-weight: 600;
            font-size: 1.05rem;
            letter-spacing: 0.5px;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
                letter-spacing: -0.01em;
            }
            .theme-toggle {
                width: 50px;
                height: 50px;
                font-size: 1.3rem;
            }
            nav {
                padding: 1rem;
            }
        }

        @keyframes bob {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(12px); }
        }

        .scroll-indicator {
            animation: bob 2.5s cubic-bezier(0.68, -0.55, 0.265, 1.55) infinite;
        }

        /* CTA Section */
        .cta-section {
            position: relative;
            padding: 8rem 2rem;
            text-align: center;
            overflow: hidden;
            z-index: 5;
        }

        .cta-background {
            position: absolute;
            inset: 0;
            z-index: -1;
            overflow: hidden;
        }

        .cta-orb-1, .cta-orb-2 {
            position: absolute;
            border-radius: 50%;
            filter: blur(120px);
            mix-blend-mode: screen;
            animation: float 30s infinite ease-in-out;
        }

        .cta-orb-1 {
            width: 500px;
            height: 500px;
            background: rgba(16, 185, 129, 0.3);
            top: -150px;
            left: -150px;
        }

        .cta-orb-2 {
            width: 400px;
            height: 400px;
            background: rgba(20, 184, 166, 0.25);
            bottom: -100px;
            right: -100px;
            animation-delay: -15s;
        }

        .cta-content {
            position: relative;
            z-index: 10;
            max-width: 700px;
            margin: 0 auto;
        }

        .cta-title {
            font-size: clamp(2rem, 6vw, 3.5rem);
            font-weight: 900;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green), var(--accent-cyan), var(--accent-teal));
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradient-shift 8s ease infinite, slideInUp 1.2s ease-out;
            letter-spacing: -0.02em;
        }

        .cta-subtitle {
            font-size: 1.15rem;
            opacity: 0.85;
            margin-bottom: 2.5rem;
            line-height: 1.8;
            font-weight: 500;
            letter-spacing: 0.3px;
            animation: slideInUp 1.4s ease-out 0.2s both;
        }

        .cta-buttons {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }

        .cta-buttons .btn-primary,
        .cta-buttons .btn-secondary {
            animation: slideInUp 1.6s ease-out 0.4s both;
        }

        .cta-footer-text {
            opacity: 0.6;
            font-size: 0.9rem;
            letter-spacing: 1px;
            animation: slideInUp 1.8s ease-out 0.6s both;
        }

        /* Footer */
        .footer {
            position: relative;
            padding: 4rem 2rem 2rem;
            background: linear-gradient(180deg, transparent, rgba(16, 185, 129, 0.03));
            border-top: 1px solid rgba(16, 185, 129, 0.1);
            margin-top: 6rem;
            z-index: 5;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            max-width: 1200px;
            margin: 0 auto 2rem;
        }

        .footer-section {
            text-align: left;
        }

        .footer-brand {
            font-size: 1.4rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 0.5px;
        }

        .footer-section a:hover {
            color: var(--primary-green) !important;
            border-bottom: 1px solid var(--primary-green) !important;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid rgba(16, 185, 129, 0.05);
            opacity: 0.6;
            font-size: 0.95rem;
        }

        @media (max-width: 1024px) {
            .cta-buttons {
                flex-direction: column;
            }

            .cta-buttons .btn-primary,
            .cta-buttons .btn-secondary {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .cta-section {
                padding: 6rem 1.5rem;
            }

            .cta-title {
                font-size: 1.8rem;
            }

            .footer-content {
                gap: 2rem;
                grid-template-columns: 1fr;
            }

            .footer-section {
                text-align: center;
            }
        }
    </style>
</head>
<body class="light-mode">
    <div class="animated-bg">
        <div class="floating-orb orb-1"></div>
        <div class="floating-orb orb-2"></div>
        <div class="floating-orb orb-3"></div>
    </div>

    <nav>
        <div class="nav-content">
            <div class="nav-logo">💰 DainikArthiki</div>
            <button class="theme-toggle" id="themeToggle" title="Toggle Dark/Light Mode">
                <span id="themeIcon">🌙</span>
            </button>
        </div>
    </nav>

    <section class="hero-section">
        <div class="hero-content scroll-reveal">
            <h1 class="hero-title">Master Your Finances</h1>
            <p class="hero-subtitle">Track income and expenses with stunning visualizations. Take control of your financial future today.</p>
            
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; margin-top: 3rem;">
                <a href="{{ url('/app') }}" class="btn-primary">
                    <span>Launch App</span>
                    <span style="font-size: 1.2rem;">→</span>
                </a>
                <button class="btn-secondary scroll-to-features">
                    <span>Learn More</span>
                </button>
            </div>

            <div style="margin-top: 4rem; animation: bob 2s infinite;">
                <div style="font-size: 2rem;">↓</div>
                <p style="font-size: 0.9rem; opacity: 0.6;">Scroll to explore</p>
            </div>
        </div>
    </section>

    <section class="features-section" id="features">
        <div class="features-header">
            <h2 class="features-heading">What Makes Us Different</h2>
            <p class="features-subheading">Explore our core features designed to give you complete control over your finances</p>
        </div>

        <div class="interactive-features-grid">
            <div class="interactive-card" data-feature="0">
                <div class="card-glow"></div>
                <div class="card-border"></div>
                <div class="card-content">
                    <div class="card-icon">📊</div>
                    <h3 class="card-title">Real-time Analytics</h3>
                    <p class="card-text">Visualize your finances with interactive charts and instant insights into spending patterns and income trends.</p>
                </div>
            </div>

            <div class="interactive-card" data-feature="1">
                <div class="card-glow"></div>
                <div class="card-border"></div>
                <div class="card-content">
                    <div class="card-icon">🎯</div>
                    <h3 class="card-title">Smart Budgets</h3>
                    <p class="card-text">Set budgets that adapt to your spending habits and receive intelligent alerts before you exceed your limits.</p>
                </div>
            </div>

            <div class="interactive-card" data-feature="2">
                <div class="card-glow"></div>
                <div class="card-border"></div>
                <div class="card-content">
                    <div class="card-icon">🔐</div>
                    <h3 class="card-title">Enterprise Security</h3>
                    <p class="card-text">Banking-grade encryption protects your data with advanced security protocols and zero compromise on privacy.</p>
                </div>
            </div>

            <div class="interactive-card" data-feature="3">
                <div class="card-glow"></div>
                <div class="card-border"></div>
                <div class="card-content">
                    <div class="card-icon">📱</div>
                    <h3 class="card-title">Omni-Device Sync</h3>
                    <p class="card-text">Seamless synchronization across all your devices keeps your financial data up-to-date in real-time.</p>
                </div>
            </div>

            <div class="interactive-card" data-feature="4">
                <div class="card-glow"></div>
                <div class="card-border"></div>
                <div class="card-content">
                    <div class="card-icon">💳</div>
                    <h3 class="card-title">Custom Categories</h3>
                    <p class="card-text">Create unlimited categories and tags to match your unique financial organization style perfectly.</p>
                </div>
            </div>

            <div class="interactive-card" data-feature="5">
                <div class="card-glow"></div>
                <div class="card-border"></div>
                <div class="card-content">
                    <div class="card-icon">📈</div>
                    <h3 class="card-title">AI Forecasting</h3>
                    <p class="card-text">Predictive analytics powered by AI help you plan ahead and make smarter financial decisions with confidence.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="stats-section">
        <div class="stat-card scroll-reveal">
            <div class="stat-number">100%</div>
            <div class="stat-label">Data Accuracy</div>
        </div>
        <div class="stat-card scroll-reveal" style="transition-delay: 0.1s;">
            <div class="stat-number">24/7</div>
            <div class="stat-label">Support Available</div>
        </div>
        <div class="stat-card scroll-reveal" style="transition-delay: 0.2s;">
            <div class="stat-number">∞</div>
            <div class="stat-label">Transactions</div>
        </div>
        <div class="stat-card scroll-reveal" style="transition-delay: 0.3s;">
            <div class="stat-number">🛡️</div>
            <div class="stat-label">Enterprise Security</div>
        </div>
    </section>

    <section class="cta-section">
        <div class="cta-background">
            <div class="cta-orb-1"></div>
            <div class="cta-orb-2"></div>
        </div>
        
        <div class="cta-content scroll-reveal" style="max-width: 700px; margin: 0 auto;">
            <h2 class="cta-title">Ready to Transform Your Finances?</h2>
            <p class="cta-subtitle">Join thousands of users who are already managing their money smarter with intelligent insights and complete control.</p>
            
            <div class="cta-buttons">
                <a href="{{ url('/app') }}" class="btn-primary">
                    <span>Get Started Now</span>
                    <span style="font-size: 1.2rem;">→</span>
                </a>
                <a href="{{ url('/app') }}" class="btn-secondary">
                    <span>Launch Dashboard</span>
                    <span style="font-size: 1.2rem;">→</span>
                </a>
            </div>
            
            <p class="cta-footer-text">No credit card required • Start for free • 30 days premium trial</p>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h4 class="footer-brand">DainikArthiki</h4>
                <p style="opacity: 0.7; margin-top: 0.5rem; font-size: 0.95rem;">Smart Finance Management System</p>
            </div>
            <div class="footer-section">
                <p style="margin-bottom: 1rem; font-weight: 600;">Quick Links</p>
                <p style="opacity: 0.7; margin: 0.5rem 0;"><a href="#" style="color: inherit; text-decoration: none; transition: color 0.3s; border-bottom: 1px solid transparent; padding-bottom: 2px;">Features</a></p>
                <p style="opacity: 0.7; margin: 0.5rem 0;"><a href="#" style="color: inherit; text-decoration: none; transition: color 0.3s; border-bottom: 1px solid transparent; padding-bottom: 2px;">Security</a></p>
                <p style="opacity: 0.7; margin: 0.5rem 0;"><a href="#" style="color: inherit; text-decoration: none; transition: color 0.3s; border-bottom: 1px solid transparent; padding-bottom: 2px;">Support</a></p>
            </div>
            <div class="footer-section">
                <p style="margin-bottom: 1rem; font-weight: 600;">Legal</p>
                <p style="opacity: 0.7; margin: 0.5rem 0;"><a href="#" style="color: inherit; text-decoration: none; transition: color 0.3s; border-bottom: 1px solid transparent; padding-bottom: 2px;">Privacy</a></p>
                <p style="opacity: 0.7; margin: 0.5rem 0;"><a href="#" style="color: inherit; text-decoration: none; transition: color 0.3s; border-bottom: 1px solid transparent; padding-bottom: 2px;">Terms</a></p>
                <p style="opacity: 0.7; margin: 0.5rem 0;"><a href="#" style="color: inherit; text-decoration: none; transition: color 0.3s; border-bottom: 1px solid transparent; padding-bottom: 2px;">Contact</a></p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2026 DainikArthiki. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Theme Toggle
        const themeToggle = document.getElementById('themeToggle');
        const body = document.body;
        const themeIcon = document.getElementById('themeIcon');

        const savedTheme = localStorage.getItem('theme') || 'light';
        body.className = savedTheme + '-mode';
        themeIcon.textContent = savedTheme === 'dark' ? '☀️' : '🌙';

        themeToggle.addEventListener('click', () => {
            const currentTheme = body.className === 'light-mode' ? 'dark' : 'light';
            body.className = currentTheme + '-mode';
            localStorage.setItem('theme', currentTheme);
            themeIcon.textContent = currentTheme === 'dark' ? '☀️' : '🌙';
        });

        // Scroll Reveal Animation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.scroll-reveal').forEach(el => {
            observer.observe(el);
        });

        // Smooth scroll to features
        const scrollButton = document.querySelector('.scroll-to-features');
        if (scrollButton) {
            scrollButton.addEventListener('click', () => {
                document.getElementById('features').scrollIntoView({ behavior: 'smooth' });
            });
        }

        // Parallax Effect on Scroll
        window.addEventListener('scroll', () => {
            const scrollY = window.scrollY;
            document.querySelectorAll('.floating-orb').forEach((orb, index) => {
                const speed = (index + 1) * 0.5;
                orb.style.transform = `translateY(${scrollY * speed}px)`;
            });
        });

        // Button Click Particle Effect
        function createParticles(event) {
            const button = event.currentTarget;
            const rect = button.getBoundingClientRect();
            const x = rect.left + rect.width / 2;
            const y = rect.top + rect.height / 2;

            for (let i = 0; i < 15; i++) {
                const particle = document.createElement('div');
                particle.style.position = 'fixed';
                particle.style.left = x + 'px';
                particle.style.top = y + 'px';
                particle.style.width = '8px';
                particle.style.height = '8px';
                particle.style.backgroundColor = getComputedStyle(button).backgroundColor;
                particle.style.borderRadius = '50%';
                particle.style.pointerEvents = 'none';
                particle.style.zIndex = '9999';
                particle.style.boxShadow = '0 0 20px rgba(16, 185, 129, 0.5)';
                
                const angle = (Math.PI * 2 * i) / 15;
                const velocity = 3 + Math.random() * 4;
                const vx = Math.cos(angle) * velocity;
                const vy = Math.sin(angle) * velocity;
                
                document.body.appendChild(particle);

                let life = 1;
                const startTime = performance.now();
                
                function animateParticle(currentTime) {
                    const elapsed = currentTime - startTime;
                    life = Math.max(0, 1 - elapsed / 800);
                    
                    particle.style.left = (x + vx * (elapsed / 16)) + 'px';
                    particle.style.top = (y + vy * (elapsed / 16) + (elapsed / 16) * 0.5) + 'px';
                    particle.style.opacity = life;
                    particle.style.transform = `scale(${life})`;

                    if (life > 0) {
                        requestAnimationFrame(animateParticle);
                    } else {
                        particle.remove();
                    }
                }
                
                requestAnimationFrame(animateParticle);
            }
        }

        // Add particle effect to all buttons
        document.querySelectorAll('.btn-primary, .btn-secondary').forEach(button => {
            button.addEventListener('click', createParticles);
            
            // Glow effect on hover
            button.addEventListener('mouseenter', function() {
                this.style.boxShadow = '0 20px 60px rgba(16, 185, 129, 0.4)';
            });
            
            button.addEventListener('mouseleave', function() {
                this.style.boxShadow = '';
            });
        });

        // Dynamic Background Glow Following Cursor
        document.addEventListener('mousemove', (e) => {
            const floatingOrbs = document.querySelectorAll('.floating-orb');
            const x = e.clientX / window.innerWidth;
            const y = e.clientY / window.innerHeight;
            
            floatingOrbs.forEach((orb, index) => {
                const speed = (index + 1) * 0.02;
                const offsetX = x * 50 * speed;
                const offsetY = y * 50 * speed;
                orb.style.setProperty('--offset-x', offsetX + 'px');
                orb.style.setProperty('--offset-y', offsetY + 'px');
            });
        });

        // Add CSS variable support for cursor tracking
        document.addEventListener('DOMContentLoaded', () => {
            const style = document.createElement('style');
            style.textContent = `
                .floating-orb {
                    --offset-x: 0px;
                    --offset-y: 0px;
                }
            `;
            document.head.appendChild(style);
        });

        // Typing effect on page load
        function typeWriter(element, text, speed = 50) {
            element.textContent = '';
            let i = 0;
            
            function type() {
                if (i < text.length) {
                    element.textContent += text.charAt(i);
                    i++;
                    setTimeout(type, speed);
                }
            }
            
            type();
        }

        // Enhanced scroll animations
        const sections = document.querySelectorAll('section');
        window.addEventListener('scroll', () => {
            sections.forEach(section => {
                const sectionTop = section.getBoundingClientRect().top;
                const isVisible = sectionTop < window.innerHeight * 0.8;
                
                if (isVisible) {
                    section.style.opacity = Math.min(1, 1 - (sectionTop / (window.innerHeight * 2)));
                }
            });
        });

        // Initialize animations on page load
        window.addEventListener('load', () => {
            document.body.style.opacity = '1';
        });

        // Mouse-following effects for interactive cards
        const interactiveCards = document.querySelectorAll('.interactive-card');
        
        interactiveCards.forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const centerX = rect.left + rect.width / 2;
                const centerY = rect.top + rect.height / 2;
                
                const mouseX = e.clientX - centerX;
                const mouseY = e.clientY - centerY;
                
                const rotateX = (mouseY / rect.height) * 15;
                const rotateY = (mouseX / rect.width) * 15;
                
                // Apply 3D tilt effect
                card.style.transform = `perspective(1000px) rotateX(${-rotateX}deg) rotateY(${rotateY}deg) scale(1.02)`;
                
                // Update shadow position to follow cursor
                const shadowX = (mouseX / rect.width) * 20;
                const shadowY = (mouseY / rect.height) * 20;
                card.style.boxShadow = `${shadowX}px ${shadowY}px 40px rgba(16, 185, 129, 0.25)`;
            });
            
            card.addEventListener('mouseleave', () => {
                // Reset transform and shadow on mouse leave
                card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale(1)';
                card.style.boxShadow = '0 10px 30px rgba(16, 185, 129, 0.1)';
            });
            
            card.addEventListener('mouseenter', () => {
                card.style.boxShadow = '0 20px 60px rgba(16, 185, 129, 0.2)';
            });
        });

        // Add smooth scroll reveal for feature cards
        const featureCardObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        interactiveCards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            featureCardObserver.observe(card);
        });
    </script>
</body>
</html>
