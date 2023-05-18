// JavaScript Document
_url = _url + "<?php echo __PRODUCT.'/' ?>";



function show_success_msg(msg,size)
{
	$.Zebra_Dialog(msg,
		{
			'type':     'confirmation',
			'title':    _message,
			'auto_close': 1500 ,
			'modal': false ,
			'width':size ,
			'buttons':  [
				{
					caption: _close, callback: function()
					{
					}
				}
			]
		});
}

function show_error_msg(msg,size)
{
	$.Zebra_Dialog(msg,
		{
			'type':     'error',
			'title':    _warning,
			/*'auto_close': 1500 ,*/
			'modal': false ,
			'width':size ,
			'buttons':  [
				{
					caption: _close, callback: function()
					{
					}
				}
			]
		});
}

function show_warning_msg(msg,size)
{
	$.Zebra_Dialog(msg,
		{
			'type':     'warning',
			'title':    _warning,
			/*'auto_close': 1500 ,*/
			'modal': false ,
			'width':size ,
			'buttons':  [
				{
					caption: _close, callback: function()
					{
					}
				}
			]
		});
}



function add_to_basket(product_id,count,basket_loading)
{
	$(basket_loading).show();

	$.ajax(
		{
			type:"POST",
			url:_url+'products/add_to_basket',
			data:'product_id='+product_id+'&count='+count,
			dataType: "json",
			success:function(response)
			{
				// hide table row on success
				if(response.success == true)
				{

					refresh_basket(product_id,0);
					//show_success_msg(response.message);
				}
				else
				{
					if( response.message )
					{
						show_error_msg(response.message);

					}
				}
				$(basket_loading).hide();

			}
		});

}

function refresh_basket(product_id,count)
{
	//alert();
	$('#basket_place').html('');
	$.ajax(
		{
			type:"POST",
			url:_url+'products/refresh_basket',
			data:'product_id='+product_id+'&count='+count,
			dataType: "json",
			success:function(response)
			{
				if(response.success == true)
				{
					//$('.basket_item').remove();
				//	$('#basket_drop_down').before(response.basket_html);
					//$('#basket_sum').html(response.basket_sum);

					//var span = "<span class='pin soft-edged secondary' >"+response.basket_count+"</span>";
					//$('#main_counter').html(span);

					$('#basket_place').html(response.basket_html);
					$('#basket_counter').html(response.basket_count);
				}
				else
				{
					show_error_msg(response.message);
				}
			}
		});

}
refresh_basket(0,0);


function delete_basket_confirm(id)
{
	$.Zebra_Dialog(_are_you_sure,
		{
			'type':     'warning',
			'title':    _warning,
			'modal': true ,
			'buttons':  [
				{
					caption: _yes, callback: function()
					{
						delete_product_from_basket(id);
					}
				},
				{
					caption: _no, callback: function()
					{
					}
				}
			]
		});
}
function delete_product_from_basket(id)
{


	$.ajax(
		{
			type: "POST",
			url: _url+'products/delete_product_from_basket',
			data: 'product_id='+id,
			dataType: "json",
			success: function(response)
			{

				if(response.success == true)
				{
					//$('#product_'+id).slideUp('slow').hide(function(){$(this).remove()});
					refresh_basket();
					if( response.message )
					{
					}
				}
				else
				{
					if( response.message )
					{
						show_error_msg(response.message);
					}
				}

			}

		});


}

function show_download_alert(){
	show_warning_msg( _login_for_download);
}

function show_loading(){
	$('.modalMain').append("<div class='box_loading'></div>");
	$(".box_loading").html('<img src="'+_url+'/img/loader/loader.gif" class="ajax-loader" >');
}

function hide_loading(){
	$(".box_loading").remove();
}

 function show_login_alert()
{
	show_warning_msg( _login_for_follow);
}
