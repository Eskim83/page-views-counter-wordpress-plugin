<?php
/**
 * Plugin Name:       Eskim Views Counter
 * Plugin URI:        https://eskim.pl/licznik-wyswietlen-strony-w-wordpress/
 * Description:       Counts page views with caching, bot filtering, IP throttling, and a shortcode for display.
 * Version:           2.0.0
 * Requires at least: 5.8
 * Requires PHP:      8.0
 * Author:            eskimpl
 * Author URI:        https://eskim.pl
 * License:           GPL v3 or later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       eskim-views-counter
 * Donate link:       https://buymeacoffee.com/eskim
 */

defined('ABSPATH') || exit;

// Plugin directory constant
define('EVC_PATH', plugin_dir_path(__FILE__));

// Modular file loading
require_once EVC_PATH . 'includes/install.php';
require_once EVC_PATH . 'includes/helpers.php';
require_once EVC_PATH . 'includes/bot-filter.php';
require_once EVC_PATH . 'includes/ip-limit.php';
require_once EVC_PATH . 'includes/counter.php';
require_once EVC_PATH . 'includes/shortcode.php';

// Register activation/uninstall hooks
register_activation_hook(__FILE__, 'evc_install');
register_uninstall_hook(__FILE__, 'evc_uninstall');

// Main view handling hook
add_action('wp_footer', 'evc_handle_view');
