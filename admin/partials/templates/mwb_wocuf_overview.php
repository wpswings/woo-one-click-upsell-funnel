<?php

/**
 * Plugin Overview Template.
 */

/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div id="mwb_upsell_lite_overview">

	<div id="mwb_upsell_lite_overview_video">


	
		<h2><?php esc_html_e( 'How Upsell Works and How to Setup a Funnel', 'woocommerce_one_click_upsell_funnel' ); ?></h2>
		<hr>

		<iframe width="100%" height="450px" src="https://www.youtube.com/embed/Wa3NL4oy-tE?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen=""></iframe>

	</div>

	<hr>

	<div id="mwb_upsell_lite_overview_pro_version">

		<h2><?php esc_html_e( 'Premium Plugin Additional Features', 'woocommerce_one_click_upsell_funnel' ); ?></h2>

		

		<h3><?php esc_html_e( 'Supported Products', 'woocommerce_one_click_upsell_funnel' ); ?></h3>
		
		<div class="mwb_upsell_overview_supported_product">

			<div class="mwb_upsell_overview_simple_product_icon">
				<img src="<?php echo MWB_WOCUF_URL . 'admin/resources/simple-products.png'; ?>">
				<h4><?php esc_html_e( 'Simple Products', 'woocommerce_one_click_upsell_funnel' ); ?></h4>
			</div>

			<div class="mwb_upsell_overview_simple_product_icon">
				<img src="<?php echo MWB_WOCUF_URL . 'admin/resources/variable-products.png'; ?>">
				<h4><?php esc_html_e( 'Variable Products', 'woocommerce_one_click_upsell_funnel' ); ?></h4>
			</div>

			<div class="mwb_upsell_overview_subscription_product_icon">
				<img src="<?php echo MWB_WOCUF_URL . 'admin/resources/subscription-products.png'; ?>">
				<h4><?php esc_html_e( 'Subscription Products', 'woocommerce_one_click_upsell_funnel' ); ?></h4>
			</div>

		</div>

		<h3><?php esc_html_e( 'Supported Payment Gateways', 'woocommerce_one_click_upsell_funnel' ); ?></h3>
		
		<div class="mwb_upsell_overview_supported_payment_gateways">

			<div class="mwb_upsell_overview_supported_payment_gateways_banner">
				<img src="<?php echo MWB_WOCUF_URL . 'admin/resources/payment-gateways.jpg'; ?>">
			</div>

		</div>

		<h3><?php esc_html_e( 'Supported Woocommerce Add-ons', 'woocommerce_one_click_upsell_funnel' ); ?></h3>

		<div class="mwb_upsell_overview_supported_woo_addons">

			<div class="mwb_upsell_overview_supported_woo_addons_banner">
				<img src="<?php echo MWB_WOCUF_URL . 'admin/resources/woo-subscription-compatibility.png'; ?>">
			</div>

		</div>

		<div class="mwb_upsell_overview_go_pro">

			<a class="button mwb_upsell_overview_go_pro_button" target="_blank" href="https://makewebbetter.com/product/woocommerce-one-click-upsell-funnel-pro/?utm_source=MWB-upsell-org&utm_medium=Overview&utm_campaign=ORG"><?php echo esc_html__( 'Upgrade to Premium', 'woocommerce_one_click_upsell_funnel' ) . ' &rarr;'; ?></a>
		</div>


	</div>

</div>

