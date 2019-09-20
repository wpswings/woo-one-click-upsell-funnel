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

// Delete funnel.
if ( isset( $_GET['del_funnel_id'] ) ) {

	$funnel_id = sanitize_text_field( wp_unslash( $_GET['del_funnel_id'] ) );

	// Get all funnels.
	$mwb_wocuf_pro_funnels = get_option( 'mwb_wocuf_funnels_list' );

	foreach ( $mwb_wocuf_pro_funnels as $single_funnel => $data ) {

		if ( $funnel_id == $single_funnel ) {

			unset( $mwb_wocuf_pro_funnels[ $single_funnel ] );
			break;
		}
	}

	// Remove array values so that the funnel id keys doesn't change.
	// $mwb_wocuf_pro_funnels = array_values($mwb_wocuf_pro_funnels);

	update_option( 'mwb_wocuf_funnels_list', $mwb_wocuf_pro_funnels );

	wp_redirect( esc_url( admin_url( 'admin.php' ) . '?page=mwb-wocuf-setting&tab=funnels-list' ) );

	exit();
}


// Get all funnels.
$mwb_wocuf_pro_funnels_list = get_option( 'mwb_wocuf_funnels_list' );

if ( ! empty( $mwb_wocuf_pro_funnels_list ) ) {

	// Temp funnel variable.
	$mwb_wocuf_pro_funnel_duplicate = $mwb_wocuf_pro_funnels_list;

	// Make key pointer point to the end funnel.
	end( $mwb_wocuf_pro_funnel_duplicate );

	// Now key function will return last funnel key.
	$mwb_wocuf_pro_funnel_number = key( $mwb_wocuf_pro_funnel_duplicate );
}

// When no funnel is there then new funnel id will be 1 (0+1).
else {

	$mwb_wocuf_pro_funnel_number = 0;
}

?>

