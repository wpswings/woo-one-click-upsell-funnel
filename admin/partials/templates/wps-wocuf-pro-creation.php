<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to create/view/edit funnels of the plugin.
 *
 * @link       https://wpswings.com/?utm_source=wpswings-official&utm_medium=upsell-org-backend&utm_campaign=official
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
	$wpswocuf_pro_funnels = get_option( 'wpswocuf_funnels_list', array() );

	if ( ! empty( $wpswocuf_pro_funnels ) ) {

		// Temp funnel variable.
		$wpswocuf_pro_funnel_duplicate = $wpswocuf_pro_funnels;

		// Make key pointer point to the end funnel.
		end( $wpswocuf_pro_funnel_duplicate );

		// Now key function will return last funnel key.
		$wpswocuf_pro_funnel_number = key( $wpswocuf_pro_funnel_duplicate );

		/**
		 * So new funnel id will be last key+1.
		 *
		 * Funnel key in array is funnel id. ( not really.. need to find, if funnel is deleted then keys change)
		 *
		 * Yes Funnel is identified by key, if deleted.. other funnel key ids will change.
		 * The array field wpswocuf_pro_funnel_id is not used so ignore it.
		 * if it is different from key means some funnel was deleted.
		 * So remember funnel id is its array[key].
		 *
		 * UPDATE : Remove array values, so now from v3 funnel id keys wont change after
		 * funnel deletion.
		 * The array field wpswocuf_pro_funnel_id will equal to funnel key from v3.
		 */
		$wpswocuf_pro_funnel_id = $wpswocuf_pro_funnel_number + 1;
	} else {

		// First funnel.
		// Firstly it was 0 now changed it to 1, make sure that doesn't cause any issues.
		$wpswocuf_pro_funnel_id = 1;
	}
} else {

	// Retrieve new funnel id from GET parameter when redirected from funnel list's page.
	$wpswocuf_pro_funnel_id = sanitize_text_field( wp_unslash( $_GET['funnel_id'] ) );
}

