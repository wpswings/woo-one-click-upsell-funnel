jQuery(document).ready(function($){

	// Google Amalytics data.
	var is_ga_enabled = mwb.google_analytics.is_ga_enabled;

	// Facebook Pixel data.
	var is_pixel_enabled = mwb.facebook_pixel.is_pixel_enabled;

	// End Pixel tracking start.
	if( 'true' == is_pixel_enabled ) {

		// Add Pixel basecode.
		var pixel_account_id = mwb.google_analytics.pixel_account_id;
		var enable_pixel_purchase_event = mwb.google_analytics.enable_purchase_event;
		var enable_pixel_pageview_event = mwb.google_analytics.enable_pageview_event;


	} // End Pixel tracking end.


	// End GA tracking start.
	if( 'true' == is_ga_enabled ) {

		// Add GA basecode.
		var ga_account_id = mwb.google_analytics.ga_account_id;
		var enable_ga_purchase_event = mwb.google_analytics.enable_purchase_event;
		var enable_ga_pageview_event = mwb.google_analytics.enable_pageview_event;


	} // End GA tracking end.

// End of script.
});