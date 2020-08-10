(function( $ ) {
	'use strict';
	$(document).ready(function(){
		$('#mwb_wocuf_pro_target_pro_ids').select2();

		//  Add multiselect to Funnel Schedule since v3.0.0
		if ( $( '.mwb-upsell-funnel-schedule-search' ).length ) {

			$( '.mwb-upsell-funnel-schedule-search' ).select2();

		}
	});
})( jQuery );

jQuery(document).ready( function($) {

	// Reflect Funnel name input value.
	$("#mwb_upsell_funnel_name").on("change paste keyup", function() {
	   
	    $("#mwb_upsell_funnel_name_heading h2").text( $(this).val() );
	}); 

	// Funnel status Live <->  Sandbox.
	$('#mwb_upsell_funnel_status_input').click( function() {

	    if( true === this.checked ) {

	    	$('.mwb_upsell_funnel_status_on').addClass('active');
			$('.mwb_upsell_funnel_status_off').removeClass('active');
	    }

	    else {

	    	$('.mwb_upsell_funnel_status_on').removeClass('active');
			$('.mwb_upsell_funnel_status_off').addClass('active');
	    }
	});

	// Preview respective template.
	$(document).on('click', '.mwb_upsell_view_offer_template', function(e) {

		// Current template id.
		var template_id = $(this).data( 'template-id' );

		$('.mwb_upsell_offer_template_previews').show();

		$('.mwb_upsell_offer_template_preview_' + template_id ).addClass('active');

		$('body').addClass('mwb_upsell_preview_body');

	});

	// Close Preview of respective template.
	$(document).on('click', '.mwb_upsell_offer_preview_close', function(e) {

		$('body').removeClass('mwb_upsell_preview_body');

		$('.mwb_upsell_offer_template_preview_one').removeClass('active');
		$('.mwb_upsell_offer_template_preview_two').removeClass('active');
		$('.mwb_upsell_offer_template_preview_three').removeClass('active');

		$('.mwb_upsell_offer_template_previews').hide();

	});

	$('.mwb_upsell_slide_down_link').click(function(e) {

		e.preventDefault();

	    $('.mwb_upsell_slide_down_content').slideToggle("fast");

	});

    // Dismiss Elementor inactive notice.
	$(document).on('click', '#mwb_upsell_dismiss_elementor_inactive_notice', function(e) {

		e.preventDefault();

		$.ajax({
		    type:'POST',
		    url :mwb_wocuf_pro_ajaxurl,
		    data:{
		    	action: 'mwb_upsell_dismiss_elementor_inactive_notice',
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
		jQuery('body').on('click', '.mwb_wocuf_pro_upload_image_button', function(e){

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
		jQuery('body').on('click', '.mwb_wocuf_pro_remove_image_button', function(e){
			e.preventDefault();
			jQuery(this).hide().prev().val('').prev().addClass('button').html('Upload image');
			return false;
		});
	});

// END OF SCRIPT,
});