// When save changes is clicked.
if ( isset( $_POST['wpswocuf_pro_creation_setting_save'] ) ) {

	unset( $_POST['wpswocuf_pro_creation_setting_save'] );

	// Nonce verification.
	check_admin_referer( 'wpswocuf_pro_creation_nonce', 'wpswocuf_pro_nonce' );

	// Saved funnel id.
	$wpswocuf_pro_funnel_id = ! empty( $_POST['wpswocuf_funnel_id'] ) ? sanitize_text_field( wp_unslash( $_POST['wpswocuf_funnel_id'] ) ) : '';

	if ( empty( $_POST['wpswocuf_target_pro_ids'] ) ) {

		$_POST['wpswocuf_target_pro_ids'] = array();
	}

	if ( empty( $_POST['wpswocuf_upsell_funnel_status'] ) ) {

		$_POST['wpswocuf_upsell_funnel_status'] = 'no';
	}

	if ( empty( $_POST['wpswocuf_upsell_offer_image'] ) ) {

		$_POST['wpswocuf_upsell_offer_image'] = array();
	}

	/**
	 * Handle the schedule here.
	 */
	if ( empty( $_POST['wpswocuf_pro_funnel_schedule'] ) ) {

		if ( isset( $_POST['wpswocuf_pro_funnel_schedule'] ) && (int) '0' === (int) $_POST['wpswocuf_pro_funnel_schedule'] ) {

			// Zero is marked as sunday.
			$_POST['wpswocuf_pro_funnel_schedule'] = array( '0' );

		} else {

			// Empty is marked as daily.
			$_POST['wpswocuf_pro_funnel_schedule'] = array( '7' );
		}
	} elseif ( ! is_array( $_POST['wpswocuf_pro_funnel_schedule'] ) ) {

		$_POST['wpswocuf_pro_funnel_schedule'] = array( sanitize_text_field( wp_unslash( $_POST['wpswocuf_pro_funnel_schedule'] ) ) );
	}

	$wpswocuf_pro_funnel        = array();
	$offer_custom_page_url_array = array();

	/**
	 * Get each associated to funnel sanitized in its own.
	 */

	// Sanitize and strip slashes for normal single value fields.
	$wpswocuf_pro_funnel['wpswocuf_upsell_funnel_status'] = ! empty( $_POST['wpswocuf_upsell_funnel_status'] ) ? sanitize_text_field( wp_unslash( $_POST['wpswocuf_upsell_funnel_status'] ) ) : '';
	$wpswocuf_pro_funnel['wpswocuf_funnel_id']      = ! empty( $_POST['wpswocuf_funnel_id'] ) ? sanitize_text_field( wp_unslash( $_POST['wpswocuf_funnel_id'] ) ) : '';
	$wpswocuf_pro_funnel['wpswocuf_upsell_fsav3']         = ! empty( $_POST['wpswocuf_upsell_fsav3'] ) ? sanitize_text_field( wp_unslash( $_POST['wpswocuf_upsell_fsav3'] ) ) : '';
	$wpswocuf_pro_funnel['wpswocuf_funnel_name']    = ! empty( $_POST['wpswocuf_funnel_name'] ) ? sanitize_text_field( wp_unslash( $_POST['wpswocuf_funnel_name'] ) ) : '';

	// Sanitize and strip slashes for Funnel Target products.
	$target_pro_schedule_array = ! empty( $_POST['wpswocuf_pro_funnel_schedule'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['wpswocuf_pro_funnel_schedule'] ) ) : array();

	$wpswocuf_pro_funnel['wpswocuf_pro_funnel_schedule'] = ! empty( $target_pro_schedule_array ) ? $target_pro_schedule_array : array();


	// Sanitize and strip slashes for Funnel Target products.
	$target_pro_ids_array = ! empty( $_POST['wpswocuf_target_pro_ids'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['wpswocuf_target_pro_ids'] ) ) : array();

	$wpswocuf_pro_funnel['wpswocuf_target_pro_ids'] = ! empty( $target_pro_ids_array ) ? $target_pro_ids_array : array();

	// Sanitize and strip slashes for Funnel Target products.
	$target_pro_ids_array = ! empty( $_POST['target_categories_ids'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['target_categories_ids'] ) ) : array();

	$wpswocuf_pro_funnel['target_categories_ids'] = ! empty( $target_pro_ids_array ) ? $target_pro_ids_array : array();


	// Sanitize and strip slashes for Funnel Offer products.
	$products_in_offer_array = ! empty( $_POST['wpswocuf_products_in_offer'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['wpswocuf_products_in_offer'] ) ) : '';

	$wpswocuf_pro_funnel['wpswocuf_products_in_offer'] = ! empty( $products_in_offer_array ) ? $products_in_offer_array : array();


	// Sanitize and strip slashes for Funnel Offer price.
	$offer_discount_price_array = ! empty( $_POST['wpswocuf_offer_discount_price'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['wpswocuf_offer_discount_price'] ) ) : '';

	$wpswocuf_pro_funnel['wpswocuf_offer_discount_price'] = ! empty( $offer_discount_price_array ) ? $offer_discount_price_array : array();


	// Sanitize and strip slashes for attached offer on yes array.
	$attached_offers_on_buy = ! empty( $_POST['wpswocuf_attached_offers_on_buy'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['wpswocuf_attached_offers_on_buy'] ) ) : '';

	$wpswocuf_pro_funnel['wpswocuf_attached_offers_on_buy'] = $attached_offers_on_buy;


	// Sanitize and strip slashes for attached offer on no array.
	$attached_offers_on_no = ! empty( $_POST['wpswocuf_attached_offers_on_no'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['wpswocuf_attached_offers_on_no'] ) ) : '';

	$wpswocuf_pro_funnel['wpswocuf_attached_offers_on_no'] = $attached_offers_on_no;


	// Sanitize and strip slashes for attached offer template array.
	$offer_template = ! empty( $_POST['wpswocuf_pro_offer_template'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['wpswocuf_pro_offer_template'] ) ) : '';

	$wpswocuf_pro_funnel['wpswocuf_pro_offer_template'] = $offer_template;


	// Sanitize and strip slashes for custom page url array.
	$offer_custom_page_url = ! empty( $_POST['wpswocuf_offer_custom_page_url'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['wpswocuf_offer_custom_page_url'] ) ) : '';

	$offer_custom_page_url = ! empty( $offer_custom_page_url ) ? array_map( 'esc_url', wp_unslash( $offer_custom_page_url ) ) : '';

	$wpswocuf_pro_funnel['wpswocuf_offer_custom_page_url'] = $offer_custom_page_url;


	// Sanitize and strip slashes for applied offer number.
	$applied_offer_number = ! empty( $_POST['wpswocuf_applied_offer_number'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['wpswocuf_applied_offer_number'] ) ) : '';

	$wpswocuf_pro_funnel['wpswocuf_applied_offer_number'] = $applied_offer_number;

	// Sanitize and strip slashes for page id assigned.
	$post_id_assigned = ! empty( $_POST['wpswocuf_upsell_post_id_assigned'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['wpswocuf_upsell_post_id_assigned'] ) ) : '';

	$wpswocuf_pro_funnel['wpswocuf_upsell_post_id_assigned'] = $post_id_assigned;

	// Since v3.0.0.
	// Sanitize and strip slashes for Funnel offer custom image.
	$custom_image_ids_array = ! empty( $_POST['wpswocuf_upsell_offer_image'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['wpswocuf_upsell_offer_image'] ) ) : array();

	$wpswocuf_pro_funnel['wpswocuf_upsell_offer_image'] = ! empty( $custom_image_ids_array ) ? $custom_image_ids_array : array();

	$wpswocuf_pro_funnel['wpswocuf_global_funnel'] = ! empty( $_POST['wpswocuf_global_funnel'] ) ? 'yes' : 'no';

	$wpswocuf_pro_funnel['wpswocuf_exclusive_offer'] = ! empty( $_POST['wpswocuf_exclusive_offer'] ) ? 'yes' : 'no';

	$wpswocuf_pro_funnel['wpswocuf_smart_offer_upgrade'] = ! empty( $_POST['wpswocuf_smart_offer_upgrade'] ) ? 'yes' : 'no';

	// Get all funnels.**.
	$wpswocuf_pro_created_funnels = get_option( 'wpswocuf_funnels_list', array() );

	// If funnel already exists then save Exclusive offer email data.
	if ( ! empty( $wpswocuf_pro_created_funnels[ $wpswocuf_pro_funnel_id ]['offer_already_shown_to_users'] ) && is_array( $wpswocuf_pro_created_funnels[ $wpswocuf_pro_funnel_id ]['offer_already_shown_to_users'] ) ) {

		$already_saved_funnel = $wpswocuf_pro_created_funnels[ $wpswocuf_pro_funnel_id ];
		// Not Post data, so no need to Sanitize and Strip slashes.

		// Empty and array already checked above.
		$wpswocuf_pro_funnel['offer_already_shown_to_users'] = $already_saved_funnel['offer_already_shown_to_users'];
		$already_saved_funnel = $already_saved_funnel + $wpswocuf_pro_funnel['offer_already_shown_to_users'];
	}

	// If funnel already exists then save Upsell Sales by Funnel - Stats if present.
	if ( ! empty( $wpswocuf_pro_created_funnels[ $wpswocuf_pro_funnel_id ]['funnel_triggered_count'] ) ) {

		$funnel_stats_funnel = $wpswocuf_pro_created_funnels[ $wpswocuf_pro_funnel_id ];

		// Not Post data, so no need to Sanitize and Strip slashes.

		// Empty for this already checked above.
		$wpswocuf_pro_funnel['funnel_triggered_count'] = $funnel_stats_funnel['funnel_triggered_count'];

		$wpswocuf_pro_funnel['funnel_success_count'] = ! empty( $funnel_stats_funnel['funnel_success_count'] ) ? $funnel_stats_funnel['funnel_success_count'] : 0;

		$wpswocuf_pro_funnel['offers_view_count'] = ! empty( $funnel_stats_funnel['offers_view_count'] ) ? $funnel_stats_funnel['offers_view_count'] : 0;

		$wpswocuf_pro_funnel['offers_accept_count'] = ! empty( $funnel_stats_funnel['offers_accept_count'] ) ? $funnel_stats_funnel['offers_accept_count'] : 0;

		$wpswocuf_pro_funnel['offers_reject_count'] = ! empty( $funnel_stats_funnel['offers_reject_count'] ) ? $funnel_stats_funnel['offers_reject_count'] : 0;

		$wpswocuf_pro_funnel['funnel_total_sales'] = ! empty( $funnel_stats_funnel['funnel_total_sales'] ) ? $funnel_stats_funnel['funnel_total_sales'] : 0;
	}

	$wpswocuf_pro_funnel_series = array();

	// POST funnel as array at funnel id key.
	$wpswocuf_pro_funnel_series[ $wpswocuf_pro_funnel_id ] = ! empty( $wpswocuf_pro_funnel ) && is_array( $wpswocuf_pro_funnel ) ? $wpswocuf_pro_funnel : array();

	// If there are other funnels.
	if ( is_array( $wpswocuf_pro_created_funnels ) && count( $wpswocuf_pro_created_funnels ) ) {

		$flag = false;

		foreach ( $wpswocuf_pro_created_funnels as $key => $data ) {

			// If funnel id key is already present, then replace that key in array.
			if ( (int) $key === (int) $wpswocuf_pro_funnel_id ) {

				$wpswocuf_pro_created_funnels[ $key ] = $wpswocuf_pro_funnel_series[ $wpswocuf_pro_funnel_id ];
				$flag                                  = true;
				break;
			}
		}

		// If funnel id key not present then merge array.
		if ( true !== $flag ) {

			// Array merge was reindexing keys so using array union operator.
			$wpswocuf_pro_created_funnels = $wpswocuf_pro_created_funnels + $wpswocuf_pro_funnel_series;
		}

		update_option( 'wpswocuf_funnels_list', $wpswocuf_pro_created_funnels );

	} else { // If there are no other funnels.

		update_option( 'wpswocuf_funnels_list', $wpswocuf_pro_funnel_series );
	}

	// After funnel is saved.
	// Handling Funnel offer-page posts deletion which are dynamically assigned.
	wpswocuf_upsell_lite_offer_page_posts_deletion();

	?>
	<!-- Settings saved notice -->
	<div class="notice notice-success is-dismissible"> 
		<p><strong><?php esc_html_e( 'Settings saved', 'woo-one-click-upsell-funnel' ); ?></strong></p>
	</div>
	<?php
}

// Get all funnels.
$wpswocuf_pro_funnel_data = get_option( 'wpswocuf_funnels_list', array() );

// Not used anywhere I guess.
$wpswocuf_pro_custom_th_page = ! empty( $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_pro_custom_th_page'] ) ? $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_pro_custom_th_page'] : 'off';

$wpswocuf_pro_funnel_schedule_options = array(
	'0' => esc_html__( 'Sunday', 'woo-one-click-upsell-funnel' ),
	'1' => esc_html__( 'Monday', 'woo-one-click-upsell-funnel' ),
	'2' => esc_html__( 'Tuesday', 'woo-one-click-upsell-funnel' ),
	'3' => esc_html__( 'Wednesday', 'woo-one-click-upsell-funnel' ),
	'4' => esc_html__( 'Thursday', 'woo-one-click-upsell-funnel' ),
	'5' => esc_html__( 'Friday', 'woo-one-click-upsell-funnel' ),
	'6' => esc_html__( 'Saturday', 'woo-one-click-upsell-funnel' ),
	'7' => esc_html__( 'Daily', 'woo-one-click-upsell-funnel' ),
);

?>

