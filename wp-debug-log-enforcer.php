<?php
/**
 * Plugin Name: WP Debug Log Enforcer
 * Description: Ensures all PHP errors, WP errors, and mail failures are written into wp-content/debug.log
 * Version: 1.2.0
 * Author: Imtiaz Epu
 * License: GPL-2.0-or-later
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require __DIR__ . '/vendor/autoload.php';

use WPDebugLogEnforcer\DebugLogEnforcer;
use WPDebugLogEnforcer\MailLogger;

// Initialize core classes
new DebugLogEnforcer();
new MailLogger();
