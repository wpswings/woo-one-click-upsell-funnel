<?php
/**
 * The file that defines the global plugin functions.
 *
 * All Global functions that are used through out the plugin.
 *
 * @link       https://makewebbetter.com/
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
function mwb_upsell_lite_elementor_plugin_active() {

	if ( mwb_upsell_lite_is_plugin_active( 'elementor/elementor.php' ) ) {

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
function mwb_upsell_lite_is_upsell_pro_active() {

	if ( mwb_upsell_lite_is_plugin_active( 'woocommerce-one-click-upsell-funnel-pro/woocommerce-one-click-upsell-funnel-pro.php' ) ) {

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
function mwb_upsell_lite_validate_upsell_nonce() {

	if ( isset( $_GET['ocuf_ns'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['ocuf_ns'] ) ), 'funnel_offers' ) ) {

		return true;
	} else {

		return false;
	}
}

/**
 * Get product discount.
 *
 * @since    2.0.0
 */
function mwb_upsell_lite_get_product_discount() {

	$mwb_wocuf_pro_offered_discount = '';

	$funnel_id = isset( $_GET['ocuf_fid'] ) ? sanitize_text_field( wp_unslash( $_GET['ocuf_fid'] ) ) : 'not_set';
	$offer_id = isset( $_GET['ocuf_ofd'] ) ? sanitize_text_field( wp_unslash( $_GET['ocuf_ofd'] ) ) : 'not_set';

	// If Live offer.
	if ( 'not_set' !== $funnel_id && 'not_set' !== $offer_id ) {

		$mwb_wocuf_pro_all_funnels = get_option( 'mwb_wocuf_funnels_list' );

		$mwb_wocuf_pro_offered_discount = $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_offer_discount_price'][ $offer_id ];

		$mwb_wocuf_pro_offered_discount = ! empty( $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_offer_discount_price'][ $offer_id ] ) ? $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_offer_discount_price'][ $offer_id ] : '';
	}

	// When not live and only for admin view.
	elseif ( current_user_can( 'manage_options' ) ) {

		// Get funnel and offer id from current offer page post id.
		global $post;
		$offer_page_id = $post->ID;

		$funnel_data = get_post_meta( $offer_page_id, 'mwb_upsell_funnel_data', true );

		$product_found_in_funnel = false;

		if ( ! empty( $funnel_data ) && is_array( $funnel_data ) && count( $funnel_data ) ) {

			$funnel_id = $funnel_data['funnel_id'];
			$offer_id = $funnel_data['offer_id'];

			if ( isset( $funnel_id ) && isset( $offer_id ) ) {

				$mwb_wocuf_pro_all_funnels = get_option( 'mwb_wocuf_funnels_list' );

				// When New offer is added ( Not saved ) so only at that time it will return 50%.
				$mwb_wocuf_pro_offered_discount = isset( $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_offer_discount_price'][ $offer_id ] ) ? $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_offer_discount_price'][ $offer_id ] : '50%';

				$mwb_wocuf_pro_offered_discount = ! empty( $mwb_wocuf_pro_offered_discount ) ? $mwb_wocuf_pro_offered_discount : '';
			}
		}

		// For Custom Page for Offer.
		else {

			// Get global product discount.

			$mwb_upsell_global_settings = get_option( 'mwb_upsell_lite_global_options', array() );

			$global_product_discount = isset( $mwb_upsell_global_settings['global_product_discount'] ) ? $mwb_upsell_global_settings['global_product_discount'] : '50%';

			$mwb_wocuf_pro_offered_discount = $global_product_discount;
		}
	}

	return $mwb_wocuf_pro_offered_discount;
}

/**
 * Upsell product id from url funnel and offer params.
 *
 * @since    2.0.0
 */
function mwb_upsell_lite_get_pid_from_url_params() {

	$params['status'] = 'false';

	if ( isset( $_GET['ocuf_ofd'] ) && isset( $_GET['ocuf_fid'] ) ) {

		$params['status'] = 'true';

		$params['offer_id'] = sanitize_text_field( wp_unslash( $_GET['ocuf_ofd'] ) );
		$params['funnel_id'] = sanitize_text_field( wp_unslash( $_GET['ocuf_fid'] ) );
	}

	return $params;
}

