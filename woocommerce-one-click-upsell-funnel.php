<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @package woo_one_click_upsell_funnel
 * @link    https://makewebbetter.com/
 * @since   1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:       One Click Upsell Funnel for Woocommerce
 * Plugin URI:        https://wordpress.org/plugins/woo-one-click-upsell-funnel/
 * Description:       Increases your woocommerce store sales instantly by showing special offers on purchased products after checkout. Offer products are purchased in a single click with Combined order. Elementor integration : Now with Built in Offer templates with Sandbox View and Edit functionality with Elementor.
 * Version:           2.0.2
 *
 * Requires at least:     4.4
 * Tested up to:          5.2.3
 * WC requires at least:  3.0
 * WC tested up to:       3.7.0
 *
 * Author:            MakeWebBetter
 * Author URI:        https://makewebbetter.com/
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       woocommerce_one_click_upsell_funnel
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is for woocommerce dependency check.
 */
function mwb_upsell_lite_plugin_activation() {
	$activation['status'] = true;
	$activation['message'] = '';

	include_once ABSPATH . 'wp-admin/includes/plugin.php';

	// Dependant plugin.
	if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {

		$activation['status'] = false;
		$activation['message'] = 'woo_inactive';

	}

	return $activation;
}

$mwb_upsell_lite_plugin_activation = mwb_upsell_lite_plugin_activation();

if ( true === $mwb_upsell_lite_plugin_activation['status'] ) {

	// If pro plugin active, load nothing.
	if ( is_plugin_active( 'woocommerce-one-click-upsell-funnel-pro/woocommerce-one-click-upsell-funnel-pro.php' ) ) {

		return;

	}

	define( 'MWB_WOCUF_URL', plugin_dir_url( __FILE__ ) );

	define( 'MWB_WOCUF_DIRPATH', plugin_dir_path( __FILE__ ) );

	define( 'MWB_WOCUF_VERSION', '2.0.2' );


	/**
	 * The code that runs during plugin activation.
	 * This action is documented in includes/class-woocommerce_one_click_upsell_funnel_pro-activator.php
	 */
	function activate_woocommerce_one_click_upsell_funnel() {
		include_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-one-click-upsell-funnel-activator.php';
		Woocommerce_one_click_upsell_funnel_Activator::activate();
	}

	/**
	 * The code that runs during plugin deactivation.
	 * This action is documented in includes/class-woocommerce_one_click_upsell_funnel_pro-deactivator.php
	 */
	function deactivate_woocommerce_one_click_upsell_funnel() {
		include_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-one-click-upsell-funnel-deactivator.php';
		woocommerce_one_click_upsell_funnel_Deactivator::deactivate();
	}

	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'mwb_wocuf_plugin_settings_link' );

	/**
	 * This action is for woocommerce dependency check.
	 */
	function mwb_wocuf_plugin_settings_link( $links ) {

		$plugin_links = array(
			'<a href="' .
						admin_url( 'admin.php?page=mwb-wocuf-setting&tab=overview' ) .
						'">' . __( 'Settings', 'woocommerce_one_click_upsell_funnel' ) . '</a>',
		);
		return array_merge( $plugin_links, $links );
	}

	add_filter( 'plugin_row_meta', 'mwb_upsell_lite_add_doc_and_premium_link', 10, 2 );

	/**
	 * This action is for add premium version link.
	 */
	function mwb_upsell_lite_add_doc_and_premium_link( $links, $file ) {
		if ( false !== strpos( $file, 'woocommerce_one_click_upsell_funnel.php' ) ) {

			$row_meta = array(
				'docs'    => '<a target="_blank" style="color:#FFF;background:linear-gradient(to right,#7a28ff 0,#00a1ff 100%);padding:5px;border-radius:6px;" href="https://docs.makewebbetter.com/woocommerce-one-click-upsell-funnel/">' . esc_html__( 'Go to Docs', 'woocommerce_one_click_upsell_funnel' ) . '</a>',
				'goPro' => '<a target="_blank" style="color:#FFF;background:linear-gradient(to right,#45b649,#dce35b);padding:5px;border-radius:6px;" href="https://makewebbetter.com/product/woocommerce-one-click-upsell-funnel-pro/?utm_source=MWB-upsell-org&utm_medium=Pro-Row&utm_campaign=ORG"><strong>' . esc_html__( 'Go Premium', 'woocommerce_one_click_upsell_funnel' ) . '</strong></a>',
			);

			return array_merge( $links, $row_meta );
		}

		return (array) $links;
	}

	register_activation_hook( __FILE__, 'activate_woocommerce_one_click_upsell_funnel' );

	register_deactivation_hook( __FILE__, 'deactivate_woocommerce_one_click_upsell_funnel' );

	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and public-facing site hooks.
	 */
	include plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-one-click-upsell-funnel.php';

	/**
	 * Begins execution of the plugin.
	 *
	 * Since everything within the plugin is registered via hooks,
	 * then kicking off the plugin from this point in the file does
	 * not affect the page life cycle.
	 *
	 * @since 1.0.0
	 */
	function run_woocommerce_one_click_upsell_funnel() {

		$plugin = new Woocommerce_one_click_upsell_funnel();
		$plugin->run();

	}

	run_woocommerce_one_click_upsell_funnel();
} else {

	// Deactivation of plugin at dependency failed.
	add_action( 'admin_init', 'mwb_upsell_lite_plugin_activation_failure' );

	/**
	 * Deactivate this plugin.
	 */
	function mwb_upsell_lite_plugin_activation_failure() {

		deactivate_plugins( plugin_basename( __FILE__ ) );
	}

	// Add admin error notice.
	add_action( 'admin_notices', 'mwb_upsell_lite_plugin_activation_admin_notice' );

	/**
	 * This function is used to display plugin activation error notice.
	 */
	function mwb_upsell_lite_plugin_activation_admin_notice() {

		global $mwb_upsell_lite_plugin_activation;

		// To hide Plugin activated notice.
		unset( $_GET['activate'] );

		?>

		<?php if ( 'woo_inactive' == $mwb_upsell_lite_plugin_activation['message'] ) : ?>

			<div class="notice notice-error is-dismissible">
				<p><strong><?php esc_html_e( 'WooCommerce' ); ?></strong><?php esc_html_e( ' is not activated, Please activate WooCommerce first to activate ' ); ?><strong><?php esc_html_e( 'One Click Upsell Funnel for WooCommerce' ); ?></strong><?php esc_html_e( '.' ); ?></p>
			</div>

		<?php endif;
	}
}

?>