<div class="mwb_wocuf_pro_funnels_list">

	<?php if ( empty( $mwb_wocuf_pro_funnels_list ) ) : ?>

		<p class="mwb_wocuf_pro_no_funnel"><?php esc_html_e( 'No funnels added', 'woocommerce_one_click_upsell_funnel' ); ?></p>

	<?php endif; ?>

	<?php if ( ! empty( $mwb_wocuf_pro_funnels_list ) ) : ?>
		<table>
			<tr>
				<th><?php esc_html_e( 'Funnel Name', 'woocommerce_one_click_upsell_funnel' ); ?></th>
				<th><?php esc_html_e( 'Status', 'woocommerce_one_click_upsell_funnel' ); ?></th>
				<th id="mwb_upsell_funnel_list_target_th"><?php esc_html_e( 'Target Product(s)', 'woocommerce_one_click_upsell_funnel' ); ?></th>
				<th><?php esc_html_e( 'Offers', 'woocommerce_one_click_upsell_funnel' ); ?></th>
				<th><?php esc_html_e( 'Action', 'woocommerce_one_click_upsell_funnel' ); ?></th>
				<?php do_action( 'mwb_wocuf_pro_funnel_add_more_col_head' ); ?>
			</tr>

			<!-- Foreach Funnel start -->
			<?php
			foreach ( $mwb_wocuf_pro_funnels_list as $key => $value ) :

				$offers_count = ! empty( $value['mwb_wocuf_products_in_offer'] ) ? $value['mwb_wocuf_products_in_offer'] : array();

				$offers_count = count( $offers_count );

				?>

				<tr>		
					<!-- Funnel Name -->
					<td><a class="mwb_upsell_funnel_list_name" href="?page=mwb-wocuf-setting&tab=creation-setting&funnel_id=<?php echo esc_html( $key ); ?>"><?php echo esc_html( $value['mwb_wocuf_funnel_name'] ); ?></a></td>

					<!-- Funnel Status -->
					<td>

						<?php

						$funnel_status = ! empty( $value['mwb_upsell_funnel_status'] ) ? $value['mwb_upsell_funnel_status'] : 'no';

						// Pre v3.0.0 Funnels will be live.
						$funnel_status = ! empty( $value['mwb_upsell_fsav3'] ) ? $funnel_status : 'yes';

						if ( 'yes' == $funnel_status ) {

							echo '<span class="mwb_upsell_funnel_list_live"></span><span class="mwb_upsell_funnel_list_live_name">' . esc_html__( 'Live', 'woocommerce_one_click_upsell_funnel' ) . '</span>';
						} else {

							echo '<span class="mwb_upsell_funnel_list_sandbox"></span><span class="mwb_upsell_funnel_list_sandbox_name">' . esc_html__( 'Sandbox', 'woocommerce_one_click_upsell_funnel' ) . '</span>';
						}

						?>
					
					</td>

					<!-- Funnel Target products. -->
					<td>
						<?php

						if ( ! empty( $value['mwb_wocuf_target_pro_ids'] ) ) {

							echo '<div class="mwb_upsell_funnel_list_targets">';

							foreach ( $value['mwb_wocuf_target_pro_ids'] as $single_target_product ) :

								$product = wc_get_product( $single_target_product );
								?>
								<p><?php echo esc_html( $product->get_title() ) . '( #' . esc_html( $single_target_product ) . ' )'; ?></p>
								<?php

							endforeach;

							echo '</div>';
						} else {

							?>

							<p><?php esc_html_e( 'No product(s) added', 'woocommerce_one_click_upsell_funnel' ); ?></p>

							<?php
						}

						?>
					</td>

					<!-- Offers -->
					<td>
						<?php

						if ( ! empty( $value['mwb_wocuf_products_in_offer'] ) ) {

							echo '<div class="mwb_upsell_funnel_list_targets">';

							echo '<p><i>' . esc_html__( 'Offers Count', 'woocommerce-one-click-upsell-funnel-pro' ) . ' - ' . esc_html( $offers_count ) . '</i></p>';

							foreach ( $value['mwb_wocuf_products_in_offer'] as $offer_key => $single_offer_product ) :

								$product = wc_get_product( $single_offer_product );

								if ( empty( $product ) ) {

									continue;
								}
								// phpcs:disable
								?>
								<p><?php echo '<strong>' . esc_html__( 'Offer', 'woocommerce-one-click-upsell-funnel-pro' ) . ' #' . esc_html( $offer_key ) . '</strong> &rarr; ' . esc_html( $product->get_title() ) . '( #' . $single_offer_product . ' )'; ?></p>
								<?php
								// phpcs:enable

							endforeach;

							echo '</div>';
						} else {

							?>
							<p><i><?php esc_html_e( 'No Offers added', 'woocommerce-one-click-upsell-funnel-pro' ); ?></i></p>
							<?php
						}

						?>
					</td> 

					<!-- Funnel Action -->
					<td>

						<!-- Funnel View/Edit link -->
						<a class="mwb_wocuf_pro_funnel_links" href="?page=mwb-wocuf-setting&tab=creation-setting&funnel_id=<?php echo esc_html( $key ); ?>"><?php esc_html_e( 'View / Edit', 'woocommerce_one_click_upsell_funnel' ); ?></a>

						<!-- Funnel Delete link -->
						<a class="mwb_wocuf_pro_funnel_links" href="?page=mwb-wocuf-setting&tab=funnels-list&del_funnel_id=<?php echo esc_html( $key ); ?>"><?php esc_html_e( 'Delete', 'woocommerce_one_click_upsell_funnel' ); ?></a>
					</td>

					<?php do_action( 'mwb_wocuf_pro_funnel_add_more_col_data' ); ?>
				</tr>
			<?php endforeach; ?>
			<!-- Foreach Funnel end -->
		</table>
	<?php endif; ?>
</div>

<br>

<!-- Create New Funnel -->
<div class="mwb_wocuf_pro_create_new_funnel">

	<a href="?page=mwb-wocuf-setting&tab=creation-setting&funnel_id=<?php echo esc_html( $mwb_wocuf_pro_funnel_number + 1 ); ?>"><?php esc_html_e( '+Create New Funnel', 'woocommerce_one_click_upsell_funnel' ); ?></a>
</div>

<?php do_action( 'mwb_wocuf_pro_extend_funnels_listing' ); ?>
