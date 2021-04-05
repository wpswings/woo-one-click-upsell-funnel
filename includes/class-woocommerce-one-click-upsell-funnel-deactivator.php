<?php
/**
 * Fired during plugin deactivation
 *
 * @link       http://makewebbetter.com/
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
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class woocommerce_one_click_upsell_funnel_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		// Clear scheduled cron for User update.
		if ( wp_next_scheduled( 'mwb_wocuf_lite_order_cron_schedule' ) ) {

			wp_clear_scheduled_hook( 'mwb_wocuf_lite_order_cron_schedule' );
		}

	}

}
