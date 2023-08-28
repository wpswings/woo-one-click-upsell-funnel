(function( $ ) {
	'use strict';
	$(document).ready(function(){
		jQuery('.wps_ubo_lite_go_pro_popup_close').attr('href','javascript:void(0)');
	
		$('#wps_wocuf_pro_target_pro_ids').select2();
		$('#product_features_ubo_lite').hide();
		//  Add multiselect to Funnel Schedule since v3.0.0
		if ( $( '.wps-upsell-funnel-schedule-search' ).length ) {

			$( '.wps-upsell-funnel-schedule-search' ).select2();

		}
	});
})( jQuery );

jQuery(document).ready( function($) {

	// Reflect Funnel name input value.
	$("#wps_upsell_funnel_name").on("change paste keyup", function() {
	   
	    $("#wps_upsell_funnel_name_heading h2").text( $(this).val() );
	}); 

	// Funnel status Live <->  Sandbox.
	$('#wps_upsell_funnel_status_input').click( function() {

	    if( true === this.checked ) {

	    	$('.wps_upsell_funnel_status_on').addClass('active');
			$('.wps_upsell_funnel_status_off').removeClass('active');
	    }

	    else {

	    	$('.wps_upsell_funnel_status_on').removeClass('active');
			$('.wps_upsell_funnel_status_off').addClass('active');
	    }
	});

	// Preview respective template.
	$(document).on('click', '.wps_upsell_view_offer_template', function(e) {

		// Current template id.
		var template_id = $(this).data( 'template-id' );

		$('.wps_upsell_offer_template_previews').show();

		$('.wps_upsell_offer_template_preview_' + template_id ).addClass('active');

		$('body').addClass('wps_upsell_preview_body');

	});

	// Close Preview of respective template.
	$(document).on('click', '.wps_upsell_offer_preview_close', function(e) {

		$('body').removeClass('wps_upsell_preview_body');

		$('.wps_upsell_offer_template_preview_one').removeClass('active');
		$('.wps_upsell_offer_template_preview_two').removeClass('active');
		$('.wps_upsell_offer_template_preview_three').removeClass('active');

		$('.wps_upsell_offer_template_previews').hide();

	});

	$('.wps_upsell_slide_down_link').click(function(e) {

		e.preventDefault();

	    $('.wps_upsell_slide_down_content').slideToggle("fast");

	});

    // Dismiss Elementor inactive notice.
	$(document).on('click', '#wps_upsell_dismiss_elementor_inactive_notice', function(e) {

		e.preventDefault();

		$.ajax({
		    type:'POST',
		    url :wps_wocuf_pro_obj.ajaxUrl,
		    data:{
		    	action: 'wps_upsell_dismiss_elementor_inactive_notice',
		    },

		    success:function() {

		    	window.location.reload();
			}
	   });		
	});

	/**
	 * Custom Image setup.
	 * Wordpress image upload.
	 */
	jQuery(function($){
		/*
		 * Select/Upload image(s) event.
		 */
		jQuery('body').on('click', '.wps_wocuf_pro_upload_image_button', function(e){

			e.preventDefault();
    		var button = jQuery(this),
    		custom_uploader = wp.media({
				title: 'Insert image',
				library : {
					type : 'image'
				},
				button: {
					text: 'Use this image' 
				},
				multiple: false
			}).on('select', function() {
				var attachment = custom_uploader.state().get('selection').first().toJSON();
				jQuery(button).removeClass('button').html('<img class="true_pre_image" src="' + attachment.url + '" style="max-width:150px;display:block;" />').next().val(attachment.id).next().show();
			}).open();
		});
	 
		/*
		 * Remove image event.
		 */
		jQuery('body').on('click', '.wps_wocuf_pro_remove_image_button', function(e){
			e.preventDefault();
			jQuery(this).hide().prev().val('').prev().addClass('button').html('Upload image');
			return false;
		});
	});

	
	/**
	 * Scripts after v1.0.2
	 */
	$('.ubo_offer_input').on( 'click', function (e) {
		var data_offer = jQuery(e.currentTarget).attr('product_offer');
		debugger;
		// Add popup to unlock pro features.
		var pro_status = document.getElementById( 'wps_ubo_pro_status' );
		if( null != pro_status ) {
			
			// Add a popup over here.
			$(this).prop("checked", false);
			$( '.wps_ubo_lite_go_pro_popup_wrap' ).addClass( 'wps_ubo_lite_go_pro_popup_show' );
			$( 'body' ).addClass( 'wps_ubo_lite_go_pro_popup_body' );
			$('.wps_ubo_lite_go_pro_popup_show').show();
		}
		if ( data_offer == "yes" ) {
			jQuery('#product_features_ubo_lite').show();
			jQuery('#all_offers_ubo_lite').hide();
		}
	});

	$('.wps_upsell_offer_preview_close').on( 'click', function (e) {
		jQuery('.wps_upsell_offer_template_preview_three').removeClass('active');
		jQuery('.wps_upsell_offer_template_preview_two').removeClass('active');
		jQuery('.wps_upsell_offer_template_preview_one').removeClass('active');
		jQuery('.wps_upsell_offer_template_preview_four').removeClass('active');
		jQuery('.wps_upsell_offer_template_preview_five').removeClass('active');
		jQuery('.wps_upsell_offer_template_preview_six').removeClass('active');
		jQuery('.wps_upsell_offer_template_preview_seven').removeClass('active');
		jQuery('.wps_upsell_offer_template_preview_eight').removeClass('active');

	});

	$('.wps_ubo_lite_go_pro_popup_close').on( 'click', function (e) {
		debugger;
		jQuery('#product_features_ubo_lite').hide();
		$( '.wps_ubo_lite_go_pro_popup_wrap' ).removeClass( 'wps_ubo_lite_go_pro_popup_show' );
		$( 'body' ).removeClass( 'wps_ubo_lite_go_pro_popup_body' );
		jQuery('#product_features_ubo_lite').hide();
		jQuery('#all_offers_ubo_lite').hide();
		
	});

	

	


// END OF SCRIPT,
});