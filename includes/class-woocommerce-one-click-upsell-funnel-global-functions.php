<?php
/**
 * The file that defines the global plugin functions.
 *
 * All Global functions that are used through out the plugin.
 *
 * @link       https://wpswings.com/?utm_source=wpswings-official&utm_medium=upsell-org-backend&utm_campaign=official
 * @since      2.0.0
 *
 * @package     woo_one_click_upsell_funnel
 * @subpackage woo_one_click_upsell_funnel/includes
 */

/**
 * Check if Elementor plugin is active or not.
 *
 * @since    2.0.0
 */
function wps_upsell_lite_elementor_plugin_active() {

	if ( wps_upsell_lite_is_plugin_active( 'elementor/elementor.php' ) ) {

		return true;
	} else {

		return false;
	}
}

/**
 * Check if Upsell Pro plugin is active or not.
 *
 * @since    3.0.0
 */
function wps_upsell_lite_is_upsell_pro_active() {

	if ( wps_upsell_lite_is_plugin_active( 'woocommerce-one-click-upsell-funnel-pro/woocommerce-one-click-upsell-funnel-pro.php' ) ) {

		return true;

	} else {

		return false;
	}
}

/**
 * Validate upsell nonce.
 *
 * @since    2.0.0
 */
function wps_upsell_lite_validate_upsell_nonce() {

	$secure_nonce      = wp_create_nonce( 'wps-upsell-auth-nonce' );
	$id_nonce_verified = wp_verify_nonce( $secure_nonce, 'wps-upsell-auth-nonce' );

	if ( ! $id_nonce_verified ) {
		wp_die( esc_html__( 'Nonce Not verified', 'woo-one-click-upsell-funnel' ) );
	}

	if ( isset( $_GET['ocuf_ns'] ) ) {

		return true;
	} else {

		return false;
	}
}

/**
 * This function returns just allowed html for order bump.
 *
 * @since    1.0.0
 */
function wps_upsell_lite_allowed_html() {

	// Return the complete html elements defined by us.
	$allowed_html = array(
		'input'  => array(
			'class'          => array(),
			'id'             => array(),
			'name'           => array(),
			'placeholder'    => array(),
			'value'          => array(),
			'type'           => array(),
			'checked'        => array(),
			'min'            => array(),
			'max'            => array(),
			'style'          => array(),
			'data-id'        => array(),
			'data-scroll-id' => array(),
			'inputmode'      => array(),
			'title'          => array(),
			'step'           => array(),
		),
		'label'  => array(
			'for'   => array(),
			'class' => array(),
			'id'    => array(),
			'value' => array(),
		),
		'span'   => array(
			'class' => array(),
			'id'    => array(),
			'value' => array(),
			'style' => array(),
		),
		'br'     => array(),
		'h2'     => array(
			'class' => array(),
			'id'    => array(),
		),
		'h3'     => array(
			'class' => array(),
			'id'    => array(),
		),
		'h4'     => array(
			'id'    => array(),
			'class' => array(),
		),
		'h5'     => array(
			'id'    => array(),
			'class' => array(),
		),
		'tr'     => array(
			'id'    => array(),
			'class' => array(),
		),
		'th'     => array(
			'id'    => array(),
			'class' => array(),
		),
		'td'     => array(
			'id'      => array(),
			'class'   => array(),
			'colspan' => array(),
		),
		'table'  => array(
			'id'    => array(),
			'class' => array(),
		),
		'div'    => array(
			'class'                              => array(),
			'id'                                 => array(),
			'data-id'                            => array(),
			'value'                              => array(),
			'data-thumb'                         => array(),
			'data-thumb-alt'                     => array(),
			'woocommerce-product-gallery__image' => array(),
			'data-thumb'                         => array(),
			'data-scroll-id'                     => array(),
			'style'                              => array(),
		),
		'button' => array(
			'class'              => array(),
			'id'                 => array(),
			'data-id'            => array(),
			'data-template-id'   => array(),
			'data-offer-id'      => array(),
			'data-funnel-id'     => array(),
			'data-offer-post-id' => array(),
		),
		'p'      => array(
			'class' => array(),
			'id'    => array(),
			'value' => array(),
		),
		'b'      => array(),
		'img'    => array(
			'class'                   => array(),
			'id'                      => array(),
			'src'                     => array(),
			'style'                   => array(),
			'data-id'                 => array(),
			'data-id'                 => array(),
			'data-id'                 => array(),
			'width'                   => array(),
			'height'                  => array(),
			'alt'                     => array(),
			'data-caption'            => array(),
			'data-src'                => array(),
			'data-large_image'        => array(),
			'data-large_image_width'  => array(),
			'data-large_image_height' => array(),
			'srcset'                  => array(),
			'sizes'                   => array(),
		),
		'a'      => array(
			'href'             => array(),
			'class'            => array(),
			'target'           => array(),
			'style'            => array(),
			'data-template-id' => array(),
		),
		'select' => array(
			'id'                    => array(),
			'class'                 => array(),
			'name'                  => array(),
			'data-placeholder'      => array(),
			'data-attribute_name'   => array(),
			'data-show_option_none' => array(),
			'order'                 => array(),
			'attribute_pa_color'    => array(),
			'style'                 => array(),
		),
		'option' => array(
			'value'    => array(),
			'selected' => array(),
		),
		'del'    => array(
			'aria-hidden' => array(),
		),
		'bdi'    => array(),
		'ins'    => array(),
		'script' => array(
			'type' => array(),
		),
	);

	return $allowed_html;
}


