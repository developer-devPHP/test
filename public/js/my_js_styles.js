jQuery(function($){
	
	$('.login_info li:last-child').css('border','none');
	//$('.content_center').corner('bottom');
	
//	$('#base_search_form tr td:even').css('float','left');
//	$('#base_search_form tr td:odd').css('float','right');
	//$('#base_search_form tr:last-child').css('border','none');
	$('#search_submit').attr('disabled','disabled');
	
	var browser = $.browser;
	if(browser.msie)
	{
		if(browser.version == "7.0")
		{
			$(".top_menu li a").css('padding-top','0px');
		}
		
	}
	
});