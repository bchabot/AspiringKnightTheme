# Implementation Plan - Template Hierarchy & Layout Systems

## Phase 1: Template Modernization & Refactoring
- [x] Task: Refactor Loop to Template Parts
    - Create `template-parts/content.php` and move the post article logic there.
- [x] Task: Create Core Templates
    - Create `single.php`, `page.php`, and `archive.php` based on the refactored `index.php`.
- [x] Task: Verification - Ensure posts and pages render using the new templates.

## Phase 2: Sidebar and Widget Areas
- [x] Task: Register Main Sidebar
    - Update `functions.php` to register a sidebar.
- [x] Task: Create Sidebar Template
    - Create `sidebar.php` with appropriate Tailwind classes.
- [x] Task: Integration - Add `get_sidebar()` to templates.
- [x] Task: Verification - Sidebar appears and widgets are functional.

## Phase 3: Layout Controls in Customizer
- [x] Task: Add Layout Settings to Customizer
    - Add a "Layout Settings" section.
    - Add a "Global Layout" select field (Right Sidebar, Left Sidebar, No Sidebar).
    - Add a "Container Width" range field.
- [x] Task: Implement Layout CSS Logic
    - Use CSS variables to control the grid order and container widths.
- [x] Task: Verification - Layout changes instantly in Customizer live preview.

## Phase 4: Responsive Layout Refinement [checkpoint: d6013de]
- [x] Task: Mobile Layout Optimization
    - Ensure sidebar stacks correctly and container padding is appropriate for small screens.
- [x] Task: Final Build & Audit
    - Run final `npm run build`.
    - Perform a manual audit of all templates.
