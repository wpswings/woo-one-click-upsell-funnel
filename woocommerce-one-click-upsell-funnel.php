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
 * Description:           One Click Upsell Funnel for WooCommerce allows showing post-checkout offers to customers which helps to increase Average Order Value & Revenue. <a href="https://wpswings.com/woocommerce-plugins/?utm_source=wpswings-upsell-shop&utm_medium=upsell-org-backend&utm_campaign=shop-page" target="_blank" >Elevate your e-commerce store by exploring more on <strong>WP Swings</strong></a>.
 * Version:               3.2.9
 *
 * Requires at least:     5.5.0
 * Tested up to:          6.2.2
 * WC requires at least:  5.5.0
 * WC tested up to:       7.7.2
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
				<p><?php esc_html_e( 'Your One Click Upsell Funnel Pro plugin update is here! Please Update it now via plugins page.', 'woo-one-click-upsell-funnel' ); ?></p>
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
					<p><?php esc_html_e( 'Your One Click Upsell Funnel Pro plugin update is here! Please Update it now.', 'woo-one-click-upsell-funnel' ); ?></p>
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
	$license_check             = get_option( 'mwb_wocuf_pro_license_check', false );

	if ( ! empty( $mwb_wocuf_pro_license_key ) && empty( $wps_wocuf_pro_license_key ) ) {
		update_option( 'wps_wocuf_pro_license_key', $mwb_wocuf_pro_license_key );
		update_option( 'wps_wocuf_pro_activated_timestamp', $thirty_days );
		update_option( 'wps_wocuf_pro_license_check', $license_check );
		$wps_wocuf_pro_license_key = get_option( 'wps_wocuf_pro_license_key', '' );
	}

	// If pro plugin not active, then load Org Plugin else Don't.
	if ( ! wps_upsell_lite_is_plugin_active( 'woocommerce-one-click-upsell-funnel-pro/woocommerce-one-click-upsell-funnel-pro.php' ) ) {

		if ( empty( get_option( 'wocuf_lite_migration_status', false ) ) ) {
			add_action( 'after_plugin_row_' . plugin_basename( __FILE__ ), 'wps_wocuf_lite_migrate_notice', 0, 3 );

		}
		/**
		 * Migration to new domain notice.
		 *
		 * @param string $plugin_file Path to the plugin file relative to the plugins directory.
		 * @param array  $plugin_data An array of plugin data.
		 * @param string $status Status filter currently applied to the plugin list.
		 */
		function wps_wocuf_lite_migrate_notice( $plugin_file, $plugin_data, $status ) {

			?>
			<tr class="plugin-update-tr active notice-warning notice-alt">
				<td colspan="4" class="plugin-update colspanchange">
					<div class="notice notice-error inline update-message notice-alt">
						<p class='wps-notice-title wps-notice-section'>
							<?php esc_html_e( 'Heads up. The latest update includes some substantial changes across different areas of the plugin. Please visit your dashboard and ', 'woo-one-click-upsell-funnel' ); ?>
							<a href="<?php echo esc_url( admin_url( 'admin.php?page=wps-wocuf-setting&tab=funnels-list' ) ); ?>"><?php esc_html_e( 'Click Here', 'woo-one-click-upsell-funnel' ); ?></a>
							<?php esc_html_e( 'migrate now button.', 'woo-one-click-upsell-funnel' ); ?>
						</p>
					</div>
				</td>
			</tr>
			<style>
				.wps-notice-section > p:before {
					content: none;
				}
			</style>
			<?php
		}

		define( 'WPS_WOCUF_URL', plugin_dir_url( __FILE__ ) );

		define( 'WPS_WOCUF_DIRPATH', plugin_dir_path( __FILE__ ) );

		define( 'WPS_WOCUF_VERSION', 'v3.2.9' );

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

			$wps_site_plugins = get_plugins();
			if ( ! isset( $wps_site_plugins['woocommerce-one-click-upsell-funnel-pro/woocommerce-one-click-upsell-funnel-pro.php'] ) ) {
				$plugin_links[] = '<a class="wps-ubo-lite-go-pro" style="background: #05d5d8; color: white; font-weight: 700; padding: 2px 5px; border: 1px solid #05d5d8; border-radius: 5px;" href="https://wpswings.com/product/one-click-upsell-funnel-for-woocommerce-pro/?utm_source=wpswings-upsell-pro&utm_medium=upsell-org-backend&utm_campaign=upsell-pro" target="_blank">' . esc_html__( 'GO PRO', 'woo-one-click-upsell-funnel' ) . '</a>';
			}
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
					'demo'    => '<a href="https://demo.wpswings.com/one-click-upsell-funnel-for-woocommerce-pro/?utm_source=wpswings-upsell-demo&utm_medium=upsell-org-backend&utm_campaign=upsell-demo" target="_blank"><img class="wps-info-img" src="' . esc_url( WPS_WOCUF_URL ) . 'admin/resources/icons/Demo.svg" class="wps-info-img" alt="Demo image">' . esc_html__( 'Demo', 'woo-one-click-upsell-funnel' ) . '</a>',
					'doc'     => '<a href="https://docs.wpswings.com/one-click-upsell-funnel-for-woocommerce/?utm_source=wpswings-upsell-doc&utm_medium=upsell-org-backend&utm_campaign=upsell-doc" target="_blank"><img class="wps-info-img" src="' . esc_url( WPS_WOCUF_URL ) . 'admin/resources/icons/Documentation.svg" class="wps-info-img" alt="Documentation image">' . esc_html__( 'Documentation', 'woo-one-click-upsell-funnel' ) . '</a>',
					'video'     => '<a href="https://www.youtube.com/watch?v=PvyKF8WEkAk" target="_blank"><img class="wps-info-img" src="' . esc_url( WPS_WOCUF_URL ) . 'admin/resources/icons/video.png" class="wps-info-img" alt="Documentation image">' . esc_html__( 'Video', 'woo-one-click-upsell-funnel' ) . '</a>',	
					'support' => '<a href="https://wpswings.com/submit-query/?utm_source=wpswings-upsell-support&utm_medium=upsell-org-backend&utm_campaign=support" target="_blank"><img class="wps-info-img" src="' . esc_url( WPS_WOCUF_URL ) . 'admin/resources/icons/Support.svg" class="wps-info-img" alt="DeSupportmo image">' . esc_html__( 'Support', 'woo-one-click-upsell-funnel' ) . '</a>',
					'services' => '<a href="https://wpswings.com/woocommerce-services/?utm_source=wpswings-upsell-services&utm_medium=upsell-org-backend&utm_campaign=woocommerce-services" target="_blank"><img class="wps-info-img" src="' . esc_url( WPS_WOCUF_URL ) . 'admin/resources/icons/Services.svg" class="wps-info-img" alt="DeServicesmo image">' . esc_html__( 'Services', 'woo-one-click-upsell-funnel' ) . '</a>',

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