/**
 * Get product discount.
 *
 * @since    2.0.0
 */
function wps_upsell_lite_get_product_discount() {

	$wps_wocuf_pro_offered_discount = '';

	$secure_nonce      = wp_create_nonce( 'wps-upsell-auth-nonce' );
	$id_nonce_verified = wp_verify_nonce( $secure_nonce, 'wps-upsell-auth-nonce' );

	if ( ! $id_nonce_verified ) {
		wp_die( esc_html__( 'Nonce Not verified', ' woo-one-click-upsell-funnel' ) );
	}

	$funnel_id = isset( $_GET['ocuf_fid'] ) ? sanitize_text_field( wp_unslash( $_GET['ocuf_fid'] ) ) : 'not_set';
	$offer_id  = isset( $_GET['ocuf_ofd'] ) ? sanitize_text_field( wp_unslash( $_GET['ocuf_ofd'] ) ) : 'not_set';

	// If Live offer.
	if ( 'not_set' !== $funnel_id && 'not_set' !== $offer_id ) {

		$wps_wocuf_pro_all_funnels = get_option( 'wps_wocuf_funnels_list' );

		$wps_wocuf_pro_offered_discount = $wps_wocuf_pro_all_funnels[ $funnel_id ]['wps_wocuf_offer_discount_price'][ $offer_id ];

		$wps_wocuf_pro_offered_discount = ! empty( $wps_wocuf_pro_all_funnels[ $funnel_id ]['wps_wocuf_offer_discount_price'][ $offer_id ] ) ? $wps_wocuf_pro_all_funnels[ $funnel_id ]['wps_wocuf_offer_discount_price'][ $offer_id ] : '';
	} elseif ( current_user_can( 'manage_options' ) ) {

		// Get funnel and offer id from current offer page post id.
		global $post;
		$offer_page_id = $post->ID;

		$funnel_data = get_post_meta( $offer_page_id, 'wps_upsell_funnel_data', true );

		$product_found_in_funnel = false;

		if ( ! empty( $funnel_data ) && is_array( $funnel_data ) && count( $funnel_data ) ) {

			$funnel_id = $funnel_data['funnel_id'];
			$offer_id  = $funnel_data['offer_id'];

			if ( isset( $funnel_id ) && isset( $offer_id ) ) {

				$wps_wocuf_pro_all_funnels = get_option( 'wps_wocuf_funnels_list' );

				// When New offer is added ( Not saved ) so only at that time it will return 50%.
				$wps_wocuf_pro_offered_discount = isset( $wps_wocuf_pro_all_funnels[ $funnel_id ]['wps_wocuf_offer_discount_price'][ $offer_id ] ) ? $wps_wocuf_pro_all_funnels[ $funnel_id ]['wps_wocuf_offer_discount_price'][ $offer_id ] : '50%';

				$wps_wocuf_pro_offered_discount = ! empty( $wps_wocuf_pro_offered_discount ) ? $wps_wocuf_pro_offered_discount : '';
			}
		} else {

			// Get global product discount.

			$wps_upsell_global_settings = get_option( 'wps_upsell_lite_global_options', array() );

			$global_product_discount = isset( $wps_upsell_global_settings['global_product_discount'] ) ? $wps_upsell_global_settings['global_product_discount'] : '50%';

			$wps_wocuf_pro_offered_discount = $global_product_discount;
		}
	}

	return $wps_wocuf_pro_offered_discount;
}

