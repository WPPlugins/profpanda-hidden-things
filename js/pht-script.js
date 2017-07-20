(function ($) {
	$('#pht_section_woocommerce, .price, .buyb').hide();
	$('#pht_section_login, .logo, .footext').hide();
	$('#pht_section_dashboard, .dplugins, .dcomments, .dprim, .dsec, .dinc, .drightn, .dquick, .dactivity').hide();
	$('h2').addClass('borderComplete');

	$('.woo').click(function(){
		$('#pht_section_woocommerce').slideToggle();	
		$('.price').slideToggle();	
		$('.buyb').slideToggle();	
		$(this).parent('h2').toggleClass('borderComplete');
	});

	$('.loginscreen').click(function(){
		$('#pht_section_login').slideToggle();	
		$('.logo').slideToggle();	
		$('.footext').slideToggle();	
		$(this).parent('h2').toggleClass('borderComplete');
	});

	$('.dash').click(function(){
		$('#pht_section_dashboard').slideToggle();	
		$('.dplugins').slideToggle();	
		$('.dcomments').slideToggle();
		$('.dprim').slideToggle();
		$('.dsec').slideToggle();
		$('.dinc').slideToggle();
		$('.drightn').slideToggle();	
		$('.dquick').slideToggle();
		$('.dactivity').slideToggle();
		$(this).parent('h2').toggleClass('borderComplete');
	});





})(jQuery);

