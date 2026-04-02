<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wpswings.com/?utm_source=wpswings-official&utm_medium=upsell-org-backend&utm_campaign=official
 * @since      1.0.0
 *
 * @package     woo_one_click_upsell_funnel
 * @subpackage  woo_one_click_upsell_funnel/tracking/templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$wpswocuf_nonce          = wp_create_nonce( 'view_upsell_tracking' ); // Create nonce.
$wpswocuf_nonce_facebook = wp_create_nonce( 'view_upsell_tracking_fb' ); // Create nonce.

?>

<div id="wpswocuf_upsell_lite_overview">
	<div id="wpswocuf_upsell_lite_overview_pro_version">

		<h2><?php esc_html_e( 'eCommerce Analytics & Tracking', 'woo-one-click-upsell-funnel' ); ?></h2>
		<h3><?php esc_html_e( 'Supported Analytics Tools', 'woo-one-click-upsell-funnel' ); ?></h3>

		<div class="wpswocuf_upsell_overview_supported_product">
				<div class="wpswocuf_upsell_overview_product_icon simple">
					<a href="<?php echo esc_url( admin_url( 'admin.php?page=wps-wocuf-setting-tracking&tab=ga-setting&nonce=' . $wpswocuf_nonce ) ); ?>">
					<img class="wpswocuf_upsell_lite_tool_ga" src="<?php echo esc_url( wpswocuf_URL . 'admin/reporting-and-tracking/resources/icons/google-analytics.svg' ); ?>">
				</a>
			</div>
				<div class="wpswocuf_upsell_overview_product_icon simple">
					<a href="<?php echo esc_url( admin_url( 'admin.php?page=wps-wocuf-setting-tracking&tab=pixel-setting&nonce=' . $wpswocuf_nonce_facebook ) ); ?>">
					<img class="wpswocuf_upsell_lite_tool_fb" src="<?php echo esc_url( wpswocuf_URL . 'admin/reporting-and-tracking/resources/icons/facebook-pixel.png' ); ?>">
				</a>
			</div>
		</div>
	</div>
</div>
