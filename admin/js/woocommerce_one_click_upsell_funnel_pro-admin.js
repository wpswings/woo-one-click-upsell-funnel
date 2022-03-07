(function( $ ) {
	'use strict';
	$(document).ready(function(){
		$('#wps_wocuf_pro_target_pro_ids').select2();

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

// END OF SCRIPT,
});

/**
 * Update Scripts for migration
 */
jQuery(document).ready( function($) {

	const ajaxUrl = wps_wocuf_pro_obj.ajaxUrl;
	const migratorHead = wps_wocuf_pro_obj.alert_preview_title;
	const migratorNotice = wps_wocuf_pro_obj.alert_preview_content;

    // Initiate Migration
	$(document).on('click', '.wps_wocuf_init_migration', function(e) {

		e.preventDefault();
		promptMigrationIsNeeded();		
	});

	const promptMigrationIsNeeded = () => {
		Swal.fire({
			backdrop: 'rgb(0 0 0 / 88%)',
			title: migratorHead,
			icon : 'error',
			text: migratorNotice,
			showDenyButton: false,
			allowOutsideClick : false,
			showCloseButton: false,
			showCancelButton: false,
			confirmButtonText: '<i class="fa fa-thumbs-up"></i> Great! Lets Start',
		  }).then((stater) => {
			if (stater.isConfirmed) {

				// let timerInterval
				Swal.fire({
					backdrop: 'rgb(0 0 0 / 88%)',
					title: 'Thank you!',
					html: 'The plugin will be ready to use shortly.',
					footer: 'Estimated time : less than 5 mins...',
					timerProgressBar: true,
					timer: 99999999,
					didOpen: () => {
						Swal.showLoading();
						$.ajax({
							type: 'POST',
							url : ajaxUrl,
							data: {
								action: 'wps_upsell_init_migrator',
							},
							success:function( response ) {
								if( response.code === 200 ) {
									Swal.fire({
										backdrop: 'rgb(0 0 0 / 88%)',
										icon: 'success',
										title: 'Yess....',
										text: 'We are good to go!',
									}).then(()	=>	{
										// window.location.reload();
									})
								}
							}
						});
					},
				})
			}
		})
	}
	
});
