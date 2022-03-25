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
 * @link    https://wpswings.com/?utm_source=wpswings-official&utm_medium=upsell-org-backend&utm_campaign=official
 * @since   1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:           One Click Upsell Funnel for Woocommerce
 * Plugin URI:            https://wordpress.org/plugins/woo-one-click-upsell-funnel/
 * Description:           Show exclusive post-checkout offers to your customers. Create dedicated Upsell offer pages. Offers that are relevant and benefits your customers on the existing purchase and so increase Average Order Value and your Revenue.
 * Version:               3.1.4
 *
 * Requires at least:     4.4
 * Tested up to:          5.9.1
 * WC requires at least:  3.0
 * WC tested up to:       6.2.1
 *
 * Author:                WP Swings
 * Author URI:            https://wpswings.com/?utm_source=wpswings-official&utm_medium=upsell-org-backend&utm_campaign=official
 * License:               GNU General Public License v3.0
 * License URI:           http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:           woo-one-click-upsell-funnel
 * Domain Path:           /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

require_once ABSPATH . 'wp-admin/includes/plugin.php';

/**
 * Plugin Active Detection.
 *
 * @param mixed $plugin_slug plugin slug.
 */
function wps_upsell_lite_is_plugin_active( $plugin_slug ) {

	if ( empty( $plugin_slug ) ) {

		return false;
	}

	$active_plugins = (array) get_option( 'active_plugins', array() );

	if ( is_multisite() ) {

		$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );

	}

	return in_array( $plugin_slug, $active_plugins, true ) || array_key_exists( $plugin_slug, $active_plugins );

}

$old_pro_present   = false;
$installed_plugins = get_plugins();

if ( array_key_exists( 'woocommerce-one-click-upsell-funnel-pro/woocommerce-one-click-upsell-funnel-pro.php', $installed_plugins ) ) {
	$pro_plugin = $installed_plugins['woocommerce-one-click-upsell-funnel-pro/woocommerce-one-click-upsell-funnel-pro.php'];
	if ( version_compare( $pro_plugin['Version'], '3.6.6', '<' ) ) {
		$old_pro_present = true;
	}
}

if ( true === $old_pro_present ) {

	add_action( 'mwb_wocuf_pro_setting_tab_active', 'mwb_wocuf_lite_add_updatenow_notice', 0, 3 );

	/**
	 * Add update now notice.
	 *
	 * @param string $v version.
	 * @param string $f version.
	 * @param string $d version.
	 */
	function mwb_wocuf_lite_add_updatenow_notice( $v = false, $f = false, $d = false ) {
		?>
			<div class="notice notice-error is-dismissible">
				<p><?php esc_html_e( 'Your One Click Upsell Funnel Pro plugin update is here! Please Update it now via plugins page.', 'sample-text-domain' ); ?></p>
			</div>
		<?php
	}

	add_action( 'admin_notices', 'check_and_inform_update' );

	/**
	 * Check update if pro is old.
	 */
	function check_and_inform_update() {
		$update_file = plugin_dir_path( dirname( __FILE__ ) ) . 'woocommerce-one-click-upsell-funnel-pro/class-mwb-wocuf-pro-update.php';

		// If present but not active.
		if ( ! wps_upsell_lite_is_plugin_active( 'woocommerce-one-click-upsell-funnel-pro/woocommerce-one-click-upsell-funnel-pro.php' ) ) {
			if ( file_exists( $update_file ) ) {
				$mwb_wocuf_pro_license_key = get_option( 'mwb_wocuf_pro_license_key', '' );
				! defined( 'MWB_WOCUF_PRO_LICENSE_KEY' ) && define( 'MWB_WOCUF_PRO_LICENSE_KEY', $mwb_wocuf_pro_license_key );
				! defined( 'MWB_WOCUF_PRO_BASE_FILE' ) && define( 'MWB_WOCUF_PRO_BASE_FILE', 'woocommerce-one-click-upsell-funnel-pro/woocommerce-one-click-upsell-funnel-pro.php' );
			}
			require_once $update_file;
		}

		if ( defined( 'MWB_WOCUF_PRO_BASE_FILE' ) ) {
			do_action( 'mwb_wocuf_pro_check_event' );
			$is_update_fetched = get_option( 'mwb_wocuf_plugin_update', 'false' );
			$plugin_transient  = get_site_transient( 'update_plugins' );
			$update_obj        = ! empty( $plugin_transient->response[ MWB_WOCUF_PRO_BASE_FILE ] ) ? $plugin_transient->response[ MWB_WOCUF_PRO_BASE_FILE ] : false;

			if ( ! empty( $update_obj ) ) :
				?>
				<div class="notice notice-error is-dismissible">
					<p><?php esc_html_e( 'Your One Click Upsell Funnel Pro plugin update is here! Please Update it now.', 'sample-text-domain' ); ?></p>
				</div>
				<?php
			endif;
		}
	}
}