<!-- FOR SINGLE FUNNEL -->
<form action="" method="POST">

	<div class="wpswocuf_upsell_table">

		<table class="form-table wpswocuf_pro_creation_setting">

			<tbody>

				<!-- Nonce field here. -->
				<?php wp_nonce_field( 'wpswocuf_pro_creation_nonce', 'wpswocuf_pro_nonce' ); ?>

				<input type="hidden" name="wpswocuf_funnel_id" value="<?php echo esc_html( $wpswocuf_pro_funnel_id ); ?>">

				<!-- Funnel saved after version 3. TO differentiate between new v3 users and old users. -->
				<input type="hidden" name="wpswocuf_upsell_fsav3" value="true">

				<?php

				$funnel_name = ! empty( $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_funnel_name'] ) ? $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_funnel_name'] : esc_html__( 'Funnel', 'woo-one-click-upsell-funnel' ) . " #$wpswocuf_pro_funnel_id";

				$funnel_status = ! empty( $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_upsell_funnel_status'] ) ? $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_upsell_funnel_status'] : 'no';
				$wpswocuf_add_product_tick = ! empty( $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_add_products'] ) ? 'yes' : 'no';

				// Pre v3.0.0 Funnels will be live.
				// The first condition to ensure funnel is already saved.
				if ( ! empty( $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_funnel_name'] ) && empty( $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_upsell_fsav3'] ) ) {

					$funnel_status = 'yes';
				}


				?>

				<div id="wpswocuf_upsell_funnel_name_heading" >

					<h2><?php echo esc_attr( $funnel_name ); ?></h2>

					<div id="wpswocuf_upsell_funnel_status" >

						<?php

						$attribute_description = sprintf( '<p class="wpswocuf_upsell_tip_tip">%s</p><p class="wpswocuf_upsell_tip_tip">%s</p><p class="wpswocuf_upsell_tip_tip">%s</p>', esc_html__( 'Post Checkout Offers will be displayed :', 'woo-one-click-upsell-funnel' ), esc_html__( 'Sandbox Mode &rarr; For Admin only', 'woo-one-click-upsell-funnel' ), esc_html__( 'Live Mode &rarr; For All', 'woo-one-click-upsell-funnel' ) );

						wpswocuf_upsell_lite_wc_help_tip( $attribute_description );
						?>

						<label>
							<input type="checkbox" id="wpswocuf_upsell_funnel_status_input" name="wpswocuf_upsell_funnel_status" value="yes" <?php checked( 'yes', $funnel_status ); ?> >
							<span class="wpswocuf_upsell_funnel_span"></span>
						</label>

						<span class="wpswocuf_upsell_funnel_status_on <?php echo 'yes' === $funnel_status ? 'active' : ''; ?>"><?php esc_html_e( 'Live', 'woo-one-click-upsell-funnel' ); ?></span>
						<span class="wpswocuf_upsell_funnel_status_off <?php echo 'no' === $funnel_status ? 'active' : ''; ?>"><?php esc_html_e( 'Sandbox', 'woo-one-click-upsell-funnel' ); ?></span>
					</div>

				</div>

				<div class="wpswocuf_upsell_offer_template_previews">

					<div class="wpswocuf_upsell_offer_template_preview_one">
						<?php

						if ( wpswocuf_upsell_divi_builder_plugin_active() ) {

							?>
								<div class="wpswocuf_upsell_offer_template_preview_one_sub_div"><img src="<?php echo esc_url( wpswocuf_URL . 'admin/resources/offer-previews/divi/offer-template-one.png' ); ?>">
								</div>
							<?php


						} else {
							?>
								<div class="wpswocuf_upsell_offer_template_preview_one_sub_div"><img src="<?php echo esc_url( wpswocuf_URL . 'admin/resources/offer-previews/offer-template-one.png' ); ?>">
								</div>
							<?php
						}
						?>
						
					</div>

					<div class="wpswocuf_upsell_offer_template_preview_two">
					<?php

					if ( wpswocuf_upsell_divi_builder_plugin_active() ) {

						?>
								<div class="wpswocuf_upsell_offer_template_preview_two_sub_div"><img src="<?php echo esc_url( wpswocuf_URL . 'admin/resources/offer-previews/divi/offer-template-two.png' ); ?>">
								</div>
							<?php


					} else {
						?>
								<div class="wpswocuf_upsell_offer_template_preview_two_sub_div"><img src="<?php echo esc_url( wpswocuf_URL . 'admin/resources/offer-previews/offer-template-two.png' ); ?>">
								</div>
							<?php
					}
					?>
						
					</div>

					<div class="wpswocuf_upsell_offer_template_preview_three">
					<?php

					if ( wpswocuf_upsell_divi_builder_plugin_active() ) {

						?>
								<div class="wpswocuf_upsell_offer_template_preview_three_sub_div"><img src="<?php echo esc_url( wpswocuf_URL . 'admin/resources/offer-previews/divi/offer-template-three.png' ); ?>">
								</div>
							<?php


					} else {
						?>
								<div class="wpswocuf_upsell_offer_template_preview_three_sub_div"><img src="<?php echo esc_url( wpswocuf_URL . 'admin/resources/offer-previews/offer-template-three.png' ); ?>">
								</div>
							<?php
					}
					?>
						
					
					
					
					</div>

					<div class="wpswocuf_upsell_offer_template_preview_four">
						<div class="wpswocuf_upsell_offer_template_preview_four_sub_div"><img src="<?php echo esc_url( wpswocuf_URL . 'admin/resources/offer-previews/offer-template-four.png' ); ?>">
						</div>
					</div>

					<div class="wpswocuf_upsell_offer_template_preview_five">
						<div class="wpswocuf_upsell_offer_template_preview_five_sub_div"><img src="<?php echo esc_url( wpswocuf_URL . 'admin/resources/offer-previews/offer-template-five.png' ); ?>">
						</div>
					</div>

					<div class="wpswocuf_upsell_offer_template_preview_six">
						<div class="wpswocuf_upsell_offer_template_preview_six_sub_div"><img src="<?php echo esc_url( wpswocuf_URL . 'admin/resources/offer-previews/offer-template-six.png' ); ?>">
						</div>
					</div>

					<div class="wpswocuf_upsell_offer_template_preview_seven">
						<div class="wpswocuf_upsell_offer_template_preview_seven_sub_div"><img src="<?php echo esc_url( wpswocuf_URL . 'admin/resources/offer-previews/offer-template-seven.png' ); ?>">
						</div>
					</div>

					<div class="wpswocuf_upsell_offer_template_preview_eight">
						<div class="wpswocuf_upsell_offer_template_preview_eight_sub_div"><img src="<?php echo esc_url( wpswocuf_URL . 'admin/resources/offer-previews/offer-template-eight.png' ); ?>">
						</div>
					</div>

					<a href="javascript:void(0)" class="wpswocuf_upsell_offer_preview_close"><span class="wpswocuf_upsell_offer_preview_close_span"></span></a>
				</div>


				<!-- Funnel Name start-->
				<tr valign="top">

					<th scope="row" class="titledesc">
						<label for="wpswocuf_funnel_name"><?php esc_html_e( 'Name of the funnel', 'woo-one-click-upsell-funnel' ); ?></label>
					</th>

					<td class="forminp forminp-text">

						<?php

						$description = esc_html__( 'Provide the name of your funnel', 'woo-one-click-upsell-funnel' );
						wpswocuf_upsell_lite_wc_help_tip( $description );
						?>

						<input type="text" id="wpswocuf_upsell_funnel_name" name="wpswocuf_funnel_name" value="<?php echo esc_html( $funnel_name ); ?>" id="wpswocuf_pro_funnel_name" class="input-text wpswocuf_pro_commone_class" required="" maxlength="30">
					</td>
				</tr>
				<!-- Funnel Name end-->

					<!-- cart amount start-->
					<tr valign="top">

<th scope="row" class="titledesc">
	<label for="wpswocuf_pro_funnel_cart_amount"><?php esc_html_e( 'Minimum Cart Amount', 'woo-one-click-upsell-funnel' ); ?></label>
</th>

<td class="forminp forminp-text">

	<?php

	$description = esc_html__( 'Enter Minimum Cart Amount To Trigger Funnel', 'woo-one-click-upsell-funnel' );
	wpswocuf_upsell_lite_wc_help_tip( $description );

	?>

	<input type="number" min="0" id="wpswocuf_upsell_funnel_cart_amount" name="wpswocuf_pro_funnel_cart_amount" value="0" class="input-text wpswocuf_pro_commone_class" required="">
