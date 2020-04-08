var mwb_wocuf_pro_custom_offer_bought = false;

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

	// Sweet Alert when Upsell Action Buttons are clicked in Preview Mode.
	$('a[href="#preview"]').on( 'click', function(e) {

		e.preventDefault();

		swal( mwb_upsell_public.alert_preview_title, mwb_upsell_public.alert_preview_content, 'info' );
	});




});