/**
 * The code that runs during plugin activation.
 * This action is for woocommerce dependency check.
 */
function wps_upsell_lite_plugin_activation() {
	$activation['status']  = true;
	$activation['message'] = '';

	// Dependant plugin.
	if ( ! wps_upsell_lite_is_plugin_active( 'woocommerce/woocommerce.php' ) ) {

		$activation['status']  = false;
		$activation['message'] = 'woo_inactive';
	}

	return $activation;
}

$wps_upsell_lite_plugin_activation = wps_upsell_lite_plugin_activation();

if ( true === $wps_upsell_lite_plugin_activation['status'] ) {

	$wps_wocuf_pro_license_key = get_option( 'wps_wocuf_pro_license_key', '' );
	$mwb_wocuf_pro_license_key = get_option( 'mwb_wocuf_pro_license_key', '' );
	$thirty_days               = get_option( 'mwb_wocuf_pro_activated_timestamp', 0 );

	if ( ! empty( $mwb_wocuf_pro_license_key ) && empty( $wps_wocuf_pro_license_key ) ) {
		update_option( 'wps_wocuf_pro_license_key', $mwb_wocuf_pro_license_key );
		update_option( 'wps_wocuf_pro_activated_timestamp', $thirty_days );
		$wps_wocuf_pro_license_key = get_option( 'wps_wocuf_pro_license_key', '' );
	}

	// If pro plugin not active, then load Org Plugin else Don't.
	if ( ! wps_upsell_lite_is_plugin_active( 'woocommerce-one-click-upsell-funnel-pro/woocommerce-one-click-upsell-funnel-pro.php' ) ) {

		define( 'WPS_WOCUF_URL', plugin_dir_url( __FILE__ ) );

		define( 'WPS_WOCUF_DIRPATH', plugin_dir_path( __FILE__ ) );

		define( 'WPS_WOCUF_VERSION', 'v3.1.4' );

		/**
		 * The code that runs during plugin activation.
		 * This action is documented in includes/class-woocommerce_one_click_upsell_funnel_pro-activator.php
		 */
		function activate_woocommerce_one_click_upsell_funnel() {
			include_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-one-click-upsell-funnel-activator.php';
			Woocommerce_One_Click_Upsell_Funnel_Activator::activate();
		}

		/**
		 * The code that runs during plugin deactivation.
		 * This action is documented in includes/class-woocommerce_one_click_upsell_funnel_pro-deactivator.php
		 */
		function deactivate_woocommerce_one_click_upsell_funnel() {
			include_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-one-click-upsell-funnel-deactivator.php';
			Woocommerce_One_Click_Upsell_Funnel_Deactivator::deactivate();
		}

		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wps_upsell_lite_plugin_settings_link' );

		/**
		 * This action is for woocommerce dependency check.
		 *
		 * @param mixed $links links.
		 */
		function wps_upsell_lite_plugin_settings_link( $links ) {

			$plugin_links = array(
				'<a href="' . admin_url( 'admin.php?page=wps-wocuf-setting&tab=overview' ) . '">' . esc_html__( 'Settings', 'woo-one-click-upsell-funnel' ) . '</a>',
			);
			return array_merge( $plugin_links, $links );
		}

		add_filter( 'plugin_row_meta', 'wps_upsell_lite_add_doc_and_premium_link', 10, 2 );

		/**
		 * This action is for add premium version link.
		 *
		 * @param mixed $links links.
		 * @param mixed $file file.
		 */
		function wps_upsell_lite_add_doc_and_premium_link( $links, $file ) {

			if ( false !== strpos( $file, 'woocommerce-one-click-upsell-funnel.php' ) ) {

				$row_meta = array(
					'docs'    => '<a target="_blank" style="color:#FFF;background:linear-gradient(to right,#7a28ff 0,#00a1ff 100%);padding:5px;border-radius:6px;" href="https://docs.wpswings.com/one-click-upsell-funnel-for-woocommerce/?utm_source=wpswings-upsell-doc&utm_medium=upsell-org-backend&utm_campaign=upsell-doc">' . esc_html__( 'Go to Docs', 'woo-one-click-upsell-funnel' ) . '</a>',
					'goPro'   => '<a target="_blank" style="color:#FFF;background:linear-gradient(to right,#45b649,#dce35b);padding:5px;border-radius:6px;" 	   href="https://wpswings.com/product/one-click-upsell-funnel-for-woocommerce-pro/?utm_source=wpswings-upsell-pro&utm_medium=upsell-org-backend&utm_campaign=upsell-pro"><strong>' . esc_html__( 'Go Premium', 'woo-one-click-upsell-funnel' ) . '</strong></a>',
					'demo'    => '<a target="_blank" style="color:#FFF;background:linear-gradient(to right,#7a28ff 0,#00a1ff 100%);padding:5px;border-radius:6px;" href="https://demo.wpswings.com/one-click-upsell-funnel-for-woocommerce-pro/?utm_source=wpswings-upsell-demo&utm_medium=upsell-org-backend&utm_campaign=upsell-demo"><strong>' . esc_html__( 'Try Premium Demo', 'woo-one-click-upsell-funnel' ) . '</strong></a>',
					'support' => '<a target="_blank" style="color:#FFF;background:linear-gradient(to right,#7a28ff 0,#00a1ff 100%);padding:5px;border-radius:6px;" href="https://support.wpswings.com/wordpress-plugins-knowledge-base/category/one-click-upsell-funnel-for-woocommerce-pro-kb/?utm_source=wpswings-upsell-kb&utm_medium=upsell-org-backend&utm_campaign=upsell-kb"><strong>' . esc_html__( 'Support', 'woo-one-click-upsell-funnel' ) . '</strong></a>',
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

			$plugin = new Woocommerce_One_Click_Upsell_Funnel();
			$plugin->run();

		}

		// Return and Load nothing.
		run_woocommerce_one_click_upsell_funnel();
	}
} else {

	// Deactivation of plugin at dependency failed.
	add_action( 'admin_init', 'wps_upsell_lite_plugin_activation_failure' );

	/**
	 * Deactivate this plugin.
	 */
	function wps_upsell_lite_plugin_activation_failure() {

		deactivate_plugins( plugin_basename( __FILE__ ) );
	}

	// Add admin error notice.
	add_action( 'admin_notices', 'wps_upsell_lite_plugin_activation_admin_notice' );

	/**
	 * This function is used to display plugin activation error notice.
	 */
	function wps_upsell_lite_plugin_activation_admin_notice() {

		global $wps_upsell_lite_plugin_activation;

		$secure_nonce      = wp_create_nonce( 'wps-upsell-auth-nonce' );
		$id_nonce_verified = wp_verify_nonce( $secure_nonce, 'wps-upsell-auth-nonce' );

		if ( ! $id_nonce_verified ) {
			wp_die( esc_html__( 'Nonce Not verified', ' woo-one-click-upsell-funnel' ) );
		}

		// To hide Plugin activated notice.
		unset( $_GET['activate'] );

		?>

			<?php if ( 'woo_inactive' === $wps_upsell_lite_plugin_activation['message'] ) : ?>

			<div class="notice notice-error is-dismissible">
				<p><strong><?php esc_html_e( 'WooCommerce', 'woo-one-click-upsell-funnel' ); ?></strong><?php esc_html_e( ' is not activated, Please activate WooCommerce first to activate ', 'woo-one-click-upsell-funnel' ); ?><strong><?php esc_html_e( 'One Click Upsell Funnel for WooCommerce', 'woo-one-click-upsell-funnel' ); ?></strong><?php esc_html_e( '.', 'woo-one-click-upsell-funnel' ); ?></p>
			</div>

		<?php endif;
	}
}

?>
