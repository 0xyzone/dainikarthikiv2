---
version: "alpha"
name: "Portrait Stories"
description: "Portrait Stories Feature Section is designed for highlighting product capabilities and value points. Key features include reusable structure, responsive behavior, and production-ready presentation. It is suitable for component libraries and responsive product interfaces."
colors:
  primary: "#0B4D1E"
  secondary: "#113F21"
  tertiary: "#0C4E1F"
  neutral: "#FFFFFF"
  background: "#FFFFFF"
  surface: "#0B4D1E"
  text-primary: "#252523"
  text-secondary: "#2B2B2A"
  border: "#0C4E1F"
  accent: "#0B4D1E"
typography:
  display-lg:
    fontFamily: "Playfair Display"
    fontSize: "72px"
    fontWeight: 600
    lineHeight: "72px"
    letterSpacing: "-0.025em"
  body-md:
    fontFamily: "Poppins"
    fontSize: "14px"
    fontWeight: 300
    lineHeight: "24px"
  label-md:
    fontFamily: "Poppins"
    fontSize: "14px"
    fontWeight: 500
    lineHeight: "20px"
rounded:
  md: "11.2px"
spacing:
  base: "8px"
  sm: "1px"
  md: "8px"
  lg: "12px"
  xl: "24px"
  gap: "8px"
  card-padding: "10px"
  section-padding: "24px"
components:
  button-primary:
    backgroundColor: "#1E1E1E"
    textColor: "{colors.neutral}"
    typography: "{typography.label-md}"
    rounded: "{rounded.md}"
    padding: "0px"
  card:
    rounded: "27px"
    padding: "24px"
---

## Overview

- **Composition cues:**
  - Layout: Grid
  - Content Width: Bounded
  - Framing: Glassy
  - Grid: Strong

## Colors

The color system uses dark mode with #0B4D1E as the main accent and #FFFFFF as the neutral foundation.

