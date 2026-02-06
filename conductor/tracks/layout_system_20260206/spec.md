# Specification - Template Hierarchy & Layout Systems

## 1. Overview
This track implements the core WordPress template hierarchy and provides users with flexible layout controls via the Customizer. It moves the theme from a single-template structure to a professional, multi-template system.

## 2. Technical Requirements

### 2.1 Template Hierarchy
- **`single.php`**: Dedicated template for single blog posts.
- **`page.php`**: Dedicated template for static pages.
- **`archive.php`**: Generic archive template (categories, tags, dates).
- **Template Parts**: Refactor the loop in `index.php` into `template-parts/content.php` to ensure DRY (Don't Repeat Yourself) principles.

### 2.2 Sidebars & Widgets
- Register a "Main Sidebar" widget area in `functions.php`.
- Create `sidebar.php` to display widgets.
- Implement responsive behavior: Sidebar should stack on mobile.

### 2.3 Layout Controls (Customizer)
- **Global Layout Setting**: Select between "Content-Sidebar", "Sidebar-Content", and "Full Width".
- **Container Width**: Control the maximum width of the site container (e.g., 1200px, 1400px).
- **Bridge to Tailwind**: Output layout choices as CSS variables or utility classes.

## 3. Success Criteria
- [ ] Single posts, pages, and archives use their respective templates.
- [ ] Users can toggle sidebar placement in the Customizer with live preview.
- [ ] The theme remains fully responsive with sidebars stacking correctly.
- [ ] The theme is ready to use without a build step (compiled CSS updated).
