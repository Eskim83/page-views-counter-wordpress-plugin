<?php
defined('ABSPATH') || exit;

/**
 * Attempts to retrieve the user's real IP address.
 *
 * This function checks common HTTP headers in order of priority
 * to account for proxies, load balancers, and services like Cloudflare.
 * It handles multiple forwarded IPs by returning the last one in the list,
 * which typically represents the user's original IP.
 *
 * @return string The resolved IP address, or 'unknown' if not found.
 */
function evc_get_user_ip(): string {
    // Common HTTP headers that may contain the client's real IP
    $keys = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'];

    foreach ($keys as $key) {
        if (!empty($_SERVER[$key])) {
            // Handle multiple IPs (e.g., "client, proxy1, proxy2")
            $ipList = explode(',', $_SERVER[$key]);

            // Return the last IP in the chain (most likely real client IP)
            return trim(end($ipList));
        }
    }

    // Fallback if no IP detected
    return 'unknown';
}
