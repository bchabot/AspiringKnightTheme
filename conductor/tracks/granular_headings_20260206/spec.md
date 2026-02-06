# Specification - Granular Heading Controls

## 1. Overview
This track provides individual font size controls for each heading level (H1-H6) to replace the single "General Headings" font size. This ensures a professional typographic hierarchy while maintaining global font family and effect settings for headings.

## 2. Technical Requirements

### 2.1 Customizer Expansion
- **Headings Category**: Keep the global Font Family, Color, and Effects.
- **Individual Sizes**: Add six new range/text fields for:
    - H1 Font Size (Default: 48px)
    - H2 Font Size (Default: 36px)
    - H3 Font Size (Default: 30px)
    - H4 Font Size (Default: 24px)
    - H5 Font Size (Default: 20px)
    - H6 Font Size (Default: 18px)

### 2.2 CSS Variable Logic
- Map new settings to:
    - `--ak-h1-font-size`
    - `--ak-h2-font-size`
    - ... up to `--ak-h6-font-size`

### 2.3 Style Application
- Update `style.css` to target `h1`, `h2`, etc., with their respective variables.

## 3. Success Criteria
- [ ] Users can set a different size for each heading level.
- [ ] Changing an H1 size does not affect H2-H6.
- [ ] Live preview updates instantly for all 6 levels.
