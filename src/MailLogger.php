<?php

namespace WPDebugLogEnforcer;

/**
 * Logs failed wp_mail() attempts.
 */
class MailLogger {

	public function __construct() {
		add_action( 'wp_mail_failed', array( $this, 'log_failed_mail' ), 10, 1 );
	}

	/**
	 * Log WP mail failure errors.
	 *
	 * @param  \WP_Error  $wp_error
	 */
	public function log_failed_mail( $wp_error ): void {
		if ( function_exists( 'write_log' ) ) {
			write_log( $wp_error );
		} else {
			error_log( print_r( $wp_error, true ) );
		}
	}
}
