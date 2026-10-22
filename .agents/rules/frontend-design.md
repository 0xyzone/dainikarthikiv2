# Frontend & Homepage Design Architecture

## Activated Design Skills
All agents working on landing pages, homepages, or mobile app UI in this repository must actively implement principles from:
1. **UI UX PRO MAX** (`ui-ux-pro-max`): Accessible contrast, responsive typography, 48px touch targets, fluid layouts, cohesive tokens.
2. **Genjutsu / Cast & Paint** (`cast`, `paint`, `bunshin`): Anti-generic aesthetics, high polish, rich dark-mode palettes, organic glassmorphism.
3. **Motion Design** (`motion-design`): Intentional timing curves (e.g. cubic-bezier(0.16, 1, 0.3, 1)), micro-interactions, responsive states.
4. **Three.js 3D** (`threejs-fundamentals`, `threejs-materials`): Interactive 3D objects (coins, holograms, particles) with WebGL fallback and 60fps performance budgets.
5. **GSAP Animation** (`gsap-core`, `gsap-timeline`): Springy card gestures, layout transitions, tab changes, number tweens.
6. **Design DNA** (`design-dna`): Strict token hierarchy:
   - Primary: Emerald (`#10b981`)
   - Accent: Teal & Cyan (`#14b8a6`, `#06b6d4`)
   - Surface: Deep Obsidian Slate (`#090d16`, `#0e1424`, `#161f36`)
   - Glass: `rgba(255, 255, 255, 0.05)` with `backdrop-blur-xl`

## Mobile-First SPA Experience Rules
- **Viewport optimization:** Always support mobile screen views with `viewport-fit=cover`, safe-area insets (`env(safe-area-inset-bottom)`), and prevent awkward layout overflow.
- **Bottom SPA Navigation:** Landing and app views must provide a native-app-style bottom navigation bar with instantaneous SPA tab switching (no full page reloads).
- **Cards & Decks:** Present core modules (Incomes, Expenses, Credits, Loans) as tactile card decks with interactive toggle and expansion states.
- **PWA Installation:** Implement automatic detection of standalone mode, `beforeinstallprompt` event listener, visible install prompts, and guided iOS Safari install instructions.