/**
 * Upsell Live Offer URL parameters.
 *
 * @since    2.0.0
 */
function mwb_upsell_lite_live_offer_url_params() {

	$add_live_nonce = ! empty( $_POST['mwb_wocuf_after_post_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_wocuf_after_post_nonce'] ) ) : '';

	wp_verify_nonce( $add_live_nonce, 'mwb_wocuf_after_field_post_nonce' );

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
function mwb_upsell_lite_offer_page_posts_deletion() {

	// Get all funnels.
	$all_created_funnels = get_option( 'mwb_wocuf_funnels_list', array() );
	// Get all saved offer post ids.
	$saved_offer_post_ids = get_option( 'mwb_upsell_lite_offer_post_ids', array() );

	if ( ! empty( $all_created_funnels ) && is_array( $all_created_funnels ) && count(
		$all_created_funnels
	) && ! empty( $saved_offer_post_ids ) && is_array( $saved_offer_post_ids ) && count(
		$saved_offer_post_ids
	) ) {

		$funnel_offer_post_ids = array();

		// Retrieve all valid( present in funnel ) offer assigned page post ids.
		foreach ( $all_created_funnels as $funnel_id => $single_funnel ) {

			if ( ! empty( $single_funnel['mwb_upsell_post_id_assigned'] ) && is_array( $single_funnel['mwb_upsell_post_id_assigned'] ) && count( $single_funnel['mwb_upsell_post_id_assigned'] ) ) {

				foreach ( $single_funnel['mwb_upsell_post_id_assigned'] as $offer_post_id ) {

					if ( ! empty( $offer_post_id ) ) {

						$funnel_offer_post_ids[] = $offer_post_id;
					}
				}
			}
		}

		// Now delete save posts which are not present in funnel.
		foreach ( $saved_offer_post_ids as $saved_offer_post_key => $saved_offer_post_id ) {

			if ( ! in_array( $saved_offer_post_id, $funnel_offer_post_ids ) ) {

				unset( $saved_offer_post_ids[ $saved_offer_post_key ] );

				// Delete post permanently.
				wp_delete_post( $saved_offer_post_id, true );
			}
		}

		// Update saved offer post ids array.
		$saved_offer_post_ids = array_values( $saved_offer_post_ids );
		update_option( 'mwb_upsell_lite_offer_post_ids', $saved_offer_post_ids );

	}
}

/**
 * Upsell supported payment gateways.
 *
 * @since    2.0.0
 */
function mwb_upsell_lite_supported_gateways() {

	$supported_gateways = array(
		'cod', // Cash on delivery
	);

	return $supported_gateways;
}

/**
 * Elementor Upsell offer template 1.
 *
 * ( Default Template ).
 *
 * @since    2.0.0
 */
function mwb_upsell_lite_elementor_offer_template_1() {

	// phpcs:disable
	$elementor_data = file_get_contents( MWB_WOCUF_DIRPATH . 'json/offer-template-1.json' );
	// phpcs:enable

	return $elementor_data;
}

/**
 * Elementor Upsell offer template 2.
 *
 * @since    2.0.0
 */
function mwb_upsell_lite_elementor_offer_template_2() {

	// phpcs:disable
	$elementor_data = file_get_contents( MWB_WOCUF_DIRPATH . 'json/offer-template-2.json' );
	// phpcs:enable

	return $elementor_data;
}

/**
 * Elementor Upsell offer template 3.
 *
 * Video Offer Template.
 *
 * @since    2.0.0
 */
function mwb_upsell_lite_lite_elementor_offer_template_3() {

	// phpcs:disable
	$elementor_data = file_get_contents( MWB_WOCUF_DIRPATH . 'json/offer-template-3.json' );
	// phpcs:enable

	return $elementor_data;
}

/**
 * Elementor Upsell offer template 3.
 *
 * Video Offer Template.
 *
 * @since    2.0.0
 */
