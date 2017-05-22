//------CART PANEL-------------
$(document).ready(function(){
	$("#cart-link").click(function(){
	$("#cart-panel").slideToggle(200);
})
})
$(document).keydown(function(e) {
	if (e.keyCode == 27) {
		$("#cart-panel").hide(0);
	}
});
//------LOGIN POP-UP-------------
$(document).ready(function() {
	$('a.login-window').click(function() {
	var loginBox = $(this).attr('href');
	$(loginBox).fadeIn(300);
	var popMargTop = ($(loginBox).height() + 24) / 2; 
	var popMargLeft = ($(loginBox).width() + 24) / 2; 		
	$(loginBox).css({ 
	'margin-top' : -popMargTop,
	'margin-left' : -popMargLeft
	});
	$('body').append('<div id="mask"></div>');
	$('#mask').fadeIn(300);		
	return false;
});
	$('a.close, #mask').live('click', function() { 
	$('#mask , .login-popup').fadeOut(300 , function() {
	$('#mask').remove();  
	}); 
	return false;
	});
});

	
$(window).load(function() {
	//------Qouvolver-------------	
	$(document).ready(function() {
	$('.feed').quovolver();		
	});
	
	//------IMAGE HOVER-------------
	jQuery(document).ready(function(){
	jQuery(function() {
		jQuery('ul.da-thumbs > li, div.da-thumbs div, li.da-thumbs div').hoverdir();
	});
	});

	//------TIPSY TOOLTIP-------------
	$('a.tip').tipsy({fade: true, gravity: 's'});
	
	
	//------SELECTED MENU IPAD, IPHONE-------------
	 $(function() {
	   
      $("<select />").appendTo("nav");
      
      $("<option />", {
         "selected": "selected",
         "value"   : "",
         "text"    : "Go to..."
      }).appendTo("nav select");
      
      $("nav a").each(function() {
       var el = $(this);
       $("<option />", {
           "value"   : el.attr("href"),
           "text"    : el.text()
       }).appendTo("nav select");
	   
      });

      $("nav select").change(function() {
        window.location = $(this).find("option:selected").val();
      });
	 
	 });
	
	//------PRETTY PHOTO------------- 
	$("a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true});
	
	//------CAMERA SLIDER-------------
	jQuery(function(){	
		jQuery('#camera_wrap_1').camera({
			thumbnails: false,
			height: '46%',
			pagination: false,
			loaderColor: '#f5640c',
			loaderOpacity: .8,
			loader: 'bar'
		});
	});
	
});