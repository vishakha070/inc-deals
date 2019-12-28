jQuery( document ).ready(
  function($){
    'use strict';

    $("#inc-launch-year").datepicker({
	    format: "yyyy",
	    viewMode: "years",
	    minViewMode: "years"
	});

	 $('#inc-funding-amount').on("input", function() {
	    $('.funding-amount').html( this.value +" $" );
    }).trigger("change");

	$( "#inc_deal_filter_submit" ).click( function(ev) {
		ev.preventDefault();
		ev.stopPropagation();
		var sector         = $( "#inc_deal_filter #inc-sectors" ).val();
		var launch_year    = $( "#inc_deal_filter #inc-launch-year" ).val();
		var deal_stage     = $( "#inc_deal_filter #inc-deal-stage" ).val();
		var funding_amount = $( "#inc_deal_filter #inc-funding-amount" ).val();
    var post_per_page  = $( "#inc_deal_filter .inc_posts_per_page" ).val();
		var nonce          = $( "#inc_deal_filter #inc_deals_filter_nonce" ).val();

		jQuery.ajax(
			{
				url: inc_deal.ajaxurl,
				type: 'post',
				dataType: 'json',
				data: {
					'action'         : 'inc_filter_deals',
					'funding_amount' : funding_amount,
					'sector'         : sector,
					'launch_year'    : launch_year,
					'deal_stage'     : deal_stage,
					'posts_per_page' : post_per_page,
          'nonce'          : nonce
				},
				complete: function( response ) {
					console.log( response.responseText );
					$( '#inc_deals_wrapper' ).html( response.responseText );
				}
			}
		);
	});

});