function mwb_upsell_lite_gutenberg_offer_content() {

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
		<div class="mwb_upsell_default_offer_image">[mwb_upsell_image]</div>
		<!-- /wp:html -->

		<!-- wp:spacer {"height":20} -->
		<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
		<!-- /wp:spacer -->

		<!-- wp:heading {"align":"center"} -->
		<h2 style="text-align:center">[mwb_upsell_title]</h2>
		<!-- /wp:heading -->

		<!-- wp:html -->
		<div class="mwb_upsell_default_offer_description">[mwb_upsell_desc]</div>
		<!-- /wp:html -->

		<!-- wp:heading {"level":3,"align":"center"} -->
		<h3 style="text-align:center">Special Offer Price : [mwb_upsell_price]</h3>
		<!-- /wp:heading -->

		<!-- wp:spacer {"height":15} -->
		<div style="height:15px" aria-hidden="true" class="wp-block-spacer"></div>
		<!-- /wp:spacer -->

		<!-- wp:html -->
		<div class="mwb_upsell_default_offer_variations">[mwb_upsell_variations]</div>
		<!-- /wp:html -->

		<!-- wp:button {"customBackgroundColor":"#78c900","align":"center","className":"mwb_upsell_default_offer_buy_now"} -->
		<div class="wp-block-button aligncenter mwb_upsell_default_offer_buy_now"><a class="wp-block-button__link has-background" href="[mwb_upsell_yes]" style="background-color:#78c900">Add this to my Order</a></div>
		<!-- /wp:button -->

		<!-- wp:spacer {"height":25} -->
		<div style="height:25px" aria-hidden="true" class="wp-block-spacer"></div>
		<!-- /wp:spacer -->

		<!-- wp:button {"customBackgroundColor":"#e50000","align":"center","className":"mwb_upsell_default_offer_no_thanks"} -->
		<div class="wp-block-button aligncenter mwb_upsell_default_offer_no_thanks"><a class="wp-block-button__link has-background" href="[mwb_upsell_no]" style="background-color:#e50000">No thanks</a></div>
		<!-- /wp:button -->

		<!-- wp:html -->
		[mwb_upsell_default_offer_identification]
		<!-- /wp:html -->

		<!-- wp:spacer {"height":50} -->
		<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
		<!-- /wp:spacer -->';

		return $post_content;
}


if( ! function_exists( 'mwb_upsell_lite_get_order_id_from_live_param' ) ) {

	/**
	 * Get Order id from key.
	 *
	 * @since    3.0.0
	 */
	function mwb_upsell_lite_get_order_id_from_live_param( $location ='thank-you' ) {

		if( 'thank-you' == $location ) {

			$order_id = ! empty( $_GET[ 'key' ] ) ? wc_get_order_id_by_order_key( $_GET[ 'key' ] ) : false;

		} elseif ( 'upsell' == $location ) {
			
			$order_id = ! empty( $_GET[ 'ocuf_ok' ] ) ? wc_get_order_id_by_order_key( $_GET[ 'ocuf_ok' ] ) : false;
		}
		return $order_id;
	}
}

if( ! function_exists( 'mwb_upsell_lite_get_first_offer_after_redirect' ) ) {

	/**
	 * Get Order id from key.
	 *
	 * @since    3.0.0
	 */
	function mwb_upsell_lite_get_first_offer_after_redirect( $url = false ) {

		if( ! empty( $url ) ) {

			$url_components = parse_url( $url ); 

			// Extract Query Params. 
			if( ! empty( $url_components[ 'query' ] ) ) {
				parse_str( $url_components['query'], $params ); 
			}
			
			if( ! empty( $params[ 'ocuf_ofd' ] ) ) {
				
				$first_offer = ! empty( $params['ocuf_ofd'] ) ? sanitize_text_field( wp_unslash( $params['ocuf_ofd'] ) ) : '';
				return $first_offer;
			}	
		}

		return false;
	}
}


