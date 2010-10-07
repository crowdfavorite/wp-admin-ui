// TODO - namespace
function getQueryVariable(variable) {
	var query = window.location.search.substring(1);
	var vars = query.split("&");
	for (var i=0;i<vars.length;i++) {
		var pair = vars[i].split("=");
		if (pair[0] == variable) {
			return pair[1];
		}
	}
	return false;
}

jQuery(function($) {
	var tab_num = getQueryVariable('cf_tab');
	if (!tab_num) {
		tab_num = 1;
	}
	
	if ($('#cf-tab-content-'+tab_num).length > 0){
		$('#cf-tab-'+tab_num+' a').addClass('current');
		$('#cf-tab-content-'+tab_num).show();
	}
	
	getQueryVariable('page');
	// show current/active form element
	$('#cf form :input').focus(function() {
		$('.cf-elm-block.active').removeClass('active');
		$(this).parents('.cf-elm-block').addClass('active');
	});

// make cookie name variable so it is plugin specific
	
	// Set's cookies and decides to show support banner or button
	// requires jquery.cookie.js
    var wphc_cookie_name = 'wphc'; // set cookie variable

	// set status variable and check if banner has been dismissed or not
	var wphc_cookie_status = $.cookie(wphc_cookie_name);
	if (wphc_cookie_status == 'dismissed') {
		// if it's been dismissed hide the widget banner
		$('#wphc-widget').hide();
	}
	else {
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
	
	//Tabs
	$('.cf-tab a').click(function() {
		$('#cf-nav .current').removeClass('current');
		$(this).addClass('current');
		
		var tab_div = $(this).parent().attr('id').replace('cf-tab-', '');
// use classes for selector
		$('[id^=cf-tab-content-]').hide();
		$('#cf-tab-content-'+tab_div).show();
		
	});
	
	
});