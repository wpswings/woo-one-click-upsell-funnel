<?php 
/**
 * Exit if accessed directly
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/*
 * General Settings Template
 */

function mwb_wocuf_array_push_assoc($array, $key, $value)
{
	$array[$key] = $value;
	return $array;
}

$flag = 0;

if( !isset( $_GET["funnel_id"] ) )
{
	$mwb_wocuf_funnels = get_option( "mwb_wocuf_funnels_list", array() );

	if( !empty( $mwb_wocuf_funnels ) )
	{
		$mwb_wocuf_funnel_duplicate = $mwb_wocuf_funnels;
		end($mwb_wocuf_funnel_duplicate);
		$mwb_wocuf_funnel_number = key($mwb_wocuf_funnel_duplicate);
		$mwb_wocuf_funnel_id =$mwb_wocuf_funnel_number+1;
	}
	else
	{
		$mwb_wocuf_funnel_id = 0;	
	}
}
else
{
	$mwb_wocuf_funnel_id = sanitize_text_field( $_GET["funnel_id"] );
}

if( isset( $_POST['mwb_wocuf_creation_setting_save'] ) )
{
	unset($_POST['mwb_wocuf_creation_setting_save']);
	
	$mwb_wocuf_funnel_id = sanitize_text_field( $_POST["mwb_wocuf_funnel_id"] );

	if( empty( $_POST["mwb_wocuf_target_pro_ids"] ) || ( isset( $_POST["mwb_wocuf_global_funnel"] ) && $_POST[ "mwb_wocuf_global_funnel"] == "yes" ) )
	{
		$_POST["mwb_wocuf_target_pro_ids"] = array();
	}

	$mwb_wocuf_funnel = array();

	foreach($_POST as $key=>$data)
	{
		$mwb_wocuf_funnel = mwb_wocuf_array_push_assoc($mwb_wocuf_funnel,$key,$data);		
	}

	$mwb_wocuf_funnel_series=array();
	
	$mwb_wocuf_funnel_series[$mwb_wocuf_funnel_id] = $mwb_wocuf_funnel;

	$mwb_wocuf_created_funnels = get_option( "mwb_wocuf_funnels_list", array() );

	if( is_array( $mwb_wocuf_created_funnels ) && count( $mwb_wocuf_created_funnels ) )
	{
		
		foreach( $mwb_wocuf_created_funnels as $key => $data )
		{
			if( $key == $mwb_wocuf_funnel_id )
			{
				$mwb_wocuf_created_funnels[$key] = $mwb_wocuf_funnel_series[$mwb_wocuf_funnel_id];
				$flag = 1;
				break;
			}
		}
		if($flag!=1)
		{
			$mwb_wocuf_created_funnels = array_merge($mwb_wocuf_created_funnels,$mwb_wocuf_funnel_series);
		}

		update_option( "mwb_wocuf_funnels_list", $mwb_wocuf_created_funnels );
	}
	else
	{
		update_option( "mwb_wocuf_funnels_list", $mwb_wocuf_funnel_series );
	}
	

	?>
	<div class="notice notice-success is-dismissible"> 
		<p><strong><?php _e('Settings saved','woocommerce_one_click_upsell_funnel'); ?></strong></p>
	</div>
	<?php
}	

$mwb_wocuf_funnel_data = get_option("mwb_wocuf_funnels_list", array() );

