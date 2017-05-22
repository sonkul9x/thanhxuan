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
	 $('.addtocart').click(function(){
        var id = $('input[name=id]').val();
        var addUri = $('input[name=addUri]').val();
        var lang = $('input[name=lang]').val();
        var qty = $('input[name=qty]').val();
        var size = $('#product_size :selected').text();
       // var size = $('span.sizebox_selected').attr('title');
        $.ajax(
        {
            type:'post',
            url : '/addtocart',
            data:{
                'id' : id,
                'size' : size,
                'qty' : qty,
            },
            beforeSend: function(){
                $('.addtocart').prop('disabled', true);
                if(lang == 'vi'){
                    $('.addtocart').html("Đang thêm vào giỏ...");
                }else{
                    $('.addtocart').html("Please wait...");
                }
            },
            success: function(data)
            {
                location.href = addUri;
            }
        });
    });
	
});


$(window).load(function() {

    gototop();

});

function gototop()
{
    $(".gotop").hide();
    $(window).scroll(function() {
        if ($(this).scrollTop() > 10) {
            $('.gotop').fadeIn();
        } else {
            $('.gotop').fadeOut();
        }
    });
    $('.gotop').click(function() {
        $('body,html').animate({scrollTop: 4}, 300);
        return false;
    });
}

function imagebox()
{
    $('.imagebox').fancybox({
         'autoSize' : false
    });
}

function fancyshow(id)
{
    $(".ft-"+id).fancybox({
        loop        : true,
        autoPlay    : true,
        playSpeed   : 4000,
        nextSpeed   : 500,
        prevSpeed   : 500,
        openSpeed   : 500,
        speedOut    : 500,
        openEffect  : "fade", 
        closeEffect : "fade",
        prevEffect	: 'fade', //fade none
        nextEffect	: 'fade', //fade none
        helpers	: {
            title	: {
                type: 'inside'
            },
            thumbs	: {
                width	: 50,
                height	: 50
            }
        }
    });
}

function update_cart(id,uri)
{
    var quantity = $('input[name=' + id + ']').val();
    $.ajax(
    {
        type: 'post',
        url: '/updatecart',
        data: {
            'id': id,
            'quantity': quantity,
        },
        success: function()
        {
            location.href = uri;
        }
    });
}

function remove_cart(row_id,uri,lang)
{
    if(lang == 'vi'){
        question = confirm("Báº¡n cĂ³ muá»‘n xĂ³a?");
    }else{
        question = confirm("Are you sure you want delete?");
    }
    if (question)
    {
        $.ajax(
        {
            type: 'post',
            url: '/removecart',
            data: {
                //'is-ajax': 1,
                'id': row_id,
            },
            success: function(responseText)
            {
                location.href = uri;
            }
        });
    }
    else
    {
        return false;
    }
}

