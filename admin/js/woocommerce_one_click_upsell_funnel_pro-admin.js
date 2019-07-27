(function( $ ) {
	'use strict';
	$(document).ready(function(){
		$('#mwb_wocuf_pro_target_pro_ids').select2();
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

	$('.mwb_upsell_old_shortcodes_link').click(function(e) {

		e.preventDefault();

	    $('.mwb_upsell_old_shortcodes').slideToggle("fast");

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

});
