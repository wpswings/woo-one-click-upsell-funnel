<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Fired during plugin activation
 *
 * @link       https://wpswings.com/
 * @since      1.0.0
 *
 * @package     woo_one_click_upsell_funnel
 * @subpackage woo_one_click_upsell_funnel/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package     woo_one_click_upsell_funnel
 * @subpackage woo_one_click_upsell_funnel/includes
 * @author     wpswings <webmaster@wpswings.com>
 */
class Wpswocuf_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		/**
		 * Generating default offer page at the time of plugin activation
		 */
		$wpswocuf_pro_offer_default_page_id = get_option( 'wpswocuf_pro_funnel_default_offer_page', '' );

		// For WordPress 5 and + versions, Guttenberg content will be used for default offer page.
		$post_content = '5' <= get_bloginfo( 'version' ) ? wpswocuf_upsell_lite_gutenberg_offer_content() : '[wpswocuf_pro_funnel_default_offer_page]';

		if ( empty( $wpswocuf_pro_offer_default_page_id ) || 'publish' !== get_post_status( $wpswocuf_pro_offer_default_page_id ) ) {
			$wpswocuf_pro_funnel_page = array(
				'comment_status' => 'closed',
				'ping_status'    => 'closed',
				'post_content'   => $post_content,
				'post_name'      => 'special-offer',
				'post_status'    => 'publish',
				'post_title'     => 'Special Offer',
				'post_type'      => 'page',
			);

			$wpswocuf_pro_post = wp_insert_post( $wpswocuf_pro_funnel_page );

			update_option( 'wpswocuf_pro_funnel_default_offer_page', $wpswocuf_pro_post );
		}

		// Schedule cron for Order payment process If redirected for upsell and still pending.
		if ( ! wp_next_scheduled( 'wpswocuf_lite_order_cron_schedule' ) ) {

			wp_schedule_event( time(), 'wpswocuf_twenty_minutes', 'wpswocuf_lite_order_cron_schedule' );
		}

		// Set default settings tab to Overview for five minutes.
		set_transient( 'wpswocuf_upsell_default_settings_tab', 'overview', 300 );
	}
}
if ( ! class_exists( 'Woocommerce_One_Click_Upsell_Funnel_Activator' ) ) {
	class_alias( 'Wpswocuf_Activator', 'Woocommerce_One_Click_Upsell_Funnel_Activator' );
}
