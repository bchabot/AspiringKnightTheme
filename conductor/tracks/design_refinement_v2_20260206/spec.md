# Specification - Design System Refinement & UI/UX Cleanup

## 1. Overview
This track addresses functional bugs in the branding system and performs a final, high-end cleanup of the Customizer UX. It ensures all settings persist correctly, branding elements are visible, and the UI is professional and intuitive.

## 2. Technical Requirements

### 2.1 UI/UX Reconstruction
- **Panel**: Refine the "Design System" panel.
- **Section Removal**: Explicitly remove core `colors` and `header_image` sections using high priority (20+).
- **Sidebar Integration**: Add a dedicated "Sidebar Design" section within the panel for:
    - Sidebar Background Color.
    - Sidebar Border Color.
    - Sidebar Padding.

### 2.2 Functional Bug Fixes
- **Tagline**: Fix visibility by setting a default white color and ensuring it's not hidden by CSS.
- **Site Title**: Fix Font Size persistence and application.
- **Variable Mapping**: Fix the bug in the effect variable mapping loop where `$id` was used instead of `$cat`.

### 2.3 UX Polish
- **Grouped Controls**: Combine related controls (e.g., Shadow Toggle and Color) into logical visual blocks.
- **Labels**: Improve all labels for clarity.

## 3. Success Criteria
- [ ] No top-level "Colors" section remains.
- [ ] Site Tagline is visible and customizable.
- [ ] Site Title font changes persist and apply correctly.
- [ ] Sidebar design can be controlled independently.