/**
 * Upsell product id from url funnel and offer params.
 *
 * @since    2.0.0
 */
function wps_upsell_lite_get_pid_from_url_params() {

	$params['status']  = 'false';
	$secure_nonce      = wp_create_nonce( 'wps-upsell-auth-nonce' );
	$id_nonce_verified = wp_verify_nonce( $secure_nonce, 'wps-upsell-auth-nonce' );

	if ( ! $id_nonce_verified ) {
		wp_die( esc_html__( 'Nonce Not verified', ' woo-one-click-upsell-funnel' ) );
	}

	if ( isset( $_GET['ocuf_ofd'] ) && isset( $_GET['ocuf_fid'] ) ) {

		$params['status'] = 'true';

		$params['offer_id']  = sanitize_text_field( wp_unslash( $_GET['ocuf_ofd'] ) );
		$params['funnel_id'] = sanitize_text_field( wp_unslash( $_GET['ocuf_fid'] ) );
	}

	return $params;
}

/**
 * Upsell Live Offer URL parameters.
 *
 * @since    2.0.0
 */
function wps_upsell_lite_live_offer_url_params() {

	$add_live_nonce = ! empty( $_POST['wps_wocuf_after_post_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['wps_wocuf_after_post_nonce'] ) ) : '';

	wp_verify_nonce( $add_live_nonce, 'wps_wocuf_after_field_post_nonce' );

	$params['status'] = 'false';

	// phpcs:disable
	if ( isset( $_POST['ocuf_ns'] ) && isset( $_POST['ocuf_ok'] ) && isset( $_POST['ocuf_ofd'] ) && isset( $_POST['ocuf_fid'] ) && isset( $_POST['product_id'] ) ) {

		$params['status'] = 'true';

		$params['upsell_nonce'] = sanitize_text_field( wp_unslash( $_POST['ocuf_ns'] ) );
		$params['order_key'] = sanitize_text_field( wp_unslash( $_POST['ocuf_ok'] ) );
		$params['offer_id'] = sanitize_text_field( wp_unslash( $_POST['ocuf_ofd'] ) );
		$params['funnel_id'] = sanitize_text_field( wp_unslash( $_POST['ocuf_fid'] ) );
		$params['product_id'] = sanitize_text_field( wp_unslash( $_POST['product_id'] ) );
		$params['quantity'] = ! empty( $_POST['fetch'] ) ? sanitize_text_field( wp_unslash( $_POST['fetch'] ) ) : '';

	} elseif ( isset( $_GET['ocuf_ns'] ) && isset( $_GET['ocuf_ok'] ) && isset( $_GET['ocuf_ofd'] ) && isset( $_GET['ocuf_fid'] ) && isset( $_GET['product_id'] ) ) {

		$params['status'] = 'true';

		$params['upsell_nonce'] = sanitize_text_field( wp_unslash( $_GET['ocuf_ns'] ) );
		$params['order_key'] = sanitize_text_field( wp_unslash( $_GET['ocuf_ok'] ) );
		$params['offer_id'] = sanitize_text_field( wp_unslash( $_GET['ocuf_ofd'] ) );
		$params['funnel_id'] = sanitize_text_field( wp_unslash( $_GET['ocuf_fid'] ) );
		$params['product_id'] = sanitize_text_field( wp_unslash( $_GET['product_id'] ) );
		$params['quantity'] = ! empty( $_GET['fetch'] ) ? sanitize_text_field( wp_unslash( $_GET['fetch'] ) ) : '';
	}
	// phpcs:enable
	return $params;
}

/**
 * Handling Funnel offer-page posts deletion which are dynamically assigned.
 *
 * @since    2.0.0
 */
function wps_upsell_lite_offer_page_posts_deletion() {

	// Get all funnels.
	$all_created_funnels = get_option( 'wps_wocuf_funnels_list', array() );
	// Get all saved offer post ids.
	$saved_offer_post_ids = get_option( 'wps_upsell_lite_offer_post_ids', array() );

	if ( ! empty( $all_created_funnels ) && is_array( $all_created_funnels ) && count(
		$all_created_funnels
	) && ! empty( $saved_offer_post_ids ) && is_array( $saved_offer_post_ids ) && count(
		$saved_offer_post_ids
	) ) {

		$funnel_offer_post_ids = array();

		// Retrieve all valid( present in funnel ) offer assigned page post ids.
		foreach ( $all_created_funnels as $funnel_id => $single_funnel ) {

			if ( ! empty( $single_funnel['wps_upsell_post_id_assigned'] ) && is_array( $single_funnel['wps_upsell_post_id_assigned'] ) && count( $single_funnel['wps_upsell_post_id_assigned'] ) ) {

				foreach ( $single_funnel['wps_upsell_post_id_assigned'] as $offer_post_id ) {

					if ( ! empty( $offer_post_id ) ) {

						$funnel_offer_post_ids[] = $offer_post_id;
					}
				}
			}
		}

		// Now delete save posts which are not present in funnel.

		foreach ( $saved_offer_post_ids as $saved_offer_post_key => $saved_offer_post_id ) {
			if ( ! in_array( (string) $saved_offer_post_id, $funnel_offer_post_ids, true ) ) {

				unset( $saved_offer_post_ids[ $saved_offer_post_key ] );

			}
		}

		// Update saved offer post ids array.
		$saved_offer_post_ids = array_values( $saved_offer_post_ids );
		update_option( 'wps_upsell_lite_offer_post_ids', $saved_offer_post_ids );

	}
}

/**
 * Upsell supported payment gateways.
 *
 * @since    2.0.0
 */
function wps_upsell_lite_supported_gateways() {

	$supported_gateways = array(
		'cod', // Cash on delivery.
	);

	return apply_filters( 'wps_upsell_lite_supported_gateways', $supported_gateways );
}

/**
 * Upsell supported payment gateways for which Parent Order is secured.
 * Either with Initial payment or via Cron.
 *
 * @since    3.0.0
 */
function wps_upsell_lite_payment_gateways_with_parent_secured() {

	$gateways_with_parent_secured = array(
		'cod', // Cash on delivery.
	);

	return apply_filters( 'wps_upsell_lite_pg_with_parent_secured', $gateways_with_parent_secured );
}

/**
 * Elementor Upsell offer template 1.
 *
 * Standard Template ( Default ).
 *
 * @since    2.0.0
 */
function wps_upsell_lite_elementor_offer_template_1() {

	// phpcs:disable
	$elementor_data = file_get_contents( WPS_WOCUF_DIRPATH . 'json/offer-template-1.json' );
	// phpcs:enable

	return $elementor_data;
}

/**
 * Elementor Upsell offer template 2.
 *
 * Creative Template.
 *
 * @since    2.0.0
 */
function wps_upsell_lite_elementor_offer_template_2() {

	// phpcs:disable
	$elementor_data = file_get_contents( WPS_WOCUF_DIRPATH . 'json/offer-template-2.json' );
	// phpcs:enable

	return $elementor_data;
}

/**
 * Elementor Upsell offer template 3.
 *
 * Video Template.
 *
 * @since    2.0.0
 */
function wps_upsell_lite_elementor_offer_template_3() {

	// phpcs:disable
	$elementor_data = file_get_contents( WPS_WOCUF_DIRPATH . 'json/offer-template-3.json' );
	// phpcs:enable

	return $elementor_data;
}

/**
 * Gutenberg Offer Page content.
 *
 * @since    2.0.0
 */
function wps_upsell_lite_gutenberg_offer_content() {

	$post_content = '<!-- wp:spacer {"height":50} -->
		<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
		<!-- /wp:spacer -->

		<!-- wp:heading {"align":"center"} -->
		<h2 style="text-align:center">Exclusive Special One time Offer for you</h2>
		<!-- /wp:heading -->

		<!-- wp:spacer {"height":50} -->
		<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
		<!-- /wp:spacer -->

		<!-- wp:html -->
		<div class="wps_upsell_default_offer_image">[wps_upsell_image]</div>
		<!-- /wp:html -->

		<!-- wp:spacer {"height":20} -->
		<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
		<!-- /wp:spacer -->

		<!-- wp:heading {"align":"center"} -->
		<h2 style="text-align:center">[wps_upsell_title]</h2>
		<!-- /wp:heading -->

		<!-- wp:html -->
		<div class="wps_upsell_default_offer_description">[wps_upsell_desc]</div>
		<!-- /wp:html -->

		<!-- wp:heading {"level":3,"align":"center"} -->
		<h3 style="text-align:center">Special Offer Price : [wps_upsell_price]</h3>
		<!-- /wp:heading -->

		<!-- wp:spacer {"height":15} -->
		<div style="height:15px" aria-hidden="true" class="wp-block-spacer"></div>
		<!-- /wp:spacer -->

		<!-- wp:html -->
		<div class="wps_upsell_default_offer_variations">[wps_upsell_variations]</div>
		<!-- /wp:html -->

		<!-- wp:button {"customBackgroundColor":"#78c900","align":"center","className":"wps_upsell_default_offer_buy_now"} -->
		<div class="wp-block-button aligncenter wps_upsell_default_offer_buy_now"><a class="wp-block-button__link has-background" href="[wps_upsell_yes]" style="background-color:#78c900">Add this to my Order</a></div>
		<!-- /wp:button -->

		<!-- wp:spacer {"height":25} -->
		<div style="height:25px" aria-hidden="true" class="wp-block-spacer"></div>
		<!-- /wp:spacer -->

		<!-- wp:button {"customBackgroundColor":"#e50000","align":"center","className":"wps_upsell_default_offer_no_thanks"} -->
		<div class="wp-block-button aligncenter wps_upsell_default_offer_no_thanks"><a class="wp-block-button__link has-background" href="[wps_upsell_no]" style="background-color:#e50000">No thanks</a></div>
		<!-- /wp:button -->

		<!-- wp:html -->
		[wps_upsell_default_offer_identification]
		<!-- /wp:html -->

		<!-- wp:spacer {"height":50} -->
		<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
		<!-- /wp:spacer -->';

		return $post_content;
}

if ( ! function_exists( 'wps_upsell_lite_get_first_offer_after_redirect' ) ) {

	/**
	 * Get Order id from key.
	 *
	 * @param mixed $url url.
	 * @since    3.0.0
	 */
	function wps_upsell_lite_get_first_offer_after_redirect( $url = false ) {

		if ( ! empty( $url ) ) {

			$url_components = wp_parse_url( $url );

			// Extract Query Params.
			if ( ! empty( $url_components['query'] ) ) {
				parse_str( $url_components['query'], $params );
			}

			if ( ! empty( $params['ocuf_ofd'] ) ) {

				$first_offer = ! empty( $params['ocuf_ofd'] ) ? sanitize_text_field( wp_unslash( $params['ocuf_ofd'] ) ) : '';
				return $first_offer;
			}
		}

		return false;
	}
}

if ( ! function_exists( 'wps_upsell_lite_wc_help_tip' ) ) {

	/**
	 * Get tooltip.
	 *
	 * @param mixed $tip message.
	 * @since    3.0.4
	 */
	function wps_upsell_lite_wc_help_tip( $tip = '' ) {
		?>
		<span class="woocommerce-help-tip" data-tip="<?php echo esc_html( $tip ); ?>"></span>
		<?php
	}
}
