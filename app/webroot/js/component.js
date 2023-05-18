// JavaScript Document
function dropdown()
{
	var myTarget = $(".dropdown");
	$("> ul li",myTarget).hide(1);
	$('.dropdownBtn',myTarget).unbind('click');
	$('.dropdownBtn',myTarget).click(function(event) {
        var myDropdown = $(this).closest(myTarget);
		if ( $("> ul li",myDropdown).css('display')=='none')
		{
			$("> ul li",myDropdown).slideDown(400);
			event.stopPropagation();
		}
		else
		{
			$("> ul li",myDropdown).clearQueue();
			$("> ul li",myDropdown).fadeOut();
		}
			
    });
}
function selectOption()
{
	//this function active select option component:
	var myTarget = $(".selectOption");
	$(myTarget).click(function(event) {
        if( $(".selectOptionOptions",this).css("display")=="none")
		{
			closeSelectOption();
			$(".selectOptionOptions",this).slideDown(400);
			event.stopPropagation();
		}else
		{
			closeSelectOption();
		}		
    });
	$(".selectOptionOptions li",myTarget).click(function(e) {
        var parentSelectOption = $(this).parent().parent();
		$(".selectOptionData input",parentSelectOption).val( $(this).text());
    });
	$(".selectOptionData input",myTarget).focusin(function(){$(this).blur()});
}

function tab2()
{
	var myTarget = $(".tab");
	$(".tabHeader li",myTarget).click(function(e) {
		if(!$(this).hasClass('active'))
		{
			$(".tabHeader li",myTarget).removeClass("active");
			var currentLi = $(".tabHeader li",myTarget).index(this);
			$(".tabContent > div",myTarget).fadeOut(400,function(){$(".tabContent div",myTarget).removeClass("active");})
			
			$(this).addClass("active");
			$(".tabContent > div",myTarget).eq(currentLi).delay(410).fadeIn(400,function(){$(".tabContent div",myTarget).eq(currentLi).addClass("active");})
		}
    });
}

function reader_tab()
{
	var myTarget = $(".readertab");
	$(".reader_tabHeader li",myTarget).click(function(e) {
		if(!$(this).hasClass('active'))
		{
			$(".reader_tabHeader li",myTarget).removeClass("active");
			var currentLi = $(".reader_tabHeader li",myTarget).index(this);
			$(".reader_tabContent > div",myTarget).fadeOut(400,function(){$(".reader_tabContent div",myTarget).removeClass("active");})
			
			$(this).addClass("active");
			$(".reader_tabContent > div",myTarget).eq(currentLi).delay(410).fadeIn(300/*,function(){$(".reader_tabContent div",myTarget).eq(currentLi).addClass("active");}*/)
		}
    });
}

function adminMessage(caller,text,color,fader)
{
	var randomClass = 'adminmsg'+Math.round(Math.random()*1000);
	$(caller).parent().prepend('<div class="adminMessage '+randomClass+' '+color+'">'+text+'</div>');
	if(fader){setTimeout(function(){$('.'+randomClass).fadeOut(400)},5000);}
}
function loading(address,element,params,callbackFunc,callBackFuncParams)
{
	$(element).html('<div class="loadingPage"><div class="loaderCycle"></div><span>در حال بارگزاری</span></div>' );
	
	$.ajax({
		url:address,
		data:params,
		success:function(result){
			$(element).html(result);
			$('.loadingPage').fadeOut(400,function(){$("div.loaderCycle",element).remove();});
			
			if(typeof callbackFunc !== "undefined") {
				if(typeof callBackFuncParams !== "undefined")
					callbackFunc(callBackFuncParams);
					else
					callbackFunc();
				}
		},
		error:function(result){alert('there is some errors . please refresh your page or try later...')},
		complete:function(result){
		}
		
	})
}
function popUp(address,params,callbackFunc,callBackFuncParams)
{
	$('body').prepend("<div id='modal'></div>");
	loading(address,$("#modal"),params,callbackFunc,callBackFuncParams);
	
	//single scroll bar
	$('body').css('overflow','hidden');
	$('.modalContent','#modal').css('overflow-x','scroll');
	
}
function modalCloser()
{
	$(".modalCloser").click(function(e) {
        $('#modal').fadeOut(400);
		setTimeout(function(){$("#modal").remove();},410)
		$('body').css('overflow','auto');
    });
}
function remove_modal(){
		$('#modal').fadeOut(400);
		setTimeout(function(){$("#modal").remove();},410)
		$('body').css('overflow','auto');
}
function addModalIframe(element,src,scrll,height)
{
	//scrll must be yes or no
	$(element).html('<div class="loaderCycle"></div>' );
	var iframStr = '<iframe class="modalIframe" src="'+src+'" scrolling="'+scrll+'" height="'+height+'" allowtransparency="true"></iframe>';
	$(element).append(iframStr);
	$('.modalIframe').load(function(e) {
		
        $('.loaderCycle',element).fadeOut(200,function(){$('.loaderCycle',element).remove()});
		$('.modalIframe',element).delay(210).fadeIn(300,function(){makeCenterVer($("#modal .modalMain"));});
		
    });
}
function fileUpload()
{
	var myTarget = $('.fileUpload');
	$('.btn',myTarget).click(function(e) {
       var myParent = $(this).parent(); 
	   $('input[type="file"]',myParent).trigger('click');
    });

}

function textBoxCounter(maxLenght)
{
	var myTarget = $('.textBoxCounter');
	$('textarea',myTarget).bind('input propertychange', function() {
        var parent = $(this).parent();
		var count =maxLenght - $('textarea',parent).val().length;
		$('.counter',parent).text( maxLenght - $('textarea',parent).val().length);
        //$('.counter',parent).text('100');
	});
		$('textarea',myTarget).focusin(function(e) {
			var parent = $(this).parent();
			$('.counter',parent).fadeIn(1000);
		});
		$('textarea',myTarget).focusout(function(e) {
			var parent = $(this).parent();
			$('.counter',parent).fadeOut(1000);
		});
}

function clear_message(ttime){
	jQuery(document).ready(function () {
	setTimeout( "jQuery('.adminMessage').hide();",ttime );
	});
}





