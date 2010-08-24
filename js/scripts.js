jQuery(function($) {
	
	// show current/active form element
	$('#cf form :input').focus(function() {
		$('.elm-block.active').removeClass('active');
		$(this).parents('.elm-block').addClass('active');
	});
	

	
	// Set's cookies and decides to show support banner or button
	// requires jquery.cookie.js
    var wphc_cookie_name = 'wphc'; // set cookie variable

	// set status variable and check if banner has been dismissed or not
	var wphc_cookie_status = $.cookie(wphc_cookie_name);
	if (wphc_cookie_status == 'dismissed') {
		// if it's been dismissed hide the widget banner
		$('#wphc-widget').hide();
	} else {
		// if it has NOT been dismissed hide the small support button
		$('.wphc-support-btn').hide();
	};
	
	// dismiss alert and set cookie
	$("#wphc-close").click(function() {
		$('#wphc-widget').slideUp(); // removes wphc-widget banner
		$('.wphc-support-btn').show(); // shows smaller support button
		$.cookie(wphc_cookie_name, 'dismissed', { expires: 30 }); // set cookie and expiration in days
		return false;
	});
		
});