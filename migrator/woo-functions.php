<?php
/**
 * The db-specific functionality of the plugin.
 *
 * @link       https://wpswings.com/?utm_source=wpswings-official&utm_medium=upsell-org-backend&utm_campaign=official
 * @since      1.0.0
 *
 * @package     woo_one_click_upsell_funnel
 * @subpackage  woo_one_click_upsell_funnel/migrator
 */

/**
 * Execute wpdb query.
 *
 * @param  string $query Query to be executed.
 */
function wps_wocuf_execute_db_query( $query ) {
	global $wpdb;
	$wpdb->query( $query ); // @codingStandardsIgnoreLine.
}


/**
 * Check for all the options saved via current crm plugin.
 *
 * @return array
 */
function wps_wocuf_get_saved_options() {

	global $wpdb;
	$table_name = $wpdb->prefix . 'options';
	$sql        = "SELECT * FROM `$table_name` WHERE `option_name` LIKE '%mwb_wocuf%' OR `option_name` LIKE '%mwb_upsell%'";

	return $wpdb->get_results( $sql, ARRAY_A );
}

/**
 * Check for all the options saved via current crm plugin.
 *
 * @return array
 */
function wps_wocuf_get_saved_post_meta() {

	global $wpdb;

	$table_name = $wpdb->prefix . 'postmeta';
	$sql        = "SELECT * FROM `$table_name` WHERE `meta_key` LIKE '%mwb_wocuf%' OR `meta_key` LIKE '%mwb_upsell%'";

	return $wpdb->get_results( $sql, ARRAY_A );
}

/**
 * Get query results from database
 *
 * @param  string $query Query to be executed.
 * @return array         Result data.
 */
function wps_wocuf_get_query_results( $query ) {
	global $wpdb;
	$result = $wpdb->get_results( $query, ARRAY_A ); // @codingStandardsIgnoreLine.
	return $result;
}
