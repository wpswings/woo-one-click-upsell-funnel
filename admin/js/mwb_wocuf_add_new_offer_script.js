jQuery(document).ready( function($){

	jQuery('.mwb_wocuf_delete_old_created_offers').on("click",function(e){
		e.preventDefault();
		var btn_id = $(this).data("id");
		jQuery("div.new_created_offers[data-id='" + btn_id + "']").slideUp( "normal", function() { $(this).remove(); } );
	});

	jQuery('.mwb_wocuf_global_funnel').change(function(){
		var data = $(this).val();
		var funnel_targets = jQuery('#mwb_wocuf_funnel_targets').closest('tr');
		if( data == 'yes' )
		{
			funnel_targets.hide();
		}
		else
		{
			funnel_targets.show();
		}
	});
	jQuery('.mwb_wocuf_global_funnel').trigger( 'change' );

	jQuery('.wc-funnel-product-search').select2({
  		ajax:{
    			url: ajaxurl,
    			dataType: 'json',
    			delay: 200,
    			data: function (params) {
      				return {
        				q: params.term,
        				action: 'seach_products_for_targets_and_offers'
      				};
    			},
    			processResults: function( data ) {
				var options = [];
				if ( data ) 
				{
					$.each( data, function( index, text )
					{
						text[1]+='( #'+text[0]+')';
						options.push( { id: text[0], text: text[1]  } );
					});
				}
				return {
					results:options
				};
			},
			cache: true
		},
		minimumInputLength: 3
	});

	jQuery('#create_new_offer').on("click",function(e){ 
		e.preventDefault();
		var index = $('.new_created_offers:last').data('id');
		var funnel = $(this).data('id');
		$("#mwb_wocuf_loader").removeClass('hide');
		$("#mwb_wocuf_loader").addClass('show');
		send_post_request(index,funnel);		
	});

	function send_post_request(index,funnel)
	{
		++index;
		$.ajax({
		    type:'POST',
		    url :ajaxurl,
		    data:{action:'mwb_wocuf_return_offer_content',mwb_wocuf_flag:index,mwb_wocuf_funnel:funnel},
		    success:function(data)
		    {
		    	jQuery("#mwb_wocuf_loader").removeClass('show');
				jQuery("#mwb_wocuf_loader").addClass('hide');
		    	jQuery('.new_offers').append(data);
		    	jQuery('.new_created_offers').slideDown(1500);
		    	jQuery('.mwb_wocuf_delete_new_created_offers').on("click",function(e){
					e.preventDefault();
			    	var btn_id = $(this).data("id");
					jQuery("div.new_created_offers[data-id='" + btn_id + "']").slideUp( "normal", function() { $(this).remove(); } );
				});
		    	jQuery('.wc-funnel-product-search').select2({
			  		ajax:{
			    			url: ajaxurl,
			    			dataType: 'json',
			    			delay: 200,
			    			data: function (params) {
			      				return {
			        				q: params.term,
			        				action: 'seach_products_for_targets_and_offers'
			      				};
			    			},
			    			processResults: function( data ) {
							var options = [];
							if ( data ) 
							{
								$.each( data, function( index, text )
								{
									text[1]+='( #'+text[0]+')';
									options.push( { id: text[0], text: text[1]  } );
								});
							}
							return {
								results:options
							};
						},
						cache: true
					},
					minimumInputLength: 3 // the minimum of symbols to input before perform a search
				});
		    }
	   });
    }  
});