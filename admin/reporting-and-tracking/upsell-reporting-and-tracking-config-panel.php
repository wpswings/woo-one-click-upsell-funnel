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

$secure_nonce      = wp_create_nonce( 'wps-upsell-tracking-nonce' );
$id_nonce_verified = wp_verify_nonce( $secure_nonce, 'wps-upsell-tracking-nonce' );
if ( ! $id_nonce_verified ) {
	wp_die( esc_html__( 'Nonce Not verified', 'woo-one-click-upsell-funnel' ) );
}
$active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'reporting';

if ( 'overview' === get_transient( 'wps_upsell_default_settings_tab' ) ) {

	$active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'overview';
}
$nonce_reporting = wp_create_nonce( 'view_upsell_tracking_reporting' ); // Create nonce.
$nonce_ga = wp_create_nonce( 'view_upsell_tracking_ga' ); // Create nonce.
$nonce_pixel = wp_create_nonce( 'view_upsell_tracking_pixel' ); // Create nonce.
$nonce_overview = wp_create_nonce( 'view_upsell_tracking_over' ); // Create nonce.

?>

<div class="wps-notice-wrapper">
<?php do_action( 'wps_wocuf_pro_setting_tab_active', '', '', '' ); ?>
</div>

<div class="wrap woocommerce" id="wps_wocuf_pro_setting_wrapper">

	<!-- To make WordPress notice appear at this place. As it searchs from top and appears at the 1st heading tag-->
	<h1></h1>

	<div class="hide"  id="wps_wocuf_pro_loader">	
		<img id="wps-wocuf-loading-image" src="<?php echo 'images/spinner-2x.gif'; ?>" >
	</div>

	<div class="wps_wocuf_pro_header">
		<div class="wps_wocuf_pro_setting_title"><?php esc_html_e( 'One Click Upsell Funnel for WooCommerce', 'woo-one-click-upsell-funnel' ); ?></div>


	</div>

	<nav class="nav-tab-wrapper woo-nav-tab-wrapper">

		<a class="nav-tab <?php echo 'reporting' === $active_tab ? 'nav-tab-active' : ''; ?>" href="?page=wps-wocuf-setting-tracking&tab=reporting&nonce=<?php echo esc_html( $nonce_reporting ); ?>"><?php esc_html_e( 'Sales Reports', 'woo-one-click-upsell-funnel' ); ?></a>
		<a class="nav-tab <?php echo 'ga-setting' === $active_tab ? 'nav-tab-active' : ''; ?>" href="?page=wps-wocuf-setting-tracking&tab=ga-setting&nonce=<?php echo esc_html( $nonce_ga ); ?>"><?php esc_html_e( 'Google Analytics', 'woo-one-click-upsell-funnel' ); ?></a>
		<a class="nav-tab <?php echo 'pixel-setting' === $active_tab ? 'nav-tab-active' : ''; ?>" href="?page=wps-wocuf-setting-tracking&tab=pixel-setting&nonce=<?php echo esc_html( $nonce_pixel ); ?>"><?php esc_html_e( 'FB Pixel', 'woo-one-click-upsell-funnel' ); ?></a>
		<a class="nav-tab <?php echo 'overview' === $active_tab ? 'nav-tab-active' : ''; ?>" href="?page=wps-wocuf-setting-tracking&tab=overview&nonce=<?php echo esc_html( $nonce_overview ); ?>"><?php esc_html_e( 'Overview', 'woo-one-click-upsell-funnel' ); ?></a>

		<?php do_action( 'wps_wocuf_pro_setting_tab' ); ?>	
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

	do_action( 'wps_wocuf_pro_setting_tab_html' );
	?>
</div>
