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
 * Version:               3.6.2
 *
 * Requires Plugins: woocommerce, upsell-order-bump-offer-for-woocommerce
 * Requires at least:     5.5.0
 * Tested up to:          6.9
 * WC requires at least:  6.5.0
 * WC tested up to:       10.6.2
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
use Automattic\WooCommerce\Utilities\OrderUtil;


/**
 * Plugin Active Detection.
 *
 * @param mixed $plugin_slug plugin slug.
 */
function wpswocuf_upsell_lite_is_plugin_active( $plugin_slug ) {

	if ( empty( $plugin_slug ) ) {

		return false;
	}

	$active_plugins = (array) get_option( 'active_plugins', array() );


	if ( is_multisite() ) {

		$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );

	}

	return in_array( $plugin_slug, $active_plugins, true ) || array_key_exists( $plugin_slug, $active_plugins );

}

$wpswocuf_old_pro_present   = false;
$wpswocuf_installed_plugins = get_plugins();

if ( array_key_exists( 'woocommerce-one-click-upsell-funnel-pro/woocommerce-one-click-upsell-funnel-pro.php', $wpswocuf_installed_plugins ) ) {
	$wpswocuf_pro_plugin = $wpswocuf_installed_plugins['woocommerce-one-click-upsell-funnel-pro/woocommerce-one-click-upsell-funnel-pro.php'];
	if ( version_compare( $wpswocuf_pro_plugin['Version'], '3.6.6', '<' ) ) {
		$wpswocuf_old_pro_present = true;
	}
}

if ( true === $wpswocuf_old_pro_present ) {

	add_action( 'mwb_wocuf_pro_setting_tab_active', 'wpswocuf_add_updatenow_notice', 0, 3 );

	/**
	 * Add update now notice.
	 *
	 * @param string $v version.
	 * @param string $f version.
	 * @param string $d version.
	 */
	function wpswocuf_add_updatenow_notice( $v = false, $f = false, $d = false ) {
		?>
			<div class="notice notice-error is-dismissible">
				<p><?php esc_html_e( 'Your One Click Upsell Funnel Pro plugin update is here! Please Update it now via plugins page.', 'woo-one-click-upsell-funnel' ); ?></p>
			</div>
		<?php
	}

}

$wpswocuf_activated         = false;
$wpswocuf_woo_plugin    = 'woocommerce/woocommerce.php';
/**
 * Checking if WooCommerce is active.
 */
if ( function_exists( 'is_multisite' ) && is_multisite() ) {
	include_once ABSPATH . 'wp-admin/includes/plugin.php';
	if ( file_exists( WP_PLUGIN_DIR . '/' . $wpswocuf_woo_plugin ) && is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
		$wpswocuf_activated = true;
	}
} else {
	if ( file_exists( WP_PLUGIN_DIR . '/' . $wpswocuf_woo_plugin ) && in_array( 'woocommerce/woocommerce.php', apply_filters( 'wpswocuf_active_plugins', get_option( 'active_plugins' ) ), true ) ) {
		$wpswocuf_activated = true;
	}
}

if ( $wpswocuf_activated ) {

		/**
		 * This function is used to check hpos enable.
		 *
		 * @return boolean
		 */
	function wpswocuf_wocfo_is_hpos_enabled() {

		$is_hpos_enable = false;
		if ( class_exists( 'Automattic\WooCommerce\Utilities\OrderUtil' ) && OrderUtil::custom_orders_table_usage_is_enabled() ) {

			$is_hpos_enable = true;
		}
		return $is_hpos_enable;
	}


	/**
	 * This function is used to get post meta data.
	 *
	 * @param  string $id        id.
	 * @param  string $meta_key  meta key.
	 * @param  bool   $bool meta bool.
	 * @return string
	 */
	function wpswocuf_wocfo_hpos_get_meta_data( $id, $meta_key, $bool ) {

		$meta_value = '';
		if ( 'shop_order' === OrderUtil::get_order_type( $id ) && wpswocuf_wocfo_is_hpos_enabled() ) {

			$order      = wc_get_order( $id );
			$meta_value = $order->get_meta( $meta_key, $bool );
		} else {

			$meta_value = get_post_meta( $id, $meta_key, $bool );
		}
		return $meta_value;
	}


	/**
	 * This function is used to update meta data.
	 *
	 * @param string $id id.
	 * @param string $meta_key meta_key.
	 * @param string $meta_value meta_value.
	 * @return void
	 */
	function wpswocuf_wocfo_hpos_update_meta_data( $id, $meta_key, $meta_value ) {

		if ( 'shop_order' === OrderUtil::get_order_type( $id ) && wpswocuf_wocfo_is_hpos_enabled() ) {

			$order = wc_get_order( $id );
			$order->update_meta_data( $meta_key, $meta_value );
			$order->save();
		} else {

			update_post_meta( $id, $meta_key, $meta_value );
		}
	}


	/**
	 * This function is used delete meta data.
	 *
	 * @param string $id       id.
	 * @param string $meta_key meta_key.
	 * @return void
	 */
	function wpswocuf_wocfo_hpos_delete_meta_data( $id, $meta_key ) {

		if ( 'shop_order' === OrderUtil::get_order_type( $id ) && wpswocuf_wocfo_is_hpos_enabled() ) {

			$order = wc_get_order( $id );
			$order->delete_meta_data( $meta_key );
			$order->save();
		} else {

			delete_post_meta( $id, $meta_key );
		}
	}

	add_filter( 'woocommerce_get_checkout_order_received_url', 'wpswocuf_redirect_order_while_upsell_org', 10, 2 );

	/**
	 * Function to save redirection.
	 *
	 * @param string $order_received_url is the order url.
	 * @param object $data is the order data.
	 * @return string
	 */
	function wpswocuf_redirect_order_while_upsell_org( $order_received_url, $data ) {

		wpswocuf_wocfo_hpos_update_meta_data( $data->get_id(), 'wpswocuf_upsell_funnel_order_redirection_link', $order_received_url );

		$order_received_url_data = wpswocuf_wocfo_hpos_get_meta_data( $data->get_id(), 'wpswocuf_wocfo_upsell_funnel_redirection_link_org', true );
		if ( ! empty( $order_received_url_data ) ) {
			$order_received_url = $order_received_url_data;
		}
		return $order_received_url;
	}
} else {

	// Deactivation of plugin at dependency failed.
	add_action( 'admin_init', 'wpswocuf_upsell_lite_plugin_activation_failure' );

	/**
	 * Deactivate this plugin.
	 */
	function wpswocuf_upsell_lite_plugin_activation_failure() {

		deactivate_plugins( plugin_basename( __FILE__ ) );
	}

	// Add admin error notice.
	add_action( 'admin_notices', 'wpswocuf_upsell_lite_plugin_activation_admin_notice' );

	/**
	 * This function is used to display plugin activation error notice.
	 */
	function wpswocuf_upsell_lite_plugin_activation_admin_notice() {

	global $wpswocuf_activated;
		$secure_nonce      = wp_create_nonce( 'wps-upsell-auth-nonce' );
		$id_nonce_verified = wp_verify_nonce( $secure_nonce, 'wps-upsell-auth-nonce' );

		if ( ! $id_nonce_verified ) {
			wp_die( esc_html__( 'Nonce Not verified', 'woo-one-click-upsell-funnel' ) );
		}

		// To hide Plugin activated notice.
		unset( $_GET['activate'] );

		?>

		<?php if ( ! $wpswocuf_activated ) : ?>

			<div class="notice notice-error is-dismissible">
				<p><strong><?php esc_html_e( 'WooCommerce', 'woo-one-click-upsell-funnel' ); ?></strong><?php esc_html_e( ' is not activated, Please activate WooCommerce first to activate ', 'woo-one-click-upsell-funnel' ); ?><strong><?php esc_html_e( 'One Click Upsell Funnel for WooCommerce', 'woo-one-click-upsell-funnel' ); ?></strong><?php esc_html_e( '.', 'woo-one-click-upsell-funnel' ); ?></p>
			</div>

				<?php
		endif;
	}
}

