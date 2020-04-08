jQuery(document).ready(function($) {

	// Facebook Pixel data.
	var is_pixel_enabled = mwb.facebook_pixel.is_pixel_enabled;
	var pixel_account_id = false;
	var product_catalog_id = false;
	var enable_pixel_purchase_event = 'no';
	var enable_pixel_viewcontent_event = 'no';
	var enable_pixel_debug_mode = 'no';

	// Other required data.
	var current_user_role = mwb.current_user;
	var currency_code = mwb.currency_code;
	var currency_symbol = mwb.currency_symbol;
	var current_location = mwb.current_location;
	var purchase_to_trigger = mwb.purchase_to_trigger;
	var is_upsell_order = mwb.is_upsell_order;
	var upsell_purchase_to_trigger = mwb.upsell_purchase_to_trigger;
	var product_price = 0;
	var quantity = 1;
	var total_value = 0;

	// End Pixel tracking start.
	if( typeof( is_pixel_enabled ) !== 'undefined' && 'true' == is_pixel_enabled ) {

		// Add Pixel basecode.
		pixel_account_id = mwb.facebook_pixel.pixel_account_id;
		product_catalog_id = mwb.facebook_pixel.product_catalog_id;
		enable_pixel_debug_mode = mwb.facebook_pixel.enable_debug_mode;
		enable_pixel_viewcontent_event = mwb.facebook_pixel.enable_viewcontent_event;
		enable_pixel_add_to_cart_event = mwb.facebook_pixel.enable_add_to_cart_event;
		enable_pixel_initiate_checkout_event = mwb.facebook_pixel.enable_initiate_checkout_event;
		enable_pixel_purchase_event = mwb.facebook_pixel.enable_purchase_event;

		/**
		 * Event : View Content.
		 * Location required : Product Page.
		 */
		if( typeof( enable_pixel_viewcontent_event ) != 'undefined' && 'yes' == enable_pixel_viewcontent_event ) {

			if( 'product' == current_location ) {
				trigger_view_content();
			}
		}

		/**
		 * Event : Add to Cart.
		 * Location required : Product Page/ Shop page.
		 */
		if( typeof( enable_pixel_add_to_cart_event ) != 'undefined' && 'yes' == enable_pixel_add_to_cart_event ) {

			if( 'product' == current_location ) {
				if( jQuery( '.single_add_to_cart_button' ).length != '0' ) {
					jQuery(document).on( 'click', '.single_add_to_cart_button', trigger_add_to_cart );
				}
			}

			if( 'shop' == current_location ) {
				jQuery(document).on( 'click', '.add_to_cart_button', trigger_add_to_cart );
			}
		}

		/**
		 * Event : Initiate Checkout.
		 * Location required : Checkout Page.
		 */
		if( typeof( enable_pixel_initiate_checkout_event ) != 'undefined' && 'yes' == enable_pixel_initiate_checkout_event ) {
			
			if( 'checkout' == current_location ) {

				if( jQuery( '#place_order' ).length != '0' ) {
					jQuery(document).on( 'click', '#place_order', trigger_initiate_checkout );
				}
			}
		}

		/**
		 * Event : Purchase.
		 * Location required : Thank you Page / Upsell.
		 */
		if( typeof( enable_pixel_purchase_event ) != 'undefined' && 'yes' == enable_pixel_purchase_event ) {
			
			if( 'upsell' == current_location || 'thank-you' == current_location ) {
				if( typeof purchase_to_trigger !== 'undefined' && Object.keys( purchase_to_trigger ).length > 0 ) {
					trigger_purchase();
				}
			}
		}

	} // End Pixel tracking end.


	/**
	 * Start Debugging via console.
	 */
	debug_setup_values();

	/**===================================
		Facebook Function Definitions
	=====================================*/
	
	/**
	 * View Content event Function.
	 */
	function trigger_view_content() {
		fbq('track', 'ViewContent', {
			value: mwb.product_price,
			currency: currency_code,
		});
	}

	/**
	 * Add to cart event Function.
	 */
	function trigger_add_to_cart(e) {

		if( 'product' == current_location ) {
			quantity = jQuery( 'input[name=quantity]' ).val();
			total_value = parseInt( quantity ) * parseFloat( mwb.product_price );
			product_id = mwb.product_id;
		}

		else if ( 'shop' == current_location ){

			quantity = jQuery( this ).attr( 'data-quantity' );
			product_id = jQuery( this ).attr( 'data-product_id' );
			jQuery( this ).parent().find( 'a' ).map( function() {
            
	            // Check if any of them are empty.
	            if( jQuery( this ).hasClass( 'woocommerce-loop-product__link' ) ) {
	            	price_html = jQuery( this ).find( 'span.price ins' ).text();
	            	total_value = price_html.replace( currency_symbol , '' );
	            }
	        });
		}

		var base_obj = {

			value: total_value,
			currency: currency_code,
		};

		if( typeof product_catalog_id != 'undefined' && product_catalog_id.length > 0 ) {

			base_obj['product_catalog_id'] = product_catalog_id;

			base_obj['contents'] = [{
				id: product_id,
				quantity: quantity
			}];

			base_obj['content_type'] = 'product';
		}

		// Trigger event.
		fbq('track', 'AddToCart', base_obj );
	}

	/**
	 * Initiate Checkout event Function.
	 */
	function trigger_initiate_checkout(e) {

		e.preventDefault();

		// Trigger event.
		fbq( 'track', 'InitiateCheckout',{
			value: mwb.cart_value,
			currency: currency_code,
		});

		// Submit checkout form.
		jQuery( 'form.checkout' ).submit();
	}

	/**
	 * Purchase event Function.
	 */
	function trigger_purchase() {
		if ( Object.keys( purchase_to_trigger ).length <= 0 ) {
			return;
		}

		var base_obj = {
			value: purchase_to_trigger.value,
			currency: currency_code,
		};

		if( typeof product_catalog_id != 'undefined' && product_catalog_id.length > 0 ) {

			base_obj['contents'] = purchase_to_trigger.content;
			base_obj['content_type'] = 'product';
			base_obj['product_catalog_id'] = product_catalog_id;
		}

		// If upsell data has to be send.
		if( 'true' == is_upsell_order && Object.keys( upsell_purchase_to_trigger ).length > 0 ) {

			base_obj['upsell_value'] = upsell_purchase_to_trigger.value;
			base_obj['upsell_contents'] = upsell_purchase_to_trigger.upsell_contents;
		}

		fbq( 'track', 'Purchase', base_obj );
	}

	/**
	 * Debugger Function.
	 */
	function debug_setup_values() {
		
		// Only for admin.
		if( ! current_user_role.includes( 'administrator' ) ) {
			return;
		}

		if( typeof( enable_pixel_debug_mode ) != 'undefined' && 'yes' == enable_pixel_debug_mode ) {
			console.log( '/**===================' );
			console.log( '  Pixel Analytics' );
			console.log( '====================*/' );
			console.log( 'Pixel Account Id : ' + pixel_account_id ) ;
			console.log( 'View Content Event : ' + enable_pixel_viewcontent_event );
			console.log( 'Add To Cart Event : ' + enable_pixel_add_to_cart_event );
			console.log( 'Initiate Checkout Event : ' + enable_pixel_initiate_checkout_event );
			console.log( 'Purchase Event : ' + enable_pixel_purchase_event );
		}

		if( typeof( enable_ga_debug_mode ) != 'undefined' && 'yes' == enable_ga_debug_mode ) {
			console.log( '/**===================' );
			console.log( '  Google Analytics' );
			console.log( '====================*/' );
			console.log( 'Google Analytics Account Id : ' + ga_account_id ) ;
			console.log( 'Page View Event : ' + enable_ga_pageview_event );
			console.log( 'Purchase Event : ' + enable_ga_purchase_event );
		}

		console.log( 'Current Location : ' + current_location );
	}

// End of script.
});