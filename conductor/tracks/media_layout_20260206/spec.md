# Specification - Media Integration & Advanced Layout Controls

## 1. Overview
This track focuses on integrating visual media (Background images, Featured images, Header images) and providing advanced layout toggles (Grid vs. List) to enhance the theme's aesthetic and versatility.

## 2. Technical Requirements

### 2.1 Background Media
- **Global Background**: Enable WordPress core `custom-background` support.
- **Header Background**: Add Customizer setting for an image overlay in the masthead.
- **Header Title Image**: Enhancements to allow a hero-style title image.

### 2.2 Featured Images
- **Display Logic**: Automate featured image display on `single.php`, `archive.php`, and `page.php`.
- **Responsive Handling**: Use Tailwind for aspect ratios and object-fit covers.

### 2.3 Layout Toggling (Grid vs. List)
- **Customizer Setting**: "Archive Layout" (Tiled Grid vs. Excerpt List).
- **Template Logic**: Condition classes in `archive.php` and `index.php`.

## 3. Success Criteria
- [ ] Users can upload and display background images for the site and header.
- [ ] Featured images appear correctly across all templates.
- [ ] Archive pages can be toggled between a modern grid and a classic list view.
- [ ] All features are fully responsive.
