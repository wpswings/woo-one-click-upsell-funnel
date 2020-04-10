<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package     woo_one_click_upsell_funnel
 * @subpackage woo_one_click_upsell_funnel/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package     woo_one_click_upsell_funnel
 * @subpackage woo_one_click_upsell_funnel/public
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Woocommerce_one_click_upsell_funnel_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		 $this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in woocommerce_one_click_upsell_funnel_pro_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The woocommerce_one_click_upsell_funnel_pro_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woocommerce_one_click_upsell_funnel_pro-public.css', array(), $this->version, 'all' );
	}

	public function enqueue_scripts() {

		wp_enqueue_script( 'mwb-upsell-sweet-alert-js', plugin_dir_url( __FILE__ ) . 'js/sweet-alert.js', array(), '2.1.2', true );

		wp_enqueue_script( 'woocommerce-one-click-upsell-public-script', plugin_dir_url( __FILE__ ) . 'js/woocommerce-oneclick-upsell-funnel-public.js', array( 'jquery' ), $this->version, true );

		$upsell_global_options = get_option( 'mwb_upsell_lite_global_options', array() );

		wp_localize_script( 'woocommerce-one-click-upsell-public-script', 'mwb_upsell_public', array(
			
			'alert_preview_title' => esc_html__( 'One Click Upsell', 'woocommerce_one_click_upsell_funnel' ),

			'alert_preview_content' => esc_html__( 'This is Preview Mode, please checkout to see Live Offers.', 'woocommerce_one_click_upsell_funnel' ),

			'upsell_actions_message'	=>	! empty( $upsell_global_options[ 'upsell_actions_message' ] ) ? sanitize_text_field( $upsell_global_options[ 'upsell_actions_message' ] ) : '',
		) );

		/**
		 * Scripts used to implement Ecommerce Tracking.
		 * After v2.1.0
		 */
		$mwb_upsell_analytics_options = get_option( 'mwb_upsell_analytics_configuration', array() );

		$mwb_upsell_fb_pixel_config = ! empty( $mwb_upsell_analytics_options[ 'facebook-pixel' ] ) ? $mwb_upsell_analytics_options[ 'facebook-pixel' ] : array();

		$mwb_upsell_ga_analytics_config = ! empty( $mwb_upsell_analytics_options[ 'google-analytics' ] ) ? $mwb_upsell_analytics_options[ 'google-analytics' ] : array();

		$localize_script_data = false;
		if( ! empty( $mwb_upsell_fb_pixel_config[ 'mwb_upsell_enable_pixel_tracking' ] ) && 'yes' == $mwb_upsell_fb_pixel_config[ 'mwb_upsell_enable_pixel_tracking' ] ) {

			// Localize the data for FB pixel and tracking.
			$localize_script_data = true;
		}

		if( false === $localize_script_data && ! empty( $mwb_upsell_ga_analytics_config[ 'mwb_upsell_enable_ga_tracking' ] ) && 'yes' == $mwb_upsell_ga_analytics_config[ 'mwb_upsell_enable_ga_tracking' ] ) {

			// Localize the data for GA analytics and tracking.
			$localize_script_data = true;
		}

		if( true === $localize_script_data ) {

			wp_register_script( 'woocommerce-one-click-upsell-public-tracking-script', plugin_dir_url( __FILE__ ) . 'js/woocommerce-oneclick-upsell-funnel-public-analytics.js', array( 'jquery' ), $this->version, true );

			$analytics_js_data = $this->get_analytics_localisation_data( $mwb_upsell_ga_analytics_config,$mwb_upsell_fb_pixel_config );

			wp_localize_script( 'woocommerce-one-click-upsell-public-tracking-script', 'mwb', $analytics_js_data );
			wp_enqueue_script( 'woocommerce-one-click-upsell-public-tracking-script' );
		}
	}

	/**
	 * Initiate Upsell Orders before processing payment.
	 *
	 * @since    1.0.0
	 */
	public function mwb_wocuf_initiate_upsell_orders( $order_id ) {

		$order = new WC_Order( $order_id );

		$payment_method = $order->get_payment_method();

		$supported_gateways = mwb_upsell_lite_supported_gateways();

		if ( in_array( $payment_method, $supported_gateways ) ) {

			$mwb_wocuf_pro_all_funnels = get_option( 'mwb_wocuf_funnels_list', array() );

			$mwb_wocuf_pro_flag = 0;

			$mwb_wocuf_pro_proceed = false;

			if ( empty( $mwb_wocuf_pro_all_funnels ) ) {
				return;
			} elseif ( empty( $order ) ) {
				return;
			}

			$funnel_redirect = false;

			if ( ! empty( $order ) ) {
				if ( function_exists( 'wcs_order_contains_subscription' ) && ( wcs_order_contains_subscription( $order_id ) || wcs_order_contains_renewal( $order_id ) ) ) {
					return;
				}

				$mwb_wocuf_pro_placed_order_items = $order->get_items();

				$ocuf_ok = $order->get_order_key();

				$ocuf_ofd = 0;

				if ( is_array( $mwb_wocuf_pro_all_funnels ) ) {

					// Move Global Funnels at the last of the array while maintaining it's key, so they execute at last.
					foreach ( $mwb_wocuf_pro_all_funnels as $funnel_key => $single_funnel_array ) {
						

						$global_funnel = ! empty( $single_funnel_array['mwb_wocuf_global_funnel'] ) ? $single_funnel_array['mwb_wocuf_global_funnel'] : '';

						// Check if global funnel.
						if ( 'yes' == $global_funnel ) {

							// Unset.
							unset( $mwb_wocuf_pro_all_funnels[$funnel_key] );

							// Append at last with the same key.
							$mwb_wocuf_pro_all_funnels[$funnel_key] = $single_funnel_array;
						}
					}

					// Main Foreach for Triggering Upsell Offers.
					foreach ( $mwb_wocuf_pro_all_funnels as $mwb_wocuf_pro_single_funnel => $mwb_wocuf_pro_funnel_data ) {

						$is_global_funnel = ! empty( $mwb_wocuf_pro_funnel_data['mwb_wocuf_global_funnel'] ) && 'yes' == $mwb_wocuf_pro_funnel_data['mwb_wocuf_global_funnel'] ? $mwb_wocuf_pro_funnel_data['mwb_wocuf_global_funnel'] : false;

						$mwb_wocuf_pro_funnel_target_products = ! empty( $mwb_wocuf_pro_all_funnels[ $mwb_wocuf_pro_single_funnel ]['mwb_wocuf_target_pro_ids'] ) ? $mwb_wocuf_pro_all_funnels[ $mwb_wocuf_pro_single_funnel ]['mwb_wocuf_target_pro_ids'] : array();

						$mwb_wocuf_pro_existing_offers = ! empty( $mwb_wocuf_pro_funnel_data['mwb_wocuf_applied_offer_number'] ) ? $mwb_wocuf_pro_funnel_data['mwb_wocuf_applied_offer_number'] : array();

						// To get the first offer from current funnel.
						if ( count( $mwb_wocuf_pro_existing_offers ) ) {

							foreach ( $mwb_wocuf_pro_existing_offers as $key => $value ) {

								$ocuf_ofd = $key;
								break;
							}
						}

						if ( is_array( $mwb_wocuf_pro_placed_order_items ) && count( $mwb_wocuf_pro_placed_order_items ) ) {
							foreach ( $mwb_wocuf_pro_placed_order_items as $item_key => $mwb_wocuf_pro_single_item ) {
								$mwb_wocuf_pro_variation_id = $mwb_wocuf_pro_single_item->get_variation_id();

								$mwb_wocuf_pro_product_id = $mwb_wocuf_pro_single_item->get_product_id();

								if ( in_array( $mwb_wocuf_pro_product_id, $mwb_wocuf_pro_funnel_target_products ) || ( $mwb_wocuf_pro_variation_id != 0 && in_array( $mwb_wocuf_pro_variation_id, $mwb_wocuf_pro_funnel_target_products ) ) || ( $is_global_funnel ) ) {

									// Check if funnel is saved after version 3.0.0.
									$funnel_saved_after_version_3 = ! empty( $mwb_wocuf_pro_all_funnels[ $mwb_wocuf_pro_single_funnel ]['mwb_upsell_fsav3'] ) ? $mwb_wocuf_pro_all_funnels[ $mwb_wocuf_pro_single_funnel ]['mwb_upsell_fsav3'] : '';

									// For funnels saved after version 3.0.0.
									if ( 'true' == $funnel_saved_after_version_3 ) {

										// Check if funnel is live or not.
										$funnel_status = ! empty( $mwb_wocuf_pro_all_funnels[ $mwb_wocuf_pro_single_funnel ]['mwb_upsell_funnel_status'] ) ? $mwb_wocuf_pro_all_funnels[ $mwb_wocuf_pro_single_funnel ]['mwb_upsell_funnel_status'] : '';

										/**
										 * For Admin don't check this.
										 * After v2.1.0
										 */
										if( ! current_user_can('administrator') ) {
											
											if ( 'yes' != $funnel_status ) {

												// Break from placed order items loop and move to next funnel.
												break;
											}
										}
									}

									/**
									 * Check for funnel schedule.
									 * After v2.1.0 convert data in array first.
									 */
									$mwb_wocuf_pro_funnel_schedule = ! empty( $mwb_wocuf_pro_all_funnels[ $mwb_wocuf_pro_single_funnel ]['mwb_wocuf_pro_funnel_schedule'] ) ? $mwb_wocuf_pro_all_funnels[ $mwb_wocuf_pro_single_funnel ]['mwb_wocuf_pro_funnel_schedule'] : array( '7' );

									if ( '0' == $mwb_wocuf_pro_all_funnels[ $mwb_wocuf_pro_single_funnel ]['mwb_wocuf_pro_funnel_schedule'] ) {

										$mwb_wocuf_pro_funnel_schedule = array( '0' );
									}

									elseif ( ! is_array( $mwb_wocuf_pro_funnel_schedule ) ) {

										$mwb_wocuf_pro_funnel_schedule = array( $mwb_wocuf_pro_funnel_schedule );
									}
									
									// In order to use server time only.
									$current_schedule = date( 'w' );

									if( in_array( '7', $mwb_wocuf_pro_funnel_schedule ) ) {

										$mwb_wocuf_pro_proceed = true;

									} elseif ( in_array( $current_schedule, $mwb_wocuf_pro_funnel_schedule ) ) {

										$mwb_wocuf_pro_proceed = true;
									}

									if ( false == $mwb_wocuf_pro_proceed ) {

										// Break from placed order items loop and move to next funnel.
										break;
									}

									// Array of offers with product id.
									if ( ! empty( $mwb_wocuf_pro_all_funnels[ $mwb_wocuf_pro_single_funnel ]['mwb_wocuf_products_in_offer'] ) && is_array( $mwb_wocuf_pro_all_funnels[ $mwb_wocuf_pro_single_funnel ]['mwb_wocuf_products_in_offer'] ) ) {

										/**
										 * Set funnel as shown if is exclusive offer funnel.
										 * Do it just after checking target.
										 * Exclusive Offer 
										 */
										if( ! empty( $mwb_wocuf_pro_funnel_data[ 'mwb_wocuf_exclusive_offer' ] ) && 'yes' == $mwb_wocuf_pro_funnel_data[ 'mwb_wocuf_exclusive_offer' ] ) {
														    	
											// Check if funnel still exists.
											if( ! empty( $mwb_wocuf_pro_funnel_data ) ) {

												if( ! empty( $mwb_wocuf_pro_funnel_data[ 'mwb_wocuf_exclusive_offer' ] ) && 'yes' == $mwb_wocuf_pro_funnel_data[ 'mwb_wocuf_exclusive_offer' ] ) {

													$offer_already_shown_to_users = ! empty( $mwb_wocuf_pro_funnel_data[ 'offer_already_shown_to_users' ] ) ? $mwb_wocuf_pro_funnel_data[ 'offer_already_shown_to_users' ] : array();

													$current_customer = ! empty( $order ) ? $order->get_billing_email() : '';

													if( ! empty( $current_customer ) && ! empty( $offer_already_shown_to_users ) && in_array( $current_customer, $offer_already_shown_to_users ) ) {

														// Skip to next funnel.
														break;
													}

													// Not skipped. Mark as shown to this customer.
													array_push( $offer_already_shown_to_users, $current_customer );
													$mwb_wocuf_pro_funnel_data[ 'offer_already_shown_to_users' ] = $offer_already_shown_to_users;

													$mwb_wocuf_pro_all_funnels[ $mwb_wocuf_pro_single_funnel ] = $mwb_wocuf_pro_funnel_data;

													// Sort Funnels before saving.
													$sorted_upsell_funnels = $mwb_wocuf_pro_all_funnels;

													ksort( $sorted_upsell_funnels );

													update_option( 'mwb_wocuf_funnels_list', $sorted_upsell_funnels );
												}
											}
										}

										/**
										 * Smart Offer Upgrade. ( Will not work for Global Funnel )
										 */
										if( ! empty( $mwb_wocuf_pro_funnel_data[ 'mwb_wocuf_smart_offer_upgrade' ] ) && 'yes' == $mwb_wocuf_pro_funnel_data[ 'mwb_wocuf_smart_offer_upgrade' ] && ! $is_global_funnel ) {
													
											if( ! empty( $item_key ) ) {

												update_post_meta( $order_id, '__smart_offer_upgrade_target_key', $item_key );
											}
										}

										// To skip funnel if any funnel offer product is already present during checkout ( Order Items ).
										$mwb_upsell_global_settings = get_option( 'mwb_upsell_lite_global_options', array() );

										$skip_similar_offer = ! empty( $mwb_upsell_global_settings['skip_similar_offer'] ) ? $mwb_upsell_global_settings['skip_similar_offer'] : 'yes';

										if ( 'yes' == $skip_similar_offer ) {

											$offer_product_in_cart = false;

											foreach ( $mwb_wocuf_pro_all_funnels[ $mwb_wocuf_pro_single_funnel ]['mwb_wocuf_products_in_offer'] as $product_in_funnel_id_array ) {

												if ( ! empty( $product_in_funnel_id_array ) ) {

													// In v2.0.0, it was array so handling accordingly.
													if ( is_array( $product_in_funnel_id_array ) && count( $product_in_funnel_id_array ) ) {

														foreach ( $product_in_funnel_id_array as $product_in_funnel_id ) {

															foreach ( $mwb_wocuf_pro_placed_order_items as $item_key => $mwb_wocuf_pro_single_item ) {

																/**
																 * Get get_product()->get_id() will return actual id, no need to call
																 * get_variation_id() separately.
																 */
																if ( $mwb_wocuf_pro_single_item->get_product()->get_id() == absint( $product_in_funnel_id ) ) {

																	$offer_product_in_cart = true;
																	break 3;

																}
															}
														}
													} else {

														foreach ( $mwb_wocuf_pro_placed_order_items as $item_key => $mwb_wocuf_pro_single_item ) {

															/**
															 * Get get_product()->get_id() will return actual id, no need to call
															 * get_variation_id() separately.
															 */
															if ( $mwb_wocuf_pro_single_item->get_product()->get_id() == absint( $product_in_funnel_id_array ) ) {

																$offer_product_in_cart = true;
																break 2;

															}
														}
													}
												}
											}

											if ( true === $offer_product_in_cart ) {

												break;
											}
										}


										/**
										 * Smart Skip if already purchased.
										 * after v2.1.0
										 */
										$smart_skip_if_purchased = ! empty( $mwb_upsell_global_settings['smart_skip_if_purchased'] ) ? $mwb_upsell_global_settings['smart_skip_if_purchased'] : '';

										if( 'yes' == $smart_skip_if_purchased ) {

											$offer_product_already_purchased = false;

											if( ! empty( $mwb_wocuf_pro_all_funnels[ $mwb_wocuf_pro_single_funnel ]['mwb_wocuf_products_in_offer'] ) && is_array( $mwb_wocuf_pro_all_funnels[ $mwb_wocuf_pro_single_funnel ]['mwb_wocuf_products_in_offer'] ) ) {

												foreach ( $mwb_wocuf_pro_all_funnels[ $mwb_wocuf_pro_single_funnel ]['mwb_wocuf_products_in_offer'] as $single_offer_id ) {

													if( true == self::mwb_wocuf_skip_for_pre_order( $single_offer_id ) ) {

														// If already purchased.
														$offer_product_already_purchased = true;
														break;
													}
												}
											}

											if( true == $offer_product_already_purchased ) {

												break;
											}
										}
										

										// To skip funnel if any offer product in funnel is out of stock.

										$product_in_funnel_stock_out = false;

										foreach ( $mwb_wocuf_pro_all_funnels[ $mwb_wocuf_pro_single_funnel ]['mwb_wocuf_products_in_offer'] as $product_in_funnel_id_array ) {

											if ( ! empty( $product_in_funnel_id_array ) ) {

												// In v2.0.0, it was array so handling accordingly.
												if ( is_array( $product_in_funnel_id_array ) && count( $product_in_funnel_id_array ) ) {

													foreach ( $product_in_funnel_id_array as $product_in_funnel_id ) {

														$product_in_funnel = wc_get_product( $product_in_funnel_id );

														if ( ! $product_in_funnel->is_in_stock() ) {

															$product_in_funnel_stock_out = true;
															break 2;
														}
													}
												} else {

													$product_in_funnel = wc_get_product( $product_in_funnel_id_array );

													if ( ! $product_in_funnel->is_in_stock() ) {

														$product_in_funnel_stock_out = true;
														break;
													}
												}
											}
										}

										if ( true === $product_in_funnel_stock_out ) {

											break;
										}
									}
									// $ocuf_ofd is first offer id in funnel, check if product id is set in it.
									if ( ! empty( $mwb_wocuf_pro_all_funnels[ $mwb_wocuf_pro_single_funnel ]['mwb_wocuf_products_in_offer'][ $ocuf_ofd ] ) ) {

										$funnel_offer_post_id_assigned = ! empty( $mwb_wocuf_pro_all_funnels[ $mwb_wocuf_pro_single_funnel ]['mwb_upsell_post_id_assigned'][ $ocuf_ofd ] ) ? $mwb_wocuf_pro_all_funnels[ $mwb_wocuf_pro_single_funnel ]['mwb_upsell_post_id_assigned'][ $ocuf_ofd ] : '';

										// When funnel is saved after v3.0.0 and offer post id is assigned and elementor active.
										if ( ! empty( $funnel_offer_post_id_assigned ) && 'true' == $funnel_saved_after_version_3 && mwb_upsell_lite_elementor_plugin_active() ) {

											$redirect_to_upsell = false;

											$offer_template = ! empty( $mwb_wocuf_pro_all_funnels[ $mwb_wocuf_pro_single_funnel ]['mwb_wocuf_pro_offer_template'][ $ocuf_ofd ] ) ? $mwb_wocuf_pro_all_funnels[ $mwb_wocuf_pro_single_funnel ]['mwb_wocuf_pro_offer_template'][ $ocuf_ofd ] : '';

											// When template is set to custom.
											if ( 'custom' == $offer_template ) {

												$custom_offer_page_url = ! empty( $mwb_wocuf_pro_all_funnels[ $mwb_wocuf_pro_single_funnel ]['mwb_wocuf_offer_custom_page_url'][ $ocuf_ofd ] ) ? $mwb_wocuf_pro_all_funnels[ $mwb_wocuf_pro_single_funnel ]['mwb_wocuf_offer_custom_page_url'][ $ocuf_ofd ] : '';

												if ( ! empty( $custom_offer_page_url ) ) {

													$redirect_to_upsell = true;
													$redirect_to_url = $custom_offer_page_url;
												}
											}

											// When template is set to one, two or three.
											elseif ( ! empty( $offer_template ) ) {

												$offer_assigned_post_id = ! empty( $mwb_wocuf_pro_all_funnels[ $mwb_wocuf_pro_single_funnel ]['mwb_upsell_post_id_assigned'][ $ocuf_ofd ] ) ? $mwb_wocuf_pro_all_funnels[ $mwb_wocuf_pro_single_funnel ]['mwb_upsell_post_id_assigned'][ $ocuf_ofd ] : '';

												if ( ! empty( $offer_assigned_post_id ) && 'publish' == get_post_status( $offer_assigned_post_id ) ) {

													$redirect_to_upsell = true;
													$redirect_to_url = get_page_link( $offer_assigned_post_id );
												}
											}

											if ( true === $redirect_to_upsell ) {

												$funnel_redirect = true;

												$mwb_wocuf_pro_nonce = wp_create_nonce( 'funnel_offers' );

												/**
												 * Updated after v2.1.0
												 * Do not append params manually.
												 */
												// $result = $redirect_to_url . '?ocuf_ns=' . $mwb_wocuf_pro_nonce . '&ocuf_fid=' . $mwb_wocuf_pro_single_funnel . '&ocuf_ok=' . $ocuf_ok . '&ocuf_ofd=' . $ocuf_ofd;

												$result = add_query_arg( array(
												    'ocuf_ns' => $mwb_wocuf_pro_nonce,
												    'ocuf_fid' => $mwb_wocuf_pro_single_funnel,
												    'ocuf_ok' => $ocuf_ok,
												    'ocuf_ofd' => $ocuf_ofd,
												), $redirect_to_url );

												$mwb_wocuf_pro_flag = 1;

												// Break from placed order items loop with both funnel redirect and pro flag as true.
												break;
											}
										}

										// When funnel is saved before v3.0.0.
										else {

											$mwb_wocuf_pro_offer_page_id = get_option( 'mwb_wocuf_pro_funnel_default_offer_page', '' );

											if ( isset( $mwb_wocuf_pro_all_funnels[ $mwb_wocuf_pro_single_funnel ]['mwb_wocuf_offer_custom_page_url'][ $ocuf_ofd ] ) && ! empty( $mwb_wocuf_pro_all_funnels[ $mwb_wocuf_pro_single_funnel ]['mwb_wocuf_offer_custom_page_url'][ $ocuf_ofd ] ) ) {
												$result = $mwb_wocuf_pro_all_funnels[ $mwb_wocuf_pro_single_funnel ]['mwb_wocuf_offer_custom_page_url'][ $ocuf_ofd ];
											} elseif ( ! empty( $mwb_wocuf_pro_offer_page_id ) && 'publish' == get_post_status( $mwb_wocuf_pro_offer_page_id ) ) {
												$result = get_page_link( $mwb_wocuf_pro_offer_page_id );
											} else {

												// Break from placed order items loop and move to next funnel.
												break;
											}

											$funnel_redirect = true;

											$mwb_wocuf_pro_nonce = wp_create_nonce( 'funnel_offers' );

											/**
											 * Updated after v2.1.0
											 * Do not append params manually.
											 */
											// $result .= '?ocuf_ns=' . $mwb_wocuf_pro_nonce . '&ocuf_fid=' . $mwb_wocuf_pro_single_funnel . '&ocuf_ok=' . $ocuf_ok . '&ocuf_ofd=' . $ocuf_ofd;

											$result = add_query_arg( array(
											    'ocuf_ns' => $mwb_wocuf_pro_nonce,
											    'ocuf_fid' => $mwb_wocuf_pro_single_funnel,
											    'ocuf_ok' => $ocuf_ok,
											    'ocuf_ofd' => $ocuf_ofd,
											), $result );

											$mwb_wocuf_pro_flag = 1;

											// Break from placed order items loop with both funnel redirect and pro flag as true.
											break;
										}
									}
								}
							}
						}

						if ( 1 == $mwb_wocuf_pro_flag ) {

							// Break from 'all funnels' loop.
							break;
						}
					}
				}

				if ( $funnel_redirect ) {

					// For cron - Upsell is initialized. As just going to Redirect.
					update_post_meta( $order_id, 'mwb_ocufp_upsell_initialized', time() );

					/**
					 * As just going to redirect, means upsell is initialized for this order.
					 *
					 * This can be used to track upsell orders in which browser window was closed
					 * and other purposes.
					 */
					update_post_meta( $order_id, 'mwb_upsell_order_started', 'true' );

					// Add Upsell Funnel Id to order meta for Sales by Funnel tracking.
					update_post_meta( $order_id, 'mwb_upsell_funnel_id', $mwb_wocuf_pro_single_funnel );

					// Add Funnel Triggered count and Offer View Count for the current Funnel.
					$Sales_By_Funnel = new Mwb_Upsell_Report_Sales_By_Funnel( $mwb_wocuf_pro_single_funnel );
					$Sales_By_Funnel->add_funnel_triggered_count();
					$Sales_By_Funnel->add_offer_view_count();


					// Store Order ID in session so it can be re-used after payment failure.
					WC()->session->set( 'order_awaiting_payment', $order_id );

					$upsell_result = array(
						'result' => 'success',
						'redirect' => $result,
					);

					// Redirect to upsell offer page.
					wp_send_json( $upsell_result );
				} else {

					return;
				}
			}

			return;

		}

	}

	/**
	 * When user clicks on No thanks for Upsell offer.
	 *
	 * @since    1.0.0
	 */

	public function mwb_wocuf_pro_process_the_funnel() {

		if ( isset( $_GET['ocuf_th'] ) && 1 == $_GET['ocuf_th'] && isset( $_GET['ocuf_ofd'] ) && isset( $_GET['ocuf_fid'] ) && isset( $_GET['ocuf_ok'] ) && isset( $_GET['ocuf_ns'] ) ) {

			$offer_id = sanitize_text_field( wp_unslash( $_GET['ocuf_ofd'] ) );

			$funnel_id = sanitize_text_field( wp_unslash( $_GET['ocuf_fid'] ) );

			$order_key = sanitize_text_field( wp_unslash( $_GET['ocuf_ok'] ) );

			$wp_nonce = sanitize_text_field( wp_unslash( $_GET['ocuf_ns'] ) );

			$order_id = wc_get_order_id_by_order_key( $order_key );

			if ( ! empty( $order_id ) ) {

				$order = wc_get_order( $order_id );

				$already_processed_order_statuses = array(
					'processing',
					'completed',
					'on-hold',
					'failed',
				);

				// If order or payment is already processed.
				if ( in_array( $order->get_status(), $already_processed_order_statuses ) ) {

					$this->expire_offer();
				}
			}

			// Add Offer Reject Count for the current Funnel.
			$Sales_By_Funnel = new Mwb_Upsell_Report_Sales_By_Funnel( $funnel_id );
			$Sales_By_Funnel->add_offer_reject_count();

			$mwb_wocuf_pro_all_funnels = get_option( 'mwb_wocuf_funnels_list', array() );

			$mwb_wocuf_pro_action_on_no = isset( $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_attached_offers_on_no'] ) ? $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_attached_offers_on_no'] : array();

			$mwb_wocuf_pro_check_action = isset( $mwb_wocuf_pro_action_on_no[ $offer_id ] ) ? $mwb_wocuf_pro_action_on_no[ $offer_id ] : '';

			if ( 'thanks' == $mwb_wocuf_pro_check_action ) {

				$this->initiate_order_payment_and_redirect( $order_id );
			} elseif ( 'thanks' != $mwb_wocuf_pro_check_action ) {

				// Next offer id.
				$offer_id = $mwb_wocuf_pro_check_action;

				// Check if next offer has product.
				$mwb_wocuf_pro_upcoming_offer = isset( $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_products_in_offer'][ $offer_id ] ) ? $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_products_in_offer'][ $offer_id ] : array();

				// If next offer has no product then redirect.
				if ( empty( $mwb_wocuf_pro_upcoming_offer ) ) {

					$this->initiate_order_payment_and_redirect( $order_id );
				}

				$funnel_saved_after_version_3 = ! empty( $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_upsell_fsav3'] ) ? $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_upsell_fsav3'] : '';

				$funnel_offer_post_id_assigned = ! empty( $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_upsell_post_id_assigned'][ $offer_id ] ) ? $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_upsell_post_id_assigned'][ $offer_id ] : '';

				// When funnel is saved after v3.0.0 and offer post id is assigned and elementor active.
				if ( ! empty( $funnel_offer_post_id_assigned ) && 'true' == $funnel_saved_after_version_3 && mwb_upsell_lite_elementor_plugin_active() ) {

					$redirect_to_upsell = false;

					$offer_template = ! empty( $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_pro_offer_template'][ $offer_id ] ) ? $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_pro_offer_template'][ $offer_id ] : '';

					// When template is set to custom.
					if ( 'custom' == $offer_template ) {

						$custom_offer_page_url = ! empty( $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_offer_custom_page_url'][ $offer_id ] ) ? $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_offer_custom_page_url'][ $offer_id ] : '';

						if ( ! empty( $custom_offer_page_url ) ) {

							$redirect_to_upsell = true;
							$redirect_to_url = $custom_offer_page_url;
						}
					}

					// When template is set to one, two or three.
					elseif ( ! empty( $offer_template ) ) {

						$offer_assigned_post_id = ! empty( $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_upsell_post_id_assigned'][ $offer_id ] ) ? $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_upsell_post_id_assigned'][ $offer_id ] : '';

						if ( ! empty( $offer_assigned_post_id ) && 'publish' == get_post_status( $offer_assigned_post_id ) ) {

							$redirect_to_upsell = true;
							$redirect_to_url = get_page_link( $offer_assigned_post_id );
						}
					}

					if ( true === $redirect_to_upsell ) {


						/**
						* Updated after v2.1.0
						* Do not append params manually.
						*/
						// $url = $redirect_to_url . '?ocuf_ns=' . $wp_nonce . '&ocuf_ofd=' . $offer_id . '&ocuf_ok=' . $order_key . '&ocuf_fid=' . $funnel_id;

						$url = add_query_arg( array(
							'ocuf_ns' => $wp_nonce,
							'ocuf_fid' => $funnel_id,
							'ocuf_ok' => $order_key,
							'ocuf_ofd' => $offer_id,
						), $redirect_to_url );

					} else {

						$this->initiate_order_payment_and_redirect( $order_id );
					}
				}

				// When funnel is saved before v3.0.0.
				else {

					$mwb_wocuf_pro_offer_page_id = get_option( 'mwb_wocuf_pro_funnel_default_offer_page', '' );

					if ( isset( $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_offer_custom_page_url'][ $offer_id ] ) && ! empty( $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_offer_custom_page_url'][ $offer_id ] ) ) {

						$mwb_wocuf_pro_next_offer_url = $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_offer_custom_page_url'][ $offer_id ];
					} elseif ( ! empty( $mwb_wocuf_pro_offer_page_id ) && get_post_status( 'publish' == $mwb_wocuf_pro_offer_page_id ) ) {

						$mwb_wocuf_pro_next_offer_url = get_page_link( $mwb_wocuf_pro_offer_page_id );
					} else {

						$this->initiate_order_payment_and_redirect( $order_id );
					}

					/**
					* Updated after v2.1.0
					* Do not append params manually.
					*/
					// $mwb_wocuf_pro_next_offer_url = $mwb_wocuf_pro_next_offer_url . '?ocuf_ns=' . $wp_nonce . '&ocuf_ofd=' . $offer_id . '&ocuf_ok=' . $order_key . '&ocuf_fid=' . $funnel_id;

					$mwb_wocuf_pro_next_offer_url = add_query_arg( array(
						'ocuf_ns' => $wp_nonce,
						'ocuf_fid' => $funnel_id,
						'ocuf_ok' => $order_key,
						'ocuf_ofd' => $offer_id,
					), $mwb_wocuf_pro_next_offer_url );

					$url = $mwb_wocuf_pro_next_offer_url;
				}

				// Add Offer View Count for the current Funnel.
				$Sales_By_Funnel = new Mwb_Upsell_Report_Sales_By_Funnel( $funnel_id );
				$Sales_By_Funnel->add_offer_view_count();

				wp_safe_redirect( $url );
				exit();
			}
		}
	}

	public function mwb_wocuf_pro_funnel_offers_shortcode() {
		$result = '';

		if ( isset( $_GET['ocuf_ok'] ) ) {
			$order_key = sanitize_text_field( wp_unslash( $_GET['ocuf_ok'] ) );

			$order_id = wc_get_order_id_by_order_key( $order_key );

			if ( isset( $_GET['ocuf_ofd'] ) && isset( $_GET['ocuf_fid'] ) ) {
				$offer_id = sanitize_text_field( wp_unslash( $_GET['ocuf_ofd'] ) );

				$funnel_id = sanitize_text_field( wp_unslash( $_GET['ocuf_fid'] ) );

				if ( isset( $_GET['ocuf_ns'] ) ) {

					$wp_nonce = sanitize_text_field( wp_unslash( $_GET['ocuf_ns'] ) );

					wp_verify_nonce( $wp_nonce, 'funnel_offers' );

					$mwb_wocuf_pro_all_funnels = get_option( 'mwb_wocuf_funnels_list', array() );

					$mwb_wocuf_pro_buy_text = get_option( 'mwb_wocuf_pro_buy_text', esc_html__( 'Buy Now', 'woocommerce_one_click_upsell_funnel' ) );

					$mwb_wocuf_pro_no_text = get_option( 'mwb_wocuf_pro_no_text', esc_html__( 'No,thanks', 'woocommerce_one_click_upsell_funnel' ) );

					$mwb_wocuf_pro_before_offer_price_text = get_option( 'mwb_wocuf_pro_before_offer_price_text', esc_html__( 'Special Offer Price', 'woocommerce_one_click_upsell_funnel' ) );

					$mwb_wocuf_pro_offered_products = isset( $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_products_in_offer'] ) ? $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_products_in_offer'] : array();

					$mwb_wocuf_pro_offered_discount = isset( $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_offer_discount_price'] ) ? $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_offer_discount_price'] : array();

					$mwb_wocuf_pro_buy_button_color = get_option( 'mwb_wocuf_pro_buy_button_color', '' );

					$ocuf_th_button_color = get_option( 'mwb_wocuf_pro_thanks_button_color', '' );

					$result .= '<div style="display:none;" id="mwb_wocuf_pro_offer_loader"><img id="mwb-wocuf-loading-offer" src="' . MWB_WOCUF_URL . 'public/images/ajax-loader.gif"></div><div class="mwb_wocuf_pro_offer_container"><div class="woocommerce"><div class="mwb_wocuf_pro_special_offers_for_you">';

					$mwb_wocuf_pro_offer_banner_text = get_option( 'mwb_wocuf_pro_offer_banner_text', esc_html__( 'Special Offer For You Only', 'woocommerce_one_click_upsell_funnel' ) );

					$result .= '<div class="mwb_wocuf_pro_special_offer_banner">
								<h1>' . trim( $mwb_wocuf_pro_offer_banner_text, '"' ) . '</h1></div>';

					$mwb_wocuf_pro_single_offered_product = '';

					if ( ! empty( $mwb_wocuf_pro_offered_products[ $offer_id ] ) ) {

						// In v2.0.0, it was array so handling to get the first product id.
						if ( is_array( $mwb_wocuf_pro_offered_products[ $offer_id ] ) && count( $mwb_wocuf_pro_offered_products[ $offer_id ] ) ) {

							foreach ( $mwb_wocuf_pro_offered_products[ $offer_id ] as $handling_offer_product_id ) {

								$mwb_wocuf_pro_single_offered_product = absint( $handling_offer_product_id );
								break;
							}
						} else {

							$mwb_wocuf_pro_single_offered_product = absint( $mwb_wocuf_pro_offered_products[ $offer_id ] );
						}
					}

					$mwb_wocuf_pro_original_offered_product = wc_get_product( $mwb_wocuf_pro_single_offered_product );

					$original_price = $mwb_wocuf_pro_original_offered_product->get_price_html();

					$product = $mwb_wocuf_pro_original_offered_product;

					if ( ! $mwb_wocuf_pro_original_offered_product->is_type( 'variable' ) ) {
						$mwb_wocuf_pro_offered_product = $this->mwb_wocuf_pro_change_offered_product_price( $mwb_wocuf_pro_original_offered_product, $mwb_wocuf_pro_offered_discount[ $offer_id ] );

						$product = $mwb_wocuf_pro_offered_product;
					}

					$result .= '<div class="mwb_wocuf_pro_main_wrapper">';

					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $mwb_wocuf_pro_single_offered_product ), 'full' );

					if ( empty( $image[0] ) ) {
						$image[0] = wc_placeholder_img_src();
					}

					$result .= '<div class="mwb_wocuf_pro_product_image"><img src="' . $image[0] . '"></div>';

					$result .= '<div class="mwb_wocuf_pro_offered_product"><div class="mwb_wocuf_pro_product_title"><h2>' . $product->get_title() . '</h2></div>';

					$result .= '<div class="mwb_wocuf_pro_offered_product_description">
							    <p class="mwb_wocuf_pro_product_desc">' . $product->get_description() . '</p></div>';

					$result .= '<div class="mwb_wocuf_pro_product_price">
						    	<h4>' . $mwb_wocuf_pro_before_offer_price_text . ' : ' . $product->get_price_html() . '</h4></div></div></div>';

					$result .= '<div class="mwb_wocuf_pro_offered_product_actions">
				    			<form class="mwb_wocuf_pro_offer_form" method="post">
								<input type="hidden" name="ocuf_ns" value="' . $wp_nonce . '">
								<input type="hidden" name="ocuf_fid" value="' . $funnel_id . '">
								<input type="hidden" class="mwb_wocuf_pro_variation_id" name="product_id" value="' . absint( $product->get_id() ) . '">
								<div id="mwb_wocuf_pro_variation_attributes" ></div>
								<input type="hidden" name="ocuf_ofd" value="' . $offer_id . '">
								<input type="hidden" name="ocuf_ok" value="' . $order_key . '">
								<input type="hidden" name="mwb_wocuf_post_nonce" value="' . wp_create_nonce( 'mwb_wocuf_field_post_nonce' ) . '">
								<input type="hidden" name="mwb_wocuf_after_post_nonce" value="' . wp_create_nonce( 'mwb_wocuf_after_field_post_nonce' ) . '">
								<button data-id="' . $funnel_id . '" style="background-color:' . $mwb_wocuf_pro_buy_button_color . '" class="mwb_wocuf_pro_buy mwb_wocuf_pro_custom_buy" type="submit" name="mwb_wocuf_pro_buy">' . $mwb_wocuf_pro_buy_text . '</button></form>
								<a style="color:' . $ocuf_th_button_color . '" class="mwb_wocuf_pro_skip mwb_wocuf_pro_no" href="?ocuf_ns=' . $wp_nonce . '&ocuf_th=1&ocuf_ok=' . $order_key . '&ocuf_ofd=' . $offer_id . '&ocuf_fid=' . $funnel_id . '">' . $mwb_wocuf_pro_no_text . '</a>
								</div>
				    		</div></div>';

					$result .= '</div>';

					$result .= '</div></div></div>';
				} else {
					$error_msg = esc_html__( 'You ran out of the special offers session.', 'woocommerce_one_click_upsell_funnel' );

					$link_text = esc_html__( 'Go to the "Order details" page.', 'woocommerce_one_click_upsell_funnel' );

					$error_msg = apply_filters( 'mwb_wocuf_pro_error_message', $error_msg );

					$link_text = apply_filters( 'mwb_wocuf_pro_order_details_link_text', $link_text );

					$order_received_url = wc_get_endpoint_url( 'order-received', $order_id, wc_get_page_permalink( 'checkout' ) );

					$order_received_url = add_query_arg( 'key', $order_key, $order_received_url );

					$result .= $error_msg . '<a href="' . $order_received_url . '" class="button">' . $link_text . '</a>';
				}
			} else {
				$error_msg = esc_html__( 'You ran out of the special offers session.', 'woocommerce_one_click_upsell_funnel' );

				$link_text = esc_html__( 'Go to the "Order details" page.', 'woocommerce_one_click_upsell_funnel' );

				$error_msg = apply_filters( 'mwb_wocuf_pro_error_message', $error_msg );

				$link_text = apply_filters( 'mwb_wocuf_pro_order_details_link_text', $link_text );

				$order_received_url = wc_get_endpoint_url( 'order-received', $order_id, wc_get_page_permalink( 'checkout' ) );

				$order_received_url = add_query_arg( 'key', $order_key, $order_received_url );

				$result .= $error_msg . '<a href="' . $order_received_url . '" class="button">' . $link_text . '</a>';
			}
		}

		if ( ! isset( $_GET['ocuf_ok'] ) || ! isset( $_GET['ocuf_ofd'] ) || ! isset( $_GET['ocuf_fid'] ) ) {
			$mwb_wocuf_pro_no_offer_text = get_option( 'mwb_wocuf_pro_no_offer_text', esc_html__( 'Sorry, you have no offers', 'woocommerce_one_click_upsell_funnel' ) );

			$result .= '<div class="mwb-wocuf_pro-no-offer"><h2>' . trim( $mwb_wocuf_pro_no_offer_text, '"' ) . '</h2>';

			$result .= '<a class="button wc-backward" href="' . esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ) . '">' . esc_html__( 'Return to Shop', 'woocommerce_one_click_upsell_funnel' ) . '</a></div>';

		}

		return $result;
	}

	/**
	 * applying offer on product price
	 *
	 * @since    1.0.0
	 * @param    object $temp_product    object of product.
	 * @param    string $price           offer price.
	 * @return   object   $temp_product    object of product with new offer price.
	 */
	// public function mwb_wocuf_pro_change_offered_product_price( $temp_product, $price ) {
	// 	if ( ! empty( $price ) && ! empty( $temp_product ) ) {

	// 		// If sale price is set then discount will be appiled on sale price else on regular price.
	// 		if ( ! empty( $temp_product->get_sale_price() ) ) {

	// 			$product_sale_price = true;
	// 			$product_price = $temp_product->get_sale_price();
	// 		} else {

	// 			$product_sale_price = false;
	// 			$product_price = $temp_product->get_regular_price();
	// 		}

	// 		$mwb_wocuf_pro_product_price = $product_price;

	// 		// Discount is in %.
	// 		if ( false !== strpos( $price, '%' ) ) {
	// 			$price = trim( $price, '%' );

	// 			$price = floatval( $mwb_wocuf_pro_product_price ) * ( floatval( $price ) / 100 );

	// 			if ( $mwb_wocuf_pro_product_price > 0 ) {
	// 				$price = $mwb_wocuf_pro_product_price - $price;
	// 			} else {
	// 				$price = $mwb_wocuf_pro_product_price;
	// 			}

	// 			if ( $product_sale_price ) {

	// 				$temp_product->set_price( $price );// Set active price.
	// 			}

	// 			/**
	// 			 * If sale price is not set then to show regular plus discounted price
	// 			 * instead of just discounted price.
	// 			 */
	// 			else {

	// 				$temp_product->set_price( $price );// Set active price.
	// 				$temp_product->set_sale_price( $price );
	// 			}
	// 		}

	// 		// Discount is fixed.
	// 		 else {

	// 			$price = floatval( $price );

	// 			if ( $product_sale_price ) {

	// 				$temp_product->set_price( $price );// Set active price.
	// 			}

	// 			/**
	// 			 * If sale price is not set then to show regular plus discounted price
	// 			 * instead of just discounted price.
	// 			 */
	// 			else {
	// 				$temp_product->set_price( $price );// Set active price.
	// 				$temp_product->set_sale_price( $price );
	// 			}
	// 		}
	// 	}

	// 	return $temp_product;
	// }

	/**
	 * applying offer on product price
	 *
	 * @since    2.1.0
	 * @param    object     $temp_product    Object of product.
	 * @param    string 	$price           Offer price.
	 * @return   object   	$temp_product    Object of product with new offer price.
	 */
	public function mwb_wocuf_pro_change_offered_product_price( $temp_product, $price ) {

		if ( ! empty( $price ) && ! empty( $temp_product ) ) {

			$payable_price = $temp_product->get_price();
			$sale_price = $temp_product->get_sale_price();
			$regular_price = $temp_product->get_regular_price();

			// Discount is in %.
			if ( false !== strpos( $price, '%' ) ) {

				$discounted_percent = trim( $price, '%' );
				$discounted_price = floatval( $payable_price ) * ( floatval( $discounted_percent ) / 100 );

				// Original price must be greater than zero.
				if ( $payable_price > 0 ) {

					$offer_price = $payable_price - $discounted_price;

				} else {

					$offer_price = $payable_price;
				}
			}

			// Discount is fixed.
			 else {

				$offer_price = floatval( $price );
			}

			/**
			 * Original price : $payable_price.
			 * Sale price : $sale_price.
			 * Regular price : $regular_price.
			 * Offer price : $offer_price.
			 */
			$mwb_upsell_global_settings = get_option( 'mwb_upsell_lite_global_options', array() );

			$price_html_format = ! empty( $mwb_upsell_global_settings[ 'offer_price_html_type' ] ) ? $mwb_upsell_global_settings[ 'offer_price_html_type' ] : 'regular';

			// ̶S̶a̶l̶e̶ ̶P̶r̶i̶c̶e̶  Offer Price.
			if( 'sale' == $price_html_format ) {

				if( ! empty( $sale_price ) ) {

					$temp_product->set_regular_price( $sale_price );
					$temp_product->set_sale_price( $offer_price );
				}

				else {

					// No sale price is present.
					$temp_product->set_sale_price( $offer_price );
				}
			}

			// ̶R̶e̶g̶u̶l̶a̶r̶ ̶P̶r̶i̶c̶e̶ Offer Price.
			else {

				// In this case set the regular price as sale.
				$temp_product->set_sale_price( $offer_price );
			}

			$temp_product->set_price( $offer_price );
		}
		
		return $temp_product;
	}


	/**
	 * When user clicks on Add upsell product to my Order.
	 *
	 * @since    1.0.0
	 */
	public function mwb_wocuf_pro_charge_the_offer() {

		$add_product_nonce = ! empty( $_POST['mwb_wocuf_post_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_wocuf_post_nonce'] ) ) : '';

		if ( ( isset( $add_product_nonce ) ) && wp_verify_nonce( $add_product_nonce, 'mwb_wocuf_field_post_nonce' ) && isset( $_POST['mwb_wocuf_pro_buy'] ) || isset( $_GET['mwb_wocuf_pro_buy'] ) ) {

			unset( $_POST['mwb_wocuf_pro_buy'] );

			$live_offer_url_params = mwb_upsell_lite_live_offer_url_params();

			if ( 'true' == $live_offer_url_params['status'] ) {

				$is_product_with_variations = false;

				if ( ! empty( $_POST['wocuf_var_attb'] ) ) {

					// Retrieve all variations from form.
					$variation_attributes = sanitize_text_field( wp_unslash( $_POST['wocuf_var_attb'] ) );
					$variation_attributes = stripslashes( $variation_attributes );
					$variation_attributes = str_replace( "'", '"', $variation_attributes );

					$variation_attributes = json_decode( $variation_attributes, true );

					$is_product_with_variations = true;
				}

				$wp_nonce   = $live_offer_url_params['upsell_nonce'];

				$offer_id   = $live_offer_url_params['offer_id'];

				$funnel_id  = $live_offer_url_params['funnel_id'];

				$product_id = $live_offer_url_params['product_id'];

				$order_key  = $live_offer_url_params['order_key'];

				$offer_quantity  = ! empty( $live_offer_url_params['quantity'] ) ? $live_offer_url_params['quantity'] : '1';

				$order_id   = wc_get_order_id_by_order_key( $order_key );

				if ( ! empty( $order_id ) ) {

					$order = wc_get_order( $order_id );

					$already_processed_order_statuses = array(
						'processing',
						'completed',
						'on-hold',
						'failed',
					);

					// If order or payment is already processed.
					if ( in_array( $order->get_status(), $already_processed_order_statuses ) ) {

						$this->expire_offer();
					}
				}

				if ( ! empty( $order ) ) {
					$upsell_product = wc_get_product( $product_id );

					if ( ! empty( $upsell_product ) && $upsell_product->is_purchasable() ) {

						$mwb_wocuf_pro_all_funnels = get_option( 'mwb_wocuf_funnels_list' );

						$mwb_wocuf_pro_offered_discount = ! empty( $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_offer_discount_price'][ $offer_id ] ) ? $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_offer_discount_price'][ $offer_id ] : '';

						$upsell_product = $this->mwb_wocuf_pro_change_offered_product_price( $upsell_product, $mwb_wocuf_pro_offered_discount );

						if ( $is_product_with_variations ) {

							if ( 'variation' == $upsell_product->get_type() ) {

								$upsell_var_attb = $upsell_product->get_variation_attributes();

								// Variation has blank attribute when it is set as 'Any..' in backend.

								// Check if upsell product variation has any blank attribute ?
								if ( false !== array_search( '', $upsell_var_attb ) ) {

									// If yes then set attributes retrieved from form.
									$upsell_product->set_attributes( $variation_attributes );
								}
							}
						}

						$upsell_item_id = $order->add_product( $upsell_product, $offer_quantity );

						// Add Offer Accept Count for the current Funnel.
						$Sales_By_Funnel = new Mwb_Upsell_Report_Sales_By_Funnel( $funnel_id );
						$Sales_By_Funnel->add_offer_accept_count();

						$target_item_id = get_post_meta( $order_id, '__smart_offer_upgrade_target_key', true );

						$force_payment = false;

						if( ! empty( $target_item_id ) && is_numeric( $target_item_id ) ) {

							foreach ( (array)$order->get_items() as $item_id => $item ) {

								if ( $item_id == $target_item_id ) {

									$order->remove_item( $item_id );
									delete_post_meta( $order_id, '__smart_offer_upgrade_target_key' );
									$force_payment = true;
								}
							}

							$order->save();
						}

						wc_add_order_item_meta(  $upsell_item_id, 'is_upsell_purchase', 'true' );

						$order->calculate_totals();

						// Upsell product was purchased for this order.
						update_post_meta( $order_id, 'mwb_wocuf_upsell_order', 'true' );

					}

					$mwb_wocuf_pro_all_funnels = get_option( 'mwb_wocuf_funnels_list', array() );

					$mwb_wocuf_pro_buy_action = isset( $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_attached_offers_on_buy'] ) ? $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_attached_offers_on_buy'] : '';

					$url = '';

					/**
					 * After v3.3.0 :: Smart offer upgraded.
					 * If target product is removed, then process the payment.
					 */
					if( ! empty( $force_payment ) && true === $force_payment ) {

						$this->initiate_order_payment_and_redirect( $order_id );
					}

					elseif ( isset( $mwb_wocuf_pro_buy_action[ $offer_id ] ) && 'thanks' == $mwb_wocuf_pro_buy_action[ $offer_id ] ) {

						$this->initiate_order_payment_and_redirect( $order_id );

					} elseif ( isset( $mwb_wocuf_pro_buy_action[ $offer_id ] ) && 'thanks' != $mwb_wocuf_pro_buy_action[ $offer_id ] ) {
						// Next offer id.
						$offer_id = $mwb_wocuf_pro_buy_action[ $offer_id ];

						// Check if next offer has product.
						$mwb_wocuf_pro_upcoming_offer = isset( $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_products_in_offer'][ $offer_id ] ) ? $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_products_in_offer'][ $offer_id ] : '';

						// If next offer has no product then redirect.
						if ( empty( $mwb_wocuf_pro_upcoming_offer ) ) {

							$this->initiate_order_payment_and_redirect( $order_id );

						} else {

							$funnel_saved_after_version_3 = ! empty( $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_upsell_fsav3'] ) ? $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_upsell_fsav3'] : '';

							$funnel_offer_post_id_assigned = ! empty( $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_upsell_post_id_assigned'][ $offer_id ] ) ? $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_upsell_post_id_assigned'][ $offer_id ] : '';

							// When funnel is saved after v3.0.0 and offer post id is assigned and elementor active.
							if ( ! empty( $funnel_offer_post_id_assigned ) && 'true' == $funnel_saved_after_version_3 && mwb_upsell_lite_elementor_plugin_active() ) {

								$redirect_to_upsell = false;

								$offer_template = ! empty( $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_pro_offer_template'][ $offer_id ] ) ? $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_pro_offer_template'][ $offer_id ] : '';

								// When template is set to custom.
								if ( 'custom' == $offer_template ) {

									$custom_offer_page_url = ! empty( $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_offer_custom_page_url'][ $offer_id ] ) ? $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_offer_custom_page_url'][ $offer_id ] : '';

									if ( ! empty( $custom_offer_page_url ) ) {

										$redirect_to_upsell = true;
										$redirect_to_url = $custom_offer_page_url;
									}
								}

								// When template is set to one, two or three.
								elseif ( ! empty( $offer_template ) ) {

									$offer_assigned_post_id = ! empty( $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_upsell_post_id_assigned'][ $offer_id ] ) ? $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_upsell_post_id_assigned'][ $offer_id ] : '';

									if ( ! empty( $offer_assigned_post_id ) && 'publish' == get_post_status( $offer_assigned_post_id ) ) {

										$redirect_to_upsell = true;
										$redirect_to_url = get_page_link( $offer_assigned_post_id );
									}
								}

								if ( true === $redirect_to_upsell ) {

									/** Updated after v2.1.0
									 */
									// $url = $redirect_to_url . '?ocuf_ns=' . $wp_nonce . '&ocuf_ofd=' . $offer_id . '&ocuf_ok=' . $order_key . '&ocuf_fid=' . $funnel_id;

									$url = add_query_arg( array(
									    'ocuf_ns' => $wp_nonce,
									    'ocuf_fid' => $funnel_id,
									    'ocuf_ok' => $order_key,
									    'ocuf_ofd' => $offer_id,
									), $redirect_to_url );

								} else {

									$this->initiate_order_payment_and_redirect( $order_id );
								}
							}

							// When funnel is saved before v3.0.0.
							else {

								$mwb_wocuf_pro_offer_page_id = get_option( 'mwb_wocuf_pro_funnel_default_offer_page', '' );

								if ( isset( $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_offer_custom_page_url'][ $offer_id ] ) && ! empty( $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_offer_custom_page_url'][ $offer_id ] ) ) {

									$mwb_wocuf_pro_next_offer_url = $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_offer_custom_page_url'][ $offer_id ];
								} elseif ( ! empty( $mwb_wocuf_pro_offer_page_id ) && 'publish' == get_post_status( $mwb_wocuf_pro_offer_page_id ) ) {

									$mwb_wocuf_pro_next_offer_url = get_page_link( $mwb_wocuf_pro_offer_page_id );
								} else {

									$this->initiate_order_payment_and_redirect( $order_id );
								}

								// $mwb_wocuf_pro_next_offer_url = $mwb_wocuf_pro_next_offer_url . '?ocuf_ns=' . $wp_nonce . '&ocuf_ofd=' . $offer_id . '&ocuf_ok=' . $order_key . '&ocuf_fid=' . $funnel_id;

								// $url = $mwb_wocuf_pro_next_offer_url;

								$url = add_query_arg( array(
								    'ocuf_ns' => $wp_nonce,
								    'ocuf_fid' => $funnel_id,
								    'ocuf_ok' => $order_key,
								    'ocuf_ofd' => $offer_id,
								), $mwb_wocuf_pro_next_offer_url );
							}
						}

						// Add Offer View Count for the current Funnel.
						$Sales_By_Funnel = new Mwb_Upsell_Report_Sales_By_Funnel( $funnel_id );
						$Sales_By_Funnel->add_offer_view_count();

						wp_safe_redirect( $url );
						exit;
					}

				} else {

					$this->initiate_order_payment_and_redirect( $order_id );
				}
			}
		}
	}

	/**
	 * Add custom cron recurrence time interval.
	 *
	 * @since    1.0.0
	 * @param       array $schedules       Array of cron Schedule times for recurrence.
	 */
	public function set_cron_schedule_time( $schedules ) {

		if ( ! isset( $schedules['mwb_wocuf_twenty_minutes'] ) ) {

			$schedules['mwb_wocuf_twenty_minutes'] = array(
				'interval' => 20 * 60,
				'display' => esc_html__( 'Once every 20 minutes', 'woocommerce_one_click_upsell_funnel' ),
			);
		}

		return $schedules;
	}

	/**
	 * Cron schedule fire Event for Order payment process.
	 *
	 * @since    1.0.0
	 */
	public function order_payment_cron_fire_event() {

		// Pending Orders.
		$pending_upsell_orders = get_posts(
			array(
				'numberposts' => -1,
				'post_status' => 'wc-pending',
				'fields'      => 'ids', // return only ids.
				'meta_key'    => 'mwb_ocufp_upsell_initialized',
				'post_type'   => 'shop_order',
				'order'       => 'ASC',
			)
		);

		if ( ! empty( $pending_upsell_orders ) && is_array( $pending_upsell_orders ) && count( $pending_upsell_orders ) ) {

			foreach ( $pending_upsell_orders as $order_id ) {

				$time_stamp = get_post_meta( $order_id, 'mwb_ocufp_upsell_initialized', true );

				if ( ! empty( $time_stamp ) ) {

					$fifteen_minutes = strtotime( '+15 minutes', $time_stamp );

					$current_time = time();

					$time_diff = $fifteen_minutes - $current_time;

					if ( 0 > $time_diff ) {

						global $woocommerce;

						$gateways = $woocommerce->payment_gateways->get_available_payment_gateways();

						$order = new WC_Order( $order_id );

						// For cron - Payment initialized.
						delete_post_meta( $order_id, 'mwb_ocufp_upsell_initialized' );

						$payment_method = $order->get_payment_method();

						$gateways[ $payment_method ]->process_payment( $order_id, 'cron' );
					}
				}
			}
		}
	}

	/**
	 * Initiate Order Payment and redirect.
	 *
	 * @since    1.0.0
	 * @param    int $order_id    Order ID.
	 */
	public function initiate_order_payment_and_redirect( $order_id ) {

		$result = $this->upsell_order_final_payment( $order_id );

		$order = new WC_Order( $order_id );

		$url = $order->get_checkout_order_received_url();

		if ( isset( $result['result'] ) && 'success' === $result['result'] ) {

			wp_safe_redirect( $result['redirect'] );
			exit;
		}

		if ( isset( $result['result'] ) && 'failure' === $result['result'] ) {

			global $woocommerce;
			$cart_page_url = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : $woocommerce->cart->get_cart_url();

			wp_safe_redirect( $cart_page_url );
			exit;
		} else {

			wp_safe_redirect( $url );
			exit;
		}
	}

	/**
	 * Process Payment for Upsell order.
	 *
	 * @since    1.0.0
	 * @param    int $order_id    Order ID.
	 */
	public function upsell_order_final_payment( $order_id = '' ) {

		if ( empty( $order_id ) ) {

			return false;
		}

		global $woocommerce;

		$gateways = $woocommerce->payment_gateways->get_available_payment_gateways();

		$order = new WC_Order( $order_id );

		// For cron - Payment initialized.
		delete_post_meta( $order_id, 'mwb_ocufp_upsell_initialized' );

		$payment_method = $order->get_payment_method();

		$result = $gateways[ $payment_method ]->process_payment( $order_id, 'true' );

		return $result;

	}

	/**
	 * Product Variations dropdown content.
	 *
	 * @since    1.0.0
	 * @param    $count             count of items
	 * @param    $args              args for variable product dropdown
	 * @return   $html              html for variable product dropdown
	 */
	public function mwb_wocuf_pro_variation_attribute_options( $args = array() ) {

		$args = wp_parse_args(
			apply_filters( 'woocommerce_dropdown_variation_attribute_options_args', $args ),
			array(
				'options'          => false,
				'attribute'        => false,
				'product'          => false,
				'selected'         => false,
				'name'             => '',
				'id'               => '',
				'class'            => '',
				'show_option_none' => false,
			)
		);

		$options               = $args['options'];
		$product               = $args['product'];
		$attribute             = $args['attribute'];
		$name                  = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title( $attribute );
		$id                    = $args['id'] ? $args['id'] : sanitize_title( $attribute );
		$class                 = $args['class'];
		$show_option_none      = $args['show_option_none'] ? true : false;
		$show_option_none_text = $args['show_option_none'] ? $args['show_option_none'] : esc_html__( 'Choose an option', 'woocommerce_one_click_upsell_funnel' );

		if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
			$attributes = $product->get_variation_attributes();
			$options    = $attributes[ $attribute ];
		}

		$html = '<select id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . '" name="' . esc_attr( $name ) . '" data-attribute_name="attribute_' . esc_attr( sanitize_title( $attribute ) ) . '" data-show_option_none="' . ( $show_option_none ? 'yes' : 'no' ) . '">';
		$html .= '<option value="">' . esc_html( $show_option_none_text ) . '</option>';

		if ( ! empty( $options ) ) {
			if ( $product && taxonomy_exists( $attribute ) ) {
				// Get terms if this is a taxonomy - ordered. We need the names too.
				$terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );

				foreach ( $terms as $term ) {
					if ( in_array( $term->slug, $options ) ) {
						$html .= '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args['selected'] ), $term->slug, false ) . '>' . esc_html__( apply_filters( 'woocommerce_variation_option_name', $term->name ) ) . '</option>';
					}
				}
			} else {
				foreach ( $options as $option ) {
					// This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
					$selected = sanitize_title( $args['selected'] ) === $args['selected'] ? selected( $args['selected'], sanitize_title( $option ), false ) : selected( $args['selected'], $option, false );
					$html .= '<option value="' . esc_attr( $option ) . '" ' . $selected . '>' . esc_html__( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
				}
			}
		}

		$html .= '</select>';

		return $html;
	}

	/**
	 * Shortcodes for Upsell action and Product attributes.
	 * The life of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function upsell_shortcodes() {

		// OLD shortcodes :->

		// Creating shortcode for accept link on custom page
		add_shortcode( 'mwb_wocuf_pro_yes', array( $this, 'mwb_wocuf_pro_custom_page_action_link_yes' ) );

		// creating shortcode for thanks link on custom page
		add_shortcode( 'mwb_wocuf_pro_no', array( $this, 'mwb_wocuf_pro_custom_page_action_link_no' ) );

		// creating shortcode for showing product price on custom page
		add_shortcode( 'mwb_wocuf_pro_offer_price', array( $this, 'mwb_wocuf_pro_custom_page_product_offer_price' ) );
		// creating shortcode for showing order details link on custom page
		add_shortcode( 'mwb_wocuf_pro_order_details', array( $this, 'mwb_wocuf_pro_custom_page_order_details_link' ) );

		// adding shortcode for default funnel offer page.
		add_shortcode( 'mwb_wocuf_pro_funnel_default_offer_page', array( $this, 'mwb_wocuf_pro_funnel_offers_shortcode' ) );

		// New shortcodes :->

		// Upsell Action.

		add_shortcode( 'mwb_upsell_yes', array( $this, 'buy_now_shortcode_content' ) );

		add_shortcode( 'mwb_upsell_no', array( $this, 'no_thanks_shortcode_content' ) );

		// Product.
		add_shortcode( 'mwb_upsell_title', array( $this, 'product_title_shortcode_content' ) );

		add_shortcode( 'mwb_upsell_desc', array( $this, 'product_description_shortcode_content' ) );

		add_shortcode( 'mwb_upsell_desc_short', array( $this, 'product_short_description_shortcode_content' ) );

		add_shortcode( 'mwb_upsell_image', array( $this, 'product_image_shortcode_content' ) );

		add_shortcode( 'mwb_upsell_price', array( $this, 'product_price_shortcode_content' ) );

		add_shortcode( 'mwb_upsell_variations', array( $this, 'variations_selector_shortcode_content' ) );

		// Review.
		add_shortcode( 'mwb_upsell_star_review', array( $this, 'product_star_review' ) );

		// Default Gutenberg offer
		add_shortcode( 'mwb_upsell_default_offer_identification', array( $this, 'default_offer_identification' ) );

		/**
		 * Shortcodes after v2.1.0.
		 * Quantity Field and Timer Shortcode.
		 */
		add_shortcode( 'mwb_upsell_timer', array( $this, 'timer_shortcode_content' ) );

		add_shortcode( 'mwb_upsell_quantity', array( $this, 'quantity_shortcode_content' ) );
	}

	/**
	 * Get upsell product id from offer page id.
	 *
	 * @since    3.0.0
	 */
	public function get_upsell_product_id_for_shortcode() {

		// Firstly try to get product id from url offer and funnel id i.e. the case of live offer.

		$product_id_from_get = mwb_upsell_lite_get_pid_from_url_params();

		// When it is live offer.
		if ( 'true' == $product_id_from_get['status'] ) {

			$funnel_id = $product_id_from_get['funnel_id'];
			$offer_id = $product_id_from_get['offer_id'];

			// Get all funnels.
			$all_funnels = get_option( 'mwb_wocuf_funnels_list', array() );

			$product_id = ! empty( $all_funnels[ $funnel_id ]['mwb_wocuf_products_in_offer'][ $offer_id ] ) ? $all_funnels[ $funnel_id ]['mwb_wocuf_products_in_offer'][ $offer_id ] : '';

			return $product_id;
		}

		// Will only execute from here when it is not live offer.

		// Get product id from current offer page post id.
		global $post;
		$offer_page_id = $post->ID;

		// Means this is Upsell offer template. 
		$funnel_data = get_post_meta( $offer_page_id, 'mwb_upsell_funnel_data', true );

		$product_found_in_funnel = false;

		if ( ! empty( $funnel_data ) && is_array( $funnel_data ) && count( $funnel_data ) ) {

			$funnel_id = $funnel_data['funnel_id'];
			$offer_id = $funnel_data['offer_id'];

			// Get all funnels.
			$all_funnels = get_option( 'mwb_wocuf_funnels_list', array() );

			$product_id = ! empty( $all_funnels[ $funnel_id ]['mwb_wocuf_products_in_offer'][ $offer_id ] ) ? $all_funnels[ $funnel_id ]['mwb_wocuf_products_in_offer'][ $offer_id ] : '';

			if ( ! empty( $product_id ) ) {

				$product_found_in_funnel = true;
				return $product_id;
			}
		}

		// Get global product only for Custom Offer page and not for Upsell offer templates.
		if ( empty( $funnel_data ) && ! $product_found_in_funnel ) {

			$mwb_upsell_global_settings = get_option( 'mwb_upsell_lite_global_options', array() );

			$product_id = ! empty( $mwb_upsell_global_settings['global_product_id'] ) ? $mwb_upsell_global_settings['global_product_id'] : '';

			if ( ! empty( $product_id ) ) {

				return $product_id;
			}
		}

		// Product not selected alert, will run one time in one reload.
		if ( false === wp_cache_get( 'mwb_upsell_no_product_in_offer' ) ) {

			$product_not_selected_alert = esc_html__( 'One Click Upsell', 'woocommerce_one_click_upsell_funnel' );

			// For Upsell offer template.
			if( ! empty( $funnel_data ) ) {

				$product_not_selected_content = esc_html__( 'Offer Product is not selected, please save a Offer Product in Funnel Offer settings.', 'woocommerce_one_click_upsell_funnel' );
			}

			// For Custom offer page.
			else {

				$product_not_selected_content = esc_html__( 'Custom Offer page - detected! Please save a global Offer product in Global settings for testing purpose.', 'woocommerce_one_click_upsell_funnel' );
			}

			

			?>

			<script src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . 'js/sweet-alert.js' ); ?>"></script>

			<script type="text/javascript">

				var product_not_selected_alert = '<?php echo esc_html( $product_not_selected_alert ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped It just displayes message that is already escaped above. ?>';

				var product_not_selected_content = '<?php echo esc_html( $product_not_selected_content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped It just displayes message that is already escaped above. ?>';

				swal( product_not_selected_alert , product_not_selected_content, 'warning' )
				
			</script>

			<?php
		}

		wp_cache_set( 'mwb_upsell_no_product_in_offer', 'true' );

	}

	/**
	 * Validate shortcode for rendering content according to user( live offer )
	 * and admin ( for viewing purpose ).
	 *
	 * @since    3.0.0
	 */
	public function validate_shortcode() {

		if ( isset( $_GET['ocuf_ns'] ) && isset( $_GET['ocuf_ok'] ) && isset( $_GET['ocuf_ofd'] ) && isset( $_GET['ocuf_fid'] ) ) {

			if ( mwb_upsell_lite_validate_upsell_nonce() ) {

				return 'live_offer';
			}
		} elseif ( current_user_can( 'manage_options' ) ) {

			return 'admin_view';
		}

		return false;
	}

	/**
	 * Shortcode for Upsell product title.
	 * Returns : Just the Content :)
	 *
	 * @since       3.0.0
	 */
	public function product_title_shortcode_content( $atts, $content = '' ) {

		$validate_shortcode = $this->validate_shortcode();

		if ( $validate_shortcode ) {

			$product_id = $this->get_upsell_product_id_for_shortcode();

			if ( ! empty( $product_id ) ) {

				$post_type = get_post_type( $product_id );

				if ( 'product' != $post_type && 'product_variation' != $post_type ) {

					return '';
				}

				$upsell_product = wc_get_product( $product_id );

				$upsell_product_title = $upsell_product->get_title();
				$upsell_product_title = ! empty( $upsell_product_title ) ? $upsell_product_title : '';

				return $upsell_product_title;
			}
		}

	}

	/**
	 * Shortcode for Upsell product description.
	 * Returns : Just the Content :)
	 *
	 * @since       3.0.0
	 */
	public function product_description_shortcode_content( $atts, $content = '' ) {

		$validate_shortcode = $this->validate_shortcode();

		if ( $validate_shortcode ) {

			$product_id = $this->get_upsell_product_id_for_shortcode();

			if ( ! empty( $product_id ) ) {

				$post_type = get_post_type( $product_id );

				if ( 'product' != $post_type && 'product_variation' != $post_type ) {

					return '';
				}

				$upsell_product = wc_get_product( $product_id );

				$upsell_product_desc = $upsell_product->get_description();
				$upsell_product_desc = ! empty( $upsell_product_desc ) ? $upsell_product_desc : '';

				return $upsell_product_desc;
			}
		}

	}

	/**
	 * Shortcode for Upsell product short description.
	 * Returns : Just the Content :)
	 *
	 * @since       3.0.0
	 */
	public function product_short_description_shortcode_content( $atts, $content = '' ) {

		$validate_shortcode = $this->validate_shortcode();

		if ( $validate_shortcode ) {

			$product_id = $this->get_upsell_product_id_for_shortcode();

			if ( ! empty( $product_id ) ) {

				$post_type = get_post_type( $product_id );

				if ( 'product' != $post_type && 'product_variation' != $post_type ) {

					return '';
				}

				$upsell_product = wc_get_product( $product_id );

				$upsell_product_short_desc = $upsell_product->get_short_description();
				$upsell_product_short_desc = ! empty( $upsell_product_short_desc ) ? $upsell_product_short_desc : '';

				return $upsell_product_short_desc;
			}
		}

	}

	/**
	 * Shortcode for Upsell product image.
	 *
	 * @since       3.0.0
	 */
	public function product_image_shortcode_content( $atts, $content = '' ) {

		$validate_shortcode = $this->validate_shortcode();

		if ( $validate_shortcode ) {

			$live_params_from_url = mwb_upsell_lite_get_pid_from_url_params();

			if( ! empty( $live_params_from_url[ 'status' ] ) && 'true' == $live_params_from_url[ 'status' ] ) {

				$offer_id = ! empty( $live_params_from_url[ 'offer_id' ] ) ? wc_clean( $live_params_from_url[ 'offer_id' ] ) : '';
				$funnel_id = ! empty( $live_params_from_url[ 'funnel_id' ] ) ? wc_clean( $live_params_from_url[ 'funnel_id' ] ) : '';

				if( ! empty( $funnel_id ) && ! empty( $offer_id ) ) {

					$all_funnels = get_option( 'mwb_wocuf_funnels_list', array() );

					$upsell_product_image_post_id = !empty( $all_funnels[$funnel_id]['mwb_upsell_offer_image'][$offer_id] ) ? $all_funnels[$funnel_id]['mwb_upsell_offer_image'][$offer_id] : '';

					if( ! empty( $upsell_product_image_post_id ) ) {

						$image_attributes = wp_get_attachment_image_src( $upsell_product_image_post_id, 'full' );

						$upsell_product_image_src = ! empty( $image_attributes[0] ) && filter_var( $image_attributes[0], FILTER_VALIDATE_URL ) ? $image_attributes[0] : false;
					}

					if( ! empty( $upsell_product_image_src ) && getimagesize( $upsell_product_image_src ) ) {

						// Shortcode attributes.
						$atts = shortcode_atts( array(
							'id' 	=> '',
							'class' => '',
							'style' => '',
						), $atts );

						$id = $atts['id'];
						$class = $atts['class'];
						$style = $atts['style'];

						$upsell_product_image_src_div = 
							"<div id='$id' class='mwb_upsell_offer_product_image $class' style='$style'>
								<img src='$upsell_product_image_src'>
							</div>";
						
						return $upsell_product_image_src_div;
					}
				}
			}

			$product_id = $this->get_upsell_product_id_for_shortcode();

			if ( ! empty( $product_id ) ) {

				$post_type = get_post_type( $product_id );

				if ( 'product' != $post_type && 'product_variation' != $post_type ) {

					return '';
				}

				$upsell_product_image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'full' );

				$upsell_product_image_src = ! empty( $upsell_product_image[0] ) ? $upsell_product_image[0] : wc_placeholder_img_src();

				// Shortcode attributes.
				$atts = shortcode_atts(
					array(
						'id'    => '',
						'class' => '',
						'style' => '',
					),
					$atts
				);

				$id = $atts['id'];
				$class = $atts['class'];
				$style = $atts['style'];

				$upsell_product_image_src_div =
					"<div id='$id' class='mwb_upsell_offer_product_image $class' style='$style'>
						<img src='$upsell_product_image_src'>
					</div>";

				return $upsell_product_image_src_div;
			}
		}
	}

	/**
	 * Shortcode for Upsell product price.
	 *
	 * @since       3.0.0
	 */
	public function product_price_shortcode_content( $atts, $content = '' ) {

		$validate_shortcode = $this->validate_shortcode();

		if ( $validate_shortcode ) {

			$product_id = $this->get_upsell_product_id_for_shortcode();

			if ( ! empty( $product_id ) ) {

				$post_type = get_post_type( $product_id );

				if ( 'product' != $post_type && 'product_variation' != $post_type ) {

					return '';
				}

				$upsell_product = wc_get_product( $product_id );

				// Get offer discount.
				$upsell_offered_discount = mwb_upsell_lite_get_product_discount();

				// Apply discount on product.
				if ( ! empty( $upsell_offered_discount ) ) {

					$upsell_product = $this->mwb_wocuf_pro_change_offered_product_price( $upsell_product, $upsell_offered_discount );
				}

				$upsell_product_price_html = $upsell_product->get_price_html();
				$upsell_product_price_html = ! empty( $upsell_product_price_html ) ? $upsell_product_price_html : '';

				// Remove amount class, as it changes price css wrt theme change.
				$upsell_product_price_html = str_replace( ' amount', ' mwb-upsell-amount', $upsell_product_price_html );

				// Shortcode attributes.
				$atts = shortcode_atts(
					array(
						'id'    => '',
						'class' => '',
						'style' => '',
					),
					$atts
				);

				$id = $atts['id'];
				$class = $atts['class'];
				$style = $atts['style'];

				$upsell_product_price_html_div =
					"<div id='$id' class='mwb_upsell_offer_product_price $class' style='$style'>
						$upsell_product_price_html</div>";

				return $upsell_product_price_html_div;
			}
		}
	}

	/**
	 * Shortcode for offer - Buy now button.
	 * Returns : Link :)
	 *
	 * Also Requires the ID to be applied on the link or button, for variable products only.
	 * Using this ID form is submitted from js.
	 *
	 * @since       3.0.0
	 */
	public function buy_now_shortcode_content( $atts, $content = '' ) {

		$validate_shortcode = $this->validate_shortcode();

		if ( $validate_shortcode ) {

			$product_id = $this->get_upsell_product_id_for_shortcode();

			if ( ! empty( $product_id ) ) {

				$post_type = get_post_type( $product_id );

				if ( 'product' != $post_type && 'product_variation' != $post_type ) {

					return '';
				}

				if ( 'live_offer' == $validate_shortcode ) {

					$upsell_product = wc_get_product( $product_id );

					if ( $upsell_product->is_type( 'variable' ) ) {

						// In this case buy now form ( in variation selector shortcode ) will be posted from js.
						$buy_now_link = '#mwb_upsell';
					} else {

						$wp_nonce = isset( $_GET['ocuf_ns'] ) ? sanitize_text_field( wp_unslash( $_GET['ocuf_ns'] ) ) : '';
						$order_key = isset( $_GET['ocuf_ok'] ) ? sanitize_text_field( wp_unslash( $_GET['ocuf_ok'] ) ) : '';
						$offer_id = isset( $_GET['ocuf_ofd'] ) ? sanitize_text_field( wp_unslash( $_GET['ocuf_ofd'] ) ) : '';
						$funnel_id = isset( $_GET['ocuf_fid'] ) ? sanitize_text_field( wp_unslash( $_GET['ocuf_fid'] ) ) : '';

						$buy_now_link = '?mwb_wocuf_pro_buy=true&ocuf_ns=' . $wp_nonce . '&ocuf_ok=' . $order_key . '&ocuf_ofd=' . $offer_id . '&ocuf_fid=' . $funnel_id . '&product_id=' . $product_id;
					}
				} elseif ( 'admin_view' == $validate_shortcode ) {

					$buy_now_link = '#preview';
				}

				return $buy_now_link;
			}
		}
	}

	/**
	 * Shortcode for offer - No thanks button.
	 * Returns : Link :)
	 *
	 * @since       3.0.0
	 */
	public function no_thanks_shortcode_content( $atts, $content = '' ) {

		$validate_shortcode = $this->validate_shortcode();

		if ( $validate_shortcode ) {

			$product_id = $this->get_upsell_product_id_for_shortcode();

			if ( ! empty( $product_id ) ) {

				$post_type = get_post_type( $product_id );

				if ( 'product' != $post_type && 'product_variation' != $post_type ) {

					return '';
				}

				if ( 'live_offer' == $validate_shortcode ) {

					$wp_nonce = isset( $_GET['ocuf_ns'] ) ? sanitize_text_field( wp_unslash( $_GET['ocuf_ns'] ) ) : '';
					$order_key = isset( $_GET['ocuf_ok'] ) ? sanitize_text_field( wp_unslash( $_GET['ocuf_ok'] ) ) : '';
					$offer_id = isset( $_GET['ocuf_ofd'] ) ? sanitize_text_field( wp_unslash( $_GET['ocuf_ofd'] ) ) : '';
					$funnel_id = isset( $_GET['ocuf_fid'] ) ? sanitize_text_field( wp_unslash( $_GET['ocuf_fid'] ) ) : '';

					$no_thanks_link = '?ocuf_ns=' . $wp_nonce . '&ocuf_th=1&ocuf_ok=' . $order_key . '&ocuf_ofd=' . $offer_id . '&ocuf_fid=' . $funnel_id;


				} elseif ( 'admin_view' == $validate_shortcode ) {

					$no_thanks_link = '#preview';
				}

				return $no_thanks_link;
			}
		}
	}

	/**
	 * Shortcode for offer - product variations.
	 *
	 * @since       3.0.0
	 */
	public function variations_selector_shortcode_content( $atts, $content = '' ) {

		return '';
	}

	/**
	 * Shortcode for star review.
	 * Returns : star review html.
	 *
	 * @since       3.0.0
	 */
	public function product_star_review( $atts, $content = '' ) {

		$stars = ! empty( $atts['stars'] ) ? abs( $atts['stars'] ) : '5';

		$stars = ( $stars >= 1 && $stars <= 5 ) ? $stars : '5';

		$stars_percent = $stars * 20;

		$review_html = '<div class="mwb-upsell-star-rating"><span style="width: ' . $stars_percent . '%;"></div>';

		return $review_html;

	}

	/**
	 * Shortcode for Default Gutenberg offer identification.
	 * Returns : empty string.
	 *
	 * @since       3.0.0
	 */
	public function default_offer_identification() {

		return '';

	}

	/**
	 * creating shortcode for special price on custom page
	 *
	 * @since       1.0.0
	 * @param       $atts           attributes of the shortcode
	 * @param       $content        content under wrapping mode
	 */
	public function mwb_wocuf_pro_custom_page_product_offer_price( $atts, $content = '' ) {
		$atts = shortcode_atts(
			array(
				'style'     => '',
				'class'     => '',
			),
			$atts
		);

		return $this->mwb_wocuf_pro_custom_page_offer_price_for_all(
			array(
				'style'     => $atts['style'],
				'class'     => $atts['class'],
			),
			$content
		);
	}

	/**
	 * creating shortcode for yes link on custom page
	 *
	 * @since       1.0.0
	 * @param       $atts           attributes of the shortcode
	 * @param       $content        content under wrapping mode
	 */
	public function mwb_wocuf_pro_custom_page_action_link_yes( $atts, $content = '' ) {
		$atts = shortcode_atts(
			array(
				'style'     => '',
				'class'     => '',
			),
			$atts
		);

		return $this->mwb_wocuf_pro_custom_page_yes_link_for_all(
			array(
				'style'     => $atts['style'],
				'class'     => $atts['class'],
			),
			$content
		);
	}

	/**
	 * creating shortcode for showing order details page
	 *
	 * @since       1.0.0
	 * @param       $atts           attributes of the shortcode
	 * @param       $content        content under wrapping mode
	 */
	public function mwb_wocuf_pro_custom_page_order_details_link( $atts, $content = '' ) {
		$atts = shortcode_atts(
			array(
				'style'     => '',
				'class'     => '',
			),
			$atts
		);

		return $this->mwb_wocuf_pro_custom_page_order_details_link_for_all(
			array(
				'style'     => $atts['style'],
				'class'     => $atts['class'],
			),
			$content
		);
	}

	/**
	 * Showing order details at thankyou page.
	 *
	 * @since       1.0.0
	 * @param       $atts           attributes of the shortcode
	 * @param       $content        content under wrapping mode
	 */
	public function mwb_wocuf_pro_custom_page_order_details_link_for_all( $atts, $content = '' ) {
		$result = '';

		if ( empty( $atts['style'] ) ) {
			$atts['style'] = '';
		}

		if ( empty( $atts['class'] ) ) {
			$atts['class'] = '';
		}

		if ( empty( $content ) ) {
			$content = esc_html__( 'Show Order Details', 'woocommerce_one_click_upsell_funnel' );
			$content = apply_filters( 'mwb_wocuf_pro_order_details_link_text', $content );
		}

		$order_key = isset( $_GET['ocuf_ok'] ) ? sanitize_text_field( wp_unslash( $_GET['ocuf_ok'] ) ) : '';

		$order_id = wc_get_order_id_by_order_key( $order_key );

		$order_received_url = wc_get_endpoint_url( 'order-received', $order_id, wc_get_page_permalink( 'checkout' ) );

		$order_received_url = add_query_arg( 'key', $order_key, $order_received_url );

		$result = '<a href="' . $order_received_url . '" class="button' . $atts['class'] . '" style="' . $atts['style'] . '">' . $content . '</a>';

		return $result;
	}

	/**
	 * Internal functioning of price shortcode.
	 *
	 * @since       1.0.0
	 * @param       $atts           attributes of the shortcode
	 * @param       $content        content under wrapping mode
	 */
	public function mwb_wocuf_pro_custom_page_offer_price_for_all( $atts, $content = '' ) {
		 $result = '';

		if ( empty( $atts['style'] ) ) {
			$atts['style'] = '';
		}

		if ( empty( $atts['class'] ) ) {
			$atts['class'] = '';
		}

		$offer_id = isset( $_GET['ocuf_ofd'] ) ? sanitize_text_field( wp_unslash( $_GET['ocuf_ofd'] ) ) : '';

		$funnel_id = isset( $_GET['ocuf_fid'] ) ? sanitize_text_field( wp_unslash( $_GET['ocuf_fid'] ) ) : '';

		$order_key = isset( $_GET['ocuf_ok'] ) ? sanitize_text_field( wp_unslash( $_GET['ocuf_ok'] ) ) : '';

		$wp_nonce = isset( $_GET['ocuf_ns'] ) ? sanitize_text_field( wp_unslash( $_GET['ocuf_ns'] ) ) : '';

		$order_id = wc_get_order_id_by_order_key( $order_key );

		$mwb_wocuf_pro_all_funnels = get_option( 'mwb_wocuf_funnels_list', array() );

		$mwb_wocuf_pro_before_offer_price_text = get_option( 'mwb_wocuf_pro_before_offer_price_text', esc_html__( 'Special Offer Price', 'woocommerce_one_click_upsell_funnel' ) );

		$mwb_wocuf_pro_offered_products = isset( $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_products_in_offer'] ) ? $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_products_in_offer'] : array();

		$mwb_wocuf_pro_offered_discount = isset( $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_offer_discount_price'] ) ? $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_offer_discount_price'] : array();

		$mwb_wocuf_pro_single_offered_product = '';

		if ( ! empty( $mwb_wocuf_pro_offered_products[ $offer_id ] ) ) {

			// In v2.0.0, it was array so handling to get the first product id.
			if ( is_array( $mwb_wocuf_pro_offered_products[ $offer_id ] ) && count( $mwb_wocuf_pro_offered_products[ $offer_id ] ) ) {

				foreach ( $mwb_wocuf_pro_offered_products[ $offer_id ] as $handling_offer_product_id ) {

					$mwb_wocuf_pro_single_offered_product = absint( $handling_offer_product_id );
					break;
				}
			} else {

				$mwb_wocuf_pro_single_offered_product = absint( $mwb_wocuf_pro_offered_products[ $offer_id ] );
			}
		}

		if ( ! empty( $mwb_wocuf_pro_single_offered_product ) ) {

			$mwb_wocuf_pro_original_offered_product = wc_get_product( $mwb_wocuf_pro_single_offered_product );

			$mwb_wocuf_pro_offered_product = $this->mwb_wocuf_pro_change_offered_product_price( $mwb_wocuf_pro_original_offered_product, $mwb_wocuf_pro_offered_discount[ $offer_id ] );

			$product = $mwb_wocuf_pro_offered_product;

			$result .= '<div style="' . $atts['style'] . '" class="mwb_wocuf_pro_custom_offer_price ' . $atts['class'] . '">' . $mwb_wocuf_pro_before_offer_price_text . ' : ' . $product->get_price_html() . '</div>';

		} else {
			$result .= '<div style="' . $atts['style'] . '" class="mwb_wocuf_pro_custom_offer_price ' . $atts['class'] . '">' . $content . '</div>';
		}

		return $result;
	}

	/**
	 * Internal functioning of yes link shortcode.
	 *
	 * @since       1.0.0
	 * @param       $atts           attributes of the shortcode
	 * @param       $content        content under wrapping mode
	 */
	public function mwb_wocuf_pro_custom_page_yes_link_for_all( $atts, $content = '' ) {
		$result = '';

		if ( empty( $atts[0] ) ) {
			$atts[0] = 'yes';
		}

		if ( empty( $atts['style'] ) ) {
			$atts['style'] = '';
		}

		if ( empty( $atts['class'] ) ) {
			$atts['class'] = '';
		}

		$mwb_wocuf_pro_all_funnels = get_option( 'mwb_wocuf_funnels_list', array() );

		$mwb_wocuf_pro_buy_text = get_option( 'mwb_wocuf_pro_buy_text', esc_html__( 'Add to my order', 'woocommerce_one_click_upsell_funnel' ) );

		if ( empty( $content ) ) {
			$content = $mwb_wocuf_pro_buy_text;
		}

		$offer_id = isset( $_GET['ocuf_ofd'] ) ? sanitize_text_field( wp_unslash( $_GET['ocuf_ofd'] ) ) : '';

		$funnel_id = isset( $_GET['ocuf_fid'] ) ? sanitize_text_field( wp_unslash( $_GET['ocuf_fid'] ) ) : '';

		$order_key = isset( $_GET['ocuf_ok'] ) ? sanitize_text_field( wp_unslash( $_GET['ocuf_ok'] ) ) : '';

		$wp_nonce = isset( $_GET['ocuf_ns'] ) ? sanitize_text_field( wp_unslash( $_GET['ocuf_ns'] ) ) : '';

		$order_id = wc_get_order_id_by_order_key( $order_key );

		$mwb_wocuf_pro_offered_products = isset( $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_products_in_offer'] ) ? $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_products_in_offer'] : array();

		$mwb_wocuf_pro_offered_discount = isset( $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_offer_discount_price'] ) ? $mwb_wocuf_pro_all_funnels[ $funnel_id ]['mwb_wocuf_offer_discount_price'] : array();

		$mwb_wocuf_pro_single_offered_product = '';

		if ( ! empty( $mwb_wocuf_pro_offered_products[ $offer_id ] ) ) {

			// In v2.0.0, it was array so handling to get the first product id.
			if ( is_array( $mwb_wocuf_pro_offered_products[ $offer_id ] ) && count( $mwb_wocuf_pro_offered_products[ $offer_id ] ) ) {

				foreach ( $mwb_wocuf_pro_offered_products[ $offer_id ] as $handling_offer_product_id ) {

					$mwb_wocuf_pro_single_offered_product = absint( $handling_offer_product_id );
					break;
				}
			} else {

				$mwb_wocuf_pro_single_offered_product = absint( $mwb_wocuf_pro_offered_products[ $offer_id ] );
			}
		}

		if ( ! empty( $mwb_wocuf_pro_single_offered_product ) ) {

			$mwb_wocuf_pro_original_offered_product = wc_get_product( $mwb_wocuf_pro_single_offered_product );

			$mwb_wocuf_pro_offered_product = $this->mwb_wocuf_pro_change_offered_product_price( $mwb_wocuf_pro_original_offered_product, $mwb_wocuf_pro_offered_discount[ $offer_id ] );

			$product = $mwb_wocuf_pro_offered_product;

			$result .= '<form method="post" class="mwb_wocuf_pro_custom_offer">
							<input type="hidden" name="ocuf_ns" value="' . $wp_nonce . '">
							<input type="hidden" name="ocuf_fid" value="' . $funnel_id . '">
							<input type="hidden" name="product_id" class="mwb_wocuf_pro_variation_id" value="' . absint( $product->get_id() ) . '">
							<input type="hidden" name="ocuf_ofd" value="' . $offer_id . '">
							<input type="hidden" name="ocuf_ok" value="' . $order_key . '">
							<input type="hidden" name="mwb_wocuf_post_nonce" value="' . wp_create_nonce( 'mwb_wocuf_field_post_nonce' ) . '">
							<input type="hidden" name="mwb_wocuf_after_post_nonce" value="' . wp_create_nonce( 'mwb_wocuf_after_field_post_nonce' ) . '">
							<button style="' . $atts['style'] . '" class="mwb_wocuf_pro_custom_buy ' . $atts['class'] . '" type="submit" onclick="" name="mwb_wocuf_pro_buy">' . $content . '</button>
						</form>';

		} else {
			$result .= '<form method="post" class="mwb_wocuf_pro_custom_offer">
						<input type="hidden" name="ocuf_ns" value="' . $wp_nonce . '">
						<input type="hidden" name="ocuf_fid" value="' . $funnel_id . '">
						<input type="hidden" name="product_id" class="mwb_wocuf_pro_variation_id" value="">
						<input type="hidden" name="ocuf_ofd" value="' . $offer_id . '">
						<input type="hidden" name="ocuf_ok" value="' . $order_key . '">
						<input type="hidden" name="mwb_wocuf_post_nonce" value="' . wp_create_nonce( 'mwb_wocuf_field_post_nonce' ) . '">
						<input type="hidden" name="mwb_wocuf_after_post_nonce" value="' . wp_create_nonce( 'mwb_wocuf_after_field_post_nonce' ) . '">
						<button style="' . $atts['style'] . '" class="mwb_wocuf_pro_custom_buy ' . $atts['class'] . '" type="submit" name="mwb_wocuf_pro_buy">' . $content . '</button>
					</form>';
		}

		return $result;
	}

	/**
	 * creating shortcode for thanks link on custom page.
	 *
	 * @since       1.0.0
	 * @param       $atts           attributes of the shortcode
	 * @param       $content        content under wrapping mode
	 */
	public function mwb_wocuf_pro_custom_page_action_link_no( $atts, $content = '' ) {
		$atts = shortcode_atts(
			array(
				'style'     => '',
				'class'     => '',
			),
			$atts
		);

		return $this->mwb_wocuf_pro_custom_page_no_link_for_all(
			array(
				'style'     => $atts['style'],
				'class'     => $atts['class'],
			),
			$content
		);
	}

	/**
	 * creating shortcode for thanks link on custom page for simple as well variable product
	 *
	 * @since       1.0.0
	 * @param       $atts           attributes of the shortcode
	 * @param       $content        content under wrapping mode
	 */
	public function mwb_wocuf_pro_custom_page_no_link_for_all( $atts, $content = '' ) {
		$result = '';

		if ( empty( $atts['style'] ) ) {
			$atts['style'] = '';
		}

		if ( empty( $atts['class'] ) ) {
			$atts['class'] = '';
		}

		$offer_id = isset( $_GET['ocuf_ofd'] ) ? sanitize_text_field( wp_unslash( $_GET['ocuf_ofd'] ) ) : '';

		$funnel_id = isset( $_GET['ocuf_fid'] ) ? sanitize_text_field( wp_unslash( $_GET['ocuf_fid'] ) ) : '';

		$order_key = isset( $_GET['ocuf_ok'] ) ? sanitize_text_field( wp_unslash( $_GET['ocuf_ok'] ) ) : '';

		$wp_nonce = isset( $_GET['ocuf_ns'] ) ? sanitize_text_field( wp_unslash( $_GET['ocuf_ns'] ) ) : '';

		$order_id = wc_get_order_id_by_order_key( $order_key );

		$th = 1;

		$mwb_wocuf_pro_no_text = get_option( 'mwb_wocuf_pro_no_text', esc_html__( 'No,thanks', 'woocommerce_one_click_upsell_funnel' ) );

		if ( empty( $content ) ) {
			$content = $mwb_wocuf_pro_no_text;
		}

		if ( ! empty( $offer_id ) && ! empty( $order_key ) && ! empty( $wp_nonce ) ) {
			$result .= '<a style="' . $atts['style'] . '" class="mwb_wocuf_pro_no mwb_wocuf_pro_custom_skip ' . $atts['class'] . '" href="?ocuf_ns=' . $wp_nonce . '&ocuf_th=1&ocuf_ok=' . $order_key . '&ocuf_ofd=' . $offer_id . '&ocuf_fid=' . $funnel_id . '">' . $content . '</a>';
		} else {
			$result .= '<a style="' . $atts['style'] . '" class="mwb_wocuf_pro_custom_skip ' . $atts['class'] . '" href="">' . $content . '</a>';
		}

		return $result;
	}

	/**
	 * Remove all styles from offer pages
	 *
	 * @since    3.0.0
	 */
	public function remove_styles_offer_pages() {

		$saved_offer_post_ids = get_option( 'mwb_upsell_lite_offer_post_ids', array() );

		if ( ! empty( $saved_offer_post_ids ) && is_array( $saved_offer_post_ids ) && count( $saved_offer_post_ids ) ) {

			global $post;

			if ( ! empty( $post->ID ) && in_array( $post->ID, $saved_offer_post_ids ) ) {

				global $wp_styles;

				// To dequeue all styles.
				// $wp_styles->queue = array();

				// To dequeue all wp-content styles.
				foreach ( $wp_styles->registered as $k => $s ) {

					if ( mb_strpos( $s->src, 'wp-content/' ) ) {

						// Except for upsell and elementor plugins.
						if ( mb_strpos( $s->src, 'elementor' ) || mb_strpos( $s->src, 'woocommerce-one-click-upsell-funnel' ) ) {

							continue;
						}

						wp_deregister_style( $k );
					}
				}

				global $wp_scripts;

				// To dequeue all theme scripts.
				foreach ( $wp_scripts->registered as $k => $s ) {

					if ( mb_strpos( $s->src, 'wp-content/themes/' ) ) {

						wp_deregister_script( $k );
					}
				}

				?>

				<style type="text/css">
					
					body{
						margin: auto;
					}
				</style>

				<?php
			}
		}
	}

	/**
	 * Hide upsell offer pages from nav menu front-end.
	 *
	 * @since    3.0.0
	 */
	public function exclude_pages_from_front_end( $args ) {

		$saved_offer_post_ids = get_option( 'mwb_upsell_lite_offer_post_ids', array() );

		if ( ! empty( $saved_offer_post_ids ) && is_array( $saved_offer_post_ids ) && count( $saved_offer_post_ids ) ) {

			$exclude_pages = $saved_offer_post_ids;
			$exclude_pages_ids = '';

			foreach ( $exclude_pages as $_post_id ) {

				if ( $exclude_pages_ids != '' ) {

					$exclude_pages_ids .= ', ';
				}

				$exclude_pages_ids .= $_post_id;
			}

			if ( ! empty( $args['exclude'] ) ) {

				$args['exclude'] .= ',';
			} else {

				$args['exclude'] = '';
			}

			$args['exclude'] .= $exclude_pages_ids;

		}

		return $args;
	}

	/**
	 * Hide upsell offer pages from added menu list in customizer and admin panel.
	 *
	 * @since    3.0.0
	 */
	public function exclude_pages_from_menu_list( $items, $menu, $args ) {

		$saved_offer_post_ids = get_option( 'mwb_upsell_lite_offer_post_ids', array() );

		if ( ! empty( $saved_offer_post_ids ) && is_array( $saved_offer_post_ids ) && count( $saved_offer_post_ids ) ) {

			$exclude_pages = $saved_offer_post_ids;
			$exclude_pages_ids = array();

			foreach ( $exclude_pages as $_post_id ) {

				array_push( $exclude_pages_ids, $_post_id );
			}

			if ( ! empty( $exclude_pages_ids ) ) {

				foreach ( $items as $key => $item ) {

					if ( in_array( $item->object_id, $exclude_pages_ids ) ) {

						unset( $items[ $key ] );
					}
				}
			}
		}

		return $items;
	}

	/**
	 * Redirect upsell offer pages if not admin or upsell nonce expired.
	 *
	 * @since    3.0.0
	 */
	public function upsell_offer_page_redirect() {

		$saved_offer_post_ids = get_option( 'mwb_upsell_lite_offer_post_ids', array() );

		if ( ! empty( $saved_offer_post_ids ) && is_array( $saved_offer_post_ids ) && count( $saved_offer_post_ids ) ) {

			global $post;

			// When current page is one of the upsell offer page.
			if ( ! empty( $post->ID ) && in_array( $post->ID, $saved_offer_post_ids ) ) {

				$validate_shortcode = $this->validate_shortcode();

				if ( false === $validate_shortcode ) {

					$this->expire_offer();

				}
			}
		}

	}

	/**
	 * Expire offer and show return to shop link.
	 *
	 * @since    2.0.0
	 */
	private function expire_offer() {

		$shop_page_url = function_exists( 'wc_get_page_id' ) ? get_permalink( wc_get_page_id( 'shop' ) ) : get_permalink( woocommerce_get_page_id( 'shop' ) );

		$result = '<div style="text-align: center;margin-top: 30px;" id="mwb_upsell_offer_expired"><h2 style="font-weight: 200;">' . esc_html__( 'Sorry, Offer expired.', 'woocommerce_one_click_upsell_funnel' ) . '</h2><a class="button wc-backward" href="' . esc_url( $shop_page_url ) . '">' . esc_html__( 'Return to Shop ', 'woocommerce_one_click_upsell_funnel' ) . '&rarr;</a></div>';

		echo $result; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped It just displayes the html itself. Content in it is already escaped.

		wp_die();
	}

	/**
	 * Handle Upsell Orders on Thankyou for Success Rate and Stats.
	 *
	 * @since    3.0.0
	 */
	public function upsell_sales_by_funnel_handling( $order_id ) {

		if( ! $order_id ) {

			return;
		}

		// Process once and only for Upsells.
		$funnel_id = get_post_meta( $order_id, 'mwb_upsell_funnel_id', true );

		if( empty( $funnel_id ) ) {

			return;
		}

		$order = new WC_Order( $order_id );

		if( empty( $order ) ) {

			return;
		}

		$processed_order_statuses = array(
				'processing',
				'completed',
				'on-hold',
			);

		if( ! in_array( $order->get_status(), $processed_order_statuses ) ) {

			return;
		}

		$order_items = $order->get_items();

		if( ! empty( $order_items ) && is_array( $order_items ) ) {

			$upsell_purchased = false;
			$upsell_item_total = 0;

			foreach ( $order_items as $item_id => $single_item ) {

				if( ! empty( wc_get_order_item_meta( $item_id, 'is_upsell_purchase', true ) ) ) {

					$upsell_purchased = true;
					$upsell_item_total += wc_get_order_item_meta( $item_id, '_line_total', true );
				}
			}
		}

		if( $upsell_purchased ) {

			// Add Funnel Success count and Total Sales for the current Funnel.
			$Sales_By_Funnel = new Mwb_Upsell_Report_Sales_By_Funnel( $funnel_id );

			$Sales_By_Funnel->add_funnel_success_count();
			$Sales_By_Funnel->add_funnel_total_sales( $upsell_item_total );
		}

		

		/**
		 * Delete Funnel id so that this is processed only once and funnel id
		 * might change so no need to associate the order with it.
		 */
		delete_post_meta( $order_id, 'mwb_upsell_funnel_id' );
	}

	/**
	 * Global Custom CSS.
	 *
	 * @since    3.0.0
	 */
	public function global_custom_css() {

		// Ignore admin, feed, robots or trackbacks.
		if ( is_admin() || is_feed() || is_robots() || is_trackback() ) {

			return;
		}

		$mwb_upsell_global_settings = get_option( 'mwb_upsell_lite_global_options', array() );

		$global_custom_css = ! empty( $mwb_upsell_global_settings['global_custom_css'] ) ? $mwb_upsell_global_settings['global_custom_css'] : '';

		if ( empty( $global_custom_css ) ) {

			return;
		}

		?>

		<style type="text/css">

			<?php
			echo wp_unslash( $global_custom_css ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped It just displayes the html itself. Content in it is already escaped if required.

			?>

		</style>

		<?php
	}

	/**
	 * Global Custom JS.
	 *
	 * @since    3.0.0
	 */
	public function global_custom_js() {

		// Ignore admin, feed, robots or trackbacks.
		if ( is_admin() || is_feed() || is_robots() || is_trackback() ) {

			return;
		}

		$mwb_upsell_global_settings = get_option( 'mwb_upsell_lite_global_options', array() );

		$global_custom_js = ! empty( $mwb_upsell_global_settings['global_custom_js'] ) ? $mwb_upsell_global_settings['global_custom_js'] : '';

		if ( empty( $global_custom_js ) ) {

			return;
		}

		?>

		<script type="text/javascript">

			<?php
				echo wp_unslash( $global_custom_js ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped It just displayes the html itself. Content in it is already escaped if required.
			?>

		</script>

		<?php

	}

	/**
	 * Shortcode for offer - Timer button.
	 * Returns : html :)
	 *
	 * 
	 *
	 * @since       2.1.0
	 */
	public function timer_shortcode_content( $atts, $content = '' ) {
		
		$validate_shortcode = $this->validate_shortcode();

		if ( $validate_shortcode ) {

			$minutes = ! empty( $atts['minutes'] ) ? abs( $atts['minutes'] ) : 5;
			$expiration = $minutes * 60;

			if( empty( $expiration ) || ! is_numeric( $expiration ) ) {

				return esc_html__( 'Time is not specified correctly.', 'woocommerce-one-click-upsell-funnel-pro' ); 
			}

			?>

			<?php ob_start(); ?>

			<?php if( false === wp_cache_get( 'mwb_upsell_countdown_timer' ) ): ?>

				<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

				<script type="text/javascript">

					jQuery(document).ready(function($) {

						// Set the date we're counting down to.
						var current = new Date();
						var expiration = parseFloat( <?php echo( esc_html__( $expiration ) ); ?> ); // Digit in seconds.
						var offer_id = <?php echo ! empty( $_GET[ 'ocuf_ofd' ] ) ? $_GET[ 'ocuf_ofd' ] : 'null' ; ?>;

						var timer_limit = sessionStorage.getItem( 'timerlimit_' + offer_id );
						var countDowntime = null != offer_id && null != timer_limit ? timer_limit : current.setSeconds( current.getSeconds()+expiration );

						// Update the count down every 1 second.
						var  timer  = setInterval(function() {

							// Find the distance between now and the count down time.
							var distance = countDowntime - new Date().getTime();

							// Time calculations for days, hours, minutes and seconds
							var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
							var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
							var seconds = Math.floor((distance % (1000 * 60)) / 1000);

							// If the count down is finished, redirect;
							if ( distance < 0 ) {

								clearInterval( timer );

								// Expired the session before redirecting.
								$( 'a' ).each(function() {

									if( this.href.includes( 'ocuf_th' ) ) {
										
										jQuery( this )[0].click();
									}
								});

							} else {

								if( seconds.toString().length == '1' ) {

									seconds = '0' + seconds;

								} 

								if( minutes.toString().length == '1' ) {

									minutes = '0' + minutes;

								}

								$('.mwb_upsell_lite_display_hours').html( hours );
								$('.mwb_upsell_lite_display_minutes').html( minutes );
								$('.mwb_upsell_lite_display_seconds').html( seconds );

							}

						}, 300 );

						sessionStorage.setItem( 'timerlimit_' + offer_id, countDowntime );
					});
		
				</script>

				<?php wp_cache_set( 'mwb_upsell_countdown_timer', 'true' ) ?>

			<?php endif; ?>
			
			<!-- Countdown timer html. -->
			<span class="mwb_upsell_lite_display_timer_wrap">
				<span class="mwb_upsell_lite_timer_digit">
					<span class="mwb_upsell_lite_display_minutes mwb_upsell_lite_display_timer">00</span>
					<span class="mwb_upsell_lite_text"><?php esc_html_e( 'minutes', 'woocommerce-one-click-upsell-funnel-pro' ); ?></span>
				</span>
				<span class="mwb_upsell_lite_timer_digit">
					<span class="mwb_upsell_lite_display_timer_col">:</span>
				</span>
				<span class="mwb_upsell_lite_timer_digit">
					<span class="mwb_upsell_lite_display_seconds mwb_upsell_lite_display_timer">00</span>
					<span class="mwb_upsell_lite_text"><?php esc_html_e( 'seconds', 'woocommerce-one-click-upsell-funnel-pro' ); ?></span>
				</span>
			</span>

			<?php

			$output = ob_get_contents();
			ob_end_clean();

			return $output;
		}
	}

	/**
	 * Global Custom JS.
	 *
	 * @since   2.1.0
	 */
	public function reset_timer_session_data() {

		// Don this only on thank you page.
		if ( ! is_wc_endpoint_url( 'order-received' ) ) {

			return;
		}

		?>

		<script type="text/javascript">
			
			// Clear timestamp from SessionStorage.
			if( typeof sessionStorage !== 'undefined' && sessionStorage.length > 0 ) {

				// Must reduce these variable.
				sessionStorage.removeItem( 'timerlimit_1' );
				sessionStorage.removeItem( 'timerlimit_null' );

				for ( var i = 0; i < sessionStorage.length; i++ ) {

				    if( sessionStorage.key(i).search( 'timerlimit_' ) == 0 ) {

				    	sessionStorage.removeItem( sessionStorage.key(i) );
				    }
				}
			}
			
		</script>

		<?php
		
	}


	/**
	 * Shortcode for quantity.
	 * Returns : html :)
	 *
	 * Shows woocommerce quantity field. 
	 *
	 * @since       2.1.0
	 */
	public function quantity_shortcode_content( $atts, $content = '' ) {
		
		$validate_shortcode = $this->validate_shortcode();

		if ( $validate_shortcode ) {

			$maximum = ! empty( $atts['max'] ) ? abs( $atts['max'] ) : 3;
			$minimum = ! empty( $atts['min'] ) ? abs( $atts['min'] ) : 1;

			$product_id = $this->get_upsell_product_id_for_shortcode();

			if ( ! empty( $product_id ) ) {

				$post_type = get_post_type( $product_id );
				$product = wc_get_product( $product_id );

				if ( empty( $product ) ) {

					return '';
				}

				if ( 'product' != $post_type && 'product_variation' != $post_type ) {

					return '';
				}

				ob_start(); ?>
				
				<!-- Countdown timer html. -->
				<div class="mwb_upsell_quantity quantity">
					<label class="screen-reader-text" for="mwb_upsell_quantity_field"><?php echo esc_html( $product->get_title() ); ?></label>
					<input type="number" id="mwb_upsell_quantity_field" class="input-text qty text mwb_upsell_quantity_input" step="1" min="<?php echo( esc_html( $minimum ) ); ?>" max="<?php echo( esc_html( $maximum ) ); ?>" value="1" title="Qty" inputmode="numeric">
				</div>

				<?php

				$output = ob_get_contents();
				ob_end_clean();

				return $output;
			}
		}
	}


	/**
	 * Hide upsell Items meta string. 
	 *
	 * @since       2.1.0
	 */
	public function hide_order_item_formatted_meta_data( $formatted_meta ){

	    foreach( $formatted_meta as $key => $meta ) {

	    	if( ! empty( $meta->key ) && 'is_upsell_purchase' == $meta->key ) {

	    		unset( $formatted_meta[ $key ] );
	    	}
	    }

	    return $formatted_meta;
	}

	/**
	 * Skip offer product in case of the purchased in prevous orders.
	 *
	 * @param      string $offer_product_id    The Offer product id to check.
	 *
	 * @since    2.1.0
	 */
	public static function mwb_wocuf_skip_for_pre_order( $offer_product_id = '' ) {

		if ( empty( $offer_product_id ) ) {

			return;
		}

		$offer_product = wc_get_product( $offer_product_id );

		// In case the offer is variable parent then no need to check this.
		if ( ! empty( $offer_product ) && is_object( $offer_product ) && $offer_product->has_child() ) {

			return false;
		}

		// Current user ID.
		$customer_user_id = get_current_user_id();

		// Getting current customer orders.
		$order_statuses = array( 'wc-on-hold', 'wc-processing', 'wc-completed' );

		$customer_orders = get_posts(
			array(
				'numberposts' => -1,
				'fields' => 'ids', // Return only order ids.
				'meta_key' => '_customer_user',
				'meta_value' => $customer_user_id,
				'post_type' => wc_get_order_types(),
				'post_status' => $order_statuses,
				'order' => 'DESC', // Get last order first.
			)
		);

		// Past Orders.
		foreach ( $customer_orders as $key => $single_order_id ) {

			// Continue if order is not a valid one.
			if ( ! $single_order_id ) {

				continue;
			}

			$single_order = wc_get_order( $single_order_id );

			// Continue if Order object is not a valid one.
			if ( empty( $single_order ) || ! is_object( $single_order ) || is_wp_error( $single_order ) ) {

				continue;
			}

			$items_purchased = $single_order->get_items();

			foreach ( $items_purchased as $key => $single_item ) {

				$product_id = ! empty( $single_item['variation_id'] ) ? $single_item['variation_id'] : $single_item['product_id'];

				if ( $product_id == $offer_product_id ) {

					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Add tracking basecode for Google Analytics and Facebook Pixel.
	 *
	 * @since   2.1.0
	 */
	public function add_tracking_base_code() {

		/**
		 * Scripts used to implement Ecommerce Tracking.
		 * After v2.1.0
		 */
		$mwb_upsell_analytics_options = get_option( 'mwb_upsell_analytics_configuration', array() );

		$mwb_upsell_ga_analytics_config = ! empty( $mwb_upsell_analytics_options[ 'google-analytics' ] ) ? $mwb_upsell_analytics_options[ 'google-analytics' ] : array();

		$mwb_upsell_fb_pixel_config = ! empty( $mwb_upsell_analytics_options[ 'facebook-pixel' ] ) ? $mwb_upsell_analytics_options[ 'facebook-pixel' ] : array();

		// Get ID.
		$google_analytics_ID = ! empty( $mwb_upsell_ga_analytics_config[ 'mwb_upsell_enable_ga_account_id' ] ) ? sanitize_text_field( wp_unslash( $mwb_upsell_ga_analytics_config[ 'mwb_upsell_enable_ga_account_id' ] ) ) : '';

		$fb_pixel_ID = ! empty( $mwb_upsell_fb_pixel_config[ 'mwb_upsell_enable_pixel_account_id' ] ) ? sanitize_text_field( wp_unslash( $mwb_upsell_fb_pixel_config[ 'mwb_upsell_enable_pixel_account_id' ] ) ) : '';

		// GA Tracking.
		if( ! empty( $mwb_upsell_ga_analytics_config[ 'mwb_upsell_enable_ga_tracking' ] ) && 'yes' == $mwb_upsell_ga_analytics_config[ 'mwb_upsell_enable_ga_tracking' ] ) : ?>

			<!-- Google Analytics Basecode. -->
			<script>
				(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
				})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
			</script>
			<script>
				ga( 'create', '<?php echo( esc_html( $google_analytics_ID ) ); ?>', 'auto' );

				<?php esc_js( $this->mwb_print_ga_script( $mwb_upsell_ga_analytics_config, $mwb_upsell_fb_pixel_config ) ); ?>
			</script>
			<!-- End Google Analytics Basecode. -->
		<?php endif; ?>

		<?php

		// FB pixel Tracking.
		if( ! empty( $mwb_upsell_fb_pixel_config[ 'mwb_upsell_enable_pixel_tracking' ] ) && 'yes' == $mwb_upsell_fb_pixel_config[ 'mwb_upsell_enable_pixel_tracking' ] ) : ?>

			<!-- Facebook Pixel Code -->
			<script>
				!function(f,b,e,v,n,t,s)
				{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
				n.callMethod.apply(n,arguments):n.queue.push(arguments)};
				if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
				n.queue=[];t=b.createElement(e);t.async=!0;
				t.src=v;s=b.getElementsByTagName(e)[0];
				s.parentNode.insertBefore(t,s)}(window, document,'script',
				'https://connect.facebook.net/en_US/fbevents.js');
				fbq('init', '<?php echo( esc_html( $fb_pixel_ID ) ); ?>');
				fbq('track', 'PageView');
			</script>
			<noscript>
				<img height="1" width="1" style="display:none"
			src="https://www.facebook.com/tr?id=<?php echo( esc_html( $fb_pixel_ID ) ); ?>&ev=PageView&noscript=1"
			/>
			</noscript>
			<!-- End Facebook Pixel Code -->

		<?php endif;
	}

	public function get_analytics_localisation_data( $mwb_upsell_ga_analytics_config=array(),$mwb_upsell_fb_pixel_config=array() ) {
		
		global $post;

		/**
		 * Get current user role.
		 */
		$current_user = wp_get_current_user();
		if( ! empty( $current_user ) ) {
			$current_user_role = ! empty( $current_user->roles ) && is_array( $current_user->roles ) ? $current_user->roles : false;
		}

		/**
		 * Get current location.
		 */
		$current_location = false;
		if( is_shop() ) {
			$current_location = 'shop';
		} elseif ( is_single() ) {
			$current_location = 'product';
		} elseif ( is_cart() ) {
			$current_location = 'cart';
		} elseif ( is_checkout() && ! is_wc_endpoint_url('order-received') ) {
			$current_location = 'checkout';
		} elseif ( ! empty( $_GET[ 'ocuf_fid' ] ) ) {
			$current_location = 'upsell';
		} elseif ( is_wc_endpoint_url('order-received') && ! empty( $_GET[ 'key' ] ) ) {
			$current_location = 'thank-you';
		} elseif ( is_account_page() ) {
			$current_location = 'my-account';
		}

		/**
		 * Get current product at single product page.
		 */
		$current_product = false;
		if( is_single() && ! empty( $post ) && 'product' == $post->post_type ) {
			$current_product = wc_get_product( $post->ID );
		}

		/**
		 * Get current cart data at cart/checkout page.
		 */
		$current_cart_value = false;
		if( is_checkout() && ! empty( WC()->cart->get_cart_contents_count() ) ) {
			$current_cart_value = WC()->cart->total;
		}

		/**
		 * Get purchase event data at Upsell/Thank you page.
		 */
		if( ! empty( $current_location ) && in_array( $current_location, array( 'upsell', 'thank-you' ) ) ) {

			/**
			 * Get order id from live params.
			 * Check the payment method for same order and ensure tracking if required.
			 */
			$order_id = mwb_upsell_lite_get_order_id_from_live_param( $current_location );
			$where_to_trigger = mwb_upsell_lite_get_tracking_location( $order_id );

			if( $where_to_trigger == $current_location ) {

				$purchase_event_data = mwb_upsell_lite_get_purchase_data( $order_id, $current_location, 'pixel' );

				$ga_purchase_event_data = mwb_upsell_lite_get_purchase_data( $order_id, $current_location, 'google_analytics' );

				/** 
				 * Check if upsell Order.
				 * If needs to send seperate param then order payment will be pending.
				 */
				$is_upsell_purchased = get_post_meta( $order_id, 'mwb_wocuf_upsell_order', true );
				if( 'true' == $is_upsell_purchased ) {

					$upsell_purchase_event_data = mwb_upsell_lite_get_upsell_purchase_data( $order_id, $current_location );
				}
			}
		}

		return array(
				'google_analytics' => array(
					'is_ga_enabled'	=>	! empty( $mwb_upsell_ga_analytics_config[ 'mwb_upsell_enable_ga_tracking' ] ) && 'yes' == $mwb_upsell_ga_analytics_config[ 'mwb_upsell_enable_ga_tracking' ] ? 'true' : 'false',
					'ga_account_id'	=>	! empty( $mwb_upsell_ga_analytics_config[ 'mwb_upsell_enable_ga_account_id' ] ) ? sanitize_text_field( wp_unslash( $mwb_upsell_ga_analytics_config[ 'mwb_upsell_enable_ga_account_id' ] ) ) : '',
					'enable_purchase_event'	=>	! empty( $mwb_upsell_ga_analytics_config[ 'mwb_upsell_enable_purchase_event' ] ) ? sanitize_text_field( wp_unslash( $mwb_upsell_ga_analytics_config[ 'mwb_upsell_enable_purchase_event' ] ) ) : 'no',
					'enable_pageview_event'	=>	! empty( $mwb_upsell_ga_analytics_config[ 'mwb_upsell_enable_pageview_event' ] ) ? sanitize_text_field( wp_unslash( $mwb_upsell_ga_analytics_config[ 'mwb_upsell_enable_pageview_event' ] ) ) : 'no',
					'enable_debug_mode'	=>	! empty( $mwb_upsell_ga_analytics_config[ 'mwb_upsell_enable_debug_mode' ] ) ? sanitize_text_field( wp_unslash( $mwb_upsell_ga_analytics_config[ 'mwb_upsell_enable_debug_mode' ] ) ) : 'no',
				),

				'facebook_pixel' => array(
					'is_pixel_enabled'	=>	! empty( $mwb_upsell_fb_pixel_config[ 'mwb_upsell_enable_pixel_tracking' ] ) && 'yes' == $mwb_upsell_fb_pixel_config[ 'mwb_upsell_enable_pixel_tracking' ] ? 'true' : 'false',
					'pixel_account_id'	=>	! empty( $mwb_upsell_fb_pixel_config[ 'mwb_upsell_enable_pixel_account_id' ] ) ? sanitize_text_field( wp_unslash( $mwb_upsell_fb_pixel_config[ 'mwb_upsell_enable_pixel_account_id' ] ) ) : '',
					'product_catalog_id'	=>	! empty( $mwb_upsell_fb_pixel_config[ 'mwb_upsell_enable_pixel_product_catalog_id' ] ) ? sanitize_text_field( wp_unslash( $mwb_upsell_fb_pixel_config[ 'mwb_upsell_enable_pixel_product_catalog_id' ] ) ) : '',
					'enable_purchase_event'	=>	! empty( $mwb_upsell_fb_pixel_config[ 'mwb_upsell_enable_purchase_event' ] ) ? sanitize_text_field( wp_unslash( $mwb_upsell_fb_pixel_config[ 'mwb_upsell_enable_purchase_event' ] ) ) : 'no',
					'enable_viewcontent_event'	=>	! empty( $mwb_upsell_fb_pixel_config[ 'mwb_upsell_enable_viewcontent_event' ] ) ? sanitize_text_field( wp_unslash( $mwb_upsell_fb_pixel_config[ 'mwb_upsell_enable_viewcontent_event' ] ) ) : 'no',
					'enable_add_to_cart_event'	=>	! empty( $mwb_upsell_fb_pixel_config[ 'mwb_upsell_enable_add_to_cart_event' ] ) ? sanitize_text_field( wp_unslash( $mwb_upsell_fb_pixel_config[ 'mwb_upsell_enable_add_to_cart_event' ] ) ) : 'no',
					'enable_initiate_checkout_event'	=>	! empty( $mwb_upsell_fb_pixel_config[ 'mwb_upsell_enable_initiate_checkout_event' ] ) ? sanitize_text_field( wp_unslash( $mwb_upsell_fb_pixel_config[ 'mwb_upsell_enable_initiate_checkout_event' ] ) ) : 'no',
					'enable_debug_mode'	=>	! empty( $mwb_upsell_fb_pixel_config[ 'mwb_upsell_enable_debug_mode' ] ) ? sanitize_text_field( wp_unslash( $mwb_upsell_fb_pixel_config[ 'mwb_upsell_enable_debug_mode' ] ) ) : 'no',
				),

				'current_user' => ! empty( $current_user_role ) ? $current_user_role : false,
				'current_location' => ! empty( $current_location ) ? $current_location : false,
				'product_id' => ! empty( $current_product ) && is_object( $current_product ) ? $current_product->get_id() : false,
				'product_name' => ! empty( $current_product ) && is_object( $current_product ) ? $current_product->get_name() : false,
				'product_price' => ! empty( $current_product ) && is_object( $current_product ) ? $current_product->get_price() : false,
				'currency_code' => function_exists( 'get_woocommerce_currency' ) ? get_woocommerce_currency() : '',
				'currency_symbol' => function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '',
				'cart_value' => ! empty( $current_cart_value ) ? $current_cart_value : false,
				'purchase_to_trigger' => ! empty( $purchase_event_data ) ? $purchase_event_data : false,
				'is_upsell_order' => ! empty( $is_upsell_purchased ) ? $is_upsell_purchased : false,
				'upsell_purchase_to_trigger' => ! empty( $upsell_purchase_event_data ) ? $upsell_purchase_event_data : false,
				'ga_purchase_event_data' => ! empty( $ga_purchase_event_data ) ? $ga_purchase_event_data : false,
			);
	}

	public function preformatting_ga_analytics_data( $analytics_live_data=array() ) {
		
		/**
		 * Facebook pixel data is not required.
		 */
		unset( $analytics_live_data[ 'facebook_pixel' ] );
		unset( $analytics_live_data[ 'purchase_to_trigger' ] );

		/**
		 * Format the data for GA data.
		 */
		$formatted_data = array(
			'is_ga_enabled' 			=>	! empty( $analytics_live_data[ 'google_analytics' ][ 'is_ga_enabled' ] ) ? $analytics_live_data[ 'google_analytics' ][ 'is_ga_enabled' ] : '' ,
			'ga_account_id' 			=>	! empty( $analytics_live_data[ 'google_analytics' ][ 'ga_account_id' ] ) ? $analytics_live_data[ 'google_analytics' ][ 'ga_account_id' ] : '' ,
			'enable_purchase_event' 	=>	! empty( $analytics_live_data[ 'google_analytics' ][ 'enable_purchase_event' ] ) ? $analytics_live_data[ 'google_analytics' ][ 'enable_purchase_event' ] : '' ,
			'enable_pageview_event' 	=>	! empty( $analytics_live_data[ 'google_analytics' ][ 'enable_pageview_event' ] ) ? $analytics_live_data[ 'google_analytics' ][ 'enable_pageview_event' ] : '' ,
			'enable_debug_mode' 		=>	! empty( $analytics_live_data[ 'google_analytics' ][ 'enable_debug_mode' ] ) ? $analytics_live_data[ 'google_analytics' ][ 'enable_debug_mode' ] : '' ,
		);

		unset( $analytics_live_data[ 'google_analytics' ] );
		unset( $analytics_live_data[ 'cart_value' ] );
		unset( $analytics_live_data[ 'product_id' ] );
		unset( $analytics_live_data[ 'product_name' ] );
		unset( $analytics_live_data[ 'product_price' ] );

		if ( ! empty( $formatted_data ) && ! empty( $analytics_live_data ) && is_array( $formatted_data ) && is_array( $analytics_live_data ) ) {
			return array_merge( $formatted_data, $analytics_live_data );
		}

		return false;
	}

	public function mwb_print_ga_script( $mwb_upsell_ga_analytics_config=array(), $mwb_upsell_fb_pixel_config=array() ) {

		$analytics_live_data = $this->get_analytics_localisation_data( $mwb_upsell_ga_analytics_config, $mwb_upsell_fb_pixel_config );

		if ( ! empty( $analytics_live_data ) ) {

			$formatted_ga_data = $this->preformatting_ga_analytics_data( $analytics_live_data );

			if( ! empty( $formatted_ga_data ) && is_array( $formatted_ga_data ) ) {

				if( ! empty( $formatted_ga_data[ 'enable_pageview_event' ] ) && 'yes' == $formatted_ga_data[ 'enable_pageview_event' ] ) : ?>

					ga( 'send', 'pageview' );

				<?php endif; ?>

				<?php if( ! empty( $formatted_ga_data[ 'enable_purchase_event' ] ) && 'yes' == $formatted_ga_data[ 'enable_purchase_event' ] ) : ?>

				<?php

				$ga_purchase_event_data = ! empty( $formatted_ga_data[ 'ga_purchase_event_data' ] ) ? $formatted_ga_data[ 'ga_purchase_event_data' ] : array();

				if ( empty( $ga_purchase_event_data ) ) {
					return;
				}

				$ga_transaction_data = ! empty( $ga_purchase_event_data[ 'ga_transaction_data' ] ) ? $ga_purchase_event_data[ 'ga_transaction_data' ] : array();

				$ga_single_item_data = ! empty( $ga_purchase_event_data[ 'ga_single_item_data' ] ) ? $ga_purchase_event_data[ 'ga_single_item_data' ] : array();
				?>

				ga('require', 'ecommerce');
				ga('ecommerce:addTransaction', <?php echo wp_json_encode( $ga_transaction_data ); ?> );

				<?php foreach ( $ga_single_item_data as $key => $single_item ) : ?>
					ga('ecommerce:addItem', <?php echo wp_json_encode( $single_item ); ?> );
				<?php endforeach; ?>
				ga('ecommerce:send');

			<?php endif; ?>

			<?php 
			} // formatted_ga_data Condition end.
		}
	}

} // End of class.
?>