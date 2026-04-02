var wpswocuf_pro_custom_offer_bought = false;

jQuery(document).ready(function($){

	
	
	jQuery('#wpswocuf_pro_offer_loader').hide();

	jQuery('.wpswocuf_pro_custom_buy').on('click',function(e) {

		jQuery('#wpswocuf_pro_offer_loader').show();

		if( wpswocuf_pro_custom_offer_bought ) {
			e.preventDefault();
			return;
		}

	    wpswocuf_pro_custom_offer_bought = true;
	});

	jQuery('.wpswocuf_pro_no').on('click',function(e){

		jQuery('#wpswocuf_pro_offer_loader').show();
		
	});

	/**
	 * Shortcode Scripts since v3.0.0
	 */
	jQuery( '.wpswocuf_upsell_quantity_input' ).on( 'change',function(e) {

		var updated_quantity = jQuery( this ).val();

		jQuery( 'a' ).map( function() {
            
            // Check if any of them are empty.
            if( this.href.includes( 'wpswocuf_pro_buy' ) ) {

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
            else if( this.href.includes( '#wpswocuf_upsell' ) ) {

            	jQuery( '.wpswocuf_pro_quantity' ).val( updated_quantity );
            }
        });
	});

	/**
	 * Sweet Alert when Upsell Action Buttons are clicked in Preview Mode. 
	 * since v3.0.0
	 */
	$('a[href="#preview"]').on( 'click', function(e) {

		e.preventDefault();

		swal( wpswocuf_upsell_public.alert_preview_title, wpswocuf_upsell_public.alert_preview_content, 'info' );
	});


	/**
	 * Adding Upsell Loader since v3.0.0
	 */
	if( 'undefined' !== typeof( wpswocuf_upsell_public ) ) {

		if( wpswocuf_upsell_public.show_upsell_loader ) {

			wpswocuf_upsell_loader_message = wpswocuf_upsell_public.upsell_actions_message;

			wpswocuf_upsell_loader_message_html = '';

			if( wpswocuf_upsell_loader_message.length ) {

				wpswocuf_upsell_loader_message_html = '<p class="wpswocuf_upsell_loader_text">' + wpswocuf_upsell_loader_message + '</p>';
			}

			jQuery( 'body' ).append( '<div class="wpswocuf_upsell_loader">' + wpswocuf_upsell_loader_message_html + '</div>' );

			jQuery( document ).on('click', 'a', function(e) {

				// Check if any of them are empty.
	            if( this.href.includes( 'wpswocuf_pro_buy' ) || this.href.includes( '#wpswocuf_upsell' ) || this.href.includes( 'ocuf_th' ) ) {

	            	// Show loader on click.
	            	jQuery( '.wpswocuf_upsell_loader' ).show();
	            }
			});
		}
	}

});


