$(document).ready(function(){
	
	$("input.hasDatetimepicker").each(function(){
		
		if ($(this).hasClass("display-datetime")) {

			var defaults = {
				dateFormat: "yy-mm-dd",
				ampm: true,
				timeFormat: "h:mm TT"
			}

			if ($(this).hasClass("min-1")) {
				$(this).datetimepicker(jQuery.extend({}, defaults));
			}
			else if ($(this).hasClass("min-5")) {
				$(this).datetimepicker(jQuery.extend({ stepMinute: 5 }, defaults));
			}
			else if ($(this).hasClass("min-10")) {
				$(this).datetimepicker(jQuery.extend({ stepMinute: 10 }, defaults));
			}
			else if ($(this).hasClass("min-15")) {
				$(this).datetimepicker(jQuery.extend({ stepMinute: 15 }, defaults));
			}
		}
		else if ($(this).hasClass("display-time")) {

			var defaults = {
				ampm: true,
				timeFormat: "h:mm TT"
			}

			if ($(this).hasClass("min-1")) {
				$(this).timepicker(jQuery.extend({}, defaults));
			}
			else if ($(this).hasClass("min-5")) {
				$(this).timepicker(jQuery.extend({ stepMinute: 5 }, defaults));
			}
			else if ($(this).hasClass("min-10")) {
				$(this).timepicker(jQuery.extend({ stepMinute: 10 }, defaults));
			}
			else if ($(this).hasClass("min-15")) {
				$(this).timepicker(jQuery.extend({ stepMinute: 15 }, defaults));
			}
		}
		else {
			$(this).datepicker({ dateFormat: "yy-mm-dd" });
		}
		
	});
	
});