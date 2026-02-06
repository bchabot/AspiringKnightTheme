# Implementation Plan - Visual Refinement & Advanced Branding

## Phase 1: Customizer Consolidation & Menu Colors
- [ ] Task: Consolidate Color Settings
    - Move menu, header, and footer colors to `colors_section`.
- [ ] Task: Add Menu Background & Granular Hover
    - Add `menu_bg_color` and refine `menu_hover_color`.
- [ ] Task: Link Underline Toggle
    - Add `link_underline` checkbox and CSS variable.
- [ ] Task: Verification - Customizer organization and new color/toggle logic.

## Phase 2: Branding Toggles & Banner Image
- [ ] Task: Implement Site Title Banner Image
    - Add `site_title_banner` image control.
- [ ] Task: Visibility Toggles
    - Add toggles for `show_site_title`, `show_site_tagline`, and `show_banner_image`.
- [ ] Task: Update `header.php`
    - Implement the logic to conditionally show branding elements and the banner image.
- [ ] Task: Verification - Toggles and banner images work as expected.

## Phase 3: Footer Background & Advanced Visuals
- [ ] Task: Footer Background Image
    - Add `footer_bg_image` setting and update `footer.php`.
- [ ] Task: Shadow & Glow System
    - Implement `text-shadow` CSS variable logic for all requested elements.
    - Add Customizer controls for shadow intensity/color (simplified as toggles or presets if needed).
- [ ] Task: Verification - Shadows and footer images render correctly.

## Phase 4: Final Build & Audit
- [ ] Task: Global Styles Audit
    - Ensure all new CSS variables are mapped in `style.css`.
- [ ] Task: Final Build
    - Run `npm run build`.
- [ ] Task: Verification - Complete manual audit.
