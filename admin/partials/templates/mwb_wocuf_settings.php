<?php
/**
 * Exit if accessed directly
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php
if( isset( $_GET["mwb_wocuf_new_offer_page"] ) )
{
	$mwb_wocuf_new_page = sanitize_text_field( $_GET["mwb_wocuf_new_offer_page"] );

	unset( $_GET["mwb_wocuf_new_offer_page"] );

	if( $mwb_wocuf_new_page == "yes" )
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
    
	wp_redirect( admin_url( 'admin.php' ) . '?page=mwb-wocuf-setting&tab=settings' );
}
?>
<?php

if(isset($_POST["mwb_wocuf_common_settings_save"]))
{
	unset($_POST["mwb_wocuf_common_settings_save"]);

	if(!empty($_POST["mwb_wocuf_enable_plugin"]))
	{
		$_POST["mwb_wocuf_enable_plugin"] = 'on';
	}
	else
	{
		$_POST["mwb_wocuf_enable_plugin"] = 'off';
	}

	foreach( $_POST as $key => $data )
	{
		update_option( $key, sanitize_text_field( $data ) );
	}
	
	?>
	<div class="notice notice-success is-dismissible"> 
		<p><strong><?php _e('Settings saved','woocommerce_one_click_upsell_funnel'); ?></strong></p>
	</div>
	<?php
}  
?>
<?php

$mwb_wocuf_enable_plugin = get_option( "mwb_wocuf_enable_plugin", "off" );

$mwb_wocuf_buy_text = get_option( "mwb_wocuf_buy_text", __("Buy Now","woocommerce_one_click_upsell_funnel" ) );

$mwb_wocuf_no_text = get_option( "mwb_wocuf_no_text", __("Skip", "woocommerce_one_click_upsell_funnel" ) );

$mwb_wocuf_no_offer_text = get_option( "mwb_wocuf_no_offer_text", "" );

$mwb_wocuf_offer_banner_text = get_option( "mwb_wocuf_offer_banner_text", "" );

$mwb_wocuf_offer_default_page_id = get_option( "mwb_wocuf_funnel_default_offer_page", "" );

$mwb_wocuf_buy_button_color = get_option( "mwb_wocuf_buy_button_color", "" );

$mwb_wocuf_thanks_button_color = get_option( "mwb_wocuf_thanks_button_color", "" );

$mwb_wocuf_before_offer_price_text = get_option( "mwb_wocuf_before_offer_price_text", __("Special Offer Price","woocommerce_one_click_upsell_funnel" ) );

?>
<form action="" method="POST">
	<div class="mwb_table">
		<table class="form-table mwb_wocuf_creation_setting">
			<tbody>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="mwb_wocuf_enable_plugin"><?php _e('Enable One Click Upsell Funnel','woocommerce_one_click_upsell_funnel');?></label>
					</th>
					<td class="forminp forminp-text">
						<?php 
						$attribut_description = __('Enable the checkbox if you want this extension to work','woocommerce_one_click_upsell_funnel');
						echo wc_help_tip( $attribut_description );
						?>
						<input style="" type="checkbox" <?php echo ($mwb_wocuf_enable_plugin == 'on')?"checked='checked'":""?> name="mwb_wocuf_enable_plugin" id="mwb_wocuf_funnel_name" class="input-checkbox mwb_wocuf_common_class">				
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="mwb_wocuf_funnel_applied_rule"><?php _e('Applied only when customer selects','woocommerce_one_click_upsell_funnel');?></label>
					</th>
					<td class="forminp forminp-text">
						<?php 
						$attribut_description = __('Your funnel offers will be shown only at selected payment methods.','woocommerce_one_click_upsell_funnel');
						echo wc_help_tip( $attribut_description );
						?>
						<select style="" id="mwb_wocuf_funnel_applied_rule" name="mwb_wocuf_funnel_applied_rule">
							<option value="in_all_case"><?php _e('COD','woocommerce_one_click_upsell_funnel');?></option>
						</select>		
					</td>
				</tr>

				<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="mwb_wocuf_buy_text"><?php _e('Text for "Buy Now" Action','woocommerce_one_click_upsell_funnel');?></label>
					</th>
					<td class="forminp forminp-text">
						<?php 
						$attribut_description = __('Set text to be visible on "Buy Now" link','woocommerce_one_click_upsell_funnel');
						echo wc_help_tip( $attribut_description );
						?>
					<input style="" type="text" name="mwb_wocuf_buy_text" id="mwb_wocuf_buy_text" class="mwb_wocuf_common_class" value="<?php echo stripslashes( wp_filter_post_kses( $mwb_wocuf_buy_text ) ) ?> ">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="mwb_wocuf_no_text"><?php _e('Text for "No,thanks" Action','woocommerce_one_click_upsell_funnel');?></label>
					</th>
					<td class="forminp forminp-text">
						<?php 
						$attribut_description = __('Set text to be visible on "No,thanks" link.','woocommerce_one_click_upsell_funnel');
						echo wc_help_tip( $attribut_description );
						?>
					<input style="" type="text" name="mwb_wocuf_no_text" id="mwb_wocuf_no_text" class="mwb_wocuf_common_class" value="<?php echo stripslashes( wp_filter_post_kses( $mwb_wocuf_no_text ) )?>">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="mwb_wocuf_buy_button_color"><?php _e('Background Color for "Buy Now" button','woocommerce_one_click_upsell_funnel');?></label>
					</th>
					<td class="forminp forminp-text">
						<?php 
						$attribut_description = __('Background color for buy button','woocommerce_one_click_upsell_funnel');
						echo wc_help_tip( $attribut_description );
						?>
					<input type="text" style="max-width: 100px;" name="mwb_wocuf_buy_button_color" id="mwb_wocuf_buy_button_color" class="mwb_wocuf_colorpicker" value="<?php echo trim($mwb_wocuf_buy_button_color,'"')?>">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="mwb_wocuf_thanks_button_color"><?php _e('Background Color for "No,thanks" button','woocommerce_one_click_upsell_funnel');?></label>
					</th>
					<td class="forminp forminp-text">
						<?php 
						$attribut_description = __('Background color for thanks button','woocommerce_one_click_upsell_funnel');
						echo wc_help_tip( $attribut_description );
						?>
					<input style="max-width:100px" type="text" name="mwb_wocuf_thanks_button_color" id="mwb_wocuf_thanks_button_color" class="mwb_wocuf_colorpicker" value="<?php echo trim($mwb_wocuf_thanks_button_color,'"')?>">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="mwb_wocuf_no_offer_text"><?php _e('Text to show when a user has no offer','woocommerce_one_click_upsell_funnel');?></label>
					</th>
					<td class="forminp forminp-text">
						<?php 
						$attribut_description = __('Set text to be visible when an user has no offers.','woocommerce_one_click_upsell_funnel');
						echo wc_help_tip( $attribut_description );
						?>
					<input style="" type="text" name="mwb_wocuf_no_offer_text" id="mwb_wocuf_no_offer_text" class="mwb_wocuf_common_class" value="<?php echo stripslashes( wp_filter_post_kses( $mwb_wocuf_no_offer_text ) )?>">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="mwb_wocuf_offer_banner_text"><?php _e('Header text for special offer page','woocommerce_one_click_upsell_funnel');?></label>
					</th>
					<td class="forminp forminp-text">
						<?php 
						$attribut_description = __('Set the banner text for special offer page visible only when an user has offers.','woocommerce_one_click_upsell_funnel');
						echo wc_help_tip( $attribut_description );
						?>
					<input style="" type="text" name="mwb_wocuf_offer_banner_text" id="mwb_wocuf_offer_banner_text" class="mwb_wocuf_common_class" value="<?php echo stripslashes( wp_filter_post_kses($mwb_wocuf_offer_banner_text ) )?>">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="mwb_wocuf_before_offer_price_text"><?php _e('Text to display before new offer price','woocommerce_one_click_upsell_funnel');?></label>
					</th>
					<td class="forminp forminp-text">
						<?php 
						$attribut_description = __('Set the custom text which you want to show just before the new offer price.','woocommerce_one_click_upsell_funnel');
						echo wc_help_tip( $attribut_description );
						?>
					<input style="" type="text" name="mwb_wocuf_before_offer_price_text" id="mwb_wocuf_before_offer_price_text" class="mwb_wocuf_common_class" value="<?php echo stripslashes( wp_filter_post_kses( $mwb_wocuf_before_offer_price_text ) )?>">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="mwb_wocuf_offer_default_page_url"><?php _e('Default page url for Special Offers','woocommerce_one_click_upsell_funnel');?></label>
					</th>
					<td class="forminp forminp-text">
						<?php 
						$attribut_description = __('Default offer page url where special offers are displayed. Please do not delete.','woocommerce_one_click_upsell_funnel');
						echo wc_help_tip( $attribut_description );
						?>
					<?php 
					
					if( get_post_status( $mwb_wocuf_offer_default_page_id ) == "publish" )
					{
						$mwb_wocuf_offer_default_page_url = get_page_link($mwb_wocuf_offer_default_page_id);

						echo trim($mwb_wocuf_offer_default_page_url,'"');
					}
					else
					{
						?>
						<span style="color:red;display: inline;"><?php _e("Default Offer page not found or deleted.","woocommerce_one_click_upsell_funnel")?></span>
						<a href="?page=mwb-wocuf-setting&tab=settings&mwb_wocuf_new_offer_page=yes"><?php _e("Create new page","woocommerce_one_click_upsell_funnel")?></a>
						<?php 
					}
					?>
					</td>
				</tr>

				<tr valign="top"> 
					<th scope="row" class="titledesc">
						<label for="mwb_wocuf_offer_page_shortcode"><?php _e('Offer page shortcode','woocommerce_one_click_upsell_funnel');?></label>
					</th>
					<td class="forminp forminp-text">
						<?php 
						$attribut_description = __('This is the shortcode for offers page. If you are using custom page for offers then please change the page content with the shortcode.','woocommerce_one_click_upsell_funnel');
						echo wc_help_tip( $attribut_description );
						?>
					<?php echo "[mwb_wocuf_funnel_default_offer_page]"?>
					</td>
				</tr>

				<?php do_action("mwb_wocuf_create_more_settings");?>
			</tbody>
		</table>
	</div>
	<p class="submit">
	<input type="submit" value="<?php _e('Save changes', 'woocommerce_one_click_upsell_funnel'); ?>" class="button-primary woocommerce-save-button" name="mwb_wocuf_common_settings_save" id="mwb_wocuf_creation_setting_save" >
	</p>
</form>