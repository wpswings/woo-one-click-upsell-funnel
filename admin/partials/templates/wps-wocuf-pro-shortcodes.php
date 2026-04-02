<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used for listing all the shortcodes of the plugin.
 *
 * @link       https://wpswings.com/?utm_source=wpswings-official&utm_medium=upsell-org-backend&utm_campaign=official
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

<div class="wpswocuf_upsell_table wpswocuf_upsell_new_shortcodes">
	<table class="form-table wpswocuf_pro_shortcodes">
		<tbody>
			<!-- Upsell Action shortcodes start-->
			<tr valign="top">
				<th scope="row" class="titledesc">
					<label><?php esc_html_e( 'Upsell Action shortcodes', 'woo-one-click-upsell-funnel' ); ?></label>
				</th>
				<td class="forminp forminp-text">
					<div class="wpswocuf_upsell_shortcode_div">
						<p class="wpswocuf_upsell_shortcode">
							<?php
							$attribute_description = sprintf( '<p class="wpswocuf_upsell_tip_tip">%s</p><p class="wpswocuf_upsell_tip_tip">%s</p>', esc_html__( 'Accept Offer.', 'woo-one-click-upsell-funnel' ), esc_html__( 'This shortcode only returns the link so it has to be used in the link section. In html use it as href="[wpswocuf_upsell_yes]" of anchor tag.', 'woo-one-click-upsell-funnel' ) );

							wpswocuf_upsell_lite_wc_help_tip( $attribute_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
							<span class="wpswocuf_upsell_shortcode_title"><?php esc_html_e( 'Buy Now &rarr;', 'woo-one-click-upsell-funnel' ); ?></span>
							<span class="wpswocuf_upsell_shortcode_content"><?php echo esc_html( '[wpswocuf_upsell_yes]' ); ?></span>
						</p>
					</div>
					<div class="wpswocuf_upsell_shortcode_div" >
						<p class="wpswocuf_upsell_shortcode">
							<?php
							$attribute_description = sprintf( '<p class="wpswocuf_upsell_tip_tip">%s</p><p class="wpswocuf_upsell_tip_tip">%s</p>', esc_html__( 'Reject Offer.', 'woo-one-click-upsell-funnel' ), esc_html__( 'This shortcode only returns the link so it has to be used in the link section. In html use it as href="[wpswocuf_upsell_no]" of anchor tag.', 'woo-one-click-upsell-funnel' ) );

							wpswocuf_upsell_lite_wc_help_tip( $attribute_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
							<span class="wpswocuf_upsell_shortcode_title"><?php esc_html_e( 'No Thanks &rarr;', 'woo-one-click-upsell-funnel' ); ?></span>
							<span class="wpswocuf_upsell_shortcode_content"><?php echo esc_html( '[wpswocuf_upsell_no]' ); ?></span>
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
					<div class="wpswocuf_upsell_shortcode_div">
						<p class="wpswocuf_upsell_shortcode">
							<?php
							$attribute_description = sprintf( '<p class="wpswocuf_upsell_tip_tip">%s</p>', esc_html__( 'This shortcode returns the product title.', 'woo-one-click-upsell-funnel' ) );

							wpswocuf_upsell_lite_wc_help_tip( $attribute_description );
							?>
							<span class="wpswocuf_upsell_shortcode_title"><?php esc_html_e( 'Product Title &rarr;', 'woo-one-click-upsell-funnel' ); ?></span>
							<span class="wpswocuf_upsell_shortcode_content"><?php echo esc_html( '[wpswocuf_upsell_title]' ); ?></span>
						</p>
					</div>
					<div class="wpswocuf_upsell_shortcode_div" >
						<p class="wpswocuf_upsell_shortcode">
							<?php
							$attribute_description = sprintf( '<p class="wpswocuf_upsell_tip_tip">%s</p>', esc_html__( 'This shortcode returns the product description.', 'woo-one-click-upsell-funnel' ) );

							wpswocuf_upsell_lite_wc_help_tip( $attribute_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
							<span class="wpswocuf_upsell_shortcode_title"><?php esc_html_e( 'Product Description &rarr;', 'woo-one-click-upsell-funnel' ); ?></span>
							<span class="wpswocuf_upsell_shortcode_content"><?php echo esc_html( '[wpswocuf_upsell_desc]' ); ?></span>
						</p>
					</div>	
					<div class="wpswocuf_upsell_shortcode_div" >
						<p class="wpswocuf_upsell_shortcode">
							<?php
							$attribute_description = sprintf( '<p class="wpswocuf_upsell_tip_tip">%s</p>', esc_html__( 'This shortcode returns the product short description.', 'woo-one-click-upsell-funnel' ) );

							wpswocuf_upsell_lite_wc_help_tip( $attribute_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped.
							?>
							<span class="wpswocuf_upsell_shortcode_title"><?php esc_html_e( 'Product Short Description &rarr;', 'woo-one-click-upsell-funnel' ); ?></span>
							<span class="wpswocuf_upsell_shortcode_content"><?php echo esc_html( '[wpswocuf_upsell_desc_short]' ); ?></span>
						</p>
					</div>
					<div class="wpswocuf_upsell_shortcode_div" >
						<p class="wpswocuf_upsell_shortcode">
							<?php
							$attribute_description = sprintf( '<p class="wpswocuf_upsell_tip_tip">%s</p>', esc_html__( 'This shortcode returns the product upsell shipping price.', 'woo-one-click-upsell-funnel' ) );

							wpswocuf_upsell_lite_wc_help_tip( $attribute_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped.
							?>
							<span class="wpswocuf_upsell_shortcode_title"><?php esc_html_e( 'Product Upsell Shipping Price &rarr;', 'woo-one-click-upsell-funnel' ); ?></span>
							<span class="wpswocuf_upsell_shortcode_content"><?php echo esc_html( '[wpswocuf_upsell_product_shipping_price]' ); ?></span>
						</p>
					</div>
					<hr class="wpswocuf_upsell_shortcodes_hr">
					<div class="wpswocuf_upsell_shortcode_div" >
						<p class="wpswocuf_upsell_shortcode">
							<?php
							$attribute_description = sprintf( '<p class="wpswocuf_upsell_tip_tip">%s</p>', esc_html__( 'This shortcode returns the product image.', 'woo-one-click-upsell-funnel' ) );

							wpswocuf_upsell_lite_wc_help_tip( $attribute_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
							<span class="wpswocuf_upsell_shortcode_title"><?php esc_html_e( 'Product Image &rarr;', 'woo-one-click-upsell-funnel' ); ?></span>
							<span class="wpswocuf_upsell_shortcode_content"><?php echo esc_html( '[wpswocuf_upsell_image]' ); ?></span>
						</p>
					</div>
					<div class="wpswocuf_upsell_shortcode_div" >
						<p class="wpswocuf_upsell_shortcode">
							<?php
							$attribute_description = sprintf( '<p class="wpswocuf_upsell_tip_tip">%s</p>', esc_html__( 'This shortcode returns the product price.', 'woo-one-click-upsell-funnel' ) );

							wpswocuf_upsell_lite_wc_help_tip( $attribute_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
							<span class="wpswocuf_upsell_shortcode_title"><?php esc_html_e( 'Product Price &rarr;', 'woo-one-click-upsell-funnel' ); ?></span>
							<span class="wpswocuf_upsell_shortcode_content"><?php echo esc_html( '[wpswocuf_upsell_price]' ); ?></span>
						</p>
					</div>
					<div class="wpswocuf_upsell_shortcode_div" >
						<p class="wpswocuf_upsell_shortcode">
							<?php
							$attribute_description = sprintf( '<p class="wpswocuf_upsell_tip_tip">%s</p>', esc_html__( '( Only for Pro ) This shortcode returns the product variations if offer product is a variable product.', 'woo-one-click-upsell-funnel' ) );

							wpswocuf_upsell_lite_wc_help_tip( $attribute_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
							<span class="wpswocuf_upsell_shortcode_title"><?php esc_html_e( 'Product Variations &rarr;', 'woo-one-click-upsell-funnel' ); ?></span>
							<span class="wpswocuf_upsell_shortcode_content"><?php echo esc_html( '[wpswocuf_upsell_variations]' ); ?></span>
						</p>
					</div>
				</td>
			</tr>
			<!-- Product shortcodes end-->

			<!-- Other shortcodes start-->
			<tr valign="top">
				<th scope="row" class="titledesc">
					<label><?php esc_html_e( 'Other shortcodes', 'woo-one-click-upsell-funnel' ); ?></label>
				</th>
				<td class="forminp forminp-text">
					<div class="wpswocuf_upsell_shortcode_div">
						<p class="wpswocuf_upsell_shortcode">
							<?php
							$attribute_description = sprintf( '<p class="wpswocuf_upsell_tip_tip">%s</p>', esc_html__( 'This shortcode returns Star ratings. You can specify the number of stars like [wpswocuf_upsell_star_review stars=4.5] .', 'woo-one-click-upsell-funnel' ) );
							wpswocuf_upsell_lite_wc_help_tip( $attribute_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
							<span class="wpswocuf_upsell_shortcode_title"><?php esc_html_e( 'Star Ratings &rarr;', 'woo-one-click-upsell-funnel' ); ?></span>
							<span class="wpswocuf_upsell_shortcode_content"><?php echo esc_html( '[wpswocuf_upsell_star_review]' ); ?></span>
						</p>
					</div>
					<div class="wpswocuf_upsell_shortcode_div">
						<p class="wpswocuf_upsell_shortcode">
							<?php

							$attribute_description = sprintf( '<p class="wpswocuf_upsell_tip_tip">%s</p>', esc_html__( 'This shortcode returns quantity field. You can restrict the customer to select the quantity offered. [wpswocuf_upsell_quantity max=4 min=1 ] .', 'woo-one-click-upsell-funnel' ) );
							wpswocuf_upsell_lite_wc_help_tip( $attribute_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped.

							?>
							<span class="wpswocuf_upsell_shortcode_title"><?php esc_html_e( 'Offer Quantity &rarr;', 'woo-one-click-upsell-funnel' ); ?></span>
							<span class="wpswocuf_upsell_shortcode_content"><?php echo esc_html( '[wpswocuf_upsell_quantity]' ); ?></span>
						</p>
					</div>
					<div class="wpswocuf_upsell_shortcode_div">
						<p class="wpswocuf_upsell_shortcode">
							<?php

							$attribute_description = sprintf( '<p class="wpswocuf_upsell_tip_tip">%s</p>', esc_html__( 'This shortcode returns urgency timer. You can specify the timer limit as [wpswocuf_upsell_timer minutes=5] .', 'woo-one-click-upsell-funnel' ) );
							wpswocuf_upsell_lite_wc_help_tip( $attribute_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped.

							?>
							<span class="wpswocuf_upsell_shortcode_title"><?php esc_html_e( 'Urgency Timer &rarr;', 'woo-one-click-upsell-funnel' ); ?></span>
							<span class="wpswocuf_upsell_shortcode_content"><?php echo esc_html( '[wpswocuf_upsell_timer]' ); ?></span>
						</p>
					</div>
				</td>
			</tr>
			<!-- Other shortcodes ends-->
		</tbody>
	</table>
</div>
