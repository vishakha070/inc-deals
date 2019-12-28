jQuery( document ).ready(
	function($){
		'use strict';

		jQuery( "#deal_info_launch_year" ).datepicker(
			{
				changeMonth: false,
				changeYear: true,
				showButtonPanel: true,
				dateFormat: 'yy',
				onClose: function(dateText, inst) {
					var year = $( "#ui-datepicker-div .ui-datepicker-year :selected" ).val();
					$( this ).datepicker( 'setDate', new Date( year, 0, 1 ) );
				}
			}
		);

		$('.inc-select-field').selectize({
		    create: true,
		    sortField: 'text'
		});
	}
);
