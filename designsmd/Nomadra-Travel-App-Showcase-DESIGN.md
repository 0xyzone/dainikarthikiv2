---
version: "alpha"
name: "Nomadra — Travel App Showcase"
description: "Nomadra Travel Onboarding Section is designed for building reusable UI components in modern web projects. Key features include reusable structure, responsive behavior, and production-ready presentation. It is suitable for component libraries and responsive product interfaces."
colors:
  primary: "#E35C3A"
  secondary: "#202A5B"
  tertiary: "#94A3B8"
  neutral: "#FFFFFF"
  background: "#FFFFFF"
  surface: "#E35C3A"
  text-primary: "#202A5B"
  text-secondary: "#94A3B8"
  border: "#FFFFFF"
  accent: "#E35C3A"
typography:
  display-lg:
    fontFamily: "Poppins"
    fontSize: "48px"
    fontWeight: 600
    lineHeight: "48px"
    letterSpacing: "-0.025em"
  body-md:
    fontFamily: "Poppins"
    fontSize: "12px"
    fontWeight: 300
    lineHeight: "16px"
  label-md:
    fontFamily: "Poppins"
    fontSize: "14px"
    fontWeight: 500
    lineHeight: "20px"
rounded:
  md: "16px"
spacing:
  base: "4px"
  sm: "1px"
  md: "4px"
  lg: "8px"
  xl: "12px"
  gap: "4px"
  card-padding: "8px"
  section-padding: "56px"
components:
  button-primary:
    textColor: "{colors.neutral}"
    typography: "{typography.label-md}"
    rounded: "{rounded.md}"
    padding: "16px"
  button-link:
    textColor: "#64748B"
    typography: "{typography.body-md}"
    rounded: "0px"
    padding: "0px"
  card:
    backgroundColor: "{colors.neutral}"
    rounded: "{rounded.md}"
    padding: "8px"
---

## Overview

- **Composition cues:**
  - Layout: Grid
  - Content Width: Bounded
  - Framing: Glassy
  - Grid: Strong

## Colors

The color system uses dark mode with #E35C3A as the main accent and #FFFFFF as the neutral foundation.

- **Primary (#E35C3A):** Main accent and emphasis color.
- **Secondary (#202A5B):** Supporting accent for secondary emphasis.
- **Tertiary (#94A3B8):** Reserved accent for supporting contrast moments.
- **Neutral (#FFFFFF):** Neutral foundation for backgrounds, surfaces, and supporting chrome.

- **Usage:** Background: #FFFFFF; Surface: #E35C3A; Text Primary: #202A5B; Text Secondary: #94A3B8; Border: #FFFFFF; Accent: #E35C3A

## Typography

Typography relies on Poppins across display, body, and utility text.

- **Display (`display-lg`):** Poppins, 48px, weight 600, line-height 48px, letter-spacing -0.025em.
- **Body (`body-md`):** Poppins, 12px, weight 300, line-height 16px.
- **Labels (`label-md`):** Poppins, 14px, weight 500, line-height 20px.

## Layout

Layout follows a grid composition with reusable spacing tokens. Preserve the grid, bounded structural frame before changing ornament or component styling. Use 4px as the base rhythm and let larger gaps step up from that cadence instead of introducing unrelated spacing values.

Treat the page as a grid / bounded composition, and keep that framing stable when adding or remixing sections.

- **Layout type:** Grid
- **Content width:** Bounded
- **Base unit:** 4px
- **Scale:** 1px, 4px, 8px, 12px, 16px, 20px, 23.04px, 24px
- **Section padding:** 56px, 64px, 76px
- **Card padding:** 8px, 12px
- **Gaps:** 4px, 6px, 8px, 10px

## Elevation & Depth

Depth is communicated through glass, border contrast, and reusable shadow or blur treatments. Keep those recipes consistent across hero panels, cards, and controls so the page reads as one material system.

Surfaces should read as glass first, with borders, shadows, and blur only reinforcing that material choice.

- **Surface style:** Glass
- **Borders:** 1px #FFFFFF
- **Shadows:** rgba(32, 42, 91, 0.35) 0px 40px 70px -28px, rgba(32, 42, 91, 0.18) 0px 8px 18px -10px; rgba(224, 79, 45, 0.95) 0px 18px 32px -16px; rgba(227, 92, 58, 0.8) 0px 10px 22px -10px
- **Blur:** 8px, 14px

### Techniques
- **Gradient border shell:** Use a thin gradient border shell around the main card. Wrap the surface in an outer shell with 1px padding and a 36px radius. Drive the shell with linear-gradient(160deg, rgba(255, 255, 255, 0.98), rgba(255, 255, 255, 0.25) 42%, rgba(150, 162, 180, 0.45)) so the edge reads like premium depth instead of a flat stroke. Keep the actual stroke understated so the gradient shell remains the hero edge treatment. Inset the real content surface inside the wrapper with a slightly smaller radius so the gradient only appears as a hairline frame.

## Shapes

Shapes rely on a tight radius system anchored by 8px and scaled across cards, buttons, and supporting surfaces. Icon geometry should stay compatible with that soft-to-controlled silhouette.

Use the radius family intentionally: larger surfaces can open up, but controls and badges should stay within the same rounded DNA instead of inventing sharper or pill-only exceptions.

- **Corner radii:** 8px, 12px, 16px, 35px, 36px, 9999px
- **Icon treatment:** Linear
- **Icon sets:** Solar

## Components

Anchor interactions to the detected button styles. Reuse the existing card surface recipe for content blocks.

### Buttons
- **Primary:** text #FFFFFF, radius 16px, padding 16px, border 0px solid rgb(229, 231, 235).
- **Links:** text #64748B, radius 0px, padding 0px, border 0px solid rgb(229, 231, 235).

### Cards and Surfaces
- **Card surface:** background #FFFFFF, border 0px solid rgb(229, 231, 235), radius 16px, padding 8px, shadow rgba(32, 42, 91, 0.65) 0px 22px 40px -22px, rgba(241, 245, 249, 0.9) 0px 0px 0px 1px.
- **Card surface:** border 0px solid rgb(229, 231, 235), radius 0px, padding 20px, shadow none.

### Iconography
- **Treatment:** Linear.
- **Sets:** Solar.

## Do's and Don'ts

Use these constraints to keep future generations aligned with the current system instead of drifting into adjacent styles.

### Do
- Do use the primary palette as the main accent for emphasis and action states.
- Do keep spacing aligned to the detected 4px rhythm.
- Do reuse the Glass surface treatment consistently across cards and controls.
- Do keep corner radii within the detected 8px, 12px, 16px, 35px, 36px, 9999px family.

### Don't
- Don't introduce extra accent colors outside the core palette roles unless the page needs a new semantic state.
- Don't mix unrelated shadow or blur recipes that break the current depth system.
- Don't exceed the detected moderate motion intensity without a deliberate reason.

## Motion

Motion feels controlled and interface-led across text, layout, and section transitions. Timing clusters around 150ms and 300ms. Easing favors ease and cubic-bezier(0.4. Hover behavior focuses on text and transform changes. Scroll choreography uses GSAP ScrollTrigger for section reveals and pacing.

**Motion Level:** moderate

**Durations:** 150ms, 300ms, 500ms, 700ms

**Easings:** ease, cubic-bezier(0.4, 0, 0.2, 1)

**Hover Patterns:** text, transform

**Scroll Patterns:** gsap-scrolltrigger
