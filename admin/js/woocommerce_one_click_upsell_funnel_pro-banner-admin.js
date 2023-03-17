
jQuery(document).ready( function($) {

    $('#product_features_ubo_lite').hide();
/**
	 * Scripts after v1.0.2
	 */
 $('.wps_wupsell_premium_strip').on( 'click', function (e) {

    // Add popup to unlock pro features.
    var pro_status = document.getElementById( 'wps_ubo_pro_status' );
    if( null != pro_status ) {
        
        // Add a popup over here.
        $(this).prop("checked", false);
        $( '.wps_ubo_lite_go_pro_popup_wrap' ).addClass( 'wps_ubo_lite_go_pro_popup_show' );
        $( 'body' ).addClass( 'wps_ubo_lite_go_pro_popup_body' );
    }
});


// END OF SCRIPT,
});