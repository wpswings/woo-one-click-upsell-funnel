<?php
/**
 * Exit if accessed directly
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/*
 * Funnels Listing Template
 */
?>
<?php
if( isset( $_GET["del_funnel_id"] ) )
{
	$funnel_id = sanitize_text_field( $_GET["del_funnel_id"] );

	$mwb_wocuf_funnels = get_option( "mwb_wocuf_funnels_list", array() );

	foreach( $mwb_wocuf_funnels as $single_funnel => $data )
	{
		if( $funnel_id == $single_funnel )
		{
			unset( $mwb_wocuf_funnels[$single_funnel] );
			break;
		}
	}

	$mwb_wocuf_funnels = array_values( $mwb_wocuf_funnels );

	update_option( "mwb_wocuf_funnels_list", $mwb_wocuf_funnels );

	wp_redirect( admin_url('admin.php').'?page=mwb-wocuf-setting&tab=funnels-list' );

	exit();
}
?>
<?php

$mwb_wocuf_funnels_list = get_option("mwb_wocuf_funnels_list", array() );

if(!empty($mwb_wocuf_funnels_list))
{
	$mwb_wocuf_funnel_duplicate = $mwb_wocuf_funnels_list;
	end($mwb_wocuf_funnel_duplicate);
	$mwb_wocuf_funnel_number = key($mwb_wocuf_funnel_duplicate);
}
else
{
	$mwb_wocuf_funnel_number = -1;
}
?>
<div class="mwb_wocuf_funnels_list">
	<h1><?php _e('Your Funnels','woocommerce_one_click_upsell_funnel');?></h1>
	<?php if(empty($mwb_wocuf_funnels_list)):?>
		<p class="mwb_wocuf_no_funnel"><?php _e('No funnels added','woocommerce_one_click_upsell_funnel');?></p>
	<?php endif; ?>
	<?php if(!empty($mwb_wocuf_funnels_list)):?>
		<table>
			<tr>
				<th><?php _e('Funnel Name','woocommerce_one_click_upsell_funnel');?></th>
				<th><?php _e('Target Products','woocommerce_one_click_upsell_funnel');?></th>
				<th><?php _e('Offers Added ','woocommerce_one_click_upsell_funnel');?></th>
				<th><?php _e('Action','woocommerce_one_click_upsell_funnel');?></th>
				<?php do_action("mwb_wocuf_funnel_add_more_col_head");?>
			</tr>
			<?php foreach ($mwb_wocuf_funnels_list as $key => $value):
				$offers_count = !empty($value["mwb_wocuf_applied_offer_number"])?$value["mwb_wocuf_applied_offer_number"]:array();?>
				<tr>
					<td><a href="?page=mwb-wocuf-setting&tab=creation-setting&funnel_id=<?php echo $key?>"><?php echo stripslashes( wp_filter_post_kses( $value["mwb_wocuf_funnel_name"] ) )?></a></td>
					<td>
					<?php if(!empty($value["mwb_wocuf_target_pro_ids"])){?>
						<?php foreach($value["mwb_wocuf_target_pro_ids"] as $single_target_product):
							$product = wc_get_product($single_target_product);
							$product_id = $product->get_id();
							$post_link = get_edit_post_link($product_id);
						?>
							<p>
							<a href="<?php echo $post_link ?>"><?php echo $product->get_title().'(#'.$product->get_id().')';?></a>
							</p>
						<?php endforeach;?>
					<?php } else {?>
						<p><?php _e("No products added","woocommerce_one_click_upsell_funnel");?></p>
					<?php }?>
					</td>
					<td><p><?php echo count($offers_count) ?></p></td> 
					<td>
					<p><a class="mwb_wocuf_funnel_links" href="?page=mwb-wocuf-setting&tab=creation-setting&funnel_id=<?php echo $key?>"><?php _e('View','woocommerce_one_click_upsell_funnel');?></a></p>
					<p><a class="mwb_wocuf_funnel_links" href="?page=mwb-wocuf-setting&tab=funnels-list&del_funnel_id=<?php echo $key?>"><?php _e('Delete','woocommerce_one_click_upsell_funnel');?></a><p></td>
					<?php do_action("mwb_wocuf_funnel_add_more_col_data");?>
				</tr>
			<?php endforeach;?>
		</table>
	<?php endif;?>
</div>
<br>
<div class="mwb_wocuf_create_new_funnel">
<a href="?page=mwb-wocuf-setting&tab=creation-setting&funnel_id=<?php echo $mwb_wocuf_funnel_number+1 ?>"><?php _e('+Create New Funnel','woocommerce_one_click_upsell_funnel')?></a>
</div>
<?php
do_action("mwb_wocuf_extend_funnels_listing");
?>