?>
<form action="" method="POST">
	<div class="mwb_table">
		<table class="form-table mwb_wocuf_creation_setting">
			<tbody>
				<input type="hidden" name="mwb_wocuf_funnel_id" value="<?php echo $mwb_wocuf_funnel_id?>">
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="mwb_wocuf_funnel_name"><?php _e('Funnel Name','woocommerce_one_click_upsell_funnel');?></label>
					</th>
					<td class="forminp forminp-text"> 
						<?php 
						$attribut_description = __('Provide the name of your funnel','woocommerce_one_click_upsell_funnel');
						echo wc_help_tip( $attribut_description );
						?>
						<input type="text" name="mwb_wocuf_funnel_name" <?php if(!empty($mwb_wocuf_funnel_data[$mwb_wocuf_funnel_id]["mwb_wocuf_funnel_name"])){?> value="<?php echo stripslashes( wp_filter_post_kses( $mwb_wocuf_funnel_data[$mwb_wocuf_funnel_id]["mwb_wocuf_funnel_name"] ) )?>" <?php }else{?> value="<?php _e("Untitled Funnel ","woocommerce_one_click_upsell_funnel"); echo $mwb_wocuf_funnel_id+1?>" <?php } ?> id="mwb_wocuf_funnel_name" class="input-text mwb_wocuf_commone_class" required="">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="mwb_wocuf_target_pro_ids"><?php _e('Make it a global funnel','woocommerce_one_click_upsell_funnel');?></label>
					</th>
					<td class="forminp forminp-text">
						<?php 
						$attribut_description = __('Do you want to make this funnel global? Global funnels will always show up the offers no matter what are its target products.','woocommerce_one_click_upsell_funnel');
						echo wc_help_tip( $attribut_description );
						?>

						<select style="" name="mwb_wocuf_global_funnel" class="mwb_wocuf_global_funnel">

						<?php

						$mwb_wocuf_global_funnel = !empty( $mwb_wocuf_funnel_data[$mwb_wocuf_funnel_id]["mwb_wocuf_global_funnel"] )?$mwb_wocuf_funnel_data[$mwb_wocuf_funnel_id]["mwb_wocuf_global_funnel"]:'no';
						
						if ( $mwb_wocuf_global_funnel == "yes" ) 
						{
							?>
							<option selected value="yes"><?php _e("Yes","woocommerce_one_click_upsell_funnel")?></option>
							<option value="no"><?php _e("No","woocommerce_one_click_upsell_funnel")?></option>
							<?php
						}
						else
						{
							?>
							<option value="yes"><?php _e("Yes","woocommerce_one_click_upsell_funnel")?></option>
							<option selected value="no"><?php _e("No","woocommerce_one_click_upsell_funnel")?></option>
							<?php
						}
						
						?>
						</select>		
					</td>	
				</tr>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="mwb_wocuf_target_pro_ids"><?php _e('Select Target Product','woocommerce_one_click_upsell_funnel');?></label>
					</th>
					<td class="forminp forminp-text">
						<?php 
						$attribut_description = __('Select the product which become the Target Product in Checkout Page','woocommerce_one_click_upsell_funnel');
						echo wc_help_tip( $attribut_description );
						?>

						<select id="mwb_wocuf_funnel_targets" class="wc-funnel-product-search" multiple="multiple" style="" name="mwb_wocuf_target_pro_ids[]" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', 'woocommerce_one_click_upsell_funnel' ); ?>">

						<?php

						$mwb_wocuf_target_products = !empty( $mwb_wocuf_funnel_data[$mwb_wocuf_funnel_id]["mwb_wocuf_target_pro_ids"] )?$mwb_wocuf_funnel_data[$mwb_wocuf_funnel_id]["mwb_wocuf_target_pro_ids"]:array();

						$mwb_wocuf_target_product_ids = ! empty( $mwb_wocuf_target_products ) ? array_map( 'absint',  $mwb_wocuf_target_products ) : null;
						
						if ( $mwb_wocuf_target_product_ids ) 
						{
							foreach ( $mwb_wocuf_target_product_ids as $mwb_wocuf_single_target_product_id ) 
							{
								$product_name = get_the_title($mwb_wocuf_single_target_product_id);
								echo '<option value="'.$mwb_wocuf_single_target_product_id.'" selected="selected">' .$product_name.'(#'.$mwb_wocuf_single_target_product_id.')'.'</option>';
							}
						}
						
						?>
						</select>		
					</td>	
				</tr>
			</tbody>
		</table>
		
		<div class="mwb_wocuf_offers"><h1><?php _e('Offers in Funnel','woocommerce_one_click_upsell_funnel');?></h1></div><br>
		<?php 

		$mwb_wocuf_existing_offers = !empty($mwb_wocuf_funnel_data[$mwb_wocuf_funnel_id]["mwb_wocuf_applied_offer_number"])?$mwb_wocuf_funnel_data[$mwb_wocuf_funnel_id]["mwb_wocuf_applied_offer_number"]:"";

		$mwb_wocuf_products_offer = !empty($mwb_wocuf_funnel_data[$mwb_wocuf_funnel_id]["mwb_wocuf_products_in_offer"])?$mwb_wocuf_funnel_data[$mwb_wocuf_funnel_id]["mwb_wocuf_products_in_offer"]:"";

		$mwb_wocuf_products_discount = !empty($mwb_wocuf_funnel_data[$mwb_wocuf_funnel_id]["mwb_wocuf_offer_discount_price"])?$mwb_wocuf_funnel_data[$mwb_wocuf_funnel_id]["mwb_wocuf_offer_discount_price"]:"";

		$mwb_wocuf_offers_buy_on_offers = !empty($mwb_wocuf_funnel_data[$mwb_wocuf_funnel_id]["mwb_wocuf_attached_offers_on_buy"])?$mwb_wocuf_funnel_data[$mwb_wocuf_funnel_id]["mwb_wocuf_attached_offers_on_buy"]:"";

		$mwb_wocuf_offers_no_thanks_offers = !empty($mwb_wocuf_funnel_data[$mwb_wocuf_funnel_id]["mwb_wocuf_attached_offers_on_no"])?$mwb_wocuf_funnel_data[$mwb_wocuf_funnel_id]["mwb_wocuf_attached_offers_on_no"]:"";

		$mwb_wocuf_offer_custom_page_url = !empty($mwb_wocuf_funnel_data[$mwb_wocuf_funnel_id]["mwb_wocuf_offer_custom_page_url"])?$mwb_wocuf_funnel_data[$mwb_wocuf_funnel_id]["mwb_wocuf_offer_custom_page_url"]:"";

		$mwb_wocuf_offers_to_add = $mwb_wocuf_existing_offers;

		$offer_count = 0;

		?>
		<div class="new_offers">
			<div class="new_created_offers" data-id="0">
			</div>
			<?php if(!empty($mwb_wocuf_existing_offers))
			{
				foreach($mwb_wocuf_existing_offers as $offers=>$mwb_wocuf_single_offer)
				{
					$mwb_wocuf_buy_attached_offers="";

					$mwb_wocuf_no_attached_offers="";

					if( !empty( $mwb_wocuf_offers_to_add ) )
					{
						foreach($mwb_wocuf_offers_to_add as $mwb_single_offer_to_add):

							if($mwb_single_offer_to_add != $mwb_wocuf_single_offer)
							{

								$mwb_wocuf_buy_attached_offers.='<option value='.$mwb_single_offer_to_add.'>'.__('Offer','woocommerce_one_click_upsell_funnel').$mwb_single_offer_to_add.'</option>';
							
								$mwb_wocuf_no_attached_offers.='<option value='.$mwb_single_offer_to_add.'>'.__('Offer','woocommerce_one_click_upsell_funnel').$mwb_single_offer_to_add.'</option>';
							}

						endforeach;
					}

					$mwb_wocuf_buy_offers="";

					if(!empty($mwb_wocuf_offers_buy_on_offers))
					{
					
						if( $mwb_wocuf_offers_buy_on_offers[$offers] == 'thanks' )
						{
							$mwb_wocuf_buy_offers='<select style="" name="mwb_wocuf_attached_offers_on_buy['.$mwb_wocuf_single_offer.']"><option value="thanks" selected="">'.__('ThankYou Page','woocommerce_one_click_upsell_funnel').'</option>'.$mwb_wocuf_buy_attached_offers;
						}
						elseif( $mwb_wocuf_offers_buy_on_offers[$offers] > 0 )
						{
							$mwb_wocuf_buy_offers='<select style="" name="mwb_wocuf_attached_offers_on_buy['.$mwb_wocuf_single_offer.']"><option value="thanks">'.__('ThankYou Page','woocommerce_one_click_upsell_funnel').'</option>';

							if(!empty($mwb_wocuf_offers_to_add))
							{
								foreach($mwb_wocuf_offers_to_add as $mwb_single_offer_to_add)
								{
									if($mwb_single_offer_to_add != $mwb_wocuf_single_offer)
									{
										if($mwb_wocuf_offers_buy_on_offers[$offers]==$mwb_single_offer_to_add)
										{
											$mwb_wocuf_buy_offers.='<option value='.$mwb_single_offer_to_add.' selected="">'.__('Offer','woocommerce_one_click_upsell_funnel').$mwb_single_offer_to_add.'</option>';
										}
										else
										{
											$mwb_wocuf_buy_offers.='<option value='.$mwb_single_offer_to_add.'>'.__('Offer','woocommerce_one_click_upsell_funnel').$mwb_single_offer_to_add.'</option>';
										}
									}
								}
							}
						}
					}

					$mwb_wocuf_no_offers="";

					if(!empty($mwb_wocuf_offers_no_thanks_offers))
					{
						if($mwb_wocuf_offers_no_thanks_offers[$offers]=='thanks')
						{
							$mwb_wocuf_no_offers='<select style="" name="mwb_wocuf_attached_offers_on_no['.$mwb_wocuf_single_offer.']"><option value="thanks">'.__('ThankYou Page','woocommerce_one_click_upsell_funnel').'</option>'.$mwb_wocuf_no_attached_offers;
						}
						elseif($mwb_wocuf_offers_no_thanks_offers[$offers]>0)
						{
							$mwb_wocuf_no_offers = '<select style="" name="mwb_wocuf_attached_offers_on_no['.$mwb_wocuf_single_offer.']"><option value="thanks">'.__('ThankYou Page','woocommerce_one_click_upsell_funnel').'</option>';
							if(!empty($mwb_wocuf_offers_to_add))
							{
								foreach($mwb_wocuf_offers_to_add as $mwb_single_offer_to_add)
								{
								
									if($mwb_wocuf_single_offer != $mwb_single_offer_to_add)
									{
										if($mwb_wocuf_offers_no_thanks_offers[$offers]==$mwb_single_offer_to_add)
										{
											$mwb_wocuf_no_offers.='<option value='.$mwb_single_offer_to_add.' selected="">'.__('Offer','woocommerce_one_click_upsell_funnel').$mwb_single_offer_to_add.'</option>';
										}
										else
										{
											$mwb_wocuf_no_offers.='<option value='.$mwb_single_offer_to_add.'>'.__('Offer','woocommerce_one_click_upsell_funnel').$mwb_single_offer_to_add.'</option>';
										}
									}
								}
							}
						}
					}
					
					$mwb_wocuf_buy_offers.='</select>';

					$mwb_wocuf_no_offers.='</select>';

					?>
					<div class="new_created_offers" data-id="<?php echo $mwb_wocuf_single_offer?>">
						<h2>
							<?php _e('Offer#','woocommerce_one_click_upsell_funnel')?>
							<?php echo $mwb_wocuf_single_offer?>
						</h2>
						<table>
							<tr>
								<th><label><h4><?php _e('Product Search : ','woocommerce_one_click_upsell_funnel')?></h4></label>
								</th>
								<td>
								<select class="wc-funnel-product-search" multiple="multiple" name="mwb_wocuf_products_in_offer[<?php echo $offers?>][]" data-placeholder="<?php _e( 'Search for a product','woocommerce_one_click_upsell_funnel')?>" data-action="woocommerce_json_search_products_and_variations" id="mwb_wocuf_target_pro_ids">
								<?php
								
									$mwb_wocuf_offers_products=$mwb_wocuf_products_offer[$offers];

									$mwb_wocuf_target_offer_ids = ! empty( $mwb_wocuf_offers_products ) ? array_map( 'absint',  $mwb_wocuf_offers_products ) : null;
									
									if ( $mwb_wocuf_target_offer_ids ) 
									{
										foreach ( $mwb_wocuf_target_offer_ids as $mwb_wocuf_single_target_offer_id ) 
										{
											
											$product_name = get_the_title($mwb_wocuf_single_target_offer_id);
											?>
											<option value="<?php echo $mwb_wocuf_single_target_offer_id ?>" selected="selected"><?php echo $product_name."(# $mwb_wocuf_single_target_offer_id)" ?>
											</option>
											<?php
										}
									}
								?>
								</select>
								</td>
							</tr>
							
						    <tr>
							    <th><label><h4><?php _e('Offer Price: ','woocommerce_one_click_upsell_funnel')?></h4></label></th>
							    <td>
							    <input type="text" style="width:50%;height:40px;" placeholder="<?php _e('enter with percentage or a numeric value','woocommerce_one_click_upsell_funnel')?>" name="mwb_wocuf_offer_discount_price[<?php echo $offers?>]" value="<?php echo $mwb_wocuf_products_discount[$offers]?>">
							    <span style="color:green"><?php _e(" Note: Enter in % or a new offer price","woocommerce_one_click_upsell_funnel")?></span>
							    </td>
						    </tr>

						    <tr>
							    <th><label><h4><?php _e('After "Buy Now" Go to : ','woocommerce_one_click_upsell_funnel')?></h4></label></th>
							    <td><?php echo $mwb_wocuf_buy_offers;?></td>
							    </tr>
							   	<tr><th>
							    <label><h4><?php _e('After "No thanks" Go to : ','woocommerce_one_click_upsell_funnel')?></h4></label></th>
							    <td>
							    <?php echo $mwb_wocuf_no_offers;?>
							    </td>
						    </tr>

						    <tr>
							    <th><label><h4><?php _e('Custom Offer Page Url:','woocommerce_one_click_upsell_funnel')?></h4></label></th>
							    <td>
							    <input type="text" style="width:50%;height:40px;" placeholder="<?php _e('enter page url for special offers','woocommerce_one_click_upsell_funnel')?>" name="mwb_wocuf_offer_custom_page_url[<?php echo $offers?>]" value="<?php echo $mwb_wocuf_offer_custom_page_url[$offers]?>"><span style="color:green"><?php _e(" Note : Leave it blank to use default page ","woocommerce_one_click_upsell_funnel")?></span>
							    </td>
						    </tr>

						    <tr>
							    <td colspan="2">
							    <button style="color:white;background-color:red;height:30px;cursor: pointer;" class="mwb_wocuf_delete_old_created_offers" data-id="<?php echo $mwb_wocuf_single_offer ?>"><?php _e('Delete','woocommerce_one_click_upsell_funnel');?></button>
							    </td>
						    </tr>
					    </table>
					    <input type="hidden" name="mwb_wocuf_applied_offer_number[<?php echo $offers?>]" value="<?php echo $mwb_wocuf_single_offer?>">
					    <?php $offer_count = $offers;?>
				    </div>
			    <?php
				}
			}
			?>
		</div>

		<div class="mwb_wocuf_new_offer">
			<button id="create_new_offer" class="mwb_wocuf_create_new_offer" data-id="<?php echo $mwb_wocuf_funnel_id?>" data-offer="<?php echo $offer_count ?>">
			<?php _e('Add New Offer','woocommerce_one_click_upsell_funnel');?>
			</button>
		</div>
		
		<?php 
		do_action('mwb_wocuf_general_setting');
		?>
				
		<p class="submit">
			<input type="submit" value="<?php _e('Save Changes', 'woocommerce_one_click_upsell_funnel'); ?>" class="button-primary woocommerce-save-button" name="mwb_wocuf_creation_setting_save" id="mwb_wocuf_creation_setting_save" >
		</p>
	</div>
</form>