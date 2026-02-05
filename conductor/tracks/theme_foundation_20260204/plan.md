# Implementation Plan - Establish Theme Foundation and Tech Stack Integration

## Phase 1: Project Scaffolding & Configuration [checkpoint: fb55613]
- [x] Task: Initialize Theme Directory and Git [afa7fd6]
    - [x] Create theme folder `aspiring-knight-theme`.
    - [x] Initialize `style.css` with required WordPress theme header metadata.
    - [x] Create `functions.php`, `index.php`, `header.php`, `footer.php`.
    - [x] Initialize Git repository (if not already done at root) and create `.gitignore`.
- [x] Task: Set up NPM and Tailwind CSS [67849c4]
    - [x] Run `npm init -y` in the theme root.
    - [x] Install Tailwind CSS, PostCSS, and Autoprefixer: `npm install -D tailwindcss postcss autoprefixer`.
    - [x] Initialize Tailwind config: `npx tailwindcss init`.
    - [x] Configure `tailwind.config.js` to scan PHP files for classes.
    - [x] Create source CSS file `assets/css/src/style.css` with Tailwind directives.
    - [x] Add build scripts to `package.json` (`dev`, `build`, `watch`).
- [x] Task: Verify Build Pipeline [45ff1c7]
    - [x] Run the build script to generate the final CSS.
    - [x] Verify that the output CSS contains Tailwind utilities.
- [ ] Task: Conductor - User Manual Verification 'Phase 1' (Protocol in workflow.md)

## Phase 2: WordPress Core Integration [checkpoint: 364149d]
- [x] Task: Asset Enqueueing [860111a]
    - [x] In `functions.php`, write a function to enqueue the compiled Tailwind CSS file.
    - [x] Register a basic navigation menu support.
    - [x] Add `add_theme_support` for essential features (title-tag, post-thumbnails).
- [x] Task: Basic Template Structure [bf2fe20]
    - [x] Implement `header.php` with `wp_head()` and basic HTML structure.
    - [x] Implement `footer.php` with `wp_footer()` and closing tags.
    - [x] Create a simple `index.php` loop to display post titles, ensuring styles load.
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
