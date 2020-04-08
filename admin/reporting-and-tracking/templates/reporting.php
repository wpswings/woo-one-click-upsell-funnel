<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used for listing all the funnels of the plugin.
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

/**
 * Funnels Listing Template.
 *
 * This template is used for listing all existing funnels with
 * view/edit and delete option.
 */


// Get all funnels.
$funnels_list = get_option( 'mwb_wocuf_funnels_list' );

?>

<div class="mwb_wocuf_pro_funnels_list">

	<div class="mwb_uspell_reporting_heading" >
		<h2><?php esc_html_e( 'Upsell Sales - Reports', 'woocommerce_one_click_upsell_funnel' ); ?></h2>
		<a target="_blank" href="<?php echo esc_url( admin_url( 'admin.php?page=wc-reports&tab=upsell' ) ); ?>"><?php esc_html_e( 'Visit here &rarr;', 'woocommerce_one_click_upsell_funnel' ); ?></a>
	</div>

	<hr class="mwb_uspell_reporting_funnel_stats_hr">

	<div class="mwb_uspell_stats_heading" ><h2><?php esc_html_e( 'Upsell Sales by Funnel - Stats', 'woocommerce_one_click_upsell_funnel' ); ?></h2></div>

	<?php if ( empty( $funnels_list ) ) : ?>

		<p class="mwb_wocuf_pro_no_funnel"><?php esc_html_e( 'No Upsell Funnel Data found', 'woocommerce_one_click_upsell_funnel' ); ?></p>

	<?php endif; ?>

	<?php if ( ! empty( $funnels_list ) ) : ?>
		<table>
			<tr>
				<th><?php esc_html_e( 'Funnel Name', 'woocommerce_one_click_upsell_funnel' ); ?></th>
				<th><?php esc_html_e( 'Trigger Count', 'woocommerce_one_click_upsell_funnel' ); ?></th>
				<th><?php esc_html_e( 'Success Count', 'woocommerce_one_click_upsell_funnel' ); ?></th>
				<th><?php esc_html_e( 'Offers Viewed', 'woocommerce_one_click_upsell_funnel' ); ?></th>
				<th><?php esc_html_e( 'Offers Accepted', 'woocommerce_one_click_upsell_funnel' ); ?></th>
				<th><?php esc_html_e( 'Offers Rejected', 'woocommerce_one_click_upsell_funnel' ); ?></th>
				<th><?php esc_html_e( 'Offers Pending', 'woocommerce_one_click_upsell_funnel' ); ?></th>
				<th><?php esc_html_e( 'Conversion Rate', 'woocommerce_one_click_upsell_funnel' ); ?></th>
				<th><?php esc_html_e( 'Total Sales', 'woocommerce_one_click_upsell_funnel' ); ?></th>
			</tr>

			<!-- Foreach Funnel start -->
			<?php
			foreach ( $funnels_list as $key => $value ) :

				$offers_count = ! empty( $value['mwb_wocuf_products_in_offer'] ) ? $value['mwb_wocuf_products_in_offer'] : array();

				$offers_count = count( $offers_count );

				?>

				<tr>		
					<!-- Funnel Name -->
					<td><a class="mwb_upsell_funnel_list_name" href="?page=mwb-wocuf-setting&tab=creation-setting&funnel_id=<?php echo esc_html( $key ); ?>"><?php echo esc_html( $value['mwb_wocuf_funnel_name'] ); ?></a></td>

					<!-- Trigger Count -->
					<td>

						<?php

						$funnel_triggered_count = ! empty( $value['funnel_triggered_count'] ) ? $value['funnel_triggered_count'] : 0;

						echo esc_html( $funnel_triggered_count );

						?>
					
					</td>

					<!-- Success Count -->
					<td>

						<?php

						$funnel_success_count = ! empty( $value['funnel_success_count'] ) ? $value['funnel_success_count'] : 0;

						echo esc_html( $funnel_success_count );

						?>
					
					</td>

					<!-- Offers Viewed -->
					<td>

						<?php

						$offers_view_count = ! empty( $value['offers_view_count'] ) ? $value['offers_view_count'] : 0;

						echo esc_html( $offers_view_count );

						?>
					
					</td>

					<!-- Offers Accepted -->
					<td>

						<?php

						$offers_accept_count = ! empty( $value['offers_accept_count'] ) ? $value['offers_accept_count'] : 0;

						echo esc_html( $offers_accept_count );

						?>
					
					</td>

					<!-- Offers Rejected -->
					<td>

						<?php

						$offers_reject_count = ! empty( $value['offers_reject_count'] ) ? $value['offers_reject_count'] : 0;

						echo esc_html( $offers_reject_count );

						?>
					
					</td>

					<!-- Offers Pending -->
					<td>

						<?php

						$offers_pending_count = $offers_view_count - $offers_accept_count - $offers_reject_count;

						echo esc_html( $offers_pending_count );

						?>
					
					</td>

					<!-- Conversion Rate -->
					<td>

						<?php

						if( ! empty( $funnel_triggered_count ) ) {

							$conversion_rate = ( $funnel_success_count * 100 ) / $funnel_triggered_count;
						}

						else {

							$conversion_rate = 0;
						}

						$conversion_rate = number_format( (float)$conversion_rate, 2 );

						echo '<div class="mwb_upsell_stats_conversion_rate"><p>' . esc_html( $conversion_rate . esc_html__( '%', 'woocommerce_one_click_upsell_funnel' ) ) . '</p><div>';

						?>
					
					</td>

					<!-- Total Sales -->
					<td>

						<?php

						$funnel_total_sales = ! empty( $value['funnel_total_sales'] ) ? $value['funnel_total_sales'] : 0;

						$funnel_total_sales = number_format( (float)$funnel_total_sales, 2 );

						echo '<div class="mwb_upsell_stats_total_sales"><p>' .  get_woocommerce_currency_symbol() . esc_html( $funnel_total_sales ) . '</p><div>';

						?>
					
					</td>

					
				</tr>
			<?php endforeach; ?>
			<!-- Foreach Funnel end -->
		</table>
	<?php endif; ?>
</div>
