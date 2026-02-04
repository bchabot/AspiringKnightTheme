# Implementation Plan - Establish Theme Foundation and Tech Stack Integration

## Phase 1: Project Scaffolding & Configuration
- [ ] Task: Initialize Theme Directory and Git
    - [ ] Create theme folder `aspiring-knight-theme`.
    - [ ] Initialize `style.css` with required WordPress theme header metadata.
    - [ ] Create `functions.php`, `index.php`, `header.php`, `footer.php`.
    - [ ] Initialize Git repository (if not already done at root) and create `.gitignore`.
- [ ] Task: Set up NPM and Tailwind CSS
    - [ ] Run `npm init -y` in the theme root.
    - [ ] Install Tailwind CSS, PostCSS, and Autoprefixer: `npm install -D tailwindcss postcss autoprefixer`.
    - [ ] Initialize Tailwind config: `npx tailwindcss init`.
    - [ ] Configure `tailwind.config.js` to scan PHP files for classes.
    - [ ] Create source CSS file `assets/css/src/style.css` with Tailwind directives.
    - [ ] Add build scripts to `package.json` (`dev`, `build`, `watch`).
- [ ] Task: Verify Build Pipeline
    - [ ] Run the build script to generate the final CSS.
    - [ ] Verify that the output CSS contains Tailwind utilities.
- [ ] Task: Conductor - User Manual Verification 'Phase 1' (Protocol in workflow.md)

## Phase 2: WordPress Core Integration
- [ ] Task: Asset Enqueueing
    - [ ] In `functions.php`, write a function to enqueue the compiled Tailwind CSS file.
    - [ ] Register a basic navigation menu support.
    - [ ] Add `add_theme_support` for essential features (title-tag, post-thumbnails).
- [ ] Task: Basic Template Structure
    - [ ] Implement `header.php` with `wp_head()` and basic HTML structure.
    - [ ] Implement `footer.php` with `wp_footer()` and closing tags.
    - [ ] Create a simple `index.php` loop to display post titles, ensuring styles load.
- [ ] Task: Conductor - User Manual Verification 'Phase 2' (Protocol in workflow.md)

## Phase 3: Kirki Customizer Setup
- [ ] Task: Kirki Integration Strategy
    - [ ] Decide on embedding vs. TGM Plugin Activation (TGMPA) for Kirki. (Plan: Use TGMPA to require the Kirki plugin as per best practices for modern themes).
    - [ ] Download and include the TGM Plugin Activation class file.
    - [ ] Configure TGMPA in `functions.php` to recommend/require Kirki.
- [ ] Task: Basic Customizer Configuration
    - [ ] Create a separate file `inc/customizer.php` and require it in `functions.php`.
    - [ ] Add a sample Kirki configuration (e.g., a "Theme Colors" panel) to verify integration.
    - [ ] Test that the Customizer panel appears and saves a value.
- [ ] Task: Conductor - User Manual Verification 'Phase 3' (Protocol in workflow.md)
