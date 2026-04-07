# Elementor Mobile Carousel Widget

A lightweight WordPress plugin that adds a custom Elementor widget for **mobile-first content carousels**.

The widget renders cards as a Swiper carousel on mobile devices and falls back to a simple multi-column grid on larger screens.

## Features

- Custom Elementor widget: **Mobile Carousel**.
- Separate Elementor category: **EMC Widgets**.
- Mobile carousel controls:
  - autoplay + delay
  - arrows
  - pagination bullets
  - loop mode
  - pause on hover
- Adjustable layout settings:
  - mobile breakpoint
  - slides per view
  - spacing between slides
- Repeater-based card content:
  - title
  - text
  - button text + link
- Style controls in Elementor:
  - card background
  - title color
  - text color
  - typography for title and text
- Graceful desktop behavior: cards are displayed as a grid when viewport is above mobile breakpoint.

## Requirements

- WordPress
- Elementor (required plugin dependency)
- PHP compatible with your WordPress/Elementor setup

> If Elementor is not active, the plugin shows an admin warning and does not register the widget.

## Installation

1. Place the plugin folder in your WordPress plugins directory:
   - `wp-content/plugins/elementor-mobile-content-carousel`
2. Activate the plugin in **WordPress Admin → Plugins**.
3. Ensure Elementor is installed and active.

## Usage

1. Open a page with Elementor.
2. Find widget category **EMC Widgets**.
3. Drag **Mobile Carousel** onto the page.
4. Add/edit slides in the **Slides** repeater.
5. Configure behavior in **Settings**:
   - Mobile max width
   - Slides per view
   - Space between
   - Autoplay + delay
   - Arrows
   - Pagination
   - Loop
   - Pause on hover
6. Adjust card appearance in the **Card** style section.

## How it works

- Plugin bootstrap file:
  - checks Elementor availability
  - registers scripts/styles
  - registers custom Elementor category and widget class
- Frontend stack:
  - Swiper 11 loaded from jsDelivr CDN
  - custom JS initializes Swiper only on mobile breakpoint
  - custom CSS styles card UI, nav, bullets, and desktop fallback grid

## Project structure

```text
.
├── elementor-mobile-carousel.php
├── assets/
│   ├── widget.css
│   └── widget.js
└── widgets/
    └── class-emc-mobile-carousel-widget.php
```

## Notes

- Widget assets are registered through `wp_enqueue_scripts` and loaded via Elementor dependency methods (`get_style_depends`, `get_script_depends`).
- Slides content is escaped (`esc_html`, `esc_url`) during rendering.
- External button links use `target="_blank"` with `rel="noopener noreferrer"`.

## Version

Current plugin version: **1.0.0**.
