# Eskim Views Counter

A lightweight and extensible WordPress plugin that tracks post/page views.  
Includes bot filtering, IP-based throttling, transient caching, and a flexible shortcode for display.  
Perfect for lightweight analytics or engagement indicators.

🔖 Version: 2.0  
📚 Version 1.0 (article in Polish): [Licznik wyświetleń strony w WordPress](https://eskim.pl/licznik-wyswietlen-strony-w-wordpress/)  
🌍 Author's website: https://eskim.pl  
☕ Donate: https://buymeacoffee.com/eskim  
📜 License: GNU GPL v2.0

---

## ✅ Features

* Fast and lightweight view counter
* Stores counts in custom DB table
* Filters known bots and crawlers
* Throttles by IP (default: 1 view per 2h per post)
* Shortcode to display view count
* Compatible with PHP 8.0+

---

## 🛠️ Installation

1. Upload the plugin folder to `/wp-content/plugins/`
2. Activate the plugin in the WordPress admin
3. No configuration required – it works out of the box

---

## 📊 Usage

### Display views in post/page content:

Add this shortcode anywhere in post content:

```
[eskim_views]
```

It will display the total number of views for the current post or page.

### Display via PHP (e.g. theme template):

```php
echo evc_get_views(get_the_ID());
```

---

## 🗃️ Changelog

### 2.0.0

* Modular file structure
* Improved compatibility with PHP 8+
* IP-based throttling (2h by default)
* Removed legacy widget support
* Clean English comments and docstrings

### 1.0.0

* Initial version with simple view counter
* Tutorial: [https://eskim.pl/licznik-wyswietlen-strony-w-wordpress/](https://eskim.pl/licznik-wyswietlen-strony-w-wordpress/)

---

## 🔮 Planned Features

A list of planned improvements and features for the `[eskim_views]` shortcode:

- [ ] Support for `post_id` attribute (display views for a specific post)
- [ ] Support for `before` and `after` text/HTML wrappers
- [ ] Fallback output when `post_id` is missing (`default` attribute)
- [ ] `format` attribute (`raw` vs `formatted` output)
- [ ] Restrict output to specific `post_type` using `allowed_types`
- [ ] Conditional rendering: `user_logged_in_only`, `exclude_logged_in`
- [ ] Cache the final rendered output for performance
- [ ] Native Gutenberg block (using `render_callback`)
