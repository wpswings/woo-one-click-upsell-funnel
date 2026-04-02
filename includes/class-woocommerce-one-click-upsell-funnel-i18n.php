<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://wpswings.com/
 * @since      1.0.0
 *
 * @package     woo_one_click_upsell_funnel
 * @subpackage woo_one_click_upsell_funnel/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package     woo_one_click_upsell_funnel
 * @subpackage woo_one_click_upsell_funnel/includes
 * @author     wpswings <webmaster@wpswings.com>
 */
class Wpswocuf_I18n {
	// phpcs:ignore


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		// WordPress loads language files automatically since WP 4.6; explicit call discouraged.
		return;
	}
}
if ( ! class_exists( 'Woocommerce_One_Click_Upsell_Funnel_I18n' ) ) {
	class_alias( 'Wpswocuf_I18n', 'Woocommerce_One_Click_Upsell_Funnel_I18n' );
}
