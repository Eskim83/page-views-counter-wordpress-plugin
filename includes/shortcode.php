<?php
defined('ABSPATH') || exit;

/**
 * Shortcode handler for [eskim_views].
 *
 * Outputs the current number of views for the post or page
 * where the shortcode is used. If used outside a loop or
 * single post/page context, it returns an empty string.
 *
 * @return string Localized number of views, or empty string if invalid context.
 */
function evc_shortcode(): string {
    $postId = get_the_ID();

    // Ensure we're in a post context
    if (!$postId) return '';

    // Retrieve and return the formatted view count
    return number_format_i18n(evc_get_views($postId));
}

// Register the shortcode [eskim_views] with WordPress
add_shortcode('eskim_views', 'evc_shortcode');