if( ! function_exists( 'mwb_upsell_lite_get_tracking_location' ) ) {

	/**
	 * Get Purchase event according to payment gateway.
	 *
	 * @since    3.0.0
	 */
	function mwb_upsell_lite_get_tracking_location( $order_id='' ) {

		if ( ! empty( $order_id ) ) {

			$location = '';
			$order = wc_get_order( $order_id );
			if( ! empty( $order ) ) {
				
				$payment_method = $order->get_payment_method();

				/**
				 * Org Payment methods.
				 * COD only.
				 */
				if( function_exists( 'mwb_upsell_lite_supported_gateways' ) && in_array( $payment_method, mwb_upsell_lite_supported_gateways() ) ) {
					
					$location = 'thank-you';
				}

				/**
				 * Pro Payment methods.
				 * Upsell Parent Supported which support parent order.
				 */
				elseif( function_exists( 'mwb_supported_gateways_to_trigger_parent' ) && in_array( $payment_method, mwb_supported_gateways_to_trigger_parent() ) ) {
					
					$location = 'upsell';
				}

				elseif( function_exists( 'mwb_upsell_supported_gateways_with_redirection' ) && in_array( $payment_method, mwb_upsell_supported_gateways_with_redirection() ) ) {
					
					$location = 'thank-you';
				}

				return $location;
			}
		}
	}
}


if( ! function_exists( 'mwb_upsell_lite_get_purchase_data' ) ) {

	/**
	 * Get Purchase event data according to location.
	 * Have to handle upsell and nonupsell orders.
	 *
	 * @since    3.0.0
	 */
	function mwb_upsell_lite_get_purchase_data( $order_id='', $current_location='', $track_type='' ) {

		if( ! empty( $order_id ) && ! empty( $current_location ) ) {

			$order = wc_get_order( $order_id );
			$is_fired_already = get_post_meta( $order_id, 'purchase_event_fired' , true );

			if( 'upsell' == $current_location ) {

				/** 
				 * Upsell is shown, May be first offer, have to fire main purchase.
				 * Check for accepeted offer, have to fire last upsell purchase.
				 */
				$is_upsell_accepted = get_post_meta( $order_id, 'mwb_wocuf_upsell_order', true );
				$is_main_accepted = get_post_meta( $order_id, 'mwb_wocuf_upsell_order', true );
			}

			elseif ( 'thank-you' == $current_location ) {

				/** 
				 * May be normal order.
				 * May be Non-upsell order.
				 * May be upsell order without redirection.
				 * May be upsell order with parent order, have to fire last purchase.
				 */
				if( function_exists( 'mwb_supported_gateways_to_trigger_parent' ) && in_array( $order->get_payment_method() , mwb_supported_gateways_to_trigger_parent() ) ) {

					/**
					 * Check upsell is accepted or not.
					 * Trigger last accepted offer.
					 */
				}
				
				elseif( ( function_exists( 'mwb_upsell_lite_supported_gateways' ) && in_array( $order->get_payment_method() , mwb_upsell_lite_supported_gateways() ) ) || ( function_exists( 'mwb_upsell_supported_gateways_with_redirection' ) && in_array( $order->get_payment_method() , mwb_upsell_supported_gateways_with_redirection() ) )  ) {

					/**
					 * Trigger for complete order items.
					 * If upsell accepted then sends data in seperate params.
					 */
					if( ! $order->needs_payment() && empty( $is_fired_already ) ) {

						/**
						 * Pixel / GA Track.
						 * Send order data now.
						 * Add upsell order too.
						 */
						$contents_array = array();

						$order_items = $order->get_items( 'line_item' );
						if( ! empty( $order_items ) && is_array( $order_items ) ) {

							foreach ( $order_items as $item_key => $item_obj ) {
														
								// Each Items purchased.

								if( 'pixel' == $track_type ) {

									$single_item_data = array(
										'id'	=> ! empty( $item_obj->get_variation_id() ) ? $item_obj->get_variation_id() : $item_obj->get_product_id(),
										'quantity'	=> $item_obj->get_quantity(),
									);

									array_push( $contents_array, $single_item_data );
								}

								elseif ( 'google_analytics' == $track_type ) {
									
									$product_id = ! empty( $item_obj->get_data()[ 'variation_id' ] ) ? $item_obj->get_data()[ 'variation_id' ] : $item_obj->get_data()[ 'product_id' ];

									$product = wc_get_product( $product_id );

									$product_categories = array();

									$product_cat_obj_array = get_the_terms( $product_id, 'product_cat' );

									if ( ! empty( $product_cat_obj_array ) && is_array( $product_cat_obj_array ) && count( $product_cat_obj_array ) ) {

										foreach ( $product_cat_obj_array as $product_cat_obj ) {

											if ( ! empty( $product_cat_obj->term_id ) ) {

												if( $term = get_term_by( 'id', $product_cat_obj->term_id, 'product_cat' ) ){
													
													$product_categories[] = ! empty( $term->name ) ? $term->name : '';
												}
											}
										}
									}

									$single_item_data = array(
									    'id'=> ! empty( $product_id ) ? $product_id : $product_id ,
									    'name'=> ! empty( $item_obj->get_name() ) ? $item_obj->get_name() : '' ,
									   	'sku'=> ! empty( $product ) ? $product->get_sku() : '' ,
									    'category'=> ! empty( $product_categories ) ? $product_categories : '' ,
									    'price'=> ! empty( $item_obj->get_total() ) ? $item_obj->get_total() : '' ,
									    'quantity'=> ! empty( $item_obj->get_quantity() ) ? $item_obj->get_quantity() : '' 
									);

									array_push( $contents_array, $single_item_data );
								}
							}
						}

						if( 'pixel' == $track_type ) {

							return 	$order_purchase_data = array(
								'value'	=>	$order->get_total(),
								'content'	=>	$contents_array,
							);
						} 

						elseif ( 'google_analytics' == $track_type ) {

							$transaction_data = array(
								'id'	=> $order_id,                     	// Transaction ID. Required.
								'affiliation'	=> get_bloginfo( 'name' ),   	// Affiliation or store name.
								'revenue'	=> $order->get_total(),               	// Grand Total.
								'shipping'	=> $order->get_shipping_total(),                  	// Shipping.
								'tax'	=> $order->get_total_tax()                     	// Tax.
							);

							return 	$order_purchase_data = array(
								'ga_transaction_data'	=>	$transaction_data,
								'ga_single_item_data'	=>	$contents_array,
							);
						}
					}
				}
			} // End Condition for thank you.
		} 
	}
}

