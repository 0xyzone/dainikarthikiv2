---
version: "alpha"
name: "Aeris Mobile Weather Flow"
description: "A three-screen mobile weather experience for discovering conditions, reviewing atmospheric detail, and planning the day."
colors:
  primary: "#201938"
  secondary: "#181427"
  tertiary: "#211A35"
  neutral: "#FFFFFF"
  background: "#FFFFFF"
  surface: "#201938"
  text-primary: "#FFFFFF"
  text-secondary: "#181427"
  border: "#FFFFFF"
  accent: "#201938"
typography:
  display-lg:
    fontFamily: "Inter"
    fontSize: "60px"
    fontWeight: 400
    lineHeight: "60px"
    letterSpacing: "-0.025em"
  body-md:
    fontFamily: "Inter"
    fontSize: "12px"
    fontWeight: 400
    lineHeight: "16px"
  label-md:
    fontFamily: "Inter"
    fontSize: "14px"
    fontWeight: 400
    lineHeight: "20px"
rounded:
  sm: "8px"
  lg: "16px"
spacing:
  base: "4px"
  sm: "4px"
  md: "6px"
  lg: "8px"
  xl: "12px"
  gap: "4px"
  card-padding: "8px"
  section-padding: "32px"
components:
  button-primary:
    backgroundColor: "{colors.neutral}"
    textColor: "{colors.neutral}"
    typography: "{typography.label-md}"
    rounded: "{rounded.lg}"
    padding: "0px"
  button-link:
    textColor: "#81798B"
    typography: "{typography.body-md}"
    rounded: "{rounded.sm}"
    padding: "0px"
  card:
    backgroundColor: "{colors.neutral}"
    rounded: "24px"
    padding: "16px"
---

## Overview

- **Composition cues:**
  - Layout: Grid
  - Content Width: Bounded
  - Framing: Glassy
  - Grid: Strong

## Colors

The color system uses dark mode with #201938 as the main accent and #FFFFFF as the neutral foundation.

- **Primary (#201938):** Main accent and emphasis color.
- **Secondary (#181427):** Supporting accent for secondary emphasis.
- **Tertiary (#211A35):** Reserved accent for supporting contrast moments.
- **Neutral (#FFFFFF):** Neutral foundation for backgrounds, surfaces, and supporting chrome.

- **Usage:** Background: #FFFFFF; Surface: #201938; Text Primary: #FFFFFF; Text Secondary: #181427; Border: #FFFFFF; Accent: #201938

## Typography

Typography relies on Inter across display, body, and utility text.

- **Display (`display-lg`):** Inter, 60px, weight 400, line-height 60px, letter-spacing -0.025em.
- **Body (`body-md`):** Inter, 12px, weight 400, line-height 16px.
- **Labels (`label-md`):** Inter, 14px, weight 400, line-height 20px.

## Layout

Layout follows a grid composition with reusable spacing tokens. Preserve the grid, bounded structural frame before changing ornament or component styling. Use 4px as the base rhythm and let larger gaps step up from that cadence instead of introducing unrelated spacing values.

Treat the page as a grid / bounded composition, and keep that framing stable when adding or remixing sections.

- **Layout type:** Grid
- **Content width:** Bounded
- **Base unit:** 4px
- **Scale:** 4px, 6px, 8px, 12px, 16px, 20px, 24px, 28px
- **Section padding:** 32px
- **Card padding:** 8px, 9px, 14px, 15px
- **Gaps:** 4px, 6px, 8px, 12px

## Elevation & Depth

Depth is communicated through glass, border contrast, and reusable shadow or blur treatments. Keep those recipes consistent across hero panels, cards, and controls so the page reads as one material system.

Surfaces should read as glass first, with borders, shadows, and blur only reinforcing that material choice.

- **Surface style:** Glass
- **Borders:** 1px #FFFFFF; 1px #E7E2EB; 1px #DED8E6; 1px #E8E4ED
- **Shadows:** rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0.05) 0px 1px 2px 0px; rgb(255, 255, 255) 0px 0px 0px 0px, rgb(255, 255, 255) 0px 0px 0px 4px, rgba(0, 0, 0, 0) 0px 0px 0px 0px; rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0.4) 0px 25px 50px -12px
- **Blur:** 24px, 12px

### Techniques
- **Gradient border shell:** Use a thin gradient border shell around the main card. Wrap the surface in an outer shell with 20px padding and a 28.8px radius. Drive the shell with linear-gradient(135deg, rgb(86, 70, 188) 0%, rgb(136, 112, 221) 55%, rgb(217, 138, 181) 100%) so the edge reads like premium depth instead of a flat stroke. Keep the actual stroke understated so the gradient shell remains the hero edge treatment. Inset the real content surface inside the wrapper with a slightly smaller radius so the gradient only appears as a hairline frame.

## Shapes

Shapes rely on a tight radius system anchored by 16px and scaled across cards, buttons, and supporting surfaces. Icon geometry should stay compatible with that soft-to-controlled silhouette.

Use the radius family intentionally: larger surfaces can open up, but controls and badges should stay within the same rounded DNA instead of inventing sharper or pill-only exceptions.

- **Corner radii:** 16px, 24px, 25.6px, 40.8px, 48px, 9999px
- **Icon treatment:** Linear
- **Icon sets:** Solar

## Components

Anchor interactions to the detected button styles. Reuse the existing card surface recipe for content blocks.

### Buttons
- **Primary:** background #FFFFFF, text #FFFFFF, radius 16px, padding 0px, border 1px solid rgba(255, 255, 255, 0.25).
- **Links:** text #81798B, radius 8px, padding 0px, border 0px solid rgb(229, 231, 235).

### Cards and Surfaces
- **Card surface:** background #FFFFFF, border 1px solid rgb(231, 226, 235), radius 24px, padding 16px, shadow none.
- **Card surface:** background rgba(255, 255, 255, 0.95), radius 0px, padding 14px, shadow none, blur 24px.
- **Card surface:** background #211A35, border 0px solid rgb(229, 231, 235), radius 25.6px, padding 16px, shadow rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(53, 36, 86, 0.15) 0px 20px 25px -5px, rgba(53, 36, 86, 0.15) 0px 8px 10px -6px.

### Iconography
- **Treatment:** Linear.
- **Sets:** Solar.

## Do's and Don'ts

Use these constraints to keep future generations aligned with the current system instead of drifting into adjacent styles.

### Do
- Do use the primary palette as the main accent for emphasis and action states.
- Do keep spacing aligned to the detected 4px rhythm.
- Do reuse the Glass surface treatment consistently across cards and controls.
- Do keep corner radii within the detected 16px, 24px, 25.6px, 40.8px, 48px, 9999px family.

### Don't
- Don't introduce extra accent colors outside the core palette roles unless the page needs a new semantic state.
- Don't mix unrelated shadow or blur recipes that break the current depth system.
- Don't exceed the detected minimal motion intensity without a deliberate reason.

## Motion

Motion stays restrained and interface-led across text, layout, and scroll transitions. Timing clusters around 150ms. Easing favors ease and cubic-bezier(0.4.

**Motion Level:** minimal

**Durations:** 150ms

**Easings:** ease, cubic-bezier(0.4, 0, 0.2, 1)
