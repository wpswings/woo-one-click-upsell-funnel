var mwb_wocuf_pro_custom_offer_bought = false;

jQuery(document).ready(function($){
	
	jQuery('#mwb_wocuf_pro_offer_loader').hide();

	jQuery('.mwb_wocuf_pro_custom_buy').on('click',function(e)
	{
		jQuery('#mwb_wocuf_pro_offer_loader').show();
		if( mwb_wocuf_pro_custom_offer_bought )
		{
			e.preventDefault();
			return;
		}
	    mwb_wocuf_pro_custom_offer_bought = true;
	});

	jQuery('.mwb_wocuf_pro_no').on('click',function(e){

		jQuery('#mwb_wocuf_pro_offer_loader').show();
		
	});
	
});