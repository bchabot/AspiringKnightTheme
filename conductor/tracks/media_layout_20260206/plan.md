# Implementation Plan - Media Integration & Advanced Layout Controls [checkpoint: cb7ccbe]

## Phase 1: Background Media Support
- [x] Task: Enable Custom Background Support
    - Add `add_theme_support( 'custom-background' )` in `functions.php`.
- [x] Task: Implement Header Background Image
    - Add Customizer setting for header background image.
    - Update `header.php` to output inline style for background.
- [x] Task: Verification - Background images render correctly.

## Phase 2: Featured Image Integration
- [x] Task: Enable Post Thumbnails
    - Ensure `add_theme_support( 'post-thumbnails' )` is active.
- [x] Task: Update Content Template Parts
    - Modify `template-parts/content.php` to display `the_post_thumbnail()`.
- [x] Task: Verification - Featured images appear on posts and archives.

## Phase 3: Archive Layout Toggle (Grid vs. List)
- [x] Task: Add Archive Layout Setting
    - Add "Archive Layout" select field in Customizer (Tiled Grid, Excerpt List).
- [x] Task: Update Archive Logic
    - Modify `index.php` and `archive.php` to swap classes based on setting.
- [x] Task: Verification - Layout updates in Customizer.

## Phase 4: Final Polish & Pre-compiled CSS
- [x] Task: Global Styles Audit
    - Ensure image overlays don't break text legibility (add overlays if needed).
- [x] Task: Final Build
    - Run `npm run build` to finalize utility classes.
- [x] Task: Verification - Complete manual audit.
