<?php

namespace WPDebugLogEnforcer;

class LogHelper {
	/**
	 * Write data to debug.log with file + line info (correct caller)
	 *
	 * @param  object|array|string  $log
	 */
	public static function write( object|array|string $log ): void {
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG === true ) {
			$file = WP_CONTENT_DIR . '/debug.log';

			// Convert arrays/objects to string
			if ( is_array( $log ) || is_object( $log ) ) {
				$log = print_r( $log, true );
			}

			// Get caller (skip self, look at the function that called write_log)
			$trace  = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 2 );
			$caller = isset( $trace[1]['file'], $trace[1]['line'] )
				? basename( $trace[1]['file'] ) . ':' . $trace[1]['line']
				: 'unknown';

			// Clean duplicate WP timestamp if exists
			$log = preg_replace( '/^\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\]\s*/', '', $log );

			// Format log line
			$formatted = sprintf(
				"[%s] [%s] %s\n",
				gmdate( 'd-M-Y H:i:s \U\T\C' ),
				$caller,
				$log
			);

			file_put_contents( $file, $formatted, FILE_APPEND );
		}
	}
}
