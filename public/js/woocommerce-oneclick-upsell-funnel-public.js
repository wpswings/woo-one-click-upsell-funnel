var wps_wocuf_pro_custom_offer_bought = false;

jQuery(document).ready(function($){

	
	
	jQuery('#wps_wocuf_pro_offer_loader').hide();

	jQuery('.wps_wocuf_pro_custom_buy').on('click',function(e) {

		jQuery('#wps_wocuf_pro_offer_loader').show();

		if( wps_wocuf_pro_custom_offer_bought ) {
			e.preventDefault();
			return;
		}

	    wps_wocuf_pro_custom_offer_bought = true;
	});

	jQuery('.wps_wocuf_pro_no').on('click',function(e){

		jQuery('#wps_wocuf_pro_offer_loader').show();
		
	});

	/**
	 * Shortcode Scripts since v3.0.0
	 */
	jQuery( '.wps_upsell_quantity_input' ).on( 'change',function(e) {

		var updated_quantity = jQuery( this ).val();

		jQuery( 'a' ).map( function() {
            
            // Check if any of them are empty.
            if( this.href.includes( 'wps_wocuf_pro_buy' ) ) {

            	if( false == this.href.includes( 'fetch' ) ) {

            		var paramurl = this.href + '&fetch=1';
            		jQuery( this ).attr( 'href', paramurl );
            	}

            	var currentquantity = jQuery( this ).attr( 'href' ).split('fetch=');

            	if( '' != currentquantity[1] ) {

            		currentquantity = currentquantity[1];
            	}

            	else {

            		currentquantity = 1;
            	}

            	var newUrl = this.href.replace( 'fetch=' + currentquantity , 'fetch=' + updated_quantity );
            	jQuery( this ).attr( 'href', newUrl );
            }

            // For variable products.
            else if( this.href.includes( '#wps_upsell' ) ) {

            	jQuery( '.wps_wocuf_pro_quantity' ).val( updated_quantity );
            }
        });
	});

	/**
	 * Sweet Alert when Upsell Action Buttons are clicked in Preview Mode. 
	 * since v3.0.0
	 */
	$('a[href="#preview"]').on( 'click', function(e) {

		e.preventDefault();

		swal( wps_upsell_public.alert_preview_title, wps_upsell_public.alert_preview_content, 'info' );
	});


	/**
	 * Adding Upsell Loader since v3.0.0
	 */
	if( 'undefined' !== typeof( wps_upsell_public ) ) {

		if( wps_upsell_public.show_upsell_loader ) {

			wps_upsell_loader_message = wps_upsell_public.upsell_actions_message;

			wps_upsell_loader_message_html = '';

			if( wps_upsell_loader_message.length ) {

				wps_upsell_loader_message_html = '<p class="wps_upsell_loader_text">' + wps_upsell_loader_message + '</p>';
			}

			jQuery( 'body' ).append( '<div class="wps_upsell_loader">' + wps_upsell_loader_message_html + '</div>' );

			jQuery( document ).on('click', 'a', function(e) {

				// Check if any of them are empty.
	            if( this.href.includes( 'wps_wocuf_pro_buy' ) || this.href.includes( '#wps_upsell' ) || this.href.includes( 'ocuf_th' ) ) {

	            	// Show loader on click.
	            	jQuery( '.wps_upsell_loader' ).show();
	            }
			});
		}
	}

});


