jQuery(document).ready(function($){

	// Facebook Pixel data.
	var is_pixel_enabled = mwb.facebook_pixel.is_pixel_enabled;
	var pixel_account_id = false;
	var enable_pixel_purchase_event = 'no';
	var enable_pixel_viewcontent_event = 'no';
	var enable_pixel_debug_mode = 'no';

	// Google Amalytics data.
	var is_ga_enabled = mwb.google_analytics.is_ga_enabled;
	var ga_account_id = false;
	var enable_ga_purchase_event = 'no';
	var enable_ga_pageview_event = 'no';
	var enable_ga_debug_mode = 'no';

	// End Pixel tracking start.
	if( typeof( is_pixel_enabled ) !== 'undefined' && 'true' == is_pixel_enabled ) {

		// Add Pixel basecode.
		pixel_account_id = mwb.facebook_pixel.pixel_account_id;
		enable_pixel_purchase_event = mwb.facebook_pixel.enable_purchase_event;
		enable_pixel_viewcontent_event = mwb.facebook_pixel.enable_viewcontent_event;
		enable_pixel_add_to_cart_event = mwb.facebook_pixel.enable_add_to_cart_event;
		enable_pixel_initiate_checkout_event = mwb.facebook_pixel.enable_initiate_checkout_event;
		enable_pixel_debug_mode = mwb.facebook_pixel.enable_debug_mode;

	} // End Pixel tracking end.

	// End GA tracking start.
	if( typeof( is_ga_enabled ) !== 'undefined' &&  'true' == is_ga_enabled ) {

		// Add GA basecode.
		ga_account_id = mwb.google_analytics.ga_account_id;
		enable_ga_purchase_event = mwb.google_analytics.enable_purchase_event;
		enable_ga_pageview_event = mwb.google_analytics.enable_pageview_event;
		enable_ga_debug_mode = mwb.google_analytics.enable_debug_mode;

	} // End GA tracking end.

	/**
	 * Start Debugging via console.
	 */
	debug_setup_values();

	function debug_setup_values() {

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
	}
// End of script.
});