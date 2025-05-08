<?php
defined('ABSPATH') || exit;

/**
 * Checks whether the current user's IP has already triggered a view count
 * for the given post within a defined time window (throttling).
 *
 * Uses a transient key based on post ID and user IP (hashed).
 *
 * @param int $postId The ID of the post being viewed.
 * @return bool True if the IP is currently throttled for this post.
 */
function evc_is_ip_limited(int $postId): bool {
    $ip = evc_get_user_ip();

    // Create a unique cache key based on post ID and IP address
    $lock_key = "evc_viewed_{$postId}_" . md5($ip);

    // If the transient exists, the IP is still in cooldown
    return get_transient($lock_key) !== false;
}

/**
 * Locks the current user's IP for a specific post to prevent repeated
 * view counting during the cooldown window.
 *
 * Stores a transient (cache entry) that acts as a time-based lock.
 *
 * @param int $postId The ID of the post being viewed.
 * @param int $duration Lock duration in seconds (default: 7200 = 2 hours).
 * @return void
 */
function evc_lock_ip_for_post(int $postId, int $duration = 7200): void {
    $ip = evc_get_user_ip();

    // Generate the same key used for throttling
    $lock_key = "evc_viewed_{$postId}_" . md5($ip);

    // Save a transient to throttle this IP for this post
    set_transient($lock_key, true, $duration);
}