</td>
</tr>
<!-- cart amount end-->

				<!-- Select Target product start -->
				<tr valign="top">

					<th scope="row" class="titledesc">
						<label for="wpswocuf_target_pro_ids"><?php esc_html_e( 'Select target product(s)', 'woo-one-click-upsell-funnel' ); ?></label>
					</th>

					<td class="forminp forminp-text">

						<?php

						$description = esc_html__( 'If any one of these Target Products is checked out then the this funnel will be triggered and the below offers will be shown.', 'woo-one-click-upsell-funnel' );

						wpswocuf_upsell_lite_wc_help_tip( $description );
						?>

						<select class="wc-funnel-product-search" multiple="multiple" style="" name="wpswocuf_target_pro_ids[]" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', 'woo-one-click-upsell-funnel' ); ?>">

						<?php

						if ( ! empty( $wpswocuf_pro_funnel_data ) ) {

							$wpswocuf_pro_target_products = isset( $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_target_pro_ids'] ) ? $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_target_pro_ids'] : array();

							// array_map with absint converts negative array values to positive, so that we dont get negative ids.
							$wpswocuf_pro_target_product_ids = ! empty( $wpswocuf_pro_target_products ) ? array_map( 'absint', $wpswocuf_pro_target_products ) : null;

							if ( $wpswocuf_pro_target_product_ids ) {

								foreach ( $wpswocuf_pro_target_product_ids as $wpswocuf_pro_single_target_product_id ) {

									$product_name = get_the_title( $wpswocuf_pro_single_target_product_id );

									echo '<option value="' . esc_html( $wpswocuf_pro_single_target_product_id ) . '" selected="selected" >' . esc_html( $product_name ) . '(#' . esc_html( $wpswocuf_pro_single_target_product_id ) . ')</option>';
								}
							}
						}
						?>
						</select>	
						
					</td>	
				</tr>
				<!-- Select Target product end -->

				<!-- Select Target category start -->
				<tr valign="top">

					<th scope="row" class="titledesc">
						<label for="wpswocuf_pro_target_pro_ids"><?php esc_html_e( 'Select target category(s)',  'woo-one-click-upsell-funnel' ); ?></label>
					</th>

					<td class="forminp forminp-text">

						<?php

						$description = esc_html__( 'If any one of these Target Category Products is checked out then the this funnel will be triggered and the below offers will be shown.',  'woo-one-click-upsell-funnel' );

						wpswocuf_upsell_lite_wc_help_tip( $description );

						?>

						<select class="wc-funnel-product-category-search" multiple="multiple" style="" name="target_categories_ids[]" data-placeholder="<?php esc_attr_e( 'Search for a category&hellip;',  'woo-one-click-upsell-funnel' ); ?>">

						<?php

						if ( ! empty( $wpswocuf_pro_funnel_data ) ) {

							$target_categories_ids = isset( $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['target_categories_ids'] ) ? $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['target_categories_ids'] : array();

							// array_map with absint converts negative array values to positive, so that we dont get negative ids.
							$target_categories_ids = ! empty( $target_categories_ids ) ? array_map( 'absint', $target_categories_ids ) : null;

							if ( $target_categories_ids ) {

								foreach ( $target_categories_ids as $single_target_category_id ) {

									$single_category_name = get_the_category_by_ID( $single_target_category_id );

									?>
									<option value="<?php echo esc_html( $single_target_category_id ); ?>" selected="selected" ><?php echo esc_html( $single_category_name ); ?>(#<?php echo esc_html( $single_target_category_id ); ?>)</option>
									<?php
								}
							}
						}

						?>
						</select>		
					</td>	
				</tr>
				<!-- Select Target category end -->

				<!-- Schedule your Funnel start -->
				<tr valign="top">

					<th scope="row" class="titledesc">
						<label for="wpswocuf_pro_funnel_schedule"><?php esc_html_e( 'Funnel Schedule', 'woo-one-click-upsell-funnel' ); ?></label>
					</th>

					<td class="forminp forminp-text">

						<?php

						$description = esc_html__( 'Schedule your funnel for specific weekdays.', 'woo-one-click-upsell-funnel' );

						wpswocuf_upsell_lite_wc_help_tip( $description );

						?>
						<!-- Add multiselect since v3.0.0 -->
						<select class="wpswocuf_pro_funnel_schedule wps-upsell-funnel-schedule-search" name="wpswocuf_pro_funnel_schedule[]" multiple="multiple" data-placeholder="<?php esc_attr_e( 'Search for a specific days&hellip;', 'woo-one-click-upsell-funnel' ); ?>">

							<?php

							/**
							 * After v1.0.0 schedule value will be array.
							 * Hence, convert earlier version data in array.
							 */
							if ( empty( $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_pro_funnel_schedule'] ) || ! is_array( $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_pro_funnel_schedule'] ) ) {

								$selected_week = ! empty( $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_pro_funnel_schedule'] ) ? array( $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_pro_funnel_schedule'] ) : array( '7' );
							} else {

								$selected_week = ! empty( $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_pro_funnel_schedule'] ) ? $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_pro_funnel_schedule'] : array( '7' );
							}

							?>

							<?php foreach ( $wpswocuf_pro_funnel_schedule_options as $key => $day ) : ?>

								<option <?php echo in_array( (string) $key, $selected_week, true ) ? 'selected' : ''; ?> value="<?php echo esc_html( $key ); ?>"><?php echo esc_html( $day ); ?></option>

							<?php endforeach; ?>

						</select>
					</td>	
				</tr>
				<!-- Schedule your Funnel end -->

				<!-- Global Funnel start -->
				<tr valign="top">

					<th scope="row" class="titledesc">
						<label for="wpswocuf_global_funnel"><?php esc_html_e( 'Global Funnel', 'woo-one-click-upsell-funnel' ); ?></label>
					</th>

					<td class="forminp forminp-text">
						<?php

						$attribut_description = esc_html__( 'Global Funnel will always trigger independent of the target products and categories. Global Funnel has the highest priority so this will execute at last when no other funnel triggers.', 'woo-one-click-upsell-funnel' );

						wpswocuf_upsell_lite_wc_help_tip( $attribut_description );

						$wpswocuf_is_global = ! empty( $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_global_funnel'] ) ? $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_global_funnel'] : 'no';
						?>

						<label class="wpswocuf_pro_enable_plugin_label">
							<input class="wpswocuf_pro_enable_plugin_input" type="checkbox" <?php echo ( 'yes' === $wpswocuf_is_global ) ? "checked='checked'" : ''; ?> name="wpswocuf_global_funnel" >	
							<span class="wpswocuf_pro_enable_plugin_span"></span>
						</label>		
					</td>
				</tr>
				<!-- Global Funnel end -->

				<!-- Exclusive Offer start -->
				<tr valign="top">

					<th scope="row" class="titledesc">
						<label for="wpswocuf_is_exclusive"><?php esc_html_e( 'Exclusive Offer', 'woo-one-click-upsell-funnel' ); ?></label>
					</th>

					<td class="forminp forminp-text">
						<?php

						$attribut_description = esc_html__( 'This feature makes the upsell funnel to be shown to the customers only once, whether they accept or reject it. This works with respect to the order billing email.', 'woo-one-click-upsell-funnel' );

						wpswocuf_upsell_lite_wc_help_tip( $attribut_description );

						$wpswocuf_is_exclusive = ! empty( $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_exclusive_offer'] ) ? $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_exclusive_offer'] : 'no';
						?>

						<label class="wpswocuf_pro_enable_plugin_label">
							<input class="wpswocuf_pro_enable_plugin_input" type="checkbox" <?php echo ( 'yes' === $wpswocuf_is_exclusive ) ? "checked='checked'" : ''; ?> name="wpswocuf_exclusive_offer" >	
							<span class="wpswocuf_pro_enable_plugin_span"></span>
						</label>		
					</td>
				</tr>
				<!-- Exclusive Offer end -->

				<!-- Smart Offer Upgrade start -->
				<tr valign="top">

					<th scope="row" class="titledesc">
						<label for="wpswocuf_smart_offer_upgrade"><?php esc_html_e( 'Smart Offer Upgrade', 'woo-one-click-upsell-funnel' ); ?></label>
					</th>

					<td class="forminp forminp-text">
						<?php

						$attribute_description = sprintf( '<p class="wpswocuf_upsell_tip_tip">%s</p><p class="wpswocuf_upsell_tip_tip">%s</p><p class="wpswocuf_upsell_tip_tip">%s</p>', esc_html__( 'This feature replaces the target product with the Offer product as an Upgrade.', 'woo-one-click-upsell-funnel' ), esc_html__( 'Please keep this Funnel limited to One Offer as other Offers won\'t show up if this feature is on.', 'woo-one-click-upsell-funnel' ), esc_html__( 'This feature will not work if Global Funnel feature is on for this funnel.', 'woo-one-click-upsell-funnel' ) );

						wpswocuf_upsell_lite_wc_help_tip( $attribute_description );

						$wpswocuf_smoff_upgrade = ! empty( $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_smart_offer_upgrade'] ) ? $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_smart_offer_upgrade'] : 'no';
						?>

						<label class="wpswocuf_pro_enable_plugin_label">
							<input class="wpswocuf_pro_enable_plugin_input" type="checkbox" <?php echo ( 'yes' === $wpswocuf_smoff_upgrade ) ? "checked='checked'" : ''; ?> name="wpswocuf_smart_offer_upgrade" >	
							<span class="wpswocuf_pro_enable_plugin_span"></span>
						</label>
					</td>
				</tr>
				<!-- Smart Offer Upgrade end -->
		<div class="wpswocuf_pro_offers"><h1><?php esc_html_e( 'Funnel Offers', 'woo-one-click-upsell-funnel' ); ?></h1>
		</div>
		<br>
		<?php

		// Funnel Offers array.
		$wpswocuf_pro_existing_offers = ! empty( $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_applied_offer_number'] ) ? $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_applied_offer_number'] : '';

		// Array of offers with product Id.
		$wpswocuf_pro_product_in_offer = ! empty( $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_products_in_offer'] ) ? $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_products_in_offer'] : '';

		// Array of offers with discount.
		$wpswocuf_pro_products_discount = ! empty( $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_offer_discount_price'] ) ? $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_offer_discount_price'] : '';

		// Array of offers with Buy now go to link.
		$wpswocuf_pro_offers_buy_now_offers = ! empty( $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_attached_offers_on_buy'] ) ? $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_attached_offers_on_buy'] : '';

		// Array of offers with No thanks go to link.
		$wpswocuf_pro_offers_no_thanks_offers = ! empty( $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_attached_offers_on_no'] ) ? $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_attached_offers_on_no'] : '';

		// Array of offers with active template.
		$wpswocuf_pro_offer_active_template = ! empty( $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_pro_offer_template'] ) ? $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_pro_offer_template'] : '';

		// Array of offers with custom page url.
		$wpswocuf_pro_offer_custom_page_url = ! empty( $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_offer_custom_page_url'] ) ? $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_offer_custom_page_url'] : '';

		// Array of offers with their post id.
		$post_id_assigned_array = ! empty( $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_upsell_post_id_assigned'] ) ? $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_upsell_post_id_assigned'] : '';

		// Funnel Offers array.
		$wpswocuf_custom_offer_images = ! empty( $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_upsell_offer_image'] ) ? $wpswocuf_pro_funnel_data[ $wpswocuf_pro_funnel_id ]['wpswocuf_upsell_offer_image'] : array();

		// Funnel Offers array.
		// To be used for showing other offers except for itself in 'buy now' and 'no thanks' go to link.
		$wpswocuf_pro_existing_offers_2 = $wpswocuf_pro_existing_offers;

		?>

		<!-- Funnel Offers Start-->
		<div class="new_offers">

			<div class="new_created_offers" data-id="0"></div>

			<!-- FOR each SINGLE OFFER start -->

			<?php

			if ( ! empty( $wpswocuf_pro_existing_offers ) ) {

				// Funnel Offers array. Foreach as offer_id => offer_id.
				// Key and value are always same as offer array keys are not reindexed.
				foreach ( $wpswocuf_pro_existing_offers as
				$current_offer_id => $current_offer_id_val ) {

					$wpswocuf_pro_buy_attached_offers = '';

					$wpswocuf_pro_no_attached_offers = '';

					// Creating options html for showing other offers except for itself in 'buy now' and 'no thanks' go to link.
					if ( ! empty( $wpswocuf_pro_existing_offers_2 ) ) {

						foreach ( $wpswocuf_pro_existing_offers_2 as $current_offer_id_2 ) :

							if ( (int) $current_offer_id_2 !== (int) $current_offer_id ) {

								$wpswocuf_pro_buy_attached_offers .= '<option value=' . esc_html( $current_offer_id_2 ) . '>' . esc_html__( 'Offer #', 'woo-one-click-upsell-funnel' ) . esc_html( $current_offer_id_2 ) . '</option>';

								$wpswocuf_pro_no_attached_offers .= '<option value=' . esc_html( $current_offer_id_2 ) . '>' . esc_html__( 'Offer #', 'woo-one-click-upsell-funnel' ) . esc_html( $current_offer_id_2 ) . '</option>';
							}

						endforeach;
					}

					$wpswocuf_pro_buy_now_action_html = '';

					// For showing Buy Now selected link.
					if ( ! empty( $wpswocuf_pro_offers_buy_now_offers ) ) {

						// If link is set to No thanks.
						if ( 'thanks' === $wpswocuf_pro_offers_buy_now_offers[ $current_offer_id ] ) {

							$wpswocuf_pro_buy_now_action_html = '<select name="wpswocuf_attached_offers_on_buy[' . $current_offer_id . ']"><option value="thanks" selected="">' . esc_html__( 'Order ThankYou Page', 'woo-one-click-upsell-funnel' ) . '</option>' . $wpswocuf_pro_buy_attached_offers;
						} elseif ( $wpswocuf_pro_offers_buy_now_offers[ $current_offer_id ] > 0 ) {

							$wpswocuf_pro_buy_now_action_html = '<select name="wpswocuf_attached_offers_on_buy[' . $current_offer_id . ']"><option value="thanks">' . esc_html__( 'Order ThankYou Page', 'woo-one-click-upsell-funnel' ) . '</option>';

							if ( ! empty( $wpswocuf_pro_existing_offers_2 ) ) {

								// Loop through offers and set the saved one as selected.
								foreach ( $wpswocuf_pro_existing_offers_2 as $current_offer_id_2 ) {

									if ( (string) $current_offer_id_2 !== (string) $current_offer_id ) {

										if ( (string) $wpswocuf_pro_offers_buy_now_offers[ $current_offer_id ] === (string) $current_offer_id_2 ) {

											$wpswocuf_pro_buy_now_action_html .= '<option value=' . $current_offer_id_2 . ' selected="">' . esc_html__( 'Offer #', 'woo-one-click-upsell-funnel' ) . $current_offer_id_2 . '</option>';
										} else {

											$wpswocuf_pro_buy_now_action_html .= '<option value=' . $current_offer_id_2 . '>' . esc_html__( 'Offer #', 'woo-one-click-upsell-funnel' ) . $current_offer_id_2 . '</option>';
										}
									}
								}
							}
						}
					}

					$wpswocuf_pro_no_thanks_action_html = '';

					// For showing No Thanks selected link.
					if ( ! empty( $wpswocuf_pro_offers_no_thanks_offers ) ) {

						// If link is set to No thanks.
						if ( 'thanks' === $wpswocuf_pro_offers_no_thanks_offers[ $current_offer_id ] ) {

							$wpswocuf_pro_no_thanks_action_html = '<select name="wpswocuf_attached_offers_on_no[' . $current_offer_id . ']"><option value="thanks" selected="">' . esc_html__( 'Order ThankYou Page', 'woo-one-click-upsell-funnel' ) . '</option>' . $wpswocuf_pro_no_attached_offers;
						} elseif ( $wpswocuf_pro_offers_no_thanks_offers[ $current_offer_id ] > 0 ) { // If link is set to other offer.

							$wpswocuf_pro_no_thanks_action_html = '<select name="wpswocuf_attached_offers_on_no[' . $current_offer_id . ']"><option value="thanks">' . esc_html__( 'Order ThankYou Page', 'woo-one-click-upsell-funnel' ) . '</option>';

							if ( ! empty( $wpswocuf_pro_existing_offers_2 ) ) {

								// Loop through offers and set the saved one as selected.
								foreach ( $wpswocuf_pro_existing_offers_2 as $current_offer_id_2 ) {

									if ( (int) $current_offer_id !== (int) $current_offer_id_2 ) {

										if ( (int) $wpswocuf_pro_offers_no_thanks_offers[ $current_offer_id ] === (int) $current_offer_id_2 ) {

											$wpswocuf_pro_no_thanks_action_html .= '<option value=' . $current_offer_id_2 . ' selected="">' . esc_html__( 'Offer #', 'woo-one-click-upsell-funnel' ) . $current_offer_id_2 . '</option>';
										} else {

											$wpswocuf_pro_no_thanks_action_html .= '<option value=' . $current_offer_id_2 . '>' . esc_html__( 'Offer #', 'woo-one-click-upsell-funnel' ) . $current_offer_id_2 . '</option>';
										}
									}
								}
							}
						}
					}

					$wpswocuf_pro_buy_now_action_html .= '</select>';

					$wpswocuf_pro_no_thanks_action_html .= '</select>';

					?>

					<!-- Single offer html start -->
					<div class="new_created_offers wpswocuf_upsell_single_offer" data-id="<?php echo esc_html( $current_offer_id ); ?>" data-scroll-id="#offer-section-<?php echo esc_html( $current_offer_id ); ?>">

						<h2 class="wpswocuf_upsell_offer_title" >
							<?php echo esc_html__( 'Offer #', 'woo-one-click-upsell-funnel' ) . esc_html( $current_offer_id ); ?>
						</h2>

						<table>
							<!-- Offer product start -->
							<tr>
								<th><label><h4><?php esc_html_e( 'Offer Product', 'woo-one-click-upsell-funnel' ); ?></h4></label>
								</th>

								<td>
								<select class="wc-offer-product-search wpswocuf_upsell_offer_product" name="wpswocuf_products_in_offer[<?php echo esc_html( $current_offer_id ); ?>]" data-placeholder="<?php esc_html_e( 'Search for a product&hellip;', 'woo-one-click-upsell-funnel' ); ?>">
								<?php

									$current_offer_product_id = '';

								if ( ! empty( $wpswocuf_pro_product_in_offer[ $current_offer_id ] ) ) {

									// In v2.0.0, it was array so handling to get the first product id.
									if ( is_array( $wpswocuf_pro_product_in_offer[ $current_offer_id ] ) && count( $wpswocuf_pro_product_in_offer[ $current_offer_id ] ) ) {

										foreach ( $wpswocuf_pro_product_in_offer[ $current_offer_id ] as $handling_offer_product_id ) {

											$current_offer_product_id = absint( $handling_offer_product_id );
											break;
										}
									} else {

										$current_offer_product_id = absint( $wpswocuf_pro_product_in_offer[ $current_offer_id ] );
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
								<input type="text" class="wpswocuf_upsell_offer_price" name="wpswocuf_offer_discount_price[<?php echo esc_html( $current_offer_id ); ?>]" value="<?php echo esc_html( $wpswocuf_pro_products_discount[ $current_offer_id ] ); ?>">
								<span class="wpswocuf_upsell_offer_description"><?php esc_html_e( 'Specify new offer price or discount %', 'woo-one-click-upsell-funnel' ); ?></span>

								</td>
							</tr>
							<!-- Offer price end -->

							<!-- Offer custom image start -->
							<tr>
								<th><label><h4><?php esc_html_e( 'Offer Image', 'woo-one-click-upsell-funnel' ); ?></h4></label>
								</th>

								<td>
									<?php

										$image_post_id = ! empty( $wpswocuf_custom_offer_images[ $current_offer_id ] ) ? $wpswocuf_custom_offer_images[ $current_offer_id ] : '';

										echo wp_kses( $this->wpswocuf_pro_image_uploader_field( $current_offer_id, $image_post_id ), wpswocuf_upsell_lite_allowed_html() );
									?>
								</td>
							</tr>
							<!-- Offer custom image end -->

							<!-- Buy now go to link start -->
							<tr>
								<th><label><h4><?php esc_html_e( 'After \'Buy Now\' go to', 'woo-one-click-upsell-funnel' ); ?></h4></label>
								</th>

								<td>
									<?php echo wp_kses( $wpswocuf_pro_buy_now_action_html, wpswocuf_upsell_lite_allowed_html() ); // phpcs:ignore ?>

									<span class="wpswocuf_upsell_offer_description"><?php esc_html_e( 'Select where the customer will be redirected after accepting this offer', 'woo-one-click-upsell-funnel' ); ?></span>
								</td>
							</tr>
							<!-- Buy now go to link end -->

							<!-- Buy now no thanks link start -->
							<tr>
								<th><label><h4><?php esc_html_e( 'After \'No thanks\' go to', 'woo-one-click-upsell-funnel' ); ?></h4></label>
								</th>

								<td>
									<?php echo wp_kses( $wpswocuf_pro_no_thanks_action_html, wpswocuf_upsell_lite_allowed_html() );  // phpcs:ignore ?>
									<span class="wpswocuf_upsell_offer_description"><?php esc_html_e( 'Select where the customer will be redirected after rejecting this offer', 'woo-one-click-upsell-funnel' ); ?></span>
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

										$offer_template_active = ! empty( $wpswocuf_pro_offer_active_template[ $current_offer_id ] ) ? $wpswocuf_pro_offer_active_template[ $current_offer_id ] : 'one';

										if ( wpswocuf_upsell_lite_elementor_plugin_active() || wpswocuf_upsell_divi_builder_plugin_active() ) {
											$offer_templates_array = array();

											$offer_templates_array = array(
												'one'   => esc_html__( 'STANDARD TEMPLATE', 'woo-one-click-upsell-funnel' ),
												'two'   => esc_html__( 'CREATIVE TEMPLATE', 'woo-one-click-upsell-funnel' ),
												'three' => esc_html__( 'VIDEO TEMPLATE', 'woo-one-click-upsell-funnel' ),
											);
										}




										?>
										<!-- Offer templates parent div start -->
										<div class="wpswocuf_upsell_offer_templates_parent">

											<input class="wpswocuf_pro_offer_template_input" type="hidden" name="wpswocuf_pro_offer_template[<?php echo esc_html( $current_offer_id ); ?>]" value="<?php echo esc_html( $offer_template_active ); ?>">
											<?php
											foreach ( $offer_templates_array as $template_key => $template_name ) :



												?>
												<!-- Offer templates foreach start-->
												<div class="wpswocuf_upsell_offer_template <?php echo esc_html( (string) $template_key === (string) $offer_template_active ? 'active' : '' ); ?>">

													<div class="wpswocuf_upsell_offer_template_sub_div">

														<h5><?php echo esc_html( $template_name ); ?></h5>

														<div class="wpswocuf_upsell_offer_preview">

															<?php
															if ( 'one' == $template_key || 'two' == $template_key || 'three' == $template_key ) {
																if ( wpswocuf_upsell_divi_builder_plugin_active() ) {
																	?>
																	<a href="javascript:void(0)" class="wpswocuf_upsell_view_offer_template" data-template-id="<?php echo esc_html( $template_key ); ?>" ><img src="<?php echo esc_url( wpswocuf_URL . "admin/resources/offer-thumbnails/divi/offer-template-$template_key.png" ); ?>"></a>
																	<?php
																} else {
																	?>
																	<a href="javascript:void(0)" class="wpswocuf_upsell_view_offer_template" data-template-id="<?php echo esc_html( $template_key ); ?>" ><img src="<?php echo esc_url( wpswocuf_URL . "admin/resources/offer-thumbnails/offer-template-$template_key.jpg" ); ?>"></a>
																	<?php

																}
															} else {
																if ( wpswocuf_upsell_divi_builder_plugin_active() ) {
																	?>
																	<a href="javascript:void(0)" class="wpswocuf_upsell_view_offer_template" data-template-id="<?php echo esc_html( $template_key ); ?>" ><img src="<?php echo esc_url( wpswocuf_URL . "admin/resources/offer-thumbnails/divi/offer-template-$template_key.png" ); ?>"></a>
																	<?php
																} else {
																	?>
																	<a href="javascript:void(0)" class="wpswocuf_upsell_view_offer_template" data-template-id="<?php echo esc_html( $template_key ); ?>" ><img src="<?php echo esc_url( wpswocuf_URL . "admin/resources/offer-thumbnails/offer-template-$template_key.jpg" ); ?>"></a>
																	<?php

																}
																?>
																<?php

															}

															?>
															
														</div>

														<div class="wpswocuf_upsell_offer_action">

															<?php if ( (string) $template_key !== (string) $offer_template_active ) : ?>

															<button class="button-primary wpswocuf_upsell_activate_offer_template" data-template-id="<?php echo esc_html( $template_key ); ?>" data-offer-id="<?php echo esc_html( $current_offer_id ); ?>" data-funnel-id="<?php echo esc_html( $wpswocuf_pro_funnel_id ); ?>" data-offer-post-id="<?php echo esc_html( $assigned_post_id ); ?>" ><?php esc_html_e( 'Insert and Activate', 'woo-one-click-upsell-funnel' ); ?></button>

															<?php else : ?>

																<a class="button" href="<?php echo esc_url( get_permalink( $assigned_post_id ) ); ?>" target="_blank"><?php esc_html_e( 'View &rarr;', 'woo-one-click-upsell-funnel' ); ?></a>
																<?php
																if ( ! wpswocuf_upsell_divi_builder_plugin_active() ) {
																	?>
																			<a class="button" href="<?php echo esc_url( admin_url( "post.php?post=$assigned_post_id&action=elementor" ) ); ?>" target="_blank"><?php esc_html_e( 'Customize &rarr;', 'woo-one-click-upsell-funnel' ); ?></a>

																		<?php
																}
																?>
																
															<?php endif; ?>
														</div>

													</div>

												</div>
												<!-- Offer templates foreach end-->
													<?php
											endforeach;
											if ( wpswocuf_upsell_lite_elementor_plugin_active() || wpswocuf_upsell_divi_builder_plugin_active() ) {
												?>



											<!-- Offer templates 4 foreach start-->
						
										<div class="wpswocuf_upsell_offer_template ">

												<div class="wpswocuf_upsell_offer_template_sub_div"> 

													<h5> <?php esc_html_e( 'FITNESS TEMPLATE', 'woo-one-click-upsell-funnel' ); ?></h5>

													<div class="wpswocuf_upsell_offer_preview">

														<a href="javascript:void(0)" class="wpswocuf_upsell_view_offer_template" data-template-id="four" >
															<span class="wpswocuf_wupsell_premium_strip"><?php esc_html_e( 'Pro', 'woo-one-click-upsell-funnel' ); ?></span><img src="<?php echo esc_url( wpswocuf_URL . 'admin/resources/offer-thumbnails/offer-template-four.png' ); ?>"></a>
													</div>

													<div class="wpswocuf_upsell_offer_action">

														<?php if ( $template_key !== $offer_template_active ) : ?>

															<input type="button" class=" wpswocuf_upsell_activate_offer_template_pro ubo_offer_input" value="<?php esc_html_e( 'Upgrade To Pro', 'woo-one-click-upsell-funnel' ); ?>"/>

											
														<?php else : ?>

															<a class="button" href="<?php echo esc_url( get_permalink( $assigned_post_id ) ); ?>" target="_blank"><?php esc_html_e( 'View &rarr;', 'woo-one-click-upsell-funnel' ); ?></a>

															<?php
															if ( ! wpswocuf_upsell_divi_builder_plugin_active() ) {
																?>
																		<a class="button" href="<?php echo esc_url( admin_url( "post.php?post=$assigned_post_id&action=elementor" ) ); ?>" target="_blank"><?php esc_html_e( 'Customize &rarr;', 'woo-one-click-upsell-funnel' ); ?></a>

																	<?php
															}
															?>
														<?php endif; ?>
													</div>
												</div>	
										</div>

										<!-- Offer templates 4 foreach start-->


										<!-- Offer templates 5 foreach start-->
										
										<div class="wpswocuf_upsell_offer_template ">

											<div class="wpswocuf_upsell_offer_template_sub_div"> 

												<h5> <?php esc_html_e( 'PET SHOP TEMPLATE', 'woo-one-click-upsell-funnel' ); ?></h5>

												<div class="wpswocuf_upsell_offer_preview">

													<a href="javascript:void(0)" class="wpswocuf_upsell_view_offer_template" data-template-id="five" >
													<span class="wpswocuf_wupsell_premium_strip"><?php esc_html_e( 'Pro', 'woo-one-click-upsell-funnel' ); ?></span><img src="<?php echo esc_url( wpswocuf_URL . 'admin/resources/offer-thumbnails/offer-template-five.png' ); ?>"></a>
												</div>

												<div class="wpswocuf_upsell_offer_action">

														<?php if ( $template_key !== $offer_template_active ) : ?>

															<input type="button" class=" wpswocuf_upsell_activate_offer_template_pro ubo_offer_input" value="<?php esc_html_e( 'Upgrade To Pro', 'woo-one-click-upsell-funnel' ); ?>"/>

														<?php else : ?>

															<a class="button" href="<?php echo esc_url( get_permalink( $assigned_post_id ) ); ?>" target="_blank"><?php esc_html_e( 'View &rarr;', 'woo-one-click-upsell-funnel' ); ?></a>

															<?php
															if ( ! wpswocuf_upsell_divi_builder_plugin_active() ) {
																?>
																		<a class="button" href="<?php echo esc_url( admin_url( "post.php?post=$assigned_post_id&action=elementor" ) ); ?>" target="_blank"><?php esc_html_e( 'Customize &rarr;', 'woo-one-click-upsell-funnel' ); ?></a>

																	<?php
															}
															?>
														<?php endif; ?>
												</div>
											</div>	
										</div>

											<!-- Offer templates 5 foreach start-->


											

											<!-- Offer templates 7 foreach start-->

											<div class="wpswocuf_upsell_offer_template ">

											<div class="wpswocuf_upsell_offer_template_sub_div"> 

											<h5> <?php esc_html_e( 'BEAUTY & MAKEUP TEMPLATE', 'woo-one-click-upsell-funnel' ); ?></h5>

											<div class="wpswocuf_upsell_offer_preview">

											<a href="javascript:void(0)" class="wpswocuf_upsell_view_offer_template" data-template-id="seven" >
											<span class="wpswocuf_wupsell_premium_strip"><?php esc_html_e( 'Pro', 'woo-one-click-upsell-funnel' ); ?></span><img src="<?php echo esc_url( wpswocuf_URL . 'admin/resources/offer-thumbnails/offer-template-seven.png' ); ?>"></a>
											</div>

											<div class="wpswocuf_upsell_offer_action">

																					<?php if ( $template_key !== $offer_template_active ) : ?>

											<input type="button" class=" wpswocuf_upsell_activate_offer_template_pro ubo_offer_input" value="<?php esc_html_e( 'Upgrade To Pro', 'woo-one-click-upsell-funnel' ); ?>"/>


																					<?php else : ?>

											<a class="button" href="<?php echo esc_url( get_permalink( $assigned_post_id ) ); ?>" target="_blank"><?php esc_html_e( 'View &rarr;', 'woo-one-click-upsell-funnel' ); ?></a>

																						<?php
																						if ( ! wpswocuf_upsell_divi_builder_plugin_active() ) {
																							?>
														<a class="button" href="<?php echo esc_url( admin_url( "post.php?post=$assigned_post_id&action=elementor" ) ); ?>" target="_blank"><?php esc_html_e( 'Customize &rarr;', 'woo-one-click-upsell-funnel' ); ?></a>

																							<?php
																						}
																						?>
																																<?php endif; ?>
											</div>
											</div>	
											</div>

											<!-- Offer templates 7 foreach start-->
											<!-- Offer templates 6 foreach start-->

											<div class="wpswocuf_upsell_offer_template ">

											<div class="wpswocuf_upsell_offer_template_sub_div"> 

											<h5> <?php esc_html_e( 'ROSE PINK TEMPLATE', 'woo-one-click-upsell-funnel' ); ?></h5>

											<div class="wpswocuf_upsell_offer_preview">

											<a href="javascript:void(0)" class="wpswocuf_upsell_view_offer_template" data-template-id="six" >
											<span class="wpswocuf_wupsell_premium_strip"><?php esc_html_e( 'Pro', 'woo-one-click-upsell-funnel' ); ?></span><img src="<?php echo esc_url( wpswocuf_URL . 'admin/resources/offer-thumbnails/offer-template-six.png' ); ?>"></a>
											</div>

											<div class="wpswocuf_upsell_offer_action">

																					<?php if ( $template_key !== $offer_template_active ) : ?>

											<input type="button" class=" wpswocuf_upsell_activate_offer_template_pro ubo_offer_input" value="<?php esc_html_e( 'Upgrade To Pro', 'woo-one-click-upsell-funnel' ); ?>"/>


																					<?php else : ?>

											<a class="button" href="<?php echo esc_url( get_permalink( $assigned_post_id ) ); ?>" target="_blank"><?php esc_html_e( 'View &rarr;', 'woo-one-click-upsell-funnel' ); ?></a>

																						<?php
																						if ( ! wpswocuf_upsell_divi_builder_plugin_active() ) {
																							?>
														<a class="button" href="<?php echo esc_url( admin_url( "post.php?post=$assigned_post_id&action=elementor" ) ); ?>" target="_blank"><?php esc_html_e( 'Customize &rarr;', 'woo-one-click-upsell-funnel' ); ?></a>

																							<?php
																						}
																						?>
																					<?php endif; ?>
											</div>
											</div>	
											</div>

											<!-- Offer templates 6 foreach start-->


											<!-- Offer templates 8 foreach start-->

											<div class="wpswocuf_upsell_offer_template ">

											<div class="wpswocuf_upsell_offer_template_sub_div"> 

											<h5> <?php esc_html_e( 'JULIUS-SCISSOR TEMPLATE', 'woo-one-click-upsell-funnel' ); ?></h5>

											<div class="wpswocuf_upsell_offer_preview">

											<a href="javascript:void(0)" class="wpswocuf_upsell_view_offer_template" data-template-id="eight" >
											<span class="wpswocuf_wupsell_premium_strip"><?php esc_html_e( 'Pro', 'woo-one-click-upsell-funnel' ); ?></span><img src="<?php echo esc_url( wpswocuf_URL . 'admin/resources/offer-thumbnails/offer-template-eight.png' ); ?>"></a>
											</div>

											<div class="wpswocuf_upsell_offer_action">

																					<?php if ( $template_key !== $offer_template_active ) : ?>

											<input type="button" class=" wpswocuf_upsell_activate_offer_template_pro ubo_offer_input" value="<?php esc_html_e( 'Upgrade To Pro', 'woo-one-click-upsell-funnel' ); ?>"/>


																					<?php else : ?>

											<a class="button" href="<?php echo esc_url( get_permalink( $assigned_post_id ) ); ?>" target="_blank"><?php esc_html_e( 'View &rarr;', 'woo-one-click-upsell-funnel' ); ?></a>

																						<?php
																						if ( ! wpswocuf_upsell_divi_builder_plugin_active() ) {
																							?>
														<a class="button" href="<?php echo esc_url( admin_url( "post.php?post=$assigned_post_id&action=elementor" ) ); ?>" target="_blank"><?php esc_html_e( 'Customize &rarr;', 'woo-one-click-upsell-funnel' ); ?></a>

																							<?php
																						}
																						?>
																					<?php endif; ?>
											</div>
											</div>	
											</div>
											<!-- Offer templates 8 foreach start-->
												<?php
											}
											?>


											<!-- Offer link to custom page start-->
											<div class="wpswocuf_upsell_offer_template wpswocuf_upsell_custom_page_link_div <?php echo esc_html( 'custom' === $offer_template_active ? 'active' : '' ); ?>">

												<div class="wpswocuf_upsell_offer_template_sub_div">

													<h5><?php esc_html_e( 'LINK TO CUSTOM PAGE', 'woo-one-click-upsell-funnel' ); ?></h5>

													<?php if ( 'custom' !== $offer_template_active ) : ?>

														<button class="button-primary wpswocuf_upsell_activate_offer_template" data-template-id="custom" data-offer-id="<?php echo esc_html( $current_offer_id ); ?>" data-funnel-id="<?php echo esc_html( $wpswocuf_pro_funnel_id ); ?>" data-offer-post-id="<?php echo esc_html( $assigned_post_id ); ?>" ><?php esc_html_e( 'Activate', 'woo-one-click-upsell-funnel' ); ?></button>

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

										<div class="wpswocuf_upsell_offer_template_unsupported">

										<h4><?php esc_html_e( 'Please activate Elementor / Divi Theme if you want to use our Pre-defined Templates, else make a custom page yourself and add link below.', 'woo-one-click-upsell-funnel' ); ?></h4>
										</div>

										<?php
									endif;
										$assigned_post_id = ! empty( $post_id_assigned_array[ $current_offer_id ] ) ? $post_id_assigned_array[ $current_offer_id ] : '';
									?>
								</td>
							</tr>
							<!-- Section : Offer template end -->

							<!-- Custom offer page url start -->
							<tr>
								<th><label><h4><?php esc_html_e( 'Offer Custom Page Link', 'woo-one-click-upsell-funnel' ); ?></h4></label>
								</th> 

								<td>
								<input type="text" class="wpswocuf_upsell_custom_offer_page_url" name="wpswocuf_offer_custom_page_url[<?php echo esc_html( $current_offer_id ); ?>]" value="<?php echo esc_url( $wpswocuf_pro_offer_custom_page_url[ $current_offer_id ] ); ?>">
								</td>
							</tr>
														
							<!-- Custom offer page url end -->

							<!-- Delete current offer ( Saved one ) -->
							<tr>
								<td colspan="2">
								<button class="button wpswocuf_pro_delete_old_created_offers" data-id="<?php echo esc_html( $current_offer_id ); ?>"><?php esc_html_e( 'Delete', 'woo-one-click-upsell-funnel' ); ?></button>
								</td>
							</tr>
							<!-- Delete current offer ( Saved one ) -->
						

						</table>

						<input type="hidden" name="wpswocuf_applied_offer_number[<?php echo esc_html( $current_offer_id ); ?>]" value="<?php echo esc_html( $current_offer_id ); ?>">

						<input type="hidden" name="wpswocuf_upsell_post_id_assigned[<?php echo esc_html( $current_offer_id ); ?>]" value="<?php echo esc_html( $assigned_post_id ); ?>">

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
		<div class="wpswocuf_pro_new_offer">
			<button id="wpswocuf_upsell_create_new_offer" class="wpswocuf_pro_create_new_offer" data-id="<?php echo esc_html( $wpswocuf_pro_funnel_id ); ?>">
			<?php esc_html_e( 'Add New Offer', 'woo-one-click-upsell-funnel' ); ?>
			</button>
		</div>

		<!-- Save Changes for whole funnel -->
		<p class="submit wps-wocuf-sticky-btn">
			<input type="submit" value="<?php esc_html_e( 'Save Changes', 'woo-one-click-upsell-funnel' ); ?>" class="button-primary woocommerce-save-button" name="wpswocuf_pro_creation_setting_save" id="wpswocuf_pro_creation_setting_save" >
		</p>
	</div>
</form>
