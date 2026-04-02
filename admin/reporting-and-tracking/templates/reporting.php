<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used for Upsell Reports and Upsell Sales by Funnel - Stats.
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

// Get all funnels.
$wpswocuf_funnels_list = get_option( 'wpswocuf_funnels_list' );

?>

<div class="wpswocuf_pro_funnels_list">

	<div class="wpswocuf_uspell_reporting_heading" >
		<h2><?php esc_html_e( 'Upsell Sales - Reports', 'woo-one-click-upsell-funnel' ); ?></h2>
		<a target="_blank" href="<?php echo esc_url( admin_url( 'admin.php?page=wc-reports&tab=upsell' ) ); ?>"><?php esc_html_e( 'Visit here &rarr;', 'woo-one-click-upsell-funnel' ); ?></a>
	</div>

	<hr class="wpswocuf_uspell_reporting_funnel_stats_hr">

	<div class="wpswocuf_uspell_stats_heading" ><h2><?php esc_html_e( 'Upsell - Behavioral Analytics', 'woo-one-click-upsell-funnel' ); ?></h2></div>

	<?php if ( empty( $wpswocuf_funnels_list ) ) : ?>

		<p class="wpswocuf_pro_no_funnel"><?php esc_html_e( 'No Upsell Data found', 'woo-one-click-upsell-funnel' ); ?></p>

	<?php endif; ?>

	<?php if ( ! empty( $wpswocuf_funnels_list ) ) : ?>
		<table>
			<tr>
				<th><?php esc_html_e( 'Funnel Name', 'woo-one-click-upsell-funnel' ); ?></th>
				<th><?php esc_html_e( 'Trigger Count', 'woo-one-click-upsell-funnel' ); ?></th>
				<th><?php esc_html_e( 'Success Count', 'woo-one-click-upsell-funnel' ); ?></th>
				<th><?php esc_html_e( 'Offers Viewed', 'woo-one-click-upsell-funnel' ); ?></th>
				<th><?php esc_html_e( 'Offers Accepted', 'woo-one-click-upsell-funnel' ); ?></th>
				<th><?php esc_html_e( 'Offers Rejected', 'woo-one-click-upsell-funnel' ); ?></th>
				<th><?php esc_html_e( 'Offers Pending', 'woo-one-click-upsell-funnel' ); ?></th>
				<th><?php esc_html_e( 'Conversion Rate', 'woo-one-click-upsell-funnel' ); ?></th>
				<th><?php esc_html_e( 'Total Sales', 'woo-one-click-upsell-funnel' ); ?></th>
			</tr>

			<!-- Foreach Funnel start -->
		<?php
		foreach ( $wpswocuf_funnels_list as $wpswocuf_funnel_key => $wpswocuf_funnel_data ) :

			?>

				<tr>		
				<!-- Funnel Name -->
				<td><a class="wpswocuf_upsell_funnel_list_name" href="?page=wps-wocuf-setting&tab=creation-setting&funnel_id=<?php echo esc_html( $wpswocuf_funnel_key ); ?>"><?php echo esc_html( $wpswocuf_funnel_data['wpswocuf_funnel_name'] ); ?></a></td>

					<!-- Trigger Count -->
					<td>

					<?php

					$wpswocuf_funnel_triggered_count = ! empty( $wpswocuf_funnel_data['funnel_triggered_count'] ) ? $wpswocuf_funnel_data['funnel_triggered_count'] : 0;

					echo esc_html( $wpswocuf_funnel_triggered_count );

					?>

					</td>

					<!-- Success Count -->
					<td>

					<?php

					$wpswocuf_funnel_success_count = ! empty( $wpswocuf_funnel_data['funnel_success_count'] ) ? $wpswocuf_funnel_data['funnel_success_count'] : 0;

					echo esc_html( $wpswocuf_funnel_success_count );

					?>

					</td>

					<!-- Offers Viewed -->
					<td>

					<?php

					$wpswocuf_offers_view_count = ! empty( $wpswocuf_funnel_data['offers_view_count'] ) ? $wpswocuf_funnel_data['offers_view_count'] : 0;

					echo esc_html( $wpswocuf_offers_view_count );

					?>

					</td>

					<!-- Offers Accepted -->
					<td>

					<?php

					$wpswocuf_offers_accept_count = ! empty( $wpswocuf_funnel_data['offers_accept_count'] ) ? $wpswocuf_funnel_data['offers_accept_count'] : 0;

					echo esc_html( $wpswocuf_offers_accept_count );

					?>

					</td>

					<!-- Offers Rejected -->
					<td>

					<?php

					$wpswocuf_offers_reject_count = ! empty( $wpswocuf_funnel_data['offers_reject_count'] ) ? $wpswocuf_funnel_data['offers_reject_count'] : 0;

					echo esc_html( $wpswocuf_offers_reject_count );

					?>

					</td>

					<!-- Offers Pending -->
					<td>

					<?php

					$wpswocuf_offers_pending_count = $wpswocuf_offers_view_count - $wpswocuf_offers_accept_count - $wpswocuf_offers_reject_count;

					echo esc_html( $wpswocuf_offers_pending_count );

					?>

					</td>

					<!-- Conversion Rate -->
					<td>

					<?php

					if ( ! empty( $wpswocuf_funnel_triggered_count ) ) {

						$wpswocuf_conversion_rate = ( $wpswocuf_funnel_success_count * 100 ) / $wpswocuf_funnel_triggered_count;
					} else {

						$wpswocuf_conversion_rate = 0;
					}

					$wpswocuf_conversion_rate = number_format( (float) $wpswocuf_conversion_rate, 2 );

					echo '<div class="wpswocuf_upsell_stats_conversion_rate"><p>' . esc_html( $wpswocuf_conversion_rate ) . esc_html__( '%', 'woo-one-click-upsell-funnel' ) . '</p><div>';

					?>

					</td>

					<!-- Total Sales -->
					<td>

					<?php

					$wpswocuf_funnel_total_sales = ! empty( $wpswocuf_funnel_data['funnel_total_sales'] ) ? $wpswocuf_funnel_data['funnel_total_sales'] : 0;

					$wpswocuf_funnel_total_sales = number_format( (float) $wpswocuf_funnel_total_sales, 2 );

					echo '<div class="wpswocuf_upsell_stats_total_sales"><p>' . esc_html( get_woocommerce_currency_symbol() ) . esc_html( $wpswocuf_funnel_total_sales ) . '</p><div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

					?>

					</td>

				</tr>
			<?php endforeach; ?>
			<!-- Foreach Funnel end -->
		</table>
	<?php endif; ?>
</div>
