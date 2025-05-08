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
		
		jQuery('#product_features_ubo_lite').hide();
		$( '.wps_ubo_lite_go_pro_popup_wrap' ).removeClass( 'wps_ubo_lite_go_pro_popup_show' );
		$( 'body' ).removeClass( 'wps_ubo_lite_go_pro_popup_body' );
		jQuery('#product_features_ubo_lite').hide();
		jQuery('#all_offers_ubo_lite').hide();
		
	});
// END OF SCRIPT,
});



(function($) {
	// here $ would be point to jQuery object
	$(document).ready(function() {
		$('.wps-ufw_store-checkout').parents('body').addClass('wps-ufw_sc-body');
		$(document).on('click', '.wps-ufw_btn-act-main', function() {
			$(this).nextAll('.wps-ufw_btn-act-desc').toggleClass('wps-ufw_btn-active');
			$(this).toggleClass('wps-ufw_btn-active');
		});
		$(document).on('click', '.wps-ufw_btn-act-desc span', function() {
			$('.wps-ufw_btn-act-desc-pop').show();
			$(this).parent().toggleClass('wps-ufw_btn-active');
			$(this).parent().prev().toggleClass('wps-ufw_btn-active');
		});
		$(document).on('click', '.wps-ufw_adp-head .dashicons,.wps-ufw_adpf-btn.wps-ufw_adpf-cancel', function() {
			$('.wps-ufw_btn-act-desc-pop').hide();
		});
		$(document).on('click', '.wps-ufw_ms-btn-link', function() {
			$(this).nextAll('.wps-ufw_ms-main').show();
		});
		$(document).on('click', '.wps-ufw_msm-head>.dashicons-arrow-left-alt', function() {
			$('.wps-ufw_ms-main').hide();
		});
		$(document).on('click', '.wps-ufw_ms-buttons .dashicons', function() {
			$(this).nextAll('.wps-ufw_btn-ms-desc').toggleClass('wps-ufw_btn-active');
		});
		$(document).on('click', '.wps-ufw_btn-ms-desc span', function() {
			$(this).parent().toggleClass('wps-ufw_btn-active');
		});


		// Draggable UI

		$(".wps-ufw_msmsmr-item").draggable({
			revert: "invalid",
			start: function(event, ui) {
				$(this).data("origPosition", $(this).position());
			}
		});

		$(".wps-ufw_msmsmli-wrap").droppable({
			accept: ".wps-ufw_msmsmr-item",
			drop: function(event, ui) {
				var draggableElement = ui.draggable;
				$(this).append(draggableElement);
				$(draggableElement).css({
					top: 0,
					left: 0,
					position: 'relative'
				});
			}
		});

		loadState();

		function saveState() {
			var state = {};
			$(".wps-ufw_msmsmli-wrap").each(function() {
				var wrapperId = $(this).attr("id");
				state[wrapperId] = [];
				$(this).find(".wps-ufw_msmsmr-item").each(function() {
					state[wrapperId].push($(this).data("id"));
				});
			});
			localStorage.setItem("dragDropState", JSON.stringify(state));
		}

		function loadState() {
			var state = localStorage.getItem("dragDropState");
			if (state) {
				state = JSON.parse(state);
				for (var wrapperId in state) {
					if (state.hasOwnProperty(wrapperId)) {
						var items = state[wrapperId];
						var $wrapper = $('#' + wrapperId);
						for (var i = 0; i < items.length; i++) {
							var $item = $('[data-id="' + items[i] + '"]').detach();
							$wrapper.append($item);
							$item.draggable({
								revert: "invalid",
								start: function(event, ui) {
									$(this).data("origPosition", $(this).position());
								}
							});
						}
					}
				}
			}
		}

		function resetState() {
			localStorage.removeItem("dragDropState");
			localStorage.removeItem("removedItems");
		}

		
		$(document).on('click', '.notice-dismiss', function() {
			jQuery('.notice-settings').html('');
		});
		


		// Save content to local storage when the save button is clicked
		$('.wps-ufw_msmh-in-btn').on('click', function() {
			
			var shippingdataIds = [];
			var shippingdatamethod = [];
			var order_summary = [];
			var billingbasicwrapid = [];
			var shippingbasicwrapid =[];
			var shipping_information_title = jQuery('#billing-information-wrap-editable').html();
			var shipping_method_title = jQuery('#shipping-method-wrap-editable').html();
			var order_summary_title = jQuery('#order-Summary-wrap-editable').html();
			var payment_method_title = jQuery('#payment-gateway-wrap-editable').html();
			jQuery('#billing-information-wrap-id span').each(function() {
    			
				// Get the data-id attribute of the current span element
				dataId = jQuery(this).attr('data-id');
				
				// Add the data-id to the array
				if (dataId) {
					shippingdataIds.push(dataId);
				}
			});
			jQuery('#shipping-information-wrap-id span').each(function() {
    			
				// Get the data-id attribute of the current span element
				dataId = jQuery(this).attr('data-id');
				
				// Add the data-id to the array
				if (dataId) {
					shippingdatamethod.push(dataId);
				}
			});
			
			jQuery('#billing-basic-wrap-id span').each(function() {
    			
				// Get the data-id attribute of the current span element
				dataId = jQuery(this).attr('data-id');
				
				// Add the data-id to the array
				if (dataId) {
					billingbasicwrapid.push(dataId);
				}
			});

			jQuery('#shipping-basic-wrap-id span').each(function() {
    			
				// Get the data-id attribute of the current span element
				dataId = jQuery(this).attr('data-id');
				
				// Add the data-id to the array
				if (dataId) {
					shippingbasicwrapid.push(dataId);
				}
			});

			var checkout_coupon_enabled = jQuery('#coupon_field_checkout').prop('checked');
			var checkout_order_note_enabled = jQuery('#order_note_checkout').prop('checked');

			$.ajax({
				type:'POST',
				url :wps_wocuf_pro_obj.ajaxUrl,
				data:{
					action: 'wps_upsell_save_store_checkout_page_data',
					nonce : wps_wocuf_pro_obj_form.nonce,
					shippingdatamethod : shippingdatamethod, 
					shippingdataIds : shippingdataIds,
					billingbasicwrapid : billingbasicwrapid,
					shippingbasicwrapid : shippingbasicwrapid,
					shipping_information_title : shipping_information_title,
					shipping_method_title : shipping_method_title,
					order_summary_title : order_summary_title,
					payment_method_title : payment_method_title,
					checkout_coupon_enabled : checkout_coupon_enabled,
					checkout_order_note_enabled : checkout_order_note_enabled,

				},

				success:function(data) {

					
				if (data == 'success' ) {
					
					jQuery('.wps-ufw_confirmation').show();
					setTimeout(function() {
						jQuery('.wps-ufw_confirmation').hide();
					}, 1000);

				}
				}
		});	




		
		});



		
		
		$('.wps-ufw_msmhthy-in-btn').on('click', function() {
			
			var wps_wocuf_content_before_order_details = jQuery('#wps_wocuf_content_before_order_details').val();
			var wps_wocuf_content_page_header_title = jQuery('#wps_wocuf_content_page_header_title').val();
			var wps_wocuf_content_after_order_details = jQuery('#wps_wocuf_content_after_order_details').val();
			var wps_wocuf_content_billing_and_shipping = jQuery('#wps_wocuf_content_billing_and_shipping').val();
			
			$.ajax({
				type:'POST',
				url :wps_wocuf_pro_obj.ajaxUrl,
				data:{
					action: 'wps_upsell_save_store_thankyou_page_data',
					nonce : wps_wocuf_pro_obj_form.nonce,
					wps_wocuf_content_before_order_details:wps_wocuf_content_before_order_details,
					wps_wocuf_content_page_header_title:wps_wocuf_content_page_header_title,
					wps_wocuf_content_after_order_details:wps_wocuf_content_after_order_details,
					wps_wocuf_content_billing_and_shipping:wps_wocuf_content_billing_and_shipping,
				},
				success:function(data) {
					
					jQuery('.wps-ufw_confirmation').show();
					setTimeout(function() {
						jQuery('.wps-ufw_confirmation').hide();
					}, 1000);
				}
			});	

		});

			
		


	
	

		document.getElementById("defaultOpen").click();

	

	});
 })(jQuery);

 function openTab(evt, tabName) {
	var i, tabcontent, tablinks;

	// Hide all tab content by default
	tabcontent = document.getElementsByClassName("wps_wocuf_tabcontent");
	for (i = 0; i < tabcontent.length; i++) {
		tabcontent[i].style.display = "none";
	}

	// Remove the active class from all tab links
	tablinks = document.getElementsByClassName("wps_wocuf_tablinks");
	for (i = 0; i < tablinks.length; i++) {
		tablinks[i].className = tablinks[i].className.replace(" active", "");
	}

	// Show the current tab's content, and add an "active" class to the clicked tab link
	document.getElementById(tabName).style.display = "block";
	evt.currentTarget.className += " active";
}

// Set the default open tab
