---
version: "alpha"
name: "GLASSBLOWN · Neon works, Deptford"
description: "Glassblown Neon Feature Section is designed for highlighting product capabilities and value points. Key features include reusable structure, responsive behavior, and production-ready presentation. It is suitable for component libraries and responsive product interfaces."
colors:
  primary: "#FF3D9E"
  secondary: "#FFD9EE"
  tertiary: "#FF6C47"
  neutral: "#F3ECF0"
  background: "#0C0910"
  surface: "#0A080C"
  text-primary: "#F3ECF0"
  text-secondary: "#6D5F68"
  border: "#F4E8F0"
  accent: "#FF3D9E"
typography:
  display-lg:
    fontFamily: "Archivo"
    fontSize: "96px"
    fontWeight: 500
    lineHeight: "96px"
    letterSpacing: "-0.025em"
    textTransform: "uppercase"
  body-md:
    fontFamily: "Archivo"
    fontSize: "16px"
    fontWeight: 400
    lineHeight: "24px"
  label-md:
    fontFamily: "Archivo"
    fontSize: "14px"
    fontWeight: 400
    lineHeight: "20px"
    letterSpacing: "0.35px"
rounded:
  md: "2px"
spacing:
  base: "4px"
  sm: "1px"
  md: "4px"
  lg: "6px"
  xl: "10px"
  gap: "12px"
  card-padding: "14px"
  section-padding: "40px"
components:
  button-secondary:
    backgroundColor: "{colors.primary}"
    textColor: "{colors.neutral}"
    typography: "{typography.label-md}"
    rounded: "{rounded.md}"
    padding: "12px"
  button-link:
    textColor: "{colors.neutral}"
    typography: "{typography.label-md}"
    rounded: "0px"
    padding: "0px"
---

## Overview

- **Composition cues:**
  - Layout: Grid
  - Content Width: Bounded
  - Framing: Open
  - Grid: Strong

## Colors

The color system uses light mode with #FF3D9E as the main accent and #F3ECF0 as the neutral foundation.

- **Primary (#FF3D9E):** Main accent and emphasis color.
- **Secondary (#FFD9EE):** Supporting accent for secondary emphasis.
- **Tertiary (#FF6C47):** Reserved accent for supporting contrast moments.
- **Neutral (#F3ECF0):** Neutral foundation for backgrounds, surfaces, and supporting chrome.

- **Usage:** Background: #0C0910; Surface: #0A080C; Text Primary: #F3ECF0; Text Secondary: #6D5F68; Border: #F4E8F0; Accent: #FF3D9E

- **Gradients:** bg-gradient-to-b from-[rgba(244,232,240,0.12)] to-transparent, bg-gradient-to-t from-[#0c0910] to-transparent via-transparent, bg-gradient-to-b from-[rgba(244,232,240,0.08)] to-transparent

## Typography

Typography relies on Archivo across display, body, and utility text.

- **Display (`display-lg`):** Archivo, 96px, weight 500, line-height 96px, letter-spacing -0.025em, uppercase.
- **Body (`body-md`):** Archivo, 16px, weight 400, line-height 24px.
- **Labels (`label-md`):** Archivo, 14px, weight 400, line-height 20px, letter-spacing 0.35px.

## Layout

Layout follows a grid composition with reusable spacing tokens. Preserve the grid, bounded structural frame before changing ornament or component styling. Use 4px as the base rhythm and let larger gaps step up from that cadence instead of introducing unrelated spacing values.

Treat the page as a grid / bounded composition, and keep that framing stable when adding or remixing sections.

- **Layout type:** Grid
- **Content width:** Bounded
- **Base unit:** 4px
- **Scale:** 1px, 4px, 6px, 10px, 12px, 16px, 32px, 36px
- **Section padding:** 40px, 72px, 128px
- **Card padding:** 14px
- **Gaps:** 12px, 16px, 20px, 24px

## Elevation & Depth

Depth is communicated through elevated, border contrast, and reusable shadow or blur treatments. Keep those recipes consistent across hero panels, cards, and controls so the page reads as one material system.

Surfaces should read as elevated first, with borders, shadows, and blur only reinforcing that material choice.

- **Surface style:** Elevated
- **Borders:** 1px #F4E8F0
- **Shadows:** rgba(255, 40, 140, 0.3) 0px 26px 64px -30px, rgba(255, 255, 255, 0.024) 0px 2px 0px 0px inset

### Techniques
- **Gradient border shell:** Use a thin gradient border shell around the main card. Wrap the surface in an outer shell with 1px padding and a 12px radius. Drive the shell with linear-gradient(rgba(244, 232, 240, 0.12), rgba(0, 0, 0, 0)) so the edge reads like premium depth instead of a flat stroke. Keep the actual stroke understated so the gradient shell remains the hero edge treatment. Inset the real content surface inside the wrapper with a slightly smaller radius so the gradient only appears as a hairline frame.

## Shapes

Shapes rely on a tight radius system anchored by 2px and scaled across cards, buttons, and supporting surfaces. Icon geometry should stay compatible with that soft-to-controlled silhouette.

Use the radius family intentionally: larger surfaces can open up, but controls and badges should stay within the same rounded DNA instead of inventing sharper or pill-only exceptions.

- **Corner radii:** 2px, 3px, 11px, 12px
- **Icon treatment:** Linear
- **Icon sets:** Solar

## Components

Anchor interactions to the detected button styles.

### Buttons
- **Secondary:** background #FF3D9E, text #F3ECF0, radius 2px, padding 12px, border 1px solid rgba(244, 232, 240, 0.18).
- **Links:** text #F3ECF0, radius 0px, padding 0px, border 0px solid rgb(229, 231, 235).

### Iconography
- **Treatment:** Linear.
- **Sets:** Solar.

## Do's and Don'ts

Use these constraints to keep future generations aligned with the current system instead of drifting into adjacent styles.

### Do
- Do use the primary palette as the main accent for emphasis and action states.
- Do keep spacing aligned to the detected 4px rhythm.
- Do reuse the Elevated surface treatment consistently across cards and controls.
- Do keep corner radii within the detected 2px, 3px, 11px, 12px family.

### Don't
- Don't introduce extra accent colors outside the core palette roles unless the page needs a new semantic state.
- Don't mix unrelated shadow or blur recipes that break the current depth system.
- Don't exceed the detected expressive motion intensity without a deliberate reason.

## Motion

Motion feels expressive but remains focused on interface, text, and layout transitions. Timing clusters around 300ms and 150ms. Easing favors ease and 1). Hover behavior focuses on text and transform changes. Scroll choreography uses GSAP ScrollTrigger for section reveals and pacing.

**Motion Level:** expressive

**Durations:** 300ms, 150ms, 700ms

**Easings:** ease, 1), cubic-bezier(0.4, 0, 0.2, cubic-bezier(0.22

**Hover Patterns:** text, transform, stroke, color

**Scroll Patterns:** gsap-scrolltrigger
