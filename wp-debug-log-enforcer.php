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
use WPDebugLogEnforcer\LogHelper;
use WPDebugLogEnforcer\MailLogger;

/**
 * Global helper function for convenience.
 * This is loaded on every page because the main plugin file is always executed.
 */
if ( ! function_exists( 'write_log' ) ) {
	function write_log( $log ): void {
		LogHelper::write( $log );
	}
}

// Initialize core classes
new DebugLogEnforcer();
new MailLogger();
