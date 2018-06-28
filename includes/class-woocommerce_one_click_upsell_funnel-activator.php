<?php

/**
 * Fired during plugin activation
 *
 * @link       http://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Woocommerce_one_click_upsell_funnel
 * @subpackage Woocommerce_one_click_upsell_funnel/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Woocommerce_one_click_upsell_funnel
 * @subpackage Woocommerce_one_click_upsell_funnel/includes
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Woocommerce_one_click_upsell_funnel_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */

	
	
	public static function activate() 
	{
		/**
		 * generating default offer page at the time of plugin activation
		 */
		$mwb_wocuf_offer_default_page_id = get_option( "mwb_wocuf_funnel_default_offer_page", "" );

		if( empty( $mwb_wocuf_offer_default_page_id ) || ( get_post_status( $mwb_wocuf_offer_default_page_id ) !== "publish" ) )
		{
	       	$mwb_wocuf_funnel_page = array(
				'comment_status' 	=> 'closed',
				'ping_status' 		=> 'closed',
				'post_content' 		=> '[mwb_wocuf_funnel_default_offer_page]',
				'post_name' 		=> 'special-discount-offer',
				'post_status' 		=> 'publish',
				'post_title' 		=> 'Special Discount Offer',
				'post_type' 		=> 'page',
			);

        	$mwb_wocuf_post = wp_insert_post( $mwb_wocuf_funnel_page );
       		update_option( "mwb_wocuf_funnel_default_offer_page", $mwb_wocuf_post );
       	}
	}
	//end of class
}
