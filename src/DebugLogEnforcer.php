<?php
namespace WPDebugLogEnforcer;

/**
 * Ensures PHP/WordPress errors are logged into debug.log.
 */
class DebugLogEnforcer {

	private string $log_file;

	public function __construct() {
		$this->log_file = WP_CONTENT_DIR . '/debug.log';

		// Try to enforce logging
		@ini_set( 'log_errors', 'On' );//phpcs:ignore
		@ini_set( 'error_log', $this->log_file );//phpcs:ignore

		// Capture shutdown fatal errors
		add_action( 'shutdown', array( $this, 'log_last_error' ) );

		// Capture WP handled errors
		add_action( 'wp_php_error', array( $this, 'log_wp_php_error' ), 10, 4 );
	}

	public function log_last_error(): void {
		$error = error_get_last();
		if ( null !== $error ) {
			LogHelper::write(
				sprintf(
					'[%s] %s: %s in %s on line %d',
					date( 'Y-m-d H:i:s' ),//phpcs:ignore
					$this->map_error_type( $error['type'] ),
					$error['message'],
					$error['file'],
					$error['line']
				)
			);
		}
	}

	public function log_wp_php_error( $error, $error_string, $filename, $line ): void {
		LogHelper::write(
			sprintf(
				'[%s] WP Error: %s in %s on line %d',
				date( 'Y-m-d H:i:s' ),//phpcs:ignore
				$error_string,
				$filename,
				$line
			)
		);
	}

	private function map_error_type( int $type ): string {
		return match ( $type ) {
			E_ERROR             => 'Fatal Error',
			E_WARNING           => 'Warning',
			E_PARSE             => 'Parse Error',
			E_NOTICE            => 'Notice',
			E_CORE_ERROR        => 'Core Error',
			E_CORE_WARNING      => 'Core Warning',
			E_COMPILE_ERROR     => 'Compile Error',
			E_COMPILE_WARNING   => 'Compile Warning',
			E_USER_ERROR        => 'User Error',
			E_USER_WARNING      => 'User Warning',
			E_USER_NOTICE       => 'User Notice',
			E_STRICT            => 'Strict Notice',
			E_RECOVERABLE_ERROR => 'Recoverable Error',
			E_DEPRECATED        => 'Deprecated',
			E_USER_DEPRECATED   => 'User Deprecated',
			default             => 'Unknown Error',
		};
	}
}
