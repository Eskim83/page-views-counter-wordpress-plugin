<?php
defined('ABSPATH') || exit;

/**
 * Retrieves the current view count for a given post ID.
 * Uses transient caching to reduce database queries.
 *
 * @param int $postId The ID of the post.
 * @return int The number of views.
 */
function evc_get_views(int $postId): int {
    // Try to fetch the view count from cache
    $cached = get_transient("evc_views_$postId");
    if ($cached !== false) return (int) $cached;

    // Fallback to database if cache is expired or missing
    global $wpdb;
    $table = $wpdb->prefix . 'eskim_pl_post_count';

    $views = $wpdb->get_var($wpdb->prepare(
        "SELECT views FROM $table WHERE postId = %d", $postId
    ));

    // Ensure views is always an integer
    $views = (int) ($views ?? 0);

    // Store the result in cache for 60 seconds
    set_transient("evc_views_$postId", $views, 60);

    return $views;
}

/**
 * Updates or inserts the view count for a given post ID.
 * Also updates the transient cache.
 *
 * @param int $postId The ID of the post.
 * @param int $views The new number of views to store.
 */
function evc_set_views(int $postId, int $views): void {
    global $wpdb;
    $table = $wpdb->prefix . 'eskim_pl_post_count';

    // Check if the post already exists in the table
    $exists = $wpdb->get_var($wpdb->prepare(
        "SELECT 1 FROM $table WHERE postId = %d", $postId
    ));

    // Update or insert accordingly
    if ($exists) {
        $wpdb->update($table, ['views' => $views], ['postId' => $postId]);
    } else {
        $wpdb->insert($table, ['postId' => $postId, 'views' => $views]);
    }

    // Update cache
    set_transient("evc_views_$postId", $views, 60);
}

/**
 * Handles a single view event: triggered in wp_footer on singular content.
 * Filters out admin users, bots, and repeated IPs (within throttling window).
 */
function evc_handle_view(): void {
    // Only run on single posts/pages on the frontend
    if (!is_singular() || is_admin()) return;

    // Skip bots
    if (evc_is_bot()) return;

    // Get current post ID
    $postId = get_the_ID();
    if (!$postId || evc_is_ip_limited($postId)) return;

    // Lock this IP from incrementing again within the throttling window
    evc_lock_ip_for_post($postId);

    // Get and increment the current view count
    $views = evc_get_views($postId);
    evc_set_views($postId, $views + 1);
}
