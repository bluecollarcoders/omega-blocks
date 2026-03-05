# Omega Blocks

Omega Blocks is a WordPress plugin that provides a collection of useful custom blocks for the Gutenberg editor.

## Blocks Included

### 1. Curvy
**Curvy** allows you to add beautiful shape dividers to your page content, making transitions between sections more interesting and visually appealing.

- **Features:**
  - Customizable top and bottom curves.
  - Controls for width, height, and color of each curve.
  - Flip horizontally or vertically.
  - Background color and padding support.
  - Variations for "Top Only" and "Bottom Only" dividers.

### 2. Clicky Group
**Clicky Group** is a container block specifically designed to hold **Clicky Buttons**. It helps manage the layout and alignment of multiple buttons.

- **Features:**
  - Alignment controls (Left, Center, Right).
  - Supports block gap for consistent spacing between buttons.

### 3. Clicky Button
**Clicky Button** is a call-to-action button that dynamically links to a specific post or page within your WordPress site, rather than using a hardcoded URL.

- **Features:**
  - Link directly to any post or page by selecting it in the editor.
  - Customizable background and text colors (including gradients).
  - Adjustable padding for the button.
  - Must be placed inside a **Clicky Group**.

## Development

### Prerequisites
- Node.js and npm
- A WordPress installation (local environment like Local WP or DevKinsta is recommended)

### Installation
1. Clone the repository into your WordPress `wp-content/plugins/` directory.
2. Run `npm install` to install dependencies.
3. Run `npm start` to start the development server with file watching.
4. Run `npm run build` to create a production-ready build.

### Building for Production
To generate the final assets for the plugin:
```bash
npm run build
```

## License
This project is licensed under the GPL-2.0-or-later License.
