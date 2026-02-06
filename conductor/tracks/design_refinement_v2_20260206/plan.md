# Implementation Plan - Design System Refinement & UI/UX Cleanup

## Phase 1: Critical UI & Branding Fixes
- [ ] Task: Remove Core Sections (High Priority)
    - Update `inc/customizer.php` to remove core sections with priority 20.
- [ ] Task: Fix Tagline & Title Rendering
    - Update `header.php` and `style.css`.
    - Change default tagline color to white.
- [ ] Task: Fix Variable Mapping Bug
    - Correct the loop in `aspiring_knight_output_css_variables`.
- [ ] Task: Verification - "Colors" section is gone, Tagline is visible.

## Phase 2: Sidebar Design Expansion
- [ ] Task: Add Sidebar Design Section
    - Implement BG color, Border color, and Padding controls.
- [ ] Task: Update CSS Variable Map
    - Add `--ak-sidebar-bg`, `--ak-sidebar-border`, and `--ak-sidebar-padding`.
- [ ] Task: Update `sidebar.php` and `style.css`
    - Apply variables to the aside element.
- [ ] Task: Verification - Sidebar styles update in live preview.

## Phase 3: Customizer UX Cleanup
- [ ] Task: Refine Control Naming & Order
    - Reorder sections for better flow.
- [ ] Task: Update `customize-preview.js`
    - Sync all handlers with the latest settings.
- [ ] Task: Verification - Entire "Design System" panel feels polished and usable.

## Phase 4: Final Polish
- [ ] Task: Global Styles Audit
- [ ] Task: Final Build
- [ ] Task: Verification - Complete manual audit.
