<?php
defined('ABSPATH') || exit;

/**
 * Checks if the current request comes from a known bot or crawler.
 *
 * This function analyzes the HTTP User-Agent string and matches it
 * against a list of common bot/crawler keywords. If a match is found,
 * it returns true, preventing that view from being counted.
 *
 * @return bool True if the user agent is identified as a bot, false otherwise.
 */
function evc_is_bot(): bool {
    // List of common bot/crawler signatures found in User-Agent headers
    $bots = [
        'bot', 'crawl', 'slurp', 'spider', 'curl',
        'wget', 'python', 'libwww', 'archive', 'monitor', 'headless'
    ];

    // Retrieve and normalize the user agent string
    $userAgent = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');

    // Check if any known bot substring appears in the User-Agent
    foreach ($bots as $bot) {
        if (str_contains($userAgent, $bot)) {
            return true;
        }
    }

    return false;
}
