<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used for listing all the shortcodes of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package     woo_one_click_upsell_funnel
 * @subpackage  woo_one_click_upsell_funnel/admin/partials/templates
 */

/**
 * Exit if accessed directly
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="mwb_upsell_table mwb_upsell_new_shortcodes">
	<table class="form-table mwb_wocuf_pro_shortcodes">
			<tbody>
				<!-- Upsell Action shortcodes start-->
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label><?php esc_html_e( 'Upsell Action shortcodes', 'woocommerce_one_click_upsell_funnel' ); ?></label>
					</th>
					<td class="forminp forminp-text">
						<div class="mwb_upsell_shortcode_div">
							<p class="mwb_upsell_shortcode">
								<?php
								$attribute_description = sprintf( '<p class="mwb_upsell_tip_tip">%s</p><p class="mwb_upsell_tip_tip">%s</p>', esc_html__( 'Accept Offer.', 'woocommerce_one_click_upsell_funnel' ), esc_html__( 'This shortcode only returns the link so it has to be used in the link section. In html use it as href="[mwb_upsell_yes]" of anchor tag.', 'woocommerce_one_click_upsell_funnel' ) );
								echo wc_help_tip( $attribute_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
								<span class="mwb_upsell_shortcode_title"><?php esc_html_e( 'Buy Now &rarr;', 'woocommerce_one_click_upsell_funnel' ); ?></span>
								<span class="mwb_upsell_shortcode_content"><?php echo '[mwb_upsell_yes]'; ?></span>
							</p>
						</div>
						<div class="mwb_upsell_shortcode_div" >
							<p class="mwb_upsell_shortcode">
								<?php
								$attribute_description = sprintf( '<p class="mwb_upsell_tip_tip">%s</p><p class="mwb_upsell_tip_tip">%s</p>', esc_html__( 'Reject Offer.', 'woocommerce_one_click_upsell_funnel' ), esc_html__( 'This shortcode only returns the link so it has to be used in the link section. In html use it as href="[mwb_upsell_no]" of anchor tag.', 'woocommerce_one_click_upsell_funnel' ) );
								echo wc_help_tip( $attribute_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
								<span class="mwb_upsell_shortcode_title"><?php esc_html_e( 'No Thanks &rarr;', 'woocommerce_one_click_upsell_funnel' ); ?></span>
								<span class="mwb_upsell_shortcode_content"><?php echo '[mwb_upsell_no]'; ?></span>
							</p>
						</div>		
					</td>
				</tr>
				<!-- Upsell Action shortcodes end-->

				<!-- Product shortcodes start-->
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label><?php esc_html_e( 'Product shortcodes', 'woocommerce_one_click_upsell_funnel' ); ?></label>
					</th>
					<td class="forminp forminp-text">
						<div class="mwb_upsell_shortcode_div">
							<p class="mwb_upsell_shortcode">
								<?php
								$attribute_description = sprintf( '<p class="mwb_upsell_tip_tip">%s</p>', esc_html__( 'This shortcode returns the product title.', 'woocommerce_one_click_upsell_funnel' ) );
								echo wc_help_tip( $attribute_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
								<span class="mwb_upsell_shortcode_title"><?php esc_html_e( 'Product Title &rarr;', 'woocommerce_one_click_upsell_funnel' ); ?></span>
								<span class="mwb_upsell_shortcode_content"><?php echo '[mwb_upsell_title]'; ?></span>
							</p>
						</div>
						<div class="mwb_upsell_shortcode_div" >
							<p class="mwb_upsell_shortcode">
								<?php
								$attribute_description = sprintf( '<p class="mwb_upsell_tip_tip">%s</p>', esc_html__( 'This shortcode returns the product description.', 'woocommerce_one_click_upsell_funnel' ) );
								echo wc_help_tip( $attribute_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
								<span class="mwb_upsell_shortcode_title"><?php esc_html_e( 'Product Description &rarr;', 'woocommerce_one_click_upsell_funnel' ); ?></span>
								<span class="mwb_upsell_shortcode_content"><?php echo '[mwb_upsell_desc]'; ?></span>
							</p>
						</div>	
						<div class="mwb_upsell_shortcode_div" >
							<p class="mwb_upsell_shortcode">
								<?php
								$attribute_description = sprintf( '<p class="mwb_upsell_tip_tip">%s</p>', esc_html__( 'This shortcode returns the product short description.', 'woocommerce_one_click_upsell_funnel' ) );
								echo wc_help_tip( $attribute_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
								<span class="mwb_upsell_shortcode_title"><?php esc_html_e( 'Product Short Description &rarr;', 'woocommerce_one_click_upsell_funnel' ); ?></span>
								<span class="mwb_upsell_shortcode_content"><?php echo '[mwb_upsell_desc_short]'; ?></span>
							</p>
						</div>	
						<hr class="mwb_upsell_shortcodes_hr">
						<div class="mwb_upsell_shortcode_div" >
							<p class="mwb_upsell_shortcode">
								<?php
								$attribute_description = sprintf( '<p class="mwb_upsell_tip_tip">%s</p>', esc_html__( 'This shortcode returns the product image.', 'woocommerce_one_click_upsell_funnel' ) );
								echo wc_help_tip( $attribute_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
								<span class="mwb_upsell_shortcode_title"><?php esc_html_e( 'Product Image &rarr;', 'woocommerce_one_click_upsell_funnel' ); ?></span>
								<span class="mwb_upsell_shortcode_content"><?php echo '[mwb_upsell_image]'; ?></span>
							</p>
						</div>
						<div class="mwb_upsell_shortcode_div" >
							<p class="mwb_upsell_shortcode">
								<?php
								$attribute_description = sprintf( '<p class="mwb_upsell_tip_tip">%s</p>', esc_html__( 'This shortcode returns the product price.', 'woocommerce_one_click_upsell_funnel' ) );
								echo wc_help_tip( $attribute_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
								<span class="mwb_upsell_shortcode_title"><?php esc_html_e( 'Product Price &rarr;', 'woocommerce_one_click_upsell_funnel' ); ?></span>
								<span class="mwb_upsell_shortcode_content"><?php echo '[mwb_upsell_price]'; ?></span>
							</p>
						</div>
						<div class="mwb_upsell_shortcode_div" >
							<p class="mwb_upsell_shortcode">
								<?php
								$attribute_description = sprintf( '<p class="mwb_upsell_tip_tip">%s</p>', esc_html__( '( Only for Pro ) This shortcode returns the product variations if offer product is a variable product.', 'woocommerce_one_click_upsell_funnel' ) );
								echo wc_help_tip( $attribute_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
								<span class="mwb_upsell_shortcode_title"><?php esc_html_e( 'Product Variations &rarr;', 'woocommerce_one_click_upsell_funnel' ); ?></span>
								<span class="mwb_upsell_shortcode_content"><?php echo '[mwb_upsell_variations]'; ?></span>
							</p>
						</div>
					</td>
				</tr>
				<!-- Product shortcodes start-->

				<!-- Product shortcodes start-->
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label><?php esc_html_e( 'Other shortcodes', 'woocommerce_one_click_upsell_funnel' ); ?></label>
					</th>
					<td class="forminp forminp-text">
						<div class="mwb_upsell_shortcode_div">
							<p class="mwb_upsell_shortcode">
								<?php
								$attribute_description = sprintf( '<p class="mwb_upsell_tip_tip">%s</p>', esc_html__( 'This shortcode returns Star ratings. You can the specify the number of stars like [mwb_upsell_star_review stars=4.5] .', 'woocommerce_one_click_upsell_funnel' ) );
								echo wc_help_tip( $attribute_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
								<span class="mwb_upsell_shortcode_title"><?php esc_html_e( 'Star Ratings &rarr;', 'woocommerce_one_click_upsell_funnel' ); ?></span>
								<span class="mwb_upsell_shortcode_content"><?php echo '[mwb_upsell_star_review]'; ?></span>
							</p>
						</div>
					</td>
				</tr>
				<!-- Product shortcodes start-->
				
			</tbody>
		</table>
</div>

<div class="mwb_upsell_old_shortcodes_title">
	<h2><?php esc_html_e( 'Old shortcodes ( Deprecated )', 'woocommerce_one_click_upsell_funnel' ); ?></h2>
	<a href="#" class="mwb_upsell_old_shortcodes_link"><img src="<?php echo MWB_WOCUF_URL . 'admin/resources/down.png'; ?>"></a>
</div>

<div class="mwb_upsell_table mwb_upsell_old_shortcodes">
		<table class="form-table mwb_wocuf_pro_shortcodes">
			<tbody>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="mwb_wocuf_pro_shortcode_2"><?php esc_html_e( 'Shortcode for "Buy Now"', 'woocommerce_one_click_upsell_funnel' ); ?></label>
					</th>
					<td class="forminp forminp-text">
						<p>
							<?php
							$attribut_description = esc_html_e( 'This is the shortcode for accepting the offer on custom page.', 'woocommerce_one_click_upsell_funnel' );
							echo wc_help_tip( $attribut_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
							<?php esc_html_e( 'Single Mode', 'woocommerce_one_click_upsell_funnel' ); ?>
							<?php echo ' : [mwb_wocuf_pro_yes]'; ?>
						</p>
						<p>
							<?php
							$attribut_description = esc_html_e( 'This is the shortcode for accepting the offer on custom page. In wrapping mode, custom text can be used in between shortcodes.', 'woocommerce_one_click_upsell_funnel' );
							echo wc_help_tip( $attribut_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
							<?php esc_html_e( 'Wrapping Mode', 'woocommerce_one_click_upsell_funnel' ); ?>
							<?php echo ':[mwb_wocuf_pro_yes]...[/mwb_wocuf_pro_yes]'; ?>
						</p>		
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="mwb_wocuf_pro_shortcode_3"><?php esc_html_e( 'Shortcode for "No,thanks"', 'woocommerce_one_click_upsell_funnel' ); ?></label>
					</th>
					<td class="forminp forminp-text">
						<p>
							<?php
							$attribut_description = esc_html_e( 'This is the shortcode for rejecting the offer on custom page.', 'woocommerce_one_click_upsell_funnel' );
							echo wc_help_tip( $attribut_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
							<?php esc_html_e( 'Single Mode', 'woocommerce_one_click_upsell_funnel' ); ?>
							<?php echo esc_html( ' : [mwb_wocuf_pro_no]' ); ?>
						</p>
						<p>
							<?php
							$attribut_description = esc_html_e( 'This is the shortcode for rejecting the offer on custom page. In wrapping mode, custom text can be used in between shortcodes.', 'woocommerce_one_click_upsell_funnel' );
							echo wc_help_tip( $attribut_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
							<?php esc_html_e( 'Wrapping Mode', 'woocommerce_one_click_upsell_funnel' ); ?>
							<?php echo esc_html( ' : [mwb_wocuf_pro_no]...[/mwb_wocuf_pro_no]' ); ?>
						</p>				
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="mwb_wocuf_pro_shortcode_5"><?php esc_html_e( 'Shortcode for "Product Selector"', 'woocommerce_one_click_upsell_funnel' ); ?></label>
					</th>
					<td class="forminp forminp-text">
						<p>
						<?php
						$attribut_description = esc_html_e( 'This is the shortcode for showing the variation selector for variable products on custom offer page.', 'woocommerce_one_click_upsell_funnel' );
						echo wc_help_tip( $attribut_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						?>
						<?php echo '[mwb_wocuf_pro_selector]'; ?>
						</p>		
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="mwb_wocuf_pro_shortcode_3"><?php esc_html_e( 'Shortcode for "Offer Price"', 'woocommerce_one_click_upsell_funnel' ); ?></label>
					</th>
					<td class="forminp forminp-text">
						<p>
						<?php
						$attribut_description = esc_html_e( 'This is the shortcode for showing the special offer price for a product on custom page. For variable product, shows the price as well as appropriate messages.', 'woocommerce_one_click_upsell_funnel' );
						echo wc_help_tip( $attribut_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						?>
						<?php echo '[mwb_wocuf_pro_offer_price]'; ?>
						</p>		
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="mwb_wocuf_pro_shortcode_4"><?php esc_html_e( 'Shortcode for "Order Details"', 'woocommerce_one_click_upsell_funnel' ); ?></label>
					</th>
					<td class="forminp forminp-text">
						<p>
						<?php
						$attribut_description = esc_html_e( "This is the shortcode for jumping directly to order details/thankyou page if customer doesn't want to buy any of your offers.", 'woocommerce_one_click_upsell_funnel' );
						echo wc_help_tip( $attribut_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						?>
						<?php esc_html_e( 'Single Mode', 'woocommerce_one_click_upsell_funnel' ); ?>
						<?php echo '[mwb_wocuf_pro_order_details]'; ?>
						</p>
						<p>
						<?php
						$attribut_description = esc_html_e( "This is the shortcode for jumping directly to order details/thankyou page if customer doesn't want to buy any of your offers. In wrapping mode, custom text can be used in between shortcodes.", 'woocommerce_one_click_upsell_funnel' );
						echo wc_help_tip( $attribut_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						?>
						<?php esc_html_e( 'Wrapping Mode', 'woocommerce_one_click_upsell_funnel' ); ?>
						<?php echo ' : [mwb_wocuf_pro_order_details]...[/mwb_wocuf_pro_order_details]'; ?>
						</p>		
					</td>
				</tr>
				<?php do_action( 'mwb_wocuf_pro_create_more_settings' ); ?>
			</tbody>
		</table>
	</div>
