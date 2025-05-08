<?php
defined('ABSPATH') || exit;

/**
 * Runs during plugin activation.
 * Creates the database table used to store view counts per post.
 *
 * Uses dbDelta() for safe table creation, allowing for upgrades.
 *
 * Table schema:
 * - postId: Primary key, links to WordPress post ID
 * - views: Number of views (unsigned integer)
 *
 * @return void
 */
function evc_install(): void {
    global $wpdb;
    $table = $wpdb->prefix . 'eskim_pl_post_count';

    // SQL query to create the views table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS $table (
        postId BIGINT(20) UNSIGNED NOT NULL,
        views BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
        PRIMARY KEY (postId)
    ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;";

    // Include dbDelta function if not already loaded
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    // Execute table creation (or upgrade if needed)
    dbDelta($sql);
}

/**
 * Runs during plugin uninstall.
 * Drops the custom table to clean up the database.
 *
 * @return void
 */
function evc_uninstall(): void {
    global $wpdb;
    $table = $wpdb->prefix . 'eskim_pl_post_count';

    // Remove the table permanently
    $wpdb->query("DROP TABLE IF EXISTS $table");
}
