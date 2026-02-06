# Specification - Design System Final Polish & UX Cleanup

## 1. Overview
This track addresses functional bugs in branding element rendering and performs a deep cleanup of the Customizer UX. It moves design settings to their most logical categorical homes and ensures all visual settings apply reliably.

## 2. Technical Requirements

### 2.1 UI/UX Consolidation
- **Colors Section**: Exclusively for Backgrounds and the Gold Accent. Remove all text-related colors.
- **Typography Section**: Fully categorical. Each category (Site Title, Tagline, Menus, etc.) will contain its own:
    - Font Family & Size.
    - Text & Link Color.
    - Underline Toggle.
    - Shadow & Glow Controls (Toggle + Color).

### 2.2 Branding Fixes
- **Site Title**: Remove hardcoded Tailwind font classes in `header.php` to allow Customizer variables to take precedence.
- **Tagline**: Fix visibility logic and ensure it uses dynamic variables for font, size, and color.
- **Banner Image**: Implement the toggle to show/hide the hero banner.

### 2.3 Underline & Effect Reliability
- Move underlining toggles from "Colors" to their respective Typography categories.
- Ensure all visual effects use `!important` where necessary to override Tailwind.

## 3. Success Criteria
- [ ] Customizer is perfectly organized by category.
- [ ] Site Title font and size changes apply instantly and reliably.
- [ ] Tagline is visible and customizable.
- [ ] Link underlining is controlled per-category in the Typography section.
