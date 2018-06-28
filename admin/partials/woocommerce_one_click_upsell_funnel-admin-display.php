<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Woocommerce_one_click_upsell_funnel
 * @subpackage Woocommerce_one_click_upsell_funnel/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) 
{
	exit;
}

$active_tab = isset( $_GET[ 'tab' ] ) ? sanitize_text_field( $_GET[ 'tab' ] ) :'settings';

do_action('mwb_wocuf_setting_tab_active');

?>
<div class="wrap woocommerce" id="mwb_wocuf_setting_wrapper">

	<div class="hide"  id="mwb_wocuf_loader">	
		<img id="mwb-wocuf-loading-image" src="<?php echo plugin_dir_url( __FILE__ ) . 'templates/images/ajax-loader.gif'?>" >
	</div>

	<h1 class="mwb_wocuf_setting_title"><?php _e('One Click Upsell Funnel Setting', 'woocommerce_one_click_upsell_funnel')?></h1>
	
	<nav class="nav-tab-wrapper woo-nav-tab-wrapper">
		<a class="nav-tab <?php echo $active_tab == 'creation-setting' ? 'nav-tab-active' : ''; ?>" href="?page=mwb-wocuf-setting&tab=creation-setting"><?php _e('Edit/Create Funnel', 'woocommerce_one_click_upsell_funnel');?></a>
		<a class="nav-tab <?php echo $active_tab == 'funnels-list' ? 'nav-tab-active' : ''; ?>" href="?page=mwb-wocuf-setting&tab=funnels-list"><?php _e('All Funnels', 'woocommerce_one_click_upsell_funnel');?></a>
		<a class="nav-tab <?php echo $active_tab == 'settings' ? 'nav-tab-active' : ''; ?>" href="?page=mwb-wocuf-setting&tab=settings"><?php _e('Settings', 'woocommerce_one_click_upsell_funnel');?></a>
		<?php 
			do_action('mwb_wocuf_setting_tab');
		?>	
	</nav>
	<?php 

		if( $active_tab == 'creation-setting' ) 
        {
            include_once 'templates/mwb_wocuf_creation.php';
        } 
        elseif($active_tab == 'funnels-list')
        {
            include_once 'templates/mwb_wocuf_funnels_list.php';
        }
        elseif($active_tab == 'settings')
        {
        	?>
        	<div class="mwb-wocuf-main">
        	<?php
        		include_once 'templates/mwb_wocuf_settings.php';
    		?>
    		</div>
    		<div class="mwb-wocuf-pro-banner">
    			<h2 class="upsell-main-heading"><u><?php _e("Our PRO version","hubwoo")?></u></h2>
    			<a target="_new" href="https://makewebbetter.com/product/woocommerce-one-click-upsell-funnel-pro/"><img src="<?php echo plugin_dir_url( __FILE__ ) .'templates/images/upsell.jpg'?>"></a>
			    <h5 class="upsell-prod-name"><?php _e("WooCommerce One Click Upsell Funnel Pro","hubwoo");?></h5>
			    <p class="upsell-para"><?php _e("Main Features","hubwoo")?></p>
		    	<ul class="upsell-prod-ul">
			        <li><?php _e("Supports variable product","woocommerce_one_click_upsell_funnel")?></li>
			        <li><?php _e("Funnels can be scheduled","woocommerce_one_click_upsell_funnel")?></li>
			        <li><?php _e("Supports other woocommerce core payment methods like cheque, BACS","woocommerce_one_click_upsell_funnel")?></li>
			        <li><?php _e("PayPal Integration","woocommerce_one_click_upsell_funnel")?></li>
			        <li><?php _e("Stripe Integartion","woocommerce_one_click_upsell_funnel")?></li>
			        <li><?php _e("Cardcom Integration","woocommerce_one_click_upsell_funnel")?></li>
			        <li><?php _e("Support for custom page shortcodes which helps in designing new offer page","woocommerce_one_click_upsell_funnel")?></li>
		    	</ul>
			    <div class="upsell-btn-wrap">
			        <a target="_new" class="upsell-prod-link upsell-main-buy" href="https://makewebbetter.com/checkout/?add-to-cart=2965&utm_source=MWB-one-click-upsell-funnel-org&utm_medium=MWB-org%26utm_campaign&utm_campaign=MWB-one-click-upsell-funnel-org"><?php _e("Purchase Now","hubwoo")?></a>
			    </div>
    		</div>
    		<?php
        }

		do_action('mwb_wocuf_setting_tab_html');
	?>
</div>
