<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to create/view/edit funnels of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package     woo_one_click_upsell_funnel
 * @subpackage woo_one_click_upsell_funnel/admin/partials/templates
 */

/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {

	exit;
}

/**
 * Funnel Creation Template.
 *
 * This template is used for creating new funnel as well
 * as viewing/editing previous funnels.
 */

/**
 * Funnel Creation Template.
 */

// New Funnel id.
if ( ! isset( $_GET['funnel_id'] ) ) {

	// Get all funnels.
	$mwb_wocuf_pro_funnels = get_option( 'mwb_wocuf_funnels_list', array() );

	if ( ! empty( $mwb_wocuf_pro_funnels ) ) {

		// Temp funnel variable.
		$mwb_wocuf_pro_funnel_duplicate = $mwb_wocuf_pro_funnels;

		// Make key pointer point to the end funnel.
		end( $mwb_wocuf_pro_funnel_duplicate );

		// Now key function will return last funnel key.
		$mwb_wocuf_pro_funnel_number = key( $mwb_wocuf_pro_funnel_duplicate );

		/**
		 * So new funnel id will be last key+1.
		 *
		 * Funnel key in array is funnel id. ( not really.. need to find, if funnel is deleted then keys change)
		 *
		 * Yes Funnel is identified by key, if deleted.. other funnel key ids will change.
		 * The array field mwb_wocuf_pro_funnel_id is not used so ignore it.
		 * if it is different from key means some funnel was deleted.
		 * So remember funnel id is its array[key].
		 *
		 * UPDATE : Remove array values, so now from v3 funnel id keys wont change after
		 * funnel deletion.
		 * The array field mwb_wocuf_pro_funnel_id will equal to funnel key from v3.
		 */
		$mwb_wocuf_pro_funnel_id = $mwb_wocuf_pro_funnel_number + 1;
	} else {

		// First funnel.
		// Firstly it was 0 now changed it to 1, make sure that doesn't cause any issues.
		$mwb_wocuf_pro_funnel_id = 1;
	}
} else {

	// Retrieve new funnel id from GET parameter when redirected from funnel list's page.
	$mwb_wocuf_pro_funnel_id = sanitize_text_field( wp_unslash( $_GET['funnel_id'] ) );
}

