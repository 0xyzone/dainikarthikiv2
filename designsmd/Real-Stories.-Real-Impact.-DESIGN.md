---
version: "alpha"
name: "Real Stories. Real Impact."
description: "Real Stories Testimonial Section is designed for showcasing social proof and customer credibility. Key features include reusable structure, responsive behavior, and production-ready presentation. It is suitable for component libraries and responsive product interfaces."
colors:
  primary: "#A855F7"
  secondary: "#C084FC"
  tertiary: "#C09AE4"
  neutral: "#0F0F0F"
  background: "#0F0F0F"
  surface: "#343434"
  text-primary: "#999999"
  text-secondary: "#737373"
  border: "#262626"
  accent: "#A855F7"
typography:
  display-lg:
    fontFamily: "Playfair Display"
    fontSize: "60px"
    fontWeight: 400
    lineHeight: "60px"
    letterSpacing: "-0.025em"
  body-md:
    fontFamily: "Inter"
    fontSize: "16px"
    fontWeight: 300
    lineHeight: "24px"
  label-md:
    fontFamily: "Inter"
    fontSize: "14px"
    fontWeight: 500
    lineHeight: "20px"
rounded:
  full: "9999px"
spacing:
  base: "4px"
  sm: "1px"
  md: "2px"
  lg: "4px"
  xl: "12px"
  gap: "2px"
  card-padding: "32px"
  section-padding: "32px"
components:
  button-primary:
    backgroundColor: "#171717"
    textColor: "#FFFFFF"
    typography: "{typography.label-md}"
    rounded: "{rounded.full}"
    padding: "14px"
  card:
    rounded: "23px"
    padding: "32px"
---

## Overview

- **Composition cues:**
  - Layout: Grid
  - Content Width: Bounded
  - Framing: Glassy
  - Grid: Strong

## Colors

The color system uses dark mode with #A855F7 as the main accent and #0F0F0F as the neutral foundation.

- **Primary (#A855F7):** Main accent and emphasis color.
- **Secondary (#C084FC):** Supporting accent for secondary emphasis.
- **Tertiary (#C09AE4):** Reserved accent for supporting contrast moments.
- **Neutral (#0F0F0F):** Neutral foundation for backgrounds, surfaces, and supporting chrome.

- **Usage:** Background: #0F0F0F; Surface: #343434; Text Primary: #999999; Text Secondary: #737373; Border: #262626; Accent: #A855F7

## Typography

Typography pairs Playfair Display for display hierarchy with Inter for supporting content and interface copy.

- **Display (`display-lg`):** Playfair Display, 60px, weight 400, line-height 60px, letter-spacing -0.025em.
- **Body (`body-md`):** Inter, 16px, weight 300, line-height 24px.
- **Labels (`label-md`):** Inter, 14px, weight 500, line-height 20px.

## Layout

Layout follows a grid composition with reusable spacing tokens. Preserve the grid, bounded structural frame before changing ornament or component styling. Use 4px as the base rhythm and let larger gaps step up from that cadence instead of introducing unrelated spacing values.

Treat the page as a grid / bounded composition, and keep that framing stable when adding or remixing sections.

- **Layout type:** Grid
- **Content width:** Bounded
- **Base unit:** 4px
- **Scale:** 1px, 2px, 4px, 12px, 14px, 24px, 32px, 40px
- **Section padding:** 32px
- **Card padding:** 32px
- **Gaps:** 2px, 8px, 12px, 24px

## Elevation & Depth

Depth is communicated through glass, border contrast, and reusable shadow or blur treatments. Keep those recipes consistent across hero panels, cards, and controls so the page reads as one material system.

Surfaces should read as glass first, with borders, shadows, and blur only reinforcing that material choice.

- **Surface style:** Glass
- **Borders:** 1px #262626; 1px #404040
- **Shadows:** rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(255, 255, 255, 0.05) 0px 1px 1px 0px inset; rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgb(168, 85, 247) 0px 0px 8px 0px; rgba(147, 51, 234, 0.176) 0px 20.9441px 41.8882px -10.4721px, rgba(147, 51, 234, 0.106) 0px 0px 27.9255px 0px
- **Blur:** 24px

### Techniques
- **Gradient border shell:** Use a thin gradient border shell around the main card. Wrap the surface in an outer shell with 1px padding and a 9999px radius. Drive the shell with linear-gradient(rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0) 100%) so the edge reads like premium depth instead of a flat stroke. Keep the actual stroke understated so the gradient shell remains the hero edge treatment. Inset the real content surface inside the wrapper with a slightly smaller radius so the gradient only appears as a hairline frame.

## Shapes

Shapes rely on a tight radius system anchored by 23px and scaled across cards, buttons, and supporting surfaces. Icon geometry should stay compatible with that soft-to-controlled silhouette.

Use the radius family intentionally: larger surfaces can open up, but controls and badges should stay within the same rounded DNA instead of inventing sharper or pill-only exceptions.

- **Corner radii:** 23px, 24px, 9999px
- **Icon treatment:** Bold
- **Icon sets:** Solar

## Components

Anchor interactions to the detected button styles. Reuse the existing card surface recipe for content blocks.

### Buttons
- **Primary:** background #171717, text #FFFFFF, radius 9999px, padding 14px, border 0px solid rgb(229, 231, 235).

### Cards and Surfaces
- **Card surface:** background rgba(15, 15, 15, 0.106), border 0px solid rgb(229, 231, 235), radius 23px, padding 32px, shadow rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(255, 255, 255, 0.05) 0px 1px 1px 0px inset, blur 24px.
- **Card surface:** background rgba(12, 12, 12, 0.14), border 0px solid rgb(229, 231, 235), radius 23px, padding 32px, shadow rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(255, 255, 255, 0.05) 0px 1px 1px 0px inset, blur 24px.

### Iconography
- **Treatment:** Bold.
- **Sets:** Solar.

## Do's and Don'ts

Use these constraints to keep future generations aligned with the current system instead of drifting into adjacent styles.

### Do
- Do use the primary palette as the main accent for emphasis and action states.
- Do keep spacing aligned to the detected 4px rhythm.
- Do reuse the Glass surface treatment consistently across cards and controls.
- Do keep corner radii within the detected 23px, 24px, 9999px family.

### Don't
- Don't introduce extra accent colors outside the core palette roles unless the page needs a new semantic state.
- Don't mix unrelated shadow or blur recipes that break the current depth system.
- Don't exceed the detected expressive motion intensity without a deliberate reason.

## Motion

Motion feels expressive but remains focused on interface, text, and layout transitions. Timing clusters around 500ms and 800ms. Easing favors ease and 0.2. Hover behavior focuses on text and stroke changes. Scroll choreography uses GSAP ScrollTrigger for section reveals and pacing.

**Motion Level:** expressive

**Durations:** 500ms, 800ms, 300ms, 150ms, 1000ms, 700ms

**Easings:** ease, 0.2, 1), cubic-bezier(0.4, 0, cubic-bezier(0.2

**Hover Patterns:** text, stroke, color, grayscale

**Scroll Patterns:** gsap-scrolltrigger
