# Specification - Visual & Typography Deep Refinement

## 1. Overview
This track addresses functional bugs in the shadow/underline system and introduces deep granularity for sub-menu styling and typography. It moves the theme from "Global" settings to "Element-Specific" settings.

## 2. Technical Requirements

### 2.1 Granular Sub-Menu Styling
- **Sub-menu Colors**: Add dedicated settings for:
    - Sub-menu Background Color.
    - Sub-menu Link Color.
    - Sub-menu Link Hover Color.

### 2.2 Advanced Shadow & Glow System
- **Separation**: Split "Shadow" (diagonal offset) and "Glow" (diffuse 360-degree).
- **Color Control**: Add color pickers for both Shadow and Glow.
- **Bug Fix**: Debug why current shadows/glows and link underlines are not applying (check selector specificity).

### 2.3 Comprehensive Typography Separation
- Separate Font Family and Font Size settings for:
    - **Site Title**
    - **Page/Post Titles**
    - **Headings (H1-H6)**
    - **Body**
    - **Menus**

### 2.4 CSS Logic
- All settings must drive CSS variables on `:root`.
- Ensure selectors in `style.css` are specific enough to override Tailwind defaults.

## 3. Success Criteria
- [ ] Sub-menus have independent color schemes.
- [ ] Shadow and Glow effects are clearly visible and color-customizable.
- [ ] Link underlining toggles reliably.
- [ ] Site Title, Headings, and Menus can each use completely different fonts/sizes.
