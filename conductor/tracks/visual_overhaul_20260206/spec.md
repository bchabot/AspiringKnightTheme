# Specification - Comprehensive Visual & Typography Overhaul

## 1. Overview
This track performs a total reorganization of the Customizer UI and expands visual controls to a per-element level. It separates typography, colors, and effects into categorical blocks for maximum design precision.

## 2. Technical Requirements

### 2.1 UI Reorganization
- **Global Styles > Colors**: Focused exclusively on Backgrounds (Site, Header, Menu, Footer, Submenu) and Accent/Gold highlights.
- **Global Styles > Typography & Effects**: Categorized by element (Site Title, Tagline, Menus, Page/Post Title, Headings, Body).

### 2.2 Categorical Design Blocks
Each category (Site Title, Tagline, etc.) will include:
- **Font Family & Size**.
- **Text Color & Link Color** (where applicable).
- **Shadow**: Toggle, Color, and Offset logic.
- **Glow**: Toggle and Color logic.
- **Underline**: Individual toggles for Titles, Headers, Menus, Sidebars, and Body.

### 2.3 Refined CSS Variable Map
- Every categorical setting will drive a unique `--ak-` variable.
- Shadow and Glow logic will be expanded to support individual colors per category.

## 3. Success Criteria
- [ ] Colors section is clean and background-focused.
- [ ] Typography section is organized logically by category.
- [ ] Each element category has full control over font, color, and effects.
- [ ] Link underlining is granularly toggleable across the site.