- **Primary (#0B4D1E):** Main accent and emphasis color.
- **Secondary (#113F21):** Supporting accent for secondary emphasis.
- **Tertiary (#0C4E1F):** Reserved accent for supporting contrast moments.
- **Neutral (#FFFFFF):** Neutral foundation for backgrounds, surfaces, and supporting chrome.

- **Usage:** Background: #FFFFFF; Surface: #0B4D1E; Text Primary: #252523; Text Secondary: #2B2B2A; Border: #0C4E1F; Accent: #0B4D1E

- **Gradients:** bg-gradient-to-br from-white/85 to-[#edf0ea]/75 via-white/70, bg-gradient-to-br from-white to-[#f7f6f1] via-white, bg-gradient-to-br from-[#4b4b49] to-[#0d0d0d] via-[#1d1d1d], bg-gradient-to-br from-[#f7f3e8] to-[#e6eadf]

## Typography

Typography pairs Playfair Display for display hierarchy with Poppins for supporting content and interface copy.

- **Display (`display-lg`):** Playfair Display, 72px, weight 600, line-height 72px, letter-spacing -0.025em.
- **Body (`body-md`):** Poppins, 14px, weight 300, line-height 24px.
- **Labels (`label-md`):** Poppins, 14px, weight 500, line-height 20px.

## Layout

Layout follows a grid composition with reusable spacing tokens. Preserve the grid, bounded structural frame before changing ornament or component styling. Use 8px as the base rhythm and let larger gaps step up from that cadence instead of introducing unrelated spacing values.

Treat the page as a grid / bounded composition, and keep that framing stable when adding or remixing sections.

- **Layout type:** Grid
- **Content width:** Bounded
- **Base unit:** 8px
- **Scale:** 1px, 8px, 12px, 24px, 28px, 32px, 36px, 48px
- **Section padding:** 24px, 48px, 56px, 72px
- **Card padding:** 10px, 24px
- **Gaps:** 8px, 16px, 20px, 32px

## Elevation & Depth

Depth is communicated through glass, border contrast, and reusable shadow or blur treatments. Keep those recipes consistent across hero panels, cards, and controls so the page reads as one material system.

Surfaces should read as glass first, with borders, shadows, and blur only reinforcing that material choice.

- **Surface style:** Glass
- **Borders:** 2px #0C4E1F; 2px #1D1D1D; 1px #FFFFFF
- **Shadows:** rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(35, 42, 35, 0.08) 0px 16px 48px 0px; rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(34, 42, 34, 0.12) 0px 24px 80px 0px; rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0.12) 0px 16px 32px 0px
- **Blur:** 8px, 12px

### Techniques
- **Gradient border shell:** Use a thin gradient border shell around the main card. Wrap the surface in an outer shell with 1px padding and a 32px radius. Drive the shell with linear-gradient(to right bottom, rgb(255, 255, 255), rgb(255, 255, 255), rgb(247, 246, 241)) so the edge reads like premium depth instead of a flat stroke. Keep the actual stroke understated so the gradient shell remains the hero edge treatment. Inset the real content surface inside the wrapper with a slightly smaller radius so the gradient only appears as a hairline frame.

## Shapes

Shapes rely on a tight radius system anchored by 12px and scaled across cards, buttons, and supporting surfaces. Icon geometry should stay compatible with that soft-to-controlled silhouette.

Use the radius family intentionally: larger surfaces can open up, but controls and badges should stay within the same rounded DNA instead of inventing sharper or pill-only exceptions.

- **Corner radii:** 12px, 24px, 27px, 28px, 32px, 9999px
- **Icon treatment:** Linear
- **Icon sets:** Solar

## Components

Anchor interactions to the detected button styles. Reuse the existing card surface recipe for content blocks.

### Buttons
- **Primary:** background #1E1E1E, text #FFFFFF, radius 11.2px, padding 0px, border 0px solid rgb(229, 231, 235).

### Cards and Surfaces
- **Card surface:** background rgba(255, 255, 255, 0.7), border 0px solid rgb(229, 231, 235), radius 27px, padding 24px, shadow none, blur 8px.

### Iconography
- **Treatment:** Linear.
- **Sets:** Solar.

## Do's and Don'ts

Use these constraints to keep future generations aligned with the current system instead of drifting into adjacent styles.

### Do
- Do use the primary palette as the main accent for emphasis and action states.
- Do keep spacing aligned to the detected 8px rhythm.
- Do reuse the Glass surface treatment consistently across cards and controls.
- Do keep corner radii within the detected 12px, 24px, 27px, 28px, 32px, 9999px family.

### Don't
- Don't introduce extra accent colors outside the core palette roles unless the page needs a new semantic state.
- Don't mix unrelated shadow or blur recipes that break the current depth system.
- Don't exceed the detected minimal motion intensity without a deliberate reason.

## Motion

Motion stays restrained and interface-led across text, layout, and scroll transitions. Timing clusters around 150ms. Easing favors ease and cubic-bezier(0.4. Hover behavior focuses on color changes. Scroll choreography uses GSAP ScrollTrigger for section reveals and pacing.

**Motion Level:** minimal

**Durations:** 150ms

**Easings:** ease, cubic-bezier(0.4, 0, 0.2, 1)

**Hover Patterns:** color

**Scroll Patterns:** gsap-scrolltrigger

## WebGL

Reconstruct the graphics as a centered hero field using alpha, antialias, dpr clamp, custom shaders. The effect should read as technical, meditative, and atmospheric: dot-matrix particle field with soft amber and sparse spacing. Build it from dot particles + soft depth fade so the effect reads clearly. Animate it as slow breathing pulse. Interaction can react to the pointer, but only as a subtle drift. Preserve reduced motion + dom fallback.

**Id:** webgl

**Label:** WebGL

**Stack:** WebGL

**Insights:**
  - **Scene:**
    - **Value:** Centered hero field
  - **Effect:**
    - **Value:** Dot-matrix particle field
  - **Primitives:**
    - **Value:** Dot particles + soft depth fade
  - **Motion:**
    - **Value:** Slow breathing pulse
  - **Interaction:**
    - **Value:** Pointer-reactive drift
  - **Render:**
    - **Value:** alpha, antialias, DPR clamp, custom shaders

**Techniques:** Dot matrix, Breathing pulse, Pointer parallax, Shader gradients, DOM fallback

**Code Evidence:**
  - **HTML reference:**
    - **Language:** html
    - **Snippet:**
      ```html
      <div class="relative w-full overflow-hidden rounded-[2rem] bg-gradient-to-br from-white via-white to-[#f7f6f1] p-[1px] shadow-[0_1.5rem_5rem_rgba(34,42,34,0.12)]">
        <div class="relative overflow-hidden rounded-[calc(2rem-1px)] bg-[#fffefa]">
          <canvas id="auraCanvas" aria-hidden="true" class="pointer-events-none absolute inset-0 z-0 h-full w-full opacity-70"></canvas>
          <div id="webglFallback" aria-hidden="true…
      ```
  - **JS reference:**
    - **Language:** js
    - **Snippet:**
      ```
      }
        `;

        const fragmentSource = `
          precision mediump float;
          uniform vec2 resolution;
          uniform float time;
      …
      ```
  - **Renderer setup:**
    - **Language:** js
    - **Snippet:**
      ```
      `;

        const fragmentSource = `
          precision mediump float;
          uniform vec2 resolution;
          uniform float time;
      …
      ```
