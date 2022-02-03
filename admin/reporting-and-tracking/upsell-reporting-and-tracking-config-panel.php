<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wpswings.com/?utm_source=wpswings-official&utm_medium=upsell-org-backend&utm_campaign=official
 * @since      1.0.0
 *
 * @package    woo_one_click_upsell_funnel
 * @subpackage woo_one_click_upsell_funnel/admin/reporting-and-tracking
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'reporting';

if ( 'overview' === get_transient( 'mwb_upsell_default_settings_tab' ) ) {

	$active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'overview';
}

?>

<div class="mwb-notice-wrapper">
<?php do_action( 'mwb_wocuf_pro_setting_tab_active', '', '', '' ); ?>
</div>

<div class="wrap woocommerce" id="mwb_wocuf_pro_setting_wrapper">

	<!-- To make WordPress notice appear at this place. As it searchs from top and appears at the 1st heading tag-->
	<h1></h1>

	<div class="hide"  id="mwb_wocuf_pro_loader">	
		<img id="mwb-wocuf-loading-image" src="<?php echo 'images/spinner-2x.gif'; ?>" >
	</div>

	<div class="mwb_wocuf_pro_header">
		<div class="mwb_wocuf_pro_setting_title"><?php esc_html_e( 'One Click Upsell Funnel for WooCommerce', 'woo-one-click-upsell-funnel' ); ?></div>

		<div id="mwb_upsell_skype_connect_with_us">   
			<div class="mwb_upsell_skype_connect_title"><?php esc_html_e( 'Connect with Us in one click', 'woo-one-click-upsell-funnel' ); ?></div>

			<a class="button" target="_blank" href="https://join.skype.com/invite/xCmwbfxx8MCX"><img src="<?php echo esc_url( MWB_WOCUF_URL . 'admin/resources/skype_logo.png' ); ?>"><?php esc_html_e( 'Connect', 'woo-one-click-upsell-funnel' ); ?></a>

			<p><?php esc_html_e( 'Regarding any issue, query or feature request for Upsell', 'woo-one-click-upsell-funnel' ); ?></p>
		</div>
	</div>

	<nav class="nav-tab-wrapper woo-nav-tab-wrapper">

		<a class="nav-tab <?php echo 'reporting' === $active_tab ? 'nav-tab-active' : ''; ?>" href="?page=mwb-wocuf-setting-tracking&tab=reporting"><?php esc_html_e( 'Sales Reports', 'woo-one-click-upsell-funnel' ); ?></a>
		<a class="nav-tab <?php echo 'ga-setting' === $active_tab ? 'nav-tab-active' : ''; ?>" href="?page=mwb-wocuf-setting-tracking&tab=ga-setting"><?php esc_html_e( 'Google Analytics', 'woo-one-click-upsell-funnel' ); ?></a>
		<a class="nav-tab <?php echo 'pixel-setting' === $active_tab ? 'nav-tab-active' : ''; ?>" href="?page=mwb-wocuf-setting-tracking&tab=pixel-setting"><?php esc_html_e( 'FB Pixel', 'woo-one-click-upsell-funnel' ); ?></a>
		<a class="nav-tab <?php echo 'overview' === $active_tab ? 'nav-tab-active' : ''; ?>" href="?page=mwb-wocuf-setting-tracking&tab=overview"><?php esc_html_e( 'Overview', 'woo-one-click-upsell-funnel' ); ?></a>

		<?php do_action( 'mwb_wocuf_pro_setting_tab' ); ?>	
	</nav>
	<?php

	if ( 'reporting' === $active_tab ) {
		include_once 'templates/reporting.php';
	} elseif ( 'ga-setting' === $active_tab ) {
		include_once 'templates/ga-settings.php';
	} elseif ( 'pixel-setting' === $active_tab ) {
		include_once 'templates/pixel-settings.php';
	} elseif ( 'overview' === $active_tab ) {
		include_once 'templates/tracking-overview.php';
	}

	do_action( 'mwb_wocuf_pro_setting_tab_html' );
	?>
</div>
