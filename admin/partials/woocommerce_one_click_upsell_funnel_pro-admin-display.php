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
 * @subpackage woo_one_click_upsell_funnel/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) 
{
	exit;
}

$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'funnels-list';

if( 'overview' === get_transient( 'mwb_upsell_default_settings_tab' ) ) {

    $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'overview';
}

do_action('mwb_wocuf_pro_setting_tab_active');

?>

<?php if( ! mwb_upsell_lite_elementor_plugin_active() && false === get_transient( 'mwb_upsell_elementor_inactive_notice' ) ): ?>

<div id="mwb_upsell_elementor_notice" class="notice notice-info is-dismissible">
    <p><span class="mwb_upsell_heading_span"><?php esc_html_e( 'We have integrated with Elementor', 'woocommerce_one_click_upsell_funnel' ); ?></span><?php esc_html_e( ' – now the most advanced Wordpress page builder can be used to completely customize Upsell Offer pages. Moreover we provide three stunning and beautiful offer templates.', 'woocommerce_one_click_upsell_funnel' ); ?></p>

    <p><?php _e( 'To completely utilize all features of this plugin please activate Elementor.', 'woocommerce_one_click_upsell_funnel' ); ?></p>

    <p><?php esc_html_e( 'Elementor is FREE and available on ORG ', 'woocommerce_one_click_upsell_funnel' ); ?><a href="https://wordpress.org/plugins/elementor/" target="_blank"><?php esc_html_e( 'here', 'woocommerce_one_click_upsell_funnel' ); ?></a></p>

    <p><?php esc_html_e( 'You don\'t need to worry about Elementor as it works independently and won\'t conflict with other page builders or Wordpress new editor.', 'woocommerce_one_click_upsell_funnel' ); ?></p>

    <p class="submit">

        <a href="<?php echo admin_url( 'plugin-install.php?s=elementor&tab=search&type=term' ); ?>" id="mwb_upsell_activate_elementor" class="button" target="_blank"><?php esc_html_e( 'Install and activate Elementor now &rarr;', 'woocommerce_one_click_upsell_funnel' ); ?></a>
        <br>
        <a id="mwb_upsell_dismiss_elementor_inactive_notice" href="javascript:void(0)" class="button"><?php esc_html_e( 'Dismiss this notice', 'woocommerce_one_click_upsell_funnel' ); ?></a>

    </p>
</div>

<?php endif; ?>

<div class="wrap woocommerce" id="mwb_wocuf_pro_setting_wrapper">

	<div class="hide"  id="mwb_wocuf_pro_loader">	
		<img id="mwb-wocuf-loading-image" src="<?php echo 'images/spinner-2x.gif'; ?>" >
	</div>
    
    <div class="mwb_wocuf_pro_header">
    	<div class="mwb_wocuf_pro_setting_title"><?php esc_html_e( 'One Click Upsell Funnel for WooCommerce', 'woocommerce_one_click_upsell_funnel' )?></div>

        <div id="mwb_upsell_skype_connect_with_us">   
            <div class="mwb_upsell_skype_connect_title"><?php esc_html_e( 'Connect with Us in one click', 'woocommerce_one_click_upsell_funnel' )?></div>

            <a class="button" target="_blank" href="https://join.skype.com/invite/IKVeNkLHebpC"><img src="<?php echo MWB_WOCUF_URL . "admin/resources/skype_logo.png"; ?>"><?php esc_html_e( 'Connect', 'woocommerce_one_click_upsell_funnel' )?></a>

            <p><?php esc_html_e( 'Regarding any issue, query or feature request for Upsell', 'woocommerce_one_click_upsell_funnel' )?></p>
        </div>
    </div>
    
    <!-- To make Wordpress notice appear at this place. As it searchs from top and appears at the 1st heading tag-->
    <h1></h1>
    
	<nav class="nav-tab-wrapper woo-nav-tab-wrapper">
		<a class="nav-tab <?php echo $active_tab == 'creation-setting' ? 'nav-tab-active' : ''; ?>" href="?page=mwb-wocuf-setting&tab=creation-setting"><?php _e('Save Funnel', 'woocommerce_one_click_upsell_funnel');?></a>
		<a class="nav-tab <?php echo $active_tab == 'funnels-list' ? 'nav-tab-active' : ''; ?>" href="?page=mwb-wocuf-setting&tab=funnels-list"><?php _e('Funnels List', 'woocommerce_one_click_upsell_funnel');?></a>
		<a class="nav-tab <?php echo $active_tab == 'shortcodes' ? 'nav-tab-active' : ''; ?>" href="?page=mwb-wocuf-setting&tab=shortcodes"><?php _e('Shortcodes', 'woocommerce_one_click_upsell_funnel');?></a>
		<a class="nav-tab <?php echo $active_tab == 'settings' ? 'nav-tab-active' : ''; ?>" href="?page=mwb-wocuf-setting&tab=settings"><?php _e('Global Settings', 'woocommerce_one_click_upsell_funnel');?></a>
        <a class="nav-tab <?php echo $active_tab == 'overview' ? 'nav-tab-active' : ''; ?>" href="?page=mwb-wocuf-setting&tab=overview"><?php _e('Overview', 'woocommerce_one_click_upsell_funnel');?></a>


        <?php do_action('mwb_wocuf_pro_setting_tab'); ?>	
	</nav>
	<?php 

		if( $active_tab == 'creation-setting' ) 
        {
            include_once 'templates/mwb_wocuf_pro_creation.php';
        } 
        elseif($active_tab == 'funnels-list')
        {
            include_once 'templates/mwb_wocuf_pro_funnels_list.php';
        }
        elseif($active_tab == 'shortcodes')
        {
            include_once 'templates/mwb_wocuf_pro_shortcodes.php';
        }
        elseif($active_tab == 'settings')
        {
        	include_once 'templates/mwb_wocuf_pro_settings.php';
        }
        elseif($active_tab == 'overview')
        {
            include_once 'templates/mwb_wocuf_overview.php';
        }
        
        do_action('mwb_wocuf_pro_setting_tab_html');
	?>
</div>
