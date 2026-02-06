# Specification - Visual Refinement & Advanced Branding

## 1. Overview
This track focuses on consolidating the design experience and adding high-end visual features like text effects (glows/shadows), advanced banner images, and granular visibility toggles.

## 2. Technical Requirements

### 2.1 UI Consolidation
- Move all color-related settings from "Header Settings" and "Footer Settings" into **Global Styles > Colors**.
- Create a unified color palette management experience.

### 2.2 Branding & Media
- **Site Title Banner Image**: A hero-style image control for the branding area.
- **Footer Background Image**: Add specific upload for the footer masthead.
- **Visibility Toggles**: Checkboxes for Site Title, Tagline, and Banner Image.

### 2.3 Visual Effects (CSS Variables)
- **Link Underlining**: Toggle for `text-decoration: underline`.
- **Glow & Shadows**: Implement `text-shadow` controls for:
    - Menu & Submenu Items.
    - Headers (H1-H6).
    - Page/Post Titles.
    - Site Title.
- **Menu Background**: Dedicated color setting for the navigation bar background.

## 3. Success Criteria
- [ ] Customizer is organized with all colors in one section.
- [ ] Users can toggle visibility of branding elements.
- [ ] Shadows and glows apply correctly via CSS variables without a build refresh.
- [ ] Footer background image renders correctly with an overlay.
