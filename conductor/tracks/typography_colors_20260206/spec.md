# Specification - Advanced Typography & Color Control

## 1. Overview
This track implements a robust customization system for typography and colors using the Kirki framework. The goal is to allow users to deeply personalize the "Aspiring Knight" aesthetic (iron grays, golds, deep reds) while ensuring high performance and professional design standards.

## 2. Technical Requirements

### 2.1 Kirki Integration
- Expand the existing `inc/customizer.php` structure.
- Use `theme_mod` for data storage.
- Implement `postMessage` transport for all controls to allow instant live preview.

### 2.2 Typography Controls
- **Global Typography Section:**
    - Body Text: Font family, font weight, font size, line height, letter spacing, and color.
    - Headings (H1-H6): Granular control over each heading level or a global "Headings" override.
- **Font Strategy:**
    - Support Google Fonts via Kirki's built-in loader.
    - Focus on medieval-inspired serif fonts for headings (e.g., 'Cinzel', 'MedievalSharp', or high-end serifs like 'Playfair Display') and clean serifs/sans-serifs for body text (e.g., 'Lora', 'Open Sans').

### 2.3 Color Controls
- **Global Palette Section:**
    - Primary Color (Iron Gray: `#3a3a3a` default).
    - Accent Color (Gold: `#d4af37` default).
    - Secondary Accent (Crimson Red: `#8b0000` default).
    - Background Colors (Site, Header, Footer).
    - Text Colors (Body, Headings, Links, Hover states).

### 2.4 Tailwind Bridge (CSS Variables)
- All Customizer settings must be injected into the frontend as CSS variables (`:root`).
- Tailwind's configuration (`tailwind.config.js`) must be updated to use these CSS variables.
- Example: `color: var(--ak-primary-color);` mapped to Tailwind's `text-primary`.

## 3. Success Criteria
- [ ] Users can change body and heading typography in the Customizer with live preview.
- [ ] Users can change the primary, accent, and background colors with live preview.
- [ ] Tailwind utilities (e.g., `text-primary`, `bg-accent`) automatically reflect Customizer choices.
- [ ] No significant performance degradation; fonts are loaded efficiently.
