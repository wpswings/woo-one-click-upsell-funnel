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
 * Upsell supported payment gateways.
 *
 * @since    2.0.0
 */
function wps_upsell_pro_supported_gateways() {

	$supported_gateways = array(
		'bacs', // Direct bank transfer.
		'cheque', // Check payments.
		'cod', // Cash on delivery.
		'wps-wocuf-pro-stripe-gateway', // Upsell Stripe.
		'cardcom', // Official Cardcom.
		'paypal',    // Woocommerce Paypal ( Standard ).
		'wps-wocuf-pro-paypal-gateway', // Upsell Paypal ( Express Checkout ).
		'ppec_paypal', // https://wordpress.org/plugins/woocommerce-gateway-paypal-express-checkout/.
		'authorize', // https://wordpress.org/plugins/authorizenet-payment-gateway-for-woocommerce/.
		'paystack', // https://wordpress.org/plugins/woo-paystack/.
		'vipps', // https://wordpress.org/plugins/woo-vipps/.
		'transferuj', // TPAY.com https://wordpress.org/plugins/woocommerce-transferujpl-payment-gateway/.
		'razorpay', // https://wordpress.org/plugins/woo-razorpay/.
		'stripe_ideal', // Official Stripe - iDeal.
		'authorize_net_cim_credit_card', // Official Authorize.Net-CC.
		'square_credit_card', // Official Square-XL plugins.
		'braintree_cc', // Official Braintree for Woocommerce plugins.
		'paypal_express', // Angeleye Paypal Express Checkout.
		'stripe', // Official Stripe - CC.
		'', // For Free Product.
		'ppcp-gateway', // For Paypal payments plugin.
		'ppcp-credit-card-gateway', // For Paypal CC payments plugin.
	);

	return apply_filters( 'wps_upsell_proe_supported_gateways', $supported_gateways );
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


/**
 * Add Go pro popup.
 *
 * @param   string $location        Location of page where you want to show popup.
 * @since   1.2.0
 */
function wps_upsee_lite_go_pro( $location = 'pro' ) {

	if ( 'pro' === $location ) {

		$message = esc_html__( 'Stucked with Limited Gateway access? Unlock your power to explore more.', 'woo-one-click-upsell-funnel' );

	} else {

		$message = esc_html__( 'Stucked to just one Order Funnel? Unlock your power to explore more.', 'woo-one-click-upsell-funnel' );
	}

	ob_start();
	?>
	<!-- Go pro popup wrap start. -->
	<div class="wps_ubo_lite_go_pro_popup_wrap" id="all_offers_ubo_lite">
		<!-- Go pro popup main start. -->
		<div class="wps_ubo_lite_go_pro_popup">
			<!-- Main heading. -->
			<div class="wps_ubo_lite_go_pro_popup_head">
				<h2><?php esc_html_e( 'Want More? Go Pro !!', 'woo-one-click-upsell-funnel' ); ?></h2>
				<!-- Close button. -->
				<a href="" class="wps_ubo_lite_go_pro_popup_close">
					<span>&times;</span>
				</a>
			</div>  

			<!-- Notice icon. -->
			<div class="wps_ubo_lite_go_pro_popup_head"><img src="<?php echo esc_url( WPS_WOCUF_URL . 'admin/resources/icons/pro.png' ); ?> ">
			</div>

			<!-- Notice. -->
			<div class="wps_ubo_lite_go_pro_popup_content">
				<p class="wps_ubo_lite_go_pro_popup_text">
					<?php echo esc_html( $message ); ?>
				</p>
				<p class="wps_ubo_lite_go_pro_popup_text">
					<?php esc_html_e( 'Go with our premium version and make unlimited numbers of Upsells. Get more smart features and make the most attractive offers with all of your products. Set Relevant offers for specific targets which will ensure customer satisfaction and higher conversion rates.', 'woo-one-click-upsell-funnel' ); ?>
				</p>
			</div>

			<!-- Go pro button. -->
			<div class="wps_ubo_lite_go_pro_popup_button">
				<a class="button wps_ubo_lite_overview_go_pro_button" target="_blank" href="https://wpswings.com/product/one-click-upsell-funnel-for-woocommerce-pro/?utm_source=wpswings-upsell-funnel-pro&utm_medium=upsell-funnel-org-backend&utm_campaign=WPS-upsell-funnel-pro"><?php echo esc_html__( 'Upgrade to Premium', 'woo-one-click-upsell-funnel' ) . ' <span class="dashicons dashicons-arrow-right-alt"></span>'; ?></a>
			</div>
		</div>
		<!-- Go pro popup main end. -->
	</div>
	<!-- Go pro popup wrap end. -->
	<?php
	$popup_html = ob_get_contents();
	ob_end_clean();
	$allowed_html = wps_upselllite_allowed_html();
	echo wp_kses( $popup_html, $allowed_html );
}




/**
 * Add Go pro popup.
 *
 * @param   string $location        Location of page where you want to show popup.
 * @since   1.2.0
 */
function wps_upsee_lite_product_offer_go_pro( $location = 'pro' ) {

		$message = esc_html__( 'Want More Product Types? Go Pro !!', 'woo-one-click-upsell-funnel' );

	ob_start();
	?>
	<div  id="product_features_ubo_lite" >
	<!-- Go pro popup wrap start. -->
	<div class="wps_ubo_lite_go_pro_popup_wrap" >
		<!-- Go pro popup main start. -->
		<div class="wps_ubo_lite_go_pro_popup" >
			<!-- Main heading. -->
			<div class="wps_ubo_lite_go_pro_popup_head">
				<h2><?php esc_html_e( 'Want more Product types and super cool features?', 'woo-one-click-upsell-funnel' ); ?></h2>
				<!-- Close button. -->
				<a href="" class="wps_ubo_lite_go_pro_popup_close">
					<span>&times;</span>
				</a>
			</div>  

			<!-- Notice icon. -->
			<div class="wps_ubo_lite_go_pro_popup_head"><img src="<?php echo esc_url( WPS_WOCUF_URL . 'admin/resources/icons/pro.png' ); ?> ">
			</div>

			<!-- Notice. -->
			<div class="wps_ubo_lite_go_pro_popup_content">
				<p class="wps_ubo_lite_go_pro_popup_text">
					<?php echo esc_html( $message ); ?>
				</p>
				<p class="wps_ubo_lite_go_pro_popup_text">
					<?php esc_html_e( 'Go with our premium version and get other product types compatible like Variable, Subscription, and Bundles. ', 'woo-one-click-upsell-funnel' ); ?>
				</p>
			</div>

			<!-- Go pro button. -->
			<div class="wps_ubo_lite_go_pro_popup_button">
				<a class="button wps_ubo_lite_overview_go_pro_button" target="_blank" href="https://wpswings.com/product/one-click-upsell-funnel-for-woocommerce-pro/?utm_source=wpswings-upsell-funnel-pro&utm_medium=upsell-funnel-org-backend&utm_campaign=WPS-upsell-funnel-pro"><?php echo esc_html__( 'Upgrade to Premium', 'woo-one-click-upsell-funnel' ) . ' <span class="dashicons dashicons-arrow-right-alt"></span>'; ?></a>
			</div>
		</div>
		<!-- Go pro popup main end. -->
	</div>
	</div>
	<!-- Go pro popup wrap end. -->
	<?php
	$popup_html = ob_get_contents();
	ob_end_clean();
	$allowed_html = wps_upselllite_allowed_html();
	echo wp_kses( $popup_html, $allowed_html );
}





/**
 * This function returns just allowed html for order bump.
 *
 * @since    1.0.0
 */
function wps_upselllite_allowed_html() {

	// Return the complete html elements defined by us.
	$allowed_html = array(
		'input'   => array(
			'class'       => array(
				'add_offer_in_cart',
				'offer_shown_id',
				'offer_shown_discount',
			),
			'id'          => array(
				'target_id_cart_key',
			),
			'name'        => array(),
			'placeholder' => array(),
			'value'       => array(),
			'type'        => array( 'hidden', 'checkbox' ),
			'checked'     => array(),
			'min'         => array(),
			'max'         => array(),
		),
		'label'   => array(
			'class' => array( 'wps_upsell_bump_checkbox_container' ),
			'id'    => array(),
			'value' => array(),
		),
		'span'    => array(
			'class' => array(
				'woocommerce-Price-amount',
				'amount',
				'woocommerce-Price-currencySymbol',
				'checkmark',
			),
			'id'    => array(),
			'value' => array(),
		),
		'br'      => '',
		'ins'     => '',
		'del'     => '',
		'h2'      => '',
		'h3'      => '',
		'h4'      => '',
		'h5'      => array(
			'class' => array(
				'add_offer_in_cart_text',
			),
		),
		'div'     => array(
			'class'                              => array(
				'wps_upsell_offer_main_wrapper',
				'wps_upsell_offer_parent_wrapper',
				'wps_upsell_offer_discount_section',
				'wps_upsell_offer_wrapper',
				'wps_upsell_offer_product_section',
				'wps_upsell_offer_image',
				'wps_upsell_offer_arrow',
				'wps_upsell_offer_product_content',
				'wps_upsell_offer_primary_section' => array(
					'div' => array(
						'img' => array(
							'src',
						),
					),
				),
				'wps_upsell_offer_secondary_section',
				'woocommerce-product-gallery__image',
				'wps_ubo_lite_go_pro_popup_wrap',
				'wps_ubo_lite_go_pro_popup',
				'wps_ubo_lite_go_pro_popup_head',
				'wps_ubo_lite_go_pro_popup_content',
				'wps_ubo_lite_go_pro_popup_button',
			),
			'id'                                 => array(),
			'value'                              => array(),
			'data-thumb'                         => array(),
			'data-thumb-alt'                     => array(),
			'woocommerce-product-gallery__image' => array(),
			'data-thumb'                         => array(),
		),
		'svg'     => array(
			'xmlns'   => array(),
			'viewbox' => array(),
		),
		'defs'    => array(),
		'style'   => array(),
		'g'       => array(
			'id' => array(),
		),
		'polygon' => array(
			'class'  => array(),
			'points' => array(),
		),
		'p'        => array(
			'class' => array(
				'wps_upsell_offer_product_price',
				'wps_upsell_offer_product_description',
				'wps_ubo_lite_go_pro_popup_text',
			),
			'id'    => array(),
			'value' => array(),
		),
		'b'       => '',
		'img'     => array(
			'class'                   => array( 'wp-post-image' ),
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
		'a'       => array(
			'href'   => array(),
			'class'  => array(
				'wps_ubo_lite_go_pro_popup_close',
				'button',
				'wps_ubo_lite_overview_go_pro_button',
			),
			'target' => '_blank',
		),
		'select'  => array(
			'id'                    => array(),
			'class'                 => array(),
			'name'                  => array(),
			'data-attribute_name'   => array(),
			'data-show_option_none' => array(),
			'order_bump_index'      => array(),
			'order'                 => array(),
			'attribute_pa_color'    => array(),
		),
		'h4'      => array(
			'data-wps_qty'          => array(),
			'data-wps_is_fixed_qty' => array(),
			'data-qty_allowed'      => array(),
			'class'                 => array(),
		),
		'option'  => array(
			'value'    => array(),
			'selected' => array(),
		),
	);
	?>

	<?php
	return $allowed_html;
}
