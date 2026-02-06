# Specification - Design System UX Overhaul & Branding Fixes

## 1. Overview
This track addresses major UX flaws in the Customizer and fixes critical branding bugs. It transitions from a single giant "Typography" section to a high-end "Design System" panel with dedicated sections for each category.

## 2. Technical Requirements

### 2.1 UX Revamp (Customizer)
- **Panel**: Create "Design System" panel.
- **Sections**: Convert categorical hidden headers into full Customizer sections:
    - Site Identity (Title & Tagline)
    - Navigation (Menus & Sub-menus)
    - Page/Post Content (Titles, Headings, Body)
- **Colors**: Consolidate all background and accent colors into a "Site Colors" section within the panel.
- **Global Cleanup**: Explicitly remove the default WordPress "Colors" and "Header Image" sections to avoid confusion.

### 2.2 Functional Fixes
- **Site Title**: Correct CSS selectors and ensure variable persistence.
- **Tagline**: Fix visibility logic in `header.php` and ensure variables map to the correct container.
- **Persistence**: Verify all variables are correctly scoped in `:root`.

### 2.3 Visual Improvements
- Use standard WordPress control grouping for a cleaner UI.
- Improve labels and descriptions for all design controls.

## 3. Success Criteria
- [ ] No top-level "Colors" item exists.
- [ ] Site Title and Tagline fonts/sizes apply reliably.
- [ ] Customizer is organized into logical, manageable sections.
- [ ] All 7 categories (Site Title, Tagline, Menus, Sub-menus, Page Titles, Headings, Body) are fully functional.