// When save changes is clicked.
if ( isset( $_POST['mwb_wocuf_pro_creation_setting_save'] ) ) {

	unset( $_POST['mwb_wocuf_pro_creation_setting_save'] );

	// Nonce verification.
	check_admin_referer( 'mwb_wocuf_pro_creation_nonce', 'mwb_wocuf_pro_nonce' );

	// Saved funnel id.
	$mwb_wocuf_pro_funnel_id = ! empty( $_POST['mwb_wocuf_funnel_id'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_wocuf_funnel_id'] ) ) : '';

	if ( empty( $_POST['mwb_wocuf_target_pro_ids'] ) ) {

		$_POST['mwb_wocuf_target_pro_ids'] = array();
	}

	if ( empty( $_POST['mwb_upsell_funnel_status'] ) ) {

		$_POST['mwb_upsell_funnel_status'] = 'no';
	}

	$mwb_wocuf_pro_funnel = array();
	$offer_custom_page_url_array = array();

	/**
	 * Get each associated to funnel sanitized in its own.
	 */

	// Sanitize and strip slashes for normal single value feilds.
	$mwb_wocuf_pro_funnel['mwb_upsell_funnel_status'] = ! empty( $_POST['mwb_upsell_funnel_status'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_upsell_funnel_status'] ) ) : '';
	$mwb_wocuf_pro_funnel['mwb_wocuf_funnel_id'] = ! empty( $_POST['mwb_wocuf_funnel_id'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_wocuf_funnel_id'] ) ) : '';
	$mwb_wocuf_pro_funnel['mwb_upsell_fsav3'] = ! empty( $_POST['mwb_upsell_fsav3'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_upsell_fsav3'] ) ) : '';
	$mwb_wocuf_pro_funnel['mwb_wocuf_funnel_name'] = ! empty( $_POST['mwb_wocuf_funnel_name'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_wocuf_funnel_name'] ) ) : '';
	$mwb_wocuf_pro_funnel['mwb_wocuf_pro_funnel_schedule'] = ! empty( $_POST['mwb_wocuf_pro_funnel_schedule'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_wocuf_pro_funnel_schedule'] ) ) : '';

	// Sanitize and strip slashes for Funnel Target products.
	$target_pro_ids_array = ! empty( $_POST['mwb_wocuf_target_pro_ids'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['mwb_wocuf_target_pro_ids'] ) ) : array();

	$mwb_wocuf_pro_funnel['mwb_wocuf_target_pro_ids'] = ! empty( $target_pro_ids_array ) ? $target_pro_ids_array : array();


	// Sanitize and strip slashes for Funnel Offer products.
	$products_in_offer_array = ! empty( $_POST['mwb_wocuf_products_in_offer'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['mwb_wocuf_products_in_offer'] ) ) : '';

	$mwb_wocuf_pro_funnel['mwb_wocuf_products_in_offer'] = ! empty( $products_in_offer_array ) ? $products_in_offer_array : array();


	// Sanitize and strip slashes for Funnel Offer price.
	$offer_discount_price_array = ! empty( $_POST['mwb_wocuf_offer_discount_price'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['mwb_wocuf_offer_discount_price'] ) ) : '';

	$mwb_wocuf_pro_funnel['mwb_wocuf_offer_discount_price'] = ! empty( $offer_discount_price_array ) ? $offer_discount_price_array : array();


	// Sanitize and strip slashes for attached offer on yes array.
	$attached_offers_on_buy = ! empty( $_POST['mwb_wocuf_attached_offers_on_buy'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['mwb_wocuf_attached_offers_on_buy'] ) ) : '';

	$mwb_wocuf_pro_funnel['mwb_wocuf_attached_offers_on_buy'] = $attached_offers_on_buy;


	// Sanitize and strip slashes for attached offer on no array.
	$attached_offers_on_no = ! empty( $_POST['mwb_wocuf_attached_offers_on_no'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['mwb_wocuf_attached_offers_on_no'] ) ) : '';

	$mwb_wocuf_pro_funnel['mwb_wocuf_attached_offers_on_no'] = $attached_offers_on_no;


	// Sanitize and strip slashes for attached offer template array.
	$offer_template = ! empty( $_POST['mwb_wocuf_pro_offer_template'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['mwb_wocuf_pro_offer_template'] ) ) : '';

	$mwb_wocuf_pro_funnel['mwb_wocuf_pro_offer_template'] = $offer_template;


	// Sanitize and strip slashes for custom page url array.
	$offer_custom_page_url = ! empty( $_POST['mwb_wocuf_offer_custom_page_url'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['mwb_wocuf_offer_custom_page_url'] ) ) : '';

	$offer_custom_page_url = ! empty( $offer_custom_page_url ) ? array_map( 'esc_url', wp_unslash( $offer_custom_page_url ) ) : '';

	$mwb_wocuf_pro_funnel['mwb_wocuf_offer_custom_page_url'] = $offer_custom_page_url;


	// Sanitize and strip slashes for applied offer number.
	$applied_offer_number = ! empty( $_POST['mwb_wocuf_applied_offer_number'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['mwb_wocuf_applied_offer_number'] ) ) : '';

	$mwb_wocuf_pro_funnel['mwb_wocuf_applied_offer_number'] = $applied_offer_number;


	// Sanitize and strip slashes for page id assigned.
	$post_id_assigned = ! empty( $_POST['mwb_upsell_post_id_assigned'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['mwb_upsell_post_id_assigned'] ) ) : '';

	$mwb_wocuf_pro_funnel['mwb_upsell_post_id_assigned'] = $post_id_assigned;

	$mwb_wocuf_pro_funnel_series = array();

	// POST funnel as array at funnel id key.
	$mwb_wocuf_pro_funnel_series[ $mwb_wocuf_pro_funnel_id ] = ! empty( $mwb_wocuf_pro_funnel ) && is_array( $mwb_wocuf_pro_funnel ) ? $mwb_wocuf_pro_funnel : array();

	// Get all funnels.
	$mwb_wocuf_pro_created_funnels = get_option( 'mwb_wocuf_funnels_list', array() );

	// If there are other funnels.
	if ( is_array( $mwb_wocuf_pro_created_funnels ) && count( $mwb_wocuf_pro_created_funnels ) ) {

		$flag = 0;

		foreach ( $mwb_wocuf_pro_created_funnels as $key => $data ) {

			// If funnel id key is already present, then replace that key in array.
			if ( $key == $mwb_wocuf_pro_funnel_id ) {

				$mwb_wocuf_pro_created_funnels[ $key ] = $mwb_wocuf_pro_funnel_series[ $mwb_wocuf_pro_funnel_id ];
				$flag = 1;
				break;
			}
		}

		// If funnel id key not present then merge array.
		if ( 1 != $flag ) {

			// Array merge was reindexing keys so using array union operator.
			$mwb_wocuf_pro_created_funnels = $mwb_wocuf_pro_created_funnels + $mwb_wocuf_pro_funnel_series;
		}

		update_option( 'mwb_wocuf_funnels_list', $mwb_wocuf_pro_created_funnels );
	}

	// If there are no other funnels.
	else {

		update_option( 'mwb_wocuf_funnels_list', $mwb_wocuf_pro_funnel_series );
	}

	// After funnel is saved.
	// Handling Funnel offer-page posts deletion which are dynamically assigned.
	mwb_upsell_lite_offer_page_posts_deletion();

	?>

	<!-- Settings saved notice -->
	<div class="notice notice-success is-dismissible"> 
		<p><strong><?php esc_html_e( 'Settings saved', 'woo-one-click-upsell-funnel' ); ?></strong></p>
	</div>

	<?php

}

// Get all funnels.
$mwb_wocuf_pro_funnel_data = get_option( 'mwb_wocuf_funnels_list', array() );

// Not used anywhere I guess.
$mwb_wocuf_pro_custom_th_page = ! empty( $mwb_wocuf_pro_funnel_data[ $mwb_wocuf_pro_funnel_id ]['mwb_wocuf_pro_custom_th_page'] ) ? $mwb_wocuf_pro_funnel_data[ $mwb_wocuf_pro_funnel_id ]['mwb_wocuf_pro_custom_th_page'] : 'off';

$mwb_wocuf_pro_funnel_schedule_options = array(
	'0'     => esc_html__( 'on every Sunday', 'woo-one-click-upsell-funnel' ),
	'1'     => esc_html__( 'on every Monday', 'woo-one-click-upsell-funnel' ),
	'2'     => esc_html__( 'on every Tuesday', 'woo-one-click-upsell-funnel' ),
	'3'     => esc_html__( 'on every Wednesday', 'woo-one-click-upsell-funnel' ),
	'4'     => esc_html__( 'on every Thursday', 'woo-one-click-upsell-funnel' ),
	'5'     => esc_html__( 'on every Friday', 'woo-one-click-upsell-funnel' ),
	'6'     => esc_html__( 'on every Saturday', 'woo-one-click-upsell-funnel' ),
	'7'     => esc_html__( 'Daily', 'woo-one-click-upsell-funnel' ),
);

?>

<!-- FOR SINGLE FUNNEL -->
<form action="" method="POST">

	<div class="mwb_upsell_table">

		<table class="form-table mwb_wocuf_pro_creation_setting">

			<tbody>
				
				<!-- Nonce field here. -->
				<?php wp_nonce_field( 'mwb_wocuf_pro_creation_nonce', 'mwb_wocuf_pro_nonce' ); ?>

				<input type="hidden" name="mwb_wocuf_funnel_id" value="<?php echo esc_html( $mwb_wocuf_pro_funnel_id ); ?>">

				<!-- Funnel saved after version 3. TO differentiate between new v3 users and old users. -->
				<input type="hidden" name="mwb_upsell_fsav3" value="true">

				<?php

				$funnel_name = ! empty( $mwb_wocuf_pro_funnel_data[ $mwb_wocuf_pro_funnel_id ]['mwb_wocuf_funnel_name'] ) ? $mwb_wocuf_pro_funnel_data[ $mwb_wocuf_pro_funnel_id ]['mwb_wocuf_funnel_name'] : esc_html__( 'Funnel', 'woo-one-click-upsell-funnel' ) . " #$mwb_wocuf_pro_funnel_id";

				$funnel_status = ! empty( $mwb_wocuf_pro_funnel_data[ $mwb_wocuf_pro_funnel_id ]['mwb_upsell_funnel_status'] ) ? $mwb_wocuf_pro_funnel_data[ $mwb_wocuf_pro_funnel_id ]['mwb_upsell_funnel_status'] : 'no';

				// Pre v3.0.0 Funnels will be live.
				// The first condition to ensure funnel is already saved.
				if ( ! empty( $mwb_wocuf_pro_funnel_data[ $mwb_wocuf_pro_funnel_id ]['mwb_wocuf_funnel_name'] ) && empty( $mwb_wocuf_pro_funnel_data[ $mwb_wocuf_pro_funnel_id ]['mwb_upsell_fsav3'] ) ) {

					$funnel_status = 'yes';
				}


				?>

				<div id="mwb_upsell_funnel_name_heading" >

					<h2><?php echo esc_attr( $funnel_name ); ?></h2>

					<div id="mwb_upsell_funnel_status" >
						<label>
							<input type="checkbox" id="mwb_upsell_funnel_status_input" name="mwb_upsell_funnel_status" value="yes" <?php checked( 'yes', $funnel_status ); ?> >
							<span class="mwb_upsell_funnel_span"></span>
						</label>

						<span class="mwb_upsell_funnel_status_on <?php echo 'yes' == $funnel_status ? 'active' : ''; ?>"><?php esc_html_e( 'Live', 'woo-one-click-upsell-funnel' ); ?></span>
						<span class="mwb_upsell_funnel_status_off <?php echo 'no' == $funnel_status ? 'active' : ''; ?>"><?php esc_html_e( 'Sandbox', 'woo-one-click-upsell-funnel' ); ?></span>
					</div>

				</div>

				<div class="mwb_upsell_offer_template_previews">

					<div class="mwb_upsell_offer_template_preview_one">
						<div class="mwb_upsell_offer_template_preview_one_sub_div"><img src="<?php echo esc_url( MWB_WOCUF_URL . 'admin/resources/offer-previews/offer-template-one.png' ); ?>">
						</div>
					</div>

					<div class="mwb_upsell_offer_template_preview_two">
						<div class="mwb_upsell_offer_template_preview_two_sub_div"><img src="<?php echo esc_url( MWB_WOCUF_URL . 'admin/resources/offer-previews/offer-template-two.png' ); ?>">
						</div>
					</div>

					<div class="mwb_upsell_offer_template_preview_three">
						<div class="mwb_upsell_offer_template_preview_three_sub_div"><img src="<?php echo esc_url( MWB_WOCUF_URL . 'admin/resources/offer-previews/offer-template-three.png' ); ?>">
						</div>
					</div>

					<a href="javascript:void(0)" class="mwb_upsell_offer_preview_close"><span class="mwb_upsell_offer_preview_close_span"></span></a>
				</div>


				<!-- Funnel Name start-->
				<tr valign="top">

					<th scope="row" class="titledesc">
						<label for="mwb_wocuf_funnel_name"><?php esc_html_e( 'Name of the funnel', 'woo-one-click-upsell-funnel' ); ?></label>
					</th>

					<td class="forminp forminp-text">

						<?php

						$description = esc_html__( 'Provide the name of your funnel', 'woo-one-click-upsell-funnel' );
						echo wc_help_tip( $description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

						?>

						<input type="text" id="mwb_upsell_funnel_name" name="mwb_wocuf_funnel_name" value="<?php echo esc_html( $funnel_name ); ?>" id="mwb_wocuf_pro_funnel_name" class="input-text mwb_wocuf_pro_commone_class" required="" maxlength="30">
					</td>
				</tr>
				<!-- Funnel Name end-->

				<!-- Select Target product start -->
				<tr valign="top">

					<th scope="row" class="titledesc">
						<label for="mwb_wocuf_target_pro_ids"><?php esc_html_e( 'Select target product(s)', 'woo-one-click-upsell-funnel' ); ?></label>
					</th>

					<td class="forminp forminp-text">

						<?php

						$description = esc_html__( 'If any one of these Target Products is checked out then the this funnel will be triggered and the below offers will be shown.', 'woo-one-click-upsell-funnel' );

						echo wc_help_tip( $description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

						?>

						<select class="wc-funnel-product-search" multiple="multiple" style="" name="mwb_wocuf_target_pro_ids[]" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', 'woo-one-click-upsell-funnel' ); ?>">

						<?php

						if ( ! empty( $mwb_wocuf_pro_funnel_data ) ) {

							$mwb_wocuf_pro_target_products = isset( $mwb_wocuf_pro_funnel_data[ $mwb_wocuf_pro_funnel_id ]['mwb_wocuf_target_pro_ids'] ) ? $mwb_wocuf_pro_funnel_data[ $mwb_wocuf_pro_funnel_id ]['mwb_wocuf_target_pro_ids'] : array();

							// array_map with absint converts negative array values to positive, so that we dont get negative ids.
							$mwb_wocuf_pro_target_product_ids = ! empty( $mwb_wocuf_pro_target_products ) ? array_map( 'absint', $mwb_wocuf_pro_target_products ) : null;

							if ( $mwb_wocuf_pro_target_product_ids ) {

								foreach ( $mwb_wocuf_pro_target_product_ids as $mwb_wocuf_pro_single_target_product_id ) {

									$product_name = get_the_title( $mwb_wocuf_pro_single_target_product_id );

									echo '<option value="' . esc_html( $mwb_wocuf_pro_single_target_product_id ) . '" selected="selected" >' . esc_html( $product_name ) . '(#' . esc_html( $mwb_wocuf_pro_single_target_product_id ) . ')' . '</option>';
								}
							}
						}

						?>
						</select>		
					</td>	
				</tr>
				<!-- Select Target product end -->

				<!-- Schedule your Funnel start -->
				<tr valign="top">

					<th scope="row" class="titledesc">
						<label for="mwb_wocuf_pro_funnel_schedule"><?php esc_html_e( 'Funnel Schedule', 'woo-one-click-upsell-funnel' ); ?></label>
					</th>

					<td class="forminp forminp-text">

						<?php

						$description = esc_html__( 'Schedule your funnel for specific weekdays.', 'woo-one-click-upsell-funnel' );

						echo wc_help_tip( $description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

						?>

						<select class="mwb_wocuf_pro_funnel_schedule" name="mwb_wocuf_pro_funnel_schedule">

							<?php

							$selected_week = ! empty( $mwb_wocuf_pro_funnel_data[ $mwb_wocuf_pro_funnel_id ]['mwb_wocuf_pro_funnel_schedule'] ) ? $mwb_wocuf_pro_funnel_data[ $mwb_wocuf_pro_funnel_id ]['mwb_wocuf_pro_funnel_schedule'] : 7;

							foreach ( $mwb_wocuf_pro_funnel_schedule_options as $key => $value ) {

								?>

								<option <?php echo esc_html( $selected_week == $key ? 'selected=""' : '' ); ?> value="<?php echo esc_html( $key ); ?>"><?php echo esc_html( $value ); ?></option>

								<?php
							}

							?>
						</select>			
					</td>	
				</tr>
				<!-- Schedule your Funnel end -->
				
			</tbody>
		</table>
		

		<div class="mwb_wocuf_pro_offers"><h1><?php esc_html_e( 'Funnel Offers', 'woo-one-click-upsell-funnel' ); ?></h1>
		</div>
		<br>
		<?php

		// Funnel Offers array.
		$mwb_wocuf_pro_existing_offers = ! empty( $mwb_wocuf_pro_funnel_data[ $mwb_wocuf_pro_funnel_id ]['mwb_wocuf_applied_offer_number'] ) ? $mwb_wocuf_pro_funnel_data[ $mwb_wocuf_pro_funnel_id ]['mwb_wocuf_applied_offer_number'] : '';

		// Array of offers with product Id.
		$mwb_wocuf_pro_product_in_offer = ! empty( $mwb_wocuf_pro_funnel_data[ $mwb_wocuf_pro_funnel_id ]['mwb_wocuf_products_in_offer'] ) ? $mwb_wocuf_pro_funnel_data[ $mwb_wocuf_pro_funnel_id ]['mwb_wocuf_products_in_offer'] : '';

		// Array of offers with discount.
		$mwb_wocuf_pro_products_discount = ! empty( $mwb_wocuf_pro_funnel_data[ $mwb_wocuf_pro_funnel_id ]['mwb_wocuf_offer_discount_price'] ) ? $mwb_wocuf_pro_funnel_data[ $mwb_wocuf_pro_funnel_id ]['mwb_wocuf_offer_discount_price'] : '';

		// Array of offers with Buy now go to link.
		$mwb_wocuf_pro_offers_buy_now_offers = ! empty( $mwb_wocuf_pro_funnel_data[ $mwb_wocuf_pro_funnel_id ]['mwb_wocuf_attached_offers_on_buy'] ) ? $mwb_wocuf_pro_funnel_data[ $mwb_wocuf_pro_funnel_id ]['mwb_wocuf_attached_offers_on_buy'] : '';

		// Array of offers with No thanks go to link.
		$mwb_wocuf_pro_offers_no_thanks_offers = ! empty( $mwb_wocuf_pro_funnel_data[ $mwb_wocuf_pro_funnel_id ]['mwb_wocuf_attached_offers_on_no'] ) ? $mwb_wocuf_pro_funnel_data[ $mwb_wocuf_pro_funnel_id ]['mwb_wocuf_attached_offers_on_no'] : '';

		// Array of offers with active template.
		$mwb_wocuf_pro_offer_active_template = ! empty( $mwb_wocuf_pro_funnel_data[ $mwb_wocuf_pro_funnel_id ]['mwb_wocuf_pro_offer_template'] ) ? $mwb_wocuf_pro_funnel_data[ $mwb_wocuf_pro_funnel_id ]['mwb_wocuf_pro_offer_template'] : '';

		// Array of offers with custom page url.
		$mwb_wocuf_pro_offer_custom_page_url = ! empty( $mwb_wocuf_pro_funnel_data[ $mwb_wocuf_pro_funnel_id ]['mwb_wocuf_offer_custom_page_url'] ) ? $mwb_wocuf_pro_funnel_data[ $mwb_wocuf_pro_funnel_id ]['mwb_wocuf_offer_custom_page_url'] : '';

		// Array of offers with their post id.
		$post_id_assigned_array = ! empty( $mwb_wocuf_pro_funnel_data[ $mwb_wocuf_pro_funnel_id ]['mwb_upsell_post_id_assigned'] ) ? $mwb_wocuf_pro_funnel_data[ $mwb_wocuf_pro_funnel_id ]['mwb_upsell_post_id_assigned'] : '';

		// Funnel Offers array.
		// To be used for showing other offers except for itself in 'buy now' and 'no thanks' go to link.
		$mwb_wocuf_pro_existing_offers_2 = $mwb_wocuf_pro_existing_offers;

		?>

		<!-- Funnel Offers Start-->
		<div class="new_offers">

			<div class="new_created_offers" data-id="0"></div>

			<!-- FOR each SINGLE OFFER start -->

			<?php

			if ( ! empty( $mwb_wocuf_pro_existing_offers ) ) {

				// Funnel Offers array. Foreach as offer_id => offer_id.
				// Key and value are always same as offer array keys are not reindexed.
				foreach ( $mwb_wocuf_pro_existing_offers as $current_offer_id => $current_offer_id_val ) {

					$mwb_wocuf_pro_buy_attached_offers = '';

					$mwb_wocuf_pro_no_attached_offers = '';

					// Creating options html for showing other offers except for itself in 'buy now' and 'no thanks' go to link.
					if ( ! empty( $mwb_wocuf_pro_existing_offers_2 ) ) {

						foreach ( $mwb_wocuf_pro_existing_offers_2 as $current_offer_id_2 ) :

							if ( $current_offer_id_2 != $current_offer_id ) {

								$mwb_wocuf_pro_buy_attached_offers .= '<option value=' . esc_html( $current_offer_id_2 ) . '>' . esc_html__( 'Offer #', 'woo-one-click-upsell-funnel' ) . esc_html( $current_offer_id_2 ) . '</option>';

								$mwb_wocuf_pro_no_attached_offers .= '<option value=' . esc_html( $current_offer_id_2 ) . '>' . esc_html__( 'Offer #', 'woo-one-click-upsell-funnel' ) . esc_html( $current_offer_id_2 ) . '</option>';
							}

						endforeach;
					}

					$mwb_wocuf_pro_buy_now_action_html = '';

					// For showing Buy Now selected link.
					if ( ! empty( $mwb_wocuf_pro_offers_buy_now_offers ) ) {

						// If link is set to No thanks.
						if ( 'thanks' == $mwb_wocuf_pro_offers_buy_now_offers[ $current_offer_id ] ) {

							$mwb_wocuf_pro_buy_now_action_html = '<select name="mwb_wocuf_attached_offers_on_buy[' . $current_offer_id . ']"><option value="thanks" selected="">' . esc_html__( 'Order ThankYou Page', 'woo-one-click-upsell-funnel' ) . '</option>' . $mwb_wocuf_pro_buy_attached_offers;
						}

						// If link is set to other offer.
						elseif ( $mwb_wocuf_pro_offers_buy_now_offers[ $current_offer_id ] > 0 ) {

							$mwb_wocuf_pro_buy_now_action_html = '<select name="mwb_wocuf_attached_offers_on_buy[' . $current_offer_id . ']"><option value="thanks">' . esc_html__( 'Order ThankYou Page', 'woo-one-click-upsell-funnel' ) . '</option>';

							if ( ! empty( $mwb_wocuf_pro_existing_offers_2 ) ) {

								// Loop through offers and set the saved one as selected.
								foreach ( $mwb_wocuf_pro_existing_offers_2 as $current_offer_id_2 ) {

									if ( $current_offer_id_2 != $current_offer_id ) {

										if ( $mwb_wocuf_pro_offers_buy_now_offers[ $current_offer_id ] == $current_offer_id_2 ) {

											$mwb_wocuf_pro_buy_now_action_html .= '<option value=' . $current_offer_id_2 . ' selected="">' . esc_html__( 'Offer #', 'woo-one-click-upsell-funnel' ) . $current_offer_id_2 . '</option>';
										} else {

											$mwb_wocuf_pro_buy_now_action_html .= '<option value=' . $current_offer_id_2 . '>' . esc_html__( 'Offer #', 'woo-one-click-upsell-funnel' ) . $current_offer_id_2 . '</option>';
										}
									}
								}
							}
						}
					}

					$mwb_wocuf_pro_no_thanks_action_html = '';

					// For showing No Thanks selected link.
					if ( ! empty( $mwb_wocuf_pro_offers_no_thanks_offers ) ) {

						// If link is set to No thanks.
						if ( 'thanks' == $mwb_wocuf_pro_offers_no_thanks_offers[ $current_offer_id ] ) {

							$mwb_wocuf_pro_no_thanks_action_html = '<select name="mwb_wocuf_attached_offers_on_no[' . $current_offer_id . ']"><option value="thanks" selected="">' . esc_html__( 'Order ThankYou Page', 'woo-one-click-upsell-funnel' ) . '</option>' . $mwb_wocuf_pro_no_attached_offers;
						}

						// If link is set to other offer.
						elseif ( $mwb_wocuf_pro_offers_no_thanks_offers[ $current_offer_id ] > 0 ) {

							$mwb_wocuf_pro_no_thanks_action_html = '<select name="mwb_wocuf_attached_offers_on_no[' . $current_offer_id . ']"><option value="thanks">' . esc_html__( 'Order ThankYou Page', 'woo-one-click-upsell-funnel' ) . '</option>';

							if ( ! empty( $mwb_wocuf_pro_existing_offers_2 ) ) {

								// Loop through offers and set the saved one as selected.
								foreach ( $mwb_wocuf_pro_existing_offers_2 as $current_offer_id_2 ) {

									if ( $current_offer_id != $current_offer_id_2 ) {

										if ( $mwb_wocuf_pro_offers_no_thanks_offers[ $current_offer_id ] == $current_offer_id_2 ) {

											$mwb_wocuf_pro_no_thanks_action_html .= '<option value=' . $current_offer_id_2 . ' selected="">' . esc_html__( 'Offer #', 'woo-one-click-upsell-funnel' ) . $current_offer_id_2 . '</option>';
										} else {

											$mwb_wocuf_pro_no_thanks_action_html .= '<option value=' . $current_offer_id_2 . '>' . esc_html__( 'Offer #', 'woo-one-click-upsell-funnel' ) . $current_offer_id_2 . '</option>';
										}
									}
								}
							}
						}
					}

					$mwb_wocuf_pro_buy_now_action_html .= '</select>';

					$mwb_wocuf_pro_no_thanks_action_html .= '</select>';

					?>

					<!-- Single offer html start -->
					<div class="new_created_offers mwb_upsell_single_offer" data-id="<?php echo esc_html( $current_offer_id ); ?>" data-scroll-id="#offer-section-<?php echo esc_html( $current_offer_id ); ?>">

						<h2 class="mwb_upsell_offer_title" >
							<?php echo esc_html__( 'Offer #', 'woo-one-click-upsell-funnel' ) . esc_html( $current_offer_id ); ?>
						</h2>

						<table>
							<!-- Offer product start -->
							<tr>
								<th><label><h4><?php esc_html_e( 'Offer Product', 'woo-one-click-upsell-funnel' ); ?></h4></label>
								</th>

								<td>
								<select class="wc-offer-product-search mwb_upsell_offer_product" name="mwb_wocuf_products_in_offer[<?php echo esc_html( $current_offer_id ); ?>]" data-placeholder="<?php esc_html_e( 'Search for a product&hellip;', 'woo-one-click-upsell-funnel' ); ?>">
								<?php

									$current_offer_product_id = '';

								if ( ! empty( $mwb_wocuf_pro_product_in_offer[ $current_offer_id ] ) ) {

									// In v2.0.0, it was array so handling to get the first product id.
									if ( is_array( $mwb_wocuf_pro_product_in_offer[ $current_offer_id ] ) && count( $mwb_wocuf_pro_product_in_offer[ $current_offer_id ] ) ) {

										foreach ( $mwb_wocuf_pro_product_in_offer[ $current_offer_id ] as $handling_offer_product_id ) {

											$current_offer_product_id = absint( $handling_offer_product_id );
											break;
										}
									} else {

										$current_offer_product_id = absint( $mwb_wocuf_pro_product_in_offer[ $current_offer_id ] );
									}
								}

								if ( ! empty( $current_offer_product_id ) ) {

									$product_title = get_the_title( $current_offer_product_id );

									?>

									<option value="<?php echo esc_html( $current_offer_product_id ); ?>" selected="selected"><?php echo esc_html( $product_title ) . '( #' . esc_html( $current_offer_product_id ) . ' )'; ?>
										</option>

									<?php

								}
								?>
								</select>
								</td>
							</tr>
							<!-- Offer product end -->
							
							<!-- Offer price start -->
							<tr>
								<th><label><h4><?php esc_html_e( 'Offer Price / Discount', 'woo-one-click-upsell-funnel' ); ?></h4></label>
								</th>

								<td>
								<input type="text" class="mwb_upsell_offer_price" name="mwb_wocuf_offer_discount_price[<?php echo esc_html( $current_offer_id ); ?>]" value="<?php echo esc_html( $mwb_wocuf_pro_products_discount[ $current_offer_id ] ); ?>">
								<span class="mwb_upsell_offer_description"><?php esc_html_e( 'Specify new offer price or discount %', 'woo-one-click-upsell-funnel' ); ?></span>

								</td>
							</tr>
							<!-- Offer price end -->

							<!-- Buy now go to link start -->
							<tr>
								<th><label><h4><?php esc_html_e( 'After \'Buy Now\' go to', 'woo-one-click-upsell-funnel' ); ?></h4></label>
								</th>

								<td>
									<?php echo $mwb_wocuf_pro_buy_now_action_html; ?>

									<span class="mwb_upsell_offer_description"><?php esc_html_e( 'Select where the customer will be redirected after accepting this offer', 'woo-one-click-upsell-funnel' ); ?></span>
								</td>
							</tr>
							<!-- Buy now go to link end -->

							<!-- Buy now no thanks link start -->
							<tr>
								<th><label><h4><?php esc_html_e( 'After \'No thanks\' go to', 'woo-one-click-upsell-funnel' ); ?></h4></label>
								</th>

								<td>
									<?php echo $mwb_wocuf_pro_no_thanks_action_html; ?>
									<span class="mwb_upsell_offer_description"><?php esc_html_e( 'Select where the customer will be redirected after rejecting this offer', 'woo-one-click-upsell-funnel' ); ?></span>
								</td>
							</tr>
						   <!-- Buy now no thanks link end -->

						   <!-- Section : Offer template start -->
							<tr>
								<th><label><h4><?php esc_html_e( 'Offer Template', 'woo-one-click-upsell-funnel' ); ?></h4></label>
								</th>

								<?php

								$assigned_post_id = ! empty( $post_id_assigned_array[ $current_offer_id ] ) ? $post_id_assigned_array[ $current_offer_id ] : '';

								?>

								<td>

									<?php if ( ! empty( $assigned_post_id ) ) : ?>

										<?php

										$offer_template_active = ! empty( $mwb_wocuf_pro_offer_active_template[ $current_offer_id ] ) ? $mwb_wocuf_pro_offer_active_template[ $current_offer_id ] : 'one';

										$offer_templates_array = array(
											'one' => esc_html__( 'STANDARD TEMPLATE', 'woo-one-click-upsell-funnel' ),
											'two' => esc_html__( 'CREATIVE TEMPLATE', 'woo-one-click-upsell-funnel' ),
											'three' => esc_html__( 'VIDEO TEMPLATE', 'woo-one-click-upsell-funnel' ),
										);

										?>

										<!-- Offer templates parent div start -->
										<div class="mwb_upsell_offer_templates_parent">

											<input class="mwb_wocuf_pro_offer_template_input" type="hidden" name="mwb_wocuf_pro_offer_template[<?php echo esc_html( $current_offer_id ); ?>]" value="<?php echo esc_html( $offer_template_active ); ?>">

											<?php foreach ( $offer_templates_array as $template_key => $template_name ) : ?>
												<!-- Offer templates foreach start-->
												<div class="mwb_upsell_offer_template <?php echo esc_html( $template_key == $offer_template_active ? 'active' : '' ); ?>">

													<div class="mwb_upsell_offer_template_sub_div"> 

														<h5><?php echo esc_html( $template_name ); ?></h5>

														<div class="mwb_upsell_offer_preview">

															<a href="javascript:void(0)" class="mwb_upsell_view_offer_template" data-template-id="<?php echo esc_html( $template_key ); ?>" ><img src="<?php echo esc_url( MWB_WOCUF_URL . "admin/resources/offer-thumbnails/offer-template-$template_key.jpg" ); ?>"></a>
														</div>

														<div class="mwb_upsell_offer_action">

															<?php if ( $template_key != $offer_template_active ) : ?>

															<button class="button-primary mwb_upsell_activate_offer_template" data-template-id="<?php echo esc_html( $template_key ); ?>" data-offer-id="<?php echo esc_html( $current_offer_id ); ?>" data-funnel-id="<?php echo esc_html( $mwb_wocuf_pro_funnel_id ); ?>" data-offer-post-id="<?php echo esc_html( $assigned_post_id ); ?>" ><?php esc_html_e( 'Insert and Activate', 'woo-one-click-upsell-funnel' ); ?></button>

															<?php else : ?>

																<a class="button" href="<?php echo esc_url( get_permalink( $assigned_post_id ) ); ?>" target="_blank"><?php esc_html_e( 'View &rarr;', 'woo-one-click-upsell-funnel' ); ?></a>

																<a class="button" href="<?php echo esc_url( admin_url( "post.php?post=$assigned_post_id&action=elementor" ) ); ?>" target="_blank"><?php esc_html_e( 'Customize &rarr;', 'woo-one-click-upsell-funnel' ); ?></a>

															<?php endif; ?>
														</div>

													</div>
													
												</div>
												<!-- Offer templates foreach end-->
											<?php endforeach; ?>
												
											<!-- Offer link to custom page start-->
											<div class="mwb_upsell_offer_template mwb_upsell_custom_page_link_div <?php echo esc_url( 'custom' == $offer_template_active ? 'active' : '' ); ?>">

												<div class="mwb_upsell_offer_template_sub_div">

													<h5><?php esc_html_e( 'LINK TO CUSTOM PAGE', 'woo-one-click-upsell-funnel' ); ?></h5>

													<?php if ( 'custom' != $offer_template_active ) : ?>

														<button class="button-primary mwb_upsell_activate_offer_template" data-template-id="custom" data-offer-id="<?php echo esc_html( $current_offer_id ); ?>" data-funnel-id="<?php echo esc_html( $mwb_wocuf_pro_funnel_id ); ?>" data-offer-post-id="<?php echo esc_html( $assigned_post_id ); ?>" ><?php esc_html_e( 'Activate', 'woo-one-click-upsell-funnel' ); ?></button>

													<?php else : ?>

														<h6><?php esc_html_e( 'Activated', 'woo-one-click-upsell-funnel' ); ?></h6>
														<p><?php esc_html_e( 'Please enter and save your custom page link below.', 'woo-one-click-upsell-funnel' ); ?></p>

													<?php endif; ?>

												</div>
												
											</div>
											<!-- Offer link to custom page end-->
											
										</div>
										<!-- Offer templates parent div end -->
									

									<?php else : ?>

										<div class="mwb_upsell_offer_template_unsupported">
											
										<h4><?php esc_html_e( 'Feature not supported for this Offer, please add a new Offer with Elementor active.', 'woo-one-click-upsell-funnel' ); ?></h4>
										</div>

									<?php endif; ?>
								</td>
							</tr>
							<!-- Section : Offer template end -->

						   <!-- Custom offer page url start -->
							<tr>
								<th><label><h4><?php esc_html_e( 'Offer Custom Page Link', 'woo-one-click-upsell-funnel' ); ?></h4></label>
								</th>

								<td>
								<input type="text" class="mwb_upsell_custom_offer_page_url" name="mwb_wocuf_offer_custom_page_url[<?php echo esc_html( $current_offer_id ); ?>]" value="<?php echo esc_url( $mwb_wocuf_pro_offer_custom_page_url[ $current_offer_id ] ); ?>">
								</td>
							</tr>
							<!-- Custom offer page url end -->

							<!-- Delete current offer ( Saved one ) -->
							<tr>
								<td colspan="2">
								<button class="button mwb_wocuf_pro_delete_old_created_offers" data-id="<?php echo esc_html( $current_offer_id ); ?>"><?php esc_html_e( 'Delete', 'woo-one-click-upsell-funnel' ); ?></button>
								</td>
							</tr>
							<!-- Delete current offer ( Saved one ) -->
							
						</table>

						<input type="hidden" name="mwb_wocuf_applied_offer_number[<?php echo esc_html( $current_offer_id ); ?>]" value="<?php echo esc_html( $current_offer_id ); ?>">

						<input type="hidden" name="mwb_upsell_post_id_assigned[<?php echo esc_html( $current_offer_id ); ?>]" value="<?php echo esc_html( $assigned_post_id ); ?>">

					</div>
					<!-- Single offer html end -->
					<?php
				}
			}
			?>
			<!-- FOR each SINGLE OFFER end -->
		</div>
		<!-- Funnel Offers End -->

		<!-- Add new Offer button with current funnel id as data-id -->
		<div class="mwb_wocuf_pro_new_offer">
			<button id="mwb_upsell_create_new_offer" class="mwb_wocuf_pro_create_new_offer" data-id="<?php echo esc_html( $mwb_wocuf_pro_funnel_id ); ?>">
			<?php esc_html_e( 'Add New Offer', 'woo-one-click-upsell-funnel' ); ?>
			</button>
		</div>
		
		<!-- Save Changes for whole funnel -->
		<p class="submit">
			<input type="submit" value="<?php esc_html_e( 'Save Changes', 'woo-one-click-upsell-funnel' ); ?>" class="button-primary woocommerce-save-button" name="mwb_wocuf_pro_creation_setting_save" id="mwb_wocuf_pro_creation_setting_save" >
		</p>
	</div>
</form>
