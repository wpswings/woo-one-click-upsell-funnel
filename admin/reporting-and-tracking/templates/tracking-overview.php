<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package     woo_one_click_upsell_funnel
 * @subpackage  woo_one_click_upsell_funnel/tracking/templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div id="mwb_upsell_lite_overview">
	<div id="mwb_upsell_lite_overview_video">
		<h2><strong><?php esc_html_e( 'How Upsell Works with eCommerce Tracking Tools', 'woo-one-click-upsell-funnel' ); ?></strong></h2>
		<hr>
		<iframe width="100%" height="450px" src="https://www.youtube.com/embed/a4_LUYzFvxw" frameborder="0" allowfullscreen=""></iframe>
	</div>

	<hr>

	<div id="mwb_upsell_lite_overview_pro_version">

		<h2><?php esc_html_e( 'eCommerce Analytics & Tracking', 'woo-one-click-upsell-funnel' ); ?></h2>
		<h3><?php esc_html_e( 'Supported Analytics Tools', 'woo-one-click-upsell-funnel' ); ?></h3>

		<div class="mwb_upsell_overview_supported_product">
			<div class="mwb_upsell_overview_product_icon simple">
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=mwb-wocuf-setting-tracking&tab=pixel-setting' ) ); ?>">
					<img class="mwb_upsell_lite_tool_fb" src="<?php echo esc_url( MWB_WOCUF_URL . 'admin/reporting-and-tracking/resources/icons/facebook-pixel.png' ); ?>">
				</a>
			</div>

			<div class="mwb_upsell_overview_product_icon simple">
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=mwb-wocuf-setting-tracking&tab=ga-setting' ) ); ?>">
					<img class="mwb_upsell_lite_tool_ga" src="<?php echo esc_url( MWB_WOCUF_URL . 'admin/reporting-and-tracking/resources/icons/google-analytics.svg' ); ?>">
				</a>
			</div>
			
		</div>

		<div class="mwb_upsell_overview_go_pro">
			<a class="button mwb_upsell_overview_go_pro_button" target="_blank" href="https://makewebbetter.com/product/woocommerce-one-click-upsell-funnel-pro/?utm_source=MWB-upsell-org&utm_medium=Overview&utm_campaign=ORG"><?php echo esc_html__( 'Upgrade to Premium', 'woo-one-click-upsell-funnel' ) . ' &rarr;'; ?></a>
		</div>
	</div>
</div>