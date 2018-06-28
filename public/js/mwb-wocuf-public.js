var mwb_wocuf_offer_bought = false;

jQuery(document).ready(function($){

	jQuery('.mwb_wocuf_buy').on('click',function(e)
	{
		if( mwb_wocuf_offer_bought )
		{
			e.preventDefault();
			return;
		}
	    mwb_wocuf_offer_bought = true;
	});
});