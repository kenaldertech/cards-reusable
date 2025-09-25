# Cards Reusable 

**Contributors:** kenaldertech  
**Author:** [Kenneth Alvarenga](https://kennethalvarenga.com)  
**Tags:** cards, reusable, shortcode, custom post type, ui, categories  
**Requires at least:** 5.0  
**Tested up to:** 6.8  
**Stable tag:** 1.1  
**License:** GPL2+  
**License URI:** [GNU GPL 2.0](https://www.gnu.org/licenses/gpl-2.0.html)

---

## Description

Cards Reusable is a flexible WordPress plugin that lets you create reusable sets of cards with **icon, title, and subtitle**.  
You can display them **by ID or by category** for maximum flexibility.

### ✨ Features
- Create **Card Sets** via a custom post type.
- Each card supports:
  - Icon (emoji or Dashicon class).
  - Title.
  - Subtitle/description.
  - Custom background color.
- Display cards anywhere with shortcodes:
  - `[cards_set id="12,13,14"]` → specific cards by IDs.
  - `[cards_set category="seo"]` → all cards from a category.
- Responsive grid design.
- Hover effects and clean UI.

---

## Installation

1. Upload the `reusable-cards` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the **Plugins** menu in WordPress.
3. A new menu item **Cards** will appear in the admin dashboard.
4. Create cards and assign them categories.
5. Insert the shortcode `[cards_set category="seo"]` or `[cards_set id="12,13,14"]` into any page or post.

---

## Frequently Asked Questions

### Can I display multiple cards at once?
Yes, you can pass multiple IDs separated by commas, or use a category to group them.

### Can I customize the design?
Yes, you can override the CSS in your theme or enqueue your own stylesheet.

### Is it mobile-friendly?
Yes, the cards grid is fully responsive.

---

## Screenshots

1. Admin view of a card with icon, subtitle, and background color.  
2. Cards displayed in a responsive grid with icons and text.  
3. Example of cards grouped by category.  

---

## Changelog

### 1.1
- Added category support in shortcode `[cards_set category="name"]`.

### 1.0
- Initial release.  
- Custom Post Type **Cards**.  
- Shortcode `[cards_set id="123"]`.  
- Responsive grid layout.

---

## Upgrade Notice

### 1.1
You can now display cards by **category**, making it easier to manage large sets.
