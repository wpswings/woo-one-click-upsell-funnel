<?php
/**
 * Fired during plugin deactivation
 *
 * @link       https://wpswings.com/
 * @since      1.0.0
 *
 * @package     woo_one_click_upsell_funnel
 * @subpackage woo_one_click_upsell_funnel/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package     woo_one_click_upsell_funnel
 * @subpackage woo_one_click_upsell_funnel/includes
 * @author     wpswings <webmaster@wpswings.com>
 */
class Woocommerce_One_Click_Upsell_Funnel_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		// Clear scheduled cron for User update.
		if ( wp_next_scheduled( 'wps_wocuf_lite_order_cron_schedule' ) ) {

			wp_clear_scheduled_hook( 'wps_wocuf_lite_order_cron_schedule' );
		}

		// Clear scheduled cron for User update.
		if ( wp_next_scheduled( 'wps_wocuf_lite_order_cron_schedule' ) ) {

			wp_clear_scheduled_hook( 'wps_wocuf_lite_order_cron_schedule' );
		}

	}

}
