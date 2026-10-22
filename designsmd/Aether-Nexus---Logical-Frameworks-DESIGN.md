---
version: "alpha"
name: "Aether Nexus - Logical Frameworks"
description: "Aether Nexus Dashboard Section is designed for demonstrating application workflows and interface hierarchy. Key features include clear information density, modular panels, and interface rhythm. It is suitable for product showcases, admin panels, and analytics experiences."
colors:
  primary: "#CBD5E1"
  secondary: "#8B5CF6"
  tertiary: "#F43F5E"
  neutral: "#000000"
  background: "#000000"
  surface: "#CBD5E1"
  text-primary: "#94A3B8"
  text-secondary: "#0A0A0A"
  border: "#000000"
  accent: "#CBD5E1"
typography:
  display-lg:
    fontFamily: "Inter"
    fontSize: "72px"
    fontWeight: 400
    lineHeight: "72px"
    letterSpacing: "-0.05em"
    textTransform: "uppercase"
  body-md:
    fontFamily: "Space Mono"
    fontSize: "14px"
    fontWeight: 400
    lineHeight: "20px"
    letterSpacing: "0.1em"
    textTransform: "uppercase"
  label-md:
    fontFamily: "Space Mono"
    fontSize: "12px"
    fontWeight: 400
    lineHeight: "16px"
    letterSpacing: "2.4px"
    textTransform: "uppercase"
rounded:
  md: "16px"
spacing:
  base: "4px"
  sm: "4px"
  md: "8px"
  lg: "16px"
  xl: "20px"
  gap: "8px"
  card-padding: "8px"
  section-padding: "32px"
components:
  button-primary:
    backgroundColor: "#1A1A1A"
    textColor: "{colors.primary}"
    typography: "{typography.label-md}"
    rounded: "{rounded.md}"
    padding: "20px"
---

## Overview

- **Composition cues:**
  - Layout: Grid
  - Content Width: Full Bleed
  - Framing: Open
  - Grid: Strong

## Colors

The color system uses dark mode with #CBD5E1 as the main accent and #000000 as the neutral foundation.

- **Primary (#CBD5E1):** Main accent and emphasis color.
- **Secondary (#8B5CF6):** Supporting accent for secondary emphasis.
- **Tertiary (#F43F5E):** Reserved accent for supporting contrast moments.
- **Neutral (#000000):** Neutral foundation for backgrounds, surfaces, and supporting chrome.

- **Usage:** Background: #000000; Surface: #CBD5E1; Text Primary: #94A3B8; Text Secondary: #0A0A0A; Border: #000000; Accent: #CBD5E1

- **Gradients:** bg-gradient-to-r from-transparent to-white/10

## Typography

Typography pairs Inter for display hierarchy with Space Mono for supporting content and interface copy.

- **Display (`display-lg`):** Inter, 72px, weight 400, line-height 72px, letter-spacing -0.05em, uppercase.
- **Body (`body-md`):** Space Mono, 14px, weight 400, line-height 20px, letter-spacing 0.1em, uppercase.
- **Labels (`label-md`):** Space Mono, 12px, weight 400, line-height 16px, letter-spacing 2.4px, uppercase.

## Layout

Layout follows a grid composition with reusable spacing tokens. Preserve the grid, full bleed structural frame before changing ornament or component styling. Use 4px as the base rhythm and let larger gaps step up from that cadence instead of introducing unrelated spacing values.

Treat the page as a grid / full bleed composition, and keep that framing stable when adding or remixing sections.

- **Layout type:** Grid
- **Content width:** Full Bleed
- **Base unit:** 4px
- **Scale:** 4px, 8px, 16px, 20px, 24px, 32px, 76px, 145.75px
- **Section padding:** 32px
- **Card padding:** 8px, 32px
- **Gaps:** 8px, 10px, 12px, 24px

## Elevation & Depth

Depth is communicated through elevated, border contrast, and reusable shadow or blur treatments. Keep those recipes consistent across hero panels, cards, and controls so the page reads as one material system.

Surfaces should read as elevated first, with borders, shadows, and blur only reinforcing that material choice.

- **Surface style:** Elevated
- **Borders:** 1px #FFFFFF; 1px #000000
- **Shadows:** rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0.4) 0px 1px 2px 0px inset, rgba(255, 255, 255, 0.8) 0px 1px 0px 0px; rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0.9) 0px 1px 3px 0px inset, rgba(255, 255, 255, 0.15) 0px 1px 0px 0px; rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0.9) 0px 1px 2px 0px inset, rgba(255, 255, 255, 0.15) 0px 1px 0px 0px

### Techniques
- **Gradient border shell:** Use a thin gradient border shell around the main card. Wrap the surface in an outer shell with 0px padding and a 0px radius. Drive the shell with linear-gradient(to right, rgba(255, 255, 255, 0.05) 1px, rgba(0, 0, 0, 0) 1px), linear-gradient(rgba(255, 255, 255, 0.05) 1px, rgba(0, 0, 0, 0) 1px) so the edge reads like premium depth instead of a flat stroke. Keep the actual stroke understated so the gradient shell remains the hero edge treatment. Inset the real content surface inside the wrapper with a slightly smaller radius so the gradient only appears as a hairline frame.

## Shapes

Shapes rely on a tight radius system anchored by 8px and scaled across cards, buttons, and supporting surfaces. Icon geometry should stay compatible with that soft-to-controlled silhouette.

Use the radius family intentionally: larger surfaces can open up, but controls and badges should stay within the same rounded DNA instead of inventing sharper or pill-only exceptions.

- **Corner radii:** 8px, 16px, 24px, 9999px
- **Icon treatment:** Linear
- **Icon sets:** Solar

## Components

Anchor interactions to the detected button styles.

### Buttons
- **Primary:** background #1A1A1A, text #CBD5E1, radius 16px, padding 20px, border 0px solid rgb(229, 231, 235).

### Iconography
- **Treatment:** Linear.
- **Sets:** Solar.

## Do's and Don'ts

Use these constraints to keep future generations aligned with the current system instead of drifting into adjacent styles.

### Do
- Do use the primary palette as the main accent for emphasis and action states.
- Do keep spacing aligned to the detected 4px rhythm.
- Do reuse the Elevated surface treatment consistently across cards and controls.
- Do keep corner radii within the detected 8px, 16px, 24px, 9999px family.

### Don't
- Don't introduce extra accent colors outside the core palette roles unless the page needs a new semantic state.
- Don't mix unrelated shadow or blur recipes that break the current depth system.
- Don't exceed the detected expressive motion intensity without a deliberate reason.

## Motion

Motion feels expressive but remains focused on interface, text, and layout transitions. Timing clusters around 150ms and 2000ms. Easing favors ease and cubic-bezier(0.4. Hover behavior focuses on color and text changes. Scroll choreography uses Parallax for section reveals and pacing.

**Motion Level:** expressive

**Durations:** 150ms, 2000ms, 500ms, 300ms

**Easings:** ease, cubic-bezier(0.4, 0, 1), 0.2, 0.6

**Hover Patterns:** color, text, shadow

**Scroll Patterns:** parallax
