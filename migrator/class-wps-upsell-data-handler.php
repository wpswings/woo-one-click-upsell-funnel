<?php
/**
 * Fired during plugin activation
 *
 * @link       https://wpswings.com
 * @since      1.0.0
 *
 * @package    Integration_With_Quickbooks
 * @subpackage Integration_With_Quickbooks/includes/migrator
 */

/**
 * Fired during plugin migration.
 *
 * This class defines all code necessary to run during the plugin's migration.
 *
 * @since      1.0.0
 * @package    Integration_With_Quickbooks
 * @subpackage Integration_With_Quickbooks/includes/migrator
 */
class WPS_Upsell_Data_Handler {

	/**
	 * Define the core functionality of the migrator.
	 *
	 * @since    1.0.4
	 */
	public function __construct() {
	}

	/**
	 * Replacement for WordPress native get option.
	 * Serves for new meta keys only.
	 *
	 * @param string $option_name   The option name.
	 * @param string $def_value     The default option value.
	 *
	 * @since     1.0.4
	 */
	public static function get_option( $option_name = false, $def_value = false ) {

		if ( empty( $option_name ) ) {
			return false;
		}

		// Key doesn't contains wps as new key.
		if ( false !== strpos( 'wps', $option_name ) ) {
			return get_option( $option_name, $def_value );
		}

		// Just in case WPS key exists.
		$option_value = get_option( $option_name );
		if ( ! empty( $option_value ) ) {
			return $option_value;
		}

		// WPS not found! Fetch from OLD saved key.
		if ( empty( $option_value ) ) {

			// prepare same key as old one.
			$mwb_option_name  = str_replace( 'wps', 'mwb', $option_name );
			$mwb_option_value = get_option( $mwb_option_name );

			// Update the same value to wps key.
			if ( ! empty( $mwb_option_value ) ) {
				update_option( $option_name, $mwb_option_value );
				delete_option( $mwb_option_name );
			}

			// return saved value.
			return get_option( $option_name, $def_value );
		}
	}

	/**
	 * Replacement for WordPress native delete option.
	 *
	 * @param string $option_name   The option name.
	 *
	 * @since     1.0.4
	 */
	public static function delete_option( $option_name = false ) {

		if ( empty( $option_name ) ) {
			return false;
		}

		$mwb_option_name = str_replace( 'wps', 'mwb', $option_name );

		delete_option( $option_name );
		delete_option( $mwb_option_name );
	}

	/**
	 * Replacement for WordPress native get post meta.
	 * Serves for new meta keys only.
	 *
	 * @param string $post_id   The post id.
	 * @param string $meta_key  The post meta key.
	 *
	 * @since     1.0.4
	 */
	public static function get_post_meta( $post_id = false, $meta_key = false ) {

		if ( empty( $meta_key ) ) {
			return false;
		}

		// Key doesn't contains wps as a key.
		if ( false !== strpos( 'wps', $meta_key ) ) {
			return get_post_meta( $post_id, $meta_key, true );
		}

		// Just in case WPS key exists.
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		if ( ! empty( $meta_value ) ) {
			return $meta_value;
		}

		// WPS not found! Fetch from OLD saved key.
		if ( empty( $meta_value ) ) {

			// prepare same key as old.
			$mwb_meta_key   = str_replace( 'wps', 'mwb', $meta_key );
			$mwb_meta_value = get_post_meta( $post_id, $mwb_meta_key, true );

			// Update the same value to wps key.
			if ( ! empty( $mwb_meta_value ) ) {
				update_post_meta( $post_id, $meta_key, $mwb_meta_value );
				delete_post_meta( $post_id, $mwb_meta_key );
			}

			// return saved value.
			return get_post_meta( $post_id, $meta_key, true );
		}
	}

	/**
	 * Replacement for tables to WPS.
	 *
	 * @since     1.0.4
	 */
	public function migrate_tables() {

		global $wpdb;
		$crm_log_table = $wpdb->prefix . 'mwb_woo_quickbooks_log';

		// If exists true.
		if ( 'exists' === wps_woo_crm_log_table_exists( $crm_log_table ) ) {
			$sql = 'ALTER TABLE `wp_mwb_woo_quickbooks_log` RENAME TO `wp_wps_woo_quickbooks_log`';
			wps_woo_crm_execute_db_query( $sql );
		}
	}

	/**
	 * Replacement for Feeds to WPS.
	 *
	 * @since     1.0.4
	 */
	public function migrate_feeds() {
		$all_feeds = get_posts(
			array(
				'post_type'      => 'mwb_quickbooks_feed',
				'post_status'    => array( 'publish', 'draft' ),
				'fields'         => 'ids',
				'posts_per_page' => -1,
			)
		);

		if ( ! empty( $all_feeds ) && is_array( $all_feeds ) ) {
			foreach ( $all_feeds as $key => $feed_id ) {
				$args = array(
					'ID'        => $feed_id,
					'post_type' => 'wps_quickbooks_feed',
				);
				wp_update_post( $args );
			}
		}
	}

	// End of class.
}
