# Implementation Plan - Design System UX Overhaul & Branding Fixes

## Phase 1: Customizer UX Reconstruction
- [ ] Task: Create Design System Panel
    - Define the panel and move `colors_section` and `typography_section` into it.
- [ ] Task: Expand to Dedicated Sections
    - Create individual sections for Site Title, Tagline, Menus, Sub-menus, Page Titles, Headings, and Body.
- [ ] Task: Remove Core Sections
    - Add code to remove the default `colors` and `header_image` sections.
- [ ] Task: Verification - Customizer UI is clean and organized.

## Phase 2: Branding & Variable Debugging
- [ ] Task: Fix Site Title & Tagline Selectors
    - Update `style.css` to use more robust selectors.
- [ ] Task: Refine Variable Persistence
    - Audit `aspiring_knight_output_css_variables` to ensure all keys match exactly what's saved.
- [ ] Task: Update `header.php`
    - Simplify markup to ensure no inline styles or Tailwind classes block Customizer output.
- [ ] Task: Verification - Branding elements reflect settings on reload.

## Phase 3: Preview Script Sync
- [ ] Task: Update `customize-preview.js`
    - Sync handlers with the new section/setting names.
- [ ] Task: Verification - Full instant preview functional across all new sections.

## Phase 4: Final Polish
- [ ] Task: Global Styles Audit
- [ ] Task: Final Build
- [ ] Task: Verification - Complete manual audit.
