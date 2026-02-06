# Implementation Plan - Advanced Typography & Color Control

## Phase 1: Foundation and CSS Bridge [checkpoint: eed8977]
- [x] Task: Set up CSS Variables Injection [4ec0649]
    - Create a function in `inc/customizer.php` to output a `<style>` block in the head.
    - Map initial Customizer defaults to CSS variables (e.g., `--ak-primary-color`, `--ak-accent-gold`).
- [x] Task: Update Tailwind Config [6ddd1d7]
    - Modify `tailwind.config.js` to extend the theme with the new CSS variables.
- [x] Task: Verification - Confirm Tailwind classes use variables. [6ddd1d7]
- [ ] Task: Conductor - User Manual Verification 'Phase 1'

## Phase 2: Expanded Color Controls [checkpoint: ea8d268]
- [x] Task: Implement Background and Text Color Controls [2163187]
    - Add Kirki fields for site background, header background, and footer background.
    - Add fields for body text and heading text colors.
- [x] Task: Implement Link and Hover Color Controls [2163187]
    - Add fields for link color and link hover color.
- [x] Task: Verification - Live preview functions for all new color fields. [2163187]
- [ ] Task: Conductor - User Manual Verification 'Phase 2'

## Phase 3: Comprehensive Typography Controls [checkpoint: aed8ea7]
- [x] Task: Implement Body Typography Fields [e772510]
    - Add a `typography` field for the body text (family, weight, size, line-height).
- [x] Task: Implement Heading Typography Fields [e772510]
    - Add a global `typography` field for all headings.
    - Add individual overrides for H1 and H2 if needed.
- [x] Task: Optimization - Ensure efficient Google Font loading via Kirki. [e772510]
- [x] Task: Verification - Fonts render correctly and change instantly in Customizer. [e772510]
- [ ] Task: Conductor - User Manual Verification 'Phase 3'