if( ! function_exists( 'mwb_upsell_lite_get_upsell_purchase_data' ) ) {

	/**
	 * Get Purchase event data according to location.
	 * Have to handle upsell orders items.
	 *
	 * @since    3.0.0
	 */
	function mwb_upsell_lite_get_upsell_purchase_data( $order_total='', $current_location='' ) {

		if( ! empty( $order_id ) && ! empty( $current_location ) ) {

			$order = wc_get_order( $order_id );

			if( ! empty( $order ) ) {

				$order_items = $order->get_items( 'line_item' );
				$upsell_items = get_post_meta( $order_id, '_upsell_remove_items_on_fail', true );

				if( ! empty( $order_items ) && is_array( $order_items ) && ! empty( $upsell_items ) && is_array( $upsell_items ) ) {

					$upsell_contents_array = array();
					$upsell_total = 0;
					foreach ( $order_items as $item_key => $item_obj ) {
						
						// Upsell orders
						if( ! empty( $item_key ) && ! empty( $upsell_items ) && in_array( $item_key, $upsell_items ) ) {

							// Each Items purchased.
							$single_item_data = array(
								'id'	=> ! empty( $item_obj->get_variation_id() ) ? $item_obj->get_variation_id() : $item_obj->get_product_id(),
								'quantity'	=> $item_obj->get_quantity(),
							);

							$upsell_total += $item_obj->get_total();
							array_push( $upsell_contents_array, $single_item_data );
						}
					}

					// Return Data.
					return array(
						'value'	=> ! empty( $upsell_total ) ? $upsell_total : '0',
						'upsell_contents'	=> ! empty( $upsell_contents_array ) ? $upsell_contents_array : array(),
					);
				}
			}

		} 
	}
}