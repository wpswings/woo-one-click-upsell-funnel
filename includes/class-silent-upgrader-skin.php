<?php
/**
 * Silent upgrader skin to suppress output during plugin installs.
 *
 * @package woo_one_click_upsell_funnel
 */

if ( ! class_exists( 'Silent_Upgrader_Skin' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

	/**
	 * Upgrader skin that silences feedback output.
	 */
	class Silent_Upgrader_Skin extends WP_Upgrader_Skin {

		/**
		 * Override feedback to suppress output.
		 *
		 * @param string $string Message string.
		 * @param mixed  ...$args Additional arguments.
		 */
		public function feedback( $string, ...$args ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
			// Intentionally left blank to silence output.
		}
	}
}
