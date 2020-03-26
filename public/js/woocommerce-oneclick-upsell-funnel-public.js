var mwb_wocuf_pro_custom_offer_bought = false;
var mwb_wocuf_custom_upsell_message = false;

jQuery(document).ready(function($){
	
	jQuery('#mwb_wocuf_pro_offer_loader').hide();

	jQuery('.mwb_wocuf_pro_custom_buy').on('click',function(e) {

		jQuery('#mwb_wocuf_pro_offer_loader').show();

		if( mwb_wocuf_pro_custom_offer_bought ) {
			e.preventDefault();
			return;
		}

	    mwb_wocuf_pro_custom_offer_bought = true;
	});

	jQuery('.mwb_wocuf_pro_no').on('click',function(e){

		jQuery('#mwb_wocuf_pro_offer_loader').show();
		
	});

	/**
	 * Shortcode Scripts after v2.1.0
	 */
	jQuery( '.mwb_upsell_quantity_input' ).on( 'change',function(e) {

		var updated_quantity = jQuery( this ).val();

		jQuery( 'a' ).map( function() {
            
            // Check if any of them are empty.
            if( this.href.includes( 'mwb_wocuf_pro_buy' ) ) {

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
            else if( this.href.includes( '#mwb_upsell' ) ) {

            	jQuery( '.mwb_wocuf_pro_quantity' ).val( updated_quantity );
            }
        });
	});

	/**
	 * Upsell Strings Scripts after v2.1.0
	 */
	if( 'undefined' !== typeof( mwb_upsell ) ) {

		mwb_wocuf_custom_upsell_message = mwb_upsell.upsell_actions_message;

		// Check if message is present.
		if( mwb_wocuf_custom_upsell_message.length ) {

			jQuery( 'body' ).append( '<div class="mwb_upsell_loader"><p class="mwb_upsell_loader_text">' + mwb_wocuf_custom_upsell_message + '</p></div>' );

			jQuery( document ).on('click', 'a', function(e) {

				// Check if any of them are empty.
	            if( this.href.includes( 'mwb_wocuf_pro_buy' ) || this.href.includes( '#mwb_upsell' ) || this.href.includes( 'ocuf_th' ) ) {

	            	// Show loader on click.
	            	jQuery( '.mwb_upsell_loader' ).show();
	            }
			});
		}
	}
});