add_action(
	'before_woocommerce_init',
	function() {
		if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
		}
	}
);

add_action(
	'before_woocommerce_init',
	function() {

		if ( class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {

			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'cart_checkout_blocks', __FILE__, true );

		}

	}
);


add_action( 'admin_notices', 'wpswocuf_banner_notification_plugin_html' );
if ( ! function_exists( 'wpswocuf_banner_notification_plugin_html' ) ) {
	/**
	 * Common Function To show banner image.
	 *
	 * @return void
	 */
	function wpswocuf_banner_notification_plugin_html() {

		$screen = get_current_screen();
		if ( isset( $screen->id ) ) {
			$pagescreen = $screen->id;
		}
		if ( ( isset( $pagescreen ) && 'plugins' === $pagescreen ) || ( 'wp-swings_page_home' == $pagescreen ) ) {
			$banner_id = get_option( 'wpswocuf_wgm_notify_new_banner_id', false );
			if ( isset( $banner_id ) && '' !== $banner_id ) {
				$hidden_banner_id            = get_option( 'wpswocuf_wgm_notify_hide_baneer_notification', false );
				$banner_image = get_option( 'wpswocuf_wgm_notify_new_banner_image', '' );
				$banner_url = get_option( 'wpswocuf_wgm_notify_new_banner_url', '' );
				if ( isset( $hidden_banner_id ) && $hidden_banner_id < $banner_id ) {

					if ( '' !== $banner_image && '' !== $banner_url ) {

						?>
							<div class="wps-offer-notice notice notice-warning is-dismissible">                
								<div class="notice-container">
									<a href="<?php echo esc_url( $banner_url ); ?>" target="_blank"><img src="<?php echo esc_url( $banner_image ); ?>" alt="Subscription cards"/></a>
								</div>
								<button type="button" class="notice-dismiss dismiss_banner" id="dismiss-banner"><span class="screen-reader-text">Dismiss this notice.</span></button>
							</div>
						<?php
					}
				}
			}
		}
	}
}

	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wpswocuf_upsell_lite_plugin_settings_link' );

		/**
		 * This action is for woocommerce dependency check.
		 *
		 * @param mixed $links links.
		 */
			function wpswocuf_upsell_lite_plugin_settings_link( $links ) {
			$nonce = wp_create_nonce( 'view_upsell_setting' ); // Create nonce.

			$plugin_links = array(
				'<a href="' . admin_url( 'admin.php?page=upsell-order-bump-offer-for-woocommerce-setting&tab=general-setting&nonce=' . $nonce ) . '">' . esc_html__( 'Settings', 'woo-one-click-upsell-funnel' ) . '</a>',
			);

			// Ensure Deactivate link is visible even if other filters modify defaults.
			if ( ! isset( $links['deactivate'] ) && current_user_can( 'activate_plugins' ) ) {
				$deactivate_url = wp_nonce_url(
					admin_url( 'plugins.php?action=deactivate&plugin=' . plugin_basename( __FILE__ ) ),
					'deactivate-plugin_' . plugin_basename( __FILE__ )
				);
				$plugin_links[] = '<a href="' . esc_url( $deactivate_url ) . '">' . esc_html__( 'Deactivate', 'woo-one-click-upsell-funnel' ) . '</a>';
			}

			return array_merge( $plugin_links, $links );
		}
