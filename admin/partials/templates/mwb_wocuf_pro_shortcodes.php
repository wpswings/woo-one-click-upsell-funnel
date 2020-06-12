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
						<label><?php esc_html_e( 'Upsell Action shortcodes', 'woo-one-click-upsell-funnel' ); ?></label>
					</th>
					<td class="forminp forminp-text">
						<div class="mwb_upsell_shortcode_div">
							<p class="mwb_upsell_shortcode">
								<?php
								$attribute_description = sprintf( '<p class="mwb_upsell_tip_tip">%s</p><p class="mwb_upsell_tip_tip">%s</p>', esc_html__( 'Accept Offer.', 'woo-one-click-upsell-funnel' ), esc_html__( 'This shortcode only returns the link so it has to be used in the link section. In html use it as href="[mwb_upsell_yes]" of anchor tag.', 'woo-one-click-upsell-funnel' ) );

								echo wc_help_tip( $attribute_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
								<span class="mwb_upsell_shortcode_title"><?php esc_html_e( 'Buy Now &rarr;', 'woo-one-click-upsell-funnel' ); ?></span>
								<span class="mwb_upsell_shortcode_content"><?php echo esc_html__( '[mwb_upsell_yes]' ); ?></span>
							</p>
						</div>
						<div class="mwb_upsell_shortcode_div" >
							<p class="mwb_upsell_shortcode">
								<?php
								$attribute_description = sprintf( '<p class="mwb_upsell_tip_tip">%s</p><p class="mwb_upsell_tip_tip">%s</p>', esc_html__( 'Reject Offer.', 'woo-one-click-upsell-funnel' ), esc_html__( 'This shortcode only returns the link so it has to be used in the link section. In html use it as href="[mwb_upsell_no]" of anchor tag.', 'woo-one-click-upsell-funnel' ) );

								echo wc_help_tip( $attribute_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
								<span class="mwb_upsell_shortcode_title"><?php esc_html_e( 'No Thanks &rarr;', 'woo-one-click-upsell-funnel' ); ?></span>
								<span class="mwb_upsell_shortcode_content"><?php echo esc_html__( '[mwb_upsell_no]' ); ?></span>
							</p>
						</div>		
					</td>
				</tr>
				<!-- Upsell Action shortcodes end-->

				<!-- Product shortcodes start-->
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label><?php esc_html_e( 'Product shortcodes', 'woo-one-click-upsell-funnel' ); ?></label>
					</th>
					<td class="forminp forminp-text">
						<div class="mwb_upsell_shortcode_div">
							<p class="mwb_upsell_shortcode">
								<?php
								$attribute_description = sprintf( '<p class="mwb_upsell_tip_tip">%s</p>', esc_html__( 'This shortcode returns the product title.', 'woo-one-click-upsell-funnel' ) );

								echo wc_help_tip( $attribute_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
								<span class="mwb_upsell_shortcode_title"><?php esc_html_e( 'Product Title &rarr;', 'woo-one-click-upsell-funnel' ); ?></span>
								<span class="mwb_upsell_shortcode_content"><?php echo esc_html__( '[mwb_upsell_title]' ); ?></span>
							</p>
						</div>
						<div class="mwb_upsell_shortcode_div" >
							<p class="mwb_upsell_shortcode">
								<?php
								$attribute_description = sprintf( '<p class="mwb_upsell_tip_tip">%s</p>', esc_html__( 'This shortcode returns the product description.', 'woo-one-click-upsell-funnel' ) );

								echo wc_help_tip( $attribute_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
								<span class="mwb_upsell_shortcode_title"><?php esc_html_e( 'Product Description &rarr;', 'woo-one-click-upsell-funnel' ); ?></span>
								<span class="mwb_upsell_shortcode_content"><?php echo esc_html__( '[mwb_upsell_desc]' ); ?></span>
							</p>
						</div>	
						<div class="mwb_upsell_shortcode_div" >
							<p class="mwb_upsell_shortcode">
								<?php
								$attribute_description = sprintf( '<p class="mwb_upsell_tip_tip">%s</p>', esc_html__( 'This shortcode returns the product short description.', 'woo-one-click-upsell-funnel' ) );

								echo wc_help_tip( $attribute_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
								<span class="mwb_upsell_shortcode_title"><?php esc_html_e( 'Product Short Description &rarr;', 'woo-one-click-upsell-funnel' ); ?></span>
								<span class="mwb_upsell_shortcode_content"><?php echo esc_html__( '[mwb_upsell_desc_short]' ); ?></span>
							</p>
						</div>	
						<hr class="mwb_upsell_shortcodes_hr">
						<div class="mwb_upsell_shortcode_div" >
							<p class="mwb_upsell_shortcode">
								<?php
								$attribute_description = sprintf( '<p class="mwb_upsell_tip_tip">%s</p>', esc_html__( 'This shortcode returns the product image.', 'woo-one-click-upsell-funnel' ) );

								echo wc_help_tip( $attribute_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
								<span class="mwb_upsell_shortcode_title"><?php esc_html_e( 'Product Image &rarr;', 'woo-one-click-upsell-funnel' ); ?></span>
								<span class="mwb_upsell_shortcode_content"><?php echo esc_html__( '[mwb_upsell_image]' ); ?></span>
							</p>
						</div>
						<div class="mwb_upsell_shortcode_div" >
							<p class="mwb_upsell_shortcode">
								<?php
								$attribute_description = sprintf( '<p class="mwb_upsell_tip_tip">%s</p>', esc_html__( 'This shortcode returns the product price.', 'woo-one-click-upsell-funnel' ) );

								echo wc_help_tip( $attribute_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
								<span class="mwb_upsell_shortcode_title"><?php esc_html_e( 'Product Price &rarr;', 'woo-one-click-upsell-funnel' ); ?></span>
								<span class="mwb_upsell_shortcode_content"><?php echo esc_html__( '[mwb_upsell_price]' ); ?></span>
							</p>
						</div>
						<div class="mwb_upsell_shortcode_div" >
							<p class="mwb_upsell_shortcode">
								<?php
								$attribute_description = sprintf( '<p class="mwb_upsell_tip_tip">%s</p>', esc_html__( '( Only for Pro ) This shortcode returns the product variations if offer product is a variable product.', 'woo-one-click-upsell-funnel' ) );

								echo wc_help_tip( $attribute_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
								<span class="mwb_upsell_shortcode_title"><?php esc_html_e( 'Product Variations &rarr;', 'woo-one-click-upsell-funnel' ); ?></span>
								<span class="mwb_upsell_shortcode_content"><?php echo esc_html__( '[mwb_upsell_variations]' ); ?></span>
							</p>
						</div>
					</td>
				</tr>
				<!-- Product shortcodes start-->

				<!-- Product shortcodes start-->
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label><?php esc_html_e( 'Other shortcodes', 'woo-one-click-upsell-funnel' ); ?></label>
					</th>
					<td class="forminp forminp-text">
						<div class="mwb_upsell_shortcode_div">
							<p class="mwb_upsell_shortcode">
								<?php
								$attribute_description = sprintf( '<p class="mwb_upsell_tip_tip">%s</p>', esc_html__( 'This shortcode returns Star ratings. You can the specify the number of stars like [mwb_upsell_star_review stars=4.5] .', 'woo-one-click-upsell-funnel' ) );
								echo wc_help_tip( $attribute_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
								<span class="mwb_upsell_shortcode_title"><?php esc_html_e( 'Star Ratings &rarr;', 'woo-one-click-upsell-funnel' ); ?></span>
								<span class="mwb_upsell_shortcode_content"><?php echo esc_html__( '[mwb_upsell_star_review]' ); ?></span>
							</p>
						</div>
					</td>
				</tr>
				<!-- Product shortcodes start-->
				
			</tbody>
		</table>
</div>

<div class="mwb_upsell_old_shortcodes_title">
	<h2><?php esc_html_e( 'Old shortcodes ( Deprecated )', 'woo-one-click-upsell-funnel' ); ?></h2>
	<a href="#" class="mwb_upsell_old_shortcodes_link"><img src="<?php echo esc_url( MWB_WOCUF_URL . 'admin/resources/down.png' ); ?>"></a>
</div>

<div class="mwb_upsell_table mwb_upsell_old_shortcodes">
		<table class="form-table mwb_wocuf_pro_shortcodes">
			<tbody>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="mwb_wocuf_pro_shortcode_2"><?php esc_html_e( 'Shortcode for "Buy Now"', 'woo-one-click-upsell-funnel' ); ?></label>
					</th>
					<td class="forminp forminp-text">
						<p>
							<?php
							$attribut_description = esc_html__( 'This is the shortcode for accepting the offer on custom page.', 'woo-one-click-upsell-funnel' );

							echo wc_help_tip( $attribut_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
							<?php esc_html_e( 'Single Mode', 'woo-one-click-upsell-funnel' ); ?>
							<?php echo esc_html__( ' : [mwb_wocuf_pro_yes]' ); ?>
						</p>
						<p>
							<?php
							$attribut_description = esc_html__( 'This is the shortcode for accepting the offer on custom page. In wrapping mode, custom text can be used in between shortcodes.', 'woo-one-click-upsell-funnel' );

							echo wc_help_tip( $attribut_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
							<?php esc_html_e( 'Wrapping Mode', 'woo-one-click-upsell-funnel' ); ?>
							<?php echo esc_html__( ':[mwb_wocuf_pro_yes]...[/mwb_wocuf_pro_yes]' ); ?>
						</p>		
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="mwb_wocuf_pro_shortcode_3"><?php esc_html_e( 'Shortcode for "No,thanks"', 'woo-one-click-upsell-funnel' ); ?></label>
					</th>
					<td class="forminp forminp-text">
						<p>
							<?php
							$attribut_description = esc_html__( 'This is the shortcode for rejecting the offer on custom page.', 'woo-one-click-upsell-funnel' );

							echo wc_help_tip( $attribut_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
							<?php esc_html_e( 'Single Mode', 'woo-one-click-upsell-funnel' ); ?>
							<?php echo esc_html__( ' : [mwb_wocuf_pro_no]' ); ?>
						</p>
						<p>
							<?php
							$attribut_description = esc_html__( 'This is the shortcode for rejecting the offer on custom page. In wrapping mode, custom text can be used in between shortcodes.', 'woo-one-click-upsell-funnel' );

							echo wc_help_tip( $attribut_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
							<?php esc_html_e( 'Wrapping Mode', 'woo-one-click-upsell-funnel' ); ?>
							<?php echo esc_html__( ' : [mwb_wocuf_pro_no]...[/mwb_wocuf_pro_no]' ); ?>
						</p>				
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="mwb_wocuf_pro_shortcode_5"><?php esc_html_e( 'Shortcode for "Product Selector"', 'woo-one-click-upsell-funnel' ); ?></label>
					</th>
					<td class="forminp forminp-text">
						<p>
						<?php
						$attribut_description = esc_html__( 'This is the shortcode for showing the variation selector for variable products on custom offer page.', 'woo-one-click-upsell-funnel' );

						echo wc_help_tip( $attribut_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						?>
						<?php echo esc_html__( '[mwb_wocuf_pro_selector]' ); ?>
						</p>		
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="mwb_wocuf_pro_shortcode_3"><?php esc_html_e( 'Shortcode for "Offer Price"', 'woo-one-click-upsell-funnel' ); ?></label>
					</th>
					<td class="forminp forminp-text">
						<p>
						<?php
						$attribut_description = esc_html__( 'This is the shortcode for showing the special offer price for a product on custom page. For variable product, shows the price as well as appropriate messages.', 'woo-one-click-upsell-funnel' );

						echo wc_help_tip( $attribut_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						?>
						<?php echo esc_html__( '[mwb_wocuf_pro_offer_price]' ); ?>
						</p>		
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="mwb_wocuf_pro_shortcode_4"><?php esc_html_e( 'Shortcode for "Order Details"', 'woo-one-click-upsell-funnel' ); ?></label>
					</th>
					<td class="forminp forminp-text">
						<p>
						<?php
						$attribut_description = esc_html__( "This is the shortcode for jumping directly to order details/thankyou page if customer doesn't want to buy any of your offers.", 'woo-one-click-upsell-funnel' );

						echo wc_help_tip( $attribut_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						?>
						<?php esc_html_e( 'Single Mode', 'woo-one-click-upsell-funnel' ); ?>
						<?php echo esc_html__( '[mwb_wocuf_pro_order_details]' ); ?>
						</p>
						<p>
						<?php
						$attribut_description = esc_html__( "This is the shortcode for jumping directly to order details/thankyou page if customer doesn't want to buy any of your offers. In wrapping mode, custom text can be used in between shortcodes.", 'woo-one-click-upsell-funnel' );

						echo wc_help_tip( $attribut_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						?>
						<?php esc_html_e( 'Wrapping Mode', 'woo-one-click-upsell-funnel' ); ?>
						<?php echo esc_html__( ' : [mwb_wocuf_pro_order_details]...[/mwb_wocuf_pro_order_details]' ); ?>
						</p>		
					</td>
				</tr>
				<?php do_action( 'mwb_wocuf_pro_create_more_settings' ); ?>
			</tbody>
		</table>
	</div>
