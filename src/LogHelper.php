<?php
namespace WPDebugLogEnforcer;

/**
 * Global logging helper for WordPress projects.
 */
class LogHelper {
	/**
	 * Write data to debug.log
	 *
	 * @param string|array|object $log
	 */
	public static function write( $log ): void {
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG === true ) {
			$file = WP_CONTENT_DIR . '/debug.log';

			if ( is_array( $log ) || is_object( $log ) ) {
				error_log( print_r( $log, true ), 3, $file );
			} else {
				error_log( $log . "\n", 3, $file );
			}
		}
	}
}

// Define a global function for convenience
if ( ! function_exists( 'write_log' ) ) {
	function write_log( $log ): void {
		LogHelper::write( $log );
	}
}
