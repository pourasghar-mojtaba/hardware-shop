// JavaScript Document

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


$(document).ready(function()
	{

		/* add post */
		$('#AddPostForm').on('submit', function(e)
			{
				e.preventDefault();
				var newpost_str =$('#newpost_input').val();
				if(newpost_str.trim()=='')
				{
					show_warning_msg(_enter_text);
					e.preventDefault();
					return false;
				}

				var newpost_video =$('#newpost_video').val();
				/*if(newpost_video.trim()!='')
				{

					if(!newpost_video.endsWith('</iframe>') )
					{
						show_warning_msg(_enter_valid_iframe);
						e.preventDefault();
						return false;
					}
				}*/

				$('body').prepend("<div id='modal'></div>");
				$("#modal").html('<div class="loadingPage"><div class="loaderCycle"></div><span>در حال بارگزاری</span></div>' );
				$(this).ajaxSubmit(
					{
						target: '#post_result',
						success:  afterPostSuccess , //call function after success
						error  :  afterPostError
					});
			});

		function afterPostSuccess()
		{
			$('#AddPostForm').resetForm();  // reset form
			$('.loadingPage').fadeOut(400,function(){$("div.loaderCycle",$("#modal")).remove();});
			$("#modal").remove();
			$('#newpost_input').val('');
			//show_success_msg(_save_post_success);
			$('#video_preview').html("");
			refresh_doctor_new_post("#post_location",0);
		}

		function afterPostError()
		{
			show_error_msg(_save_post_notsuccess);
		}

		$('#newpost_image').change(function()
			{

				var count = 0;
				var arr = $("#newpost_image_attachment").map(function()
					{
						count+=1;
					});
				if(count>=1)
				{
					show_warning_msg(_exist_image);return;
				}

				var attach="<span class='imageStatus' id='newpost_image_attachment'><span style='cursor:pointer' class='icon icon-cancel clearInput' id='closethis'> x </span>"+_image_added+"</span>";
				$('#NewPost').append(attach);

				$("#closethis").click(function(e)
					{
						//$(this).parent().remove();
						$(this).parent().fadeOut(200,function(){$(this).remove()});
					});
			});





		/* add charity post */
		$('#AddCharityPostForm').on('submit', function(e)
			{
				e.preventDefault();
				var newpost_str =$('#newpost_input').val();
				if(newpost_str.trim()=='')
				{
					show_warning_msg(_enter_text);
					e.preventDefault();
					return false;
				}
				$('body').prepend("<div id='modal'></div>");
				$("#modal").html('<div class="loadingPage"><div class="loaderCycle"></div><span>در حال بارگزاری</span></div>' );
				$(this).ajaxSubmit(
					{
						target: '#post_result',
						success:  afterCharityPostSuccess , //call function after success
						error  :  afterCharityPostError
					});
			});

		function afterCharityPostSuccess()
		{
			$('#AddCharityPostForm').resetForm();  // reset form
			$('.loadingPage').fadeOut(400,function(){$("div.loaderCycle",$("#modal")).remove();});
			$("#modal").remove();
			$('#newpost_input').val('');
			//show_success_msg(_save_post_success);
			refresh_charity_new_post("#post_location",0);
			$('#video_preview').html("");
		}

		function afterCharityPostError()
		{
			show_error_msg(_save_post_notsuccess);
		}

	});

function refresh_tag(count,tag)
{
	$("#tag_loading").html('<img src="'+_url+'/img/loader/loader.gif" >');
	if(tag=='undefined')
	{
		tag='';
	}
	var first =  count * 5;
	$.ajax(
		{
			type:"POST",
			url:_url+'posts/refresh_tag',
			data:'first='+first+'&tag='+tag,
			success:function(response)
			{
				$('#tag_body').prepend(response);
				$("#tag_loading").html('');
			}
		}) ;
}

function refresh_doctor_post(element,count,user_id,islogin)
{
	$('#post_loading').html('<img src="'+_url+'/img/loader/loader.gif" >');
	var first =  count * 5;

	/*if(islogin==0 && first ==0)
	{
		$.ajax(
			{
				type:"POST",
				url:_url+'posts/refresh_doctor_post/'+user_id,
				data:'first='+first,

				success:function(response)
				{
					$('#post_loading').html('');
					$('#post_body').prepend(response);
				}
			}) ;
	}
	if(islogin==1)
	{*/
		$.ajax(
			{
				type:"POST",
				url:_url+'posts/refresh_doctor_post/'+user_id,
				data:'first='+first,

				success:function(response)
				{
					$('#post_loading').html('');
					$('#post_body').prepend(response);
				}
			}) ;
	//}

}

function refresh_doctor_new_post(element,count)
{
	$('#post_loading').html('<img src="'+_url+'/img/loader/loader.gif" style="margin-right: 280px;">');
	var first =  count * 5;
	$.ajax(
		{
			type:"POST",
			url:_url+'posts/refresh_doctor_post',
			data:'first='+first,

			success:function(response)
			{
				$('#post_loading').html('');
				$('#post_body').html(response);
			}
		}) ;
}
function refresh_doctor_journal(element,count,id)
{
	$('#journal_loading').html('<img src="'+_url+'/img/loader/loader.gif" style="margin-right: 280px;">');
	var first =  count * 10;
	$.ajax(
		{
			type:"POST",
			url:_url+'posts/refresh_doctor_journal',
			data:'first='+first+'&id='+id,

			success:function(response)
			{
				$('#journal_loading').html('');
				$('#journal_body').prepend(response);
			}
		}) ;
}
function refresh_post(element,count,user_id,islogin)
{
	$('#post_loading').html('<img src="'+_url+'/img/loader/loader.gif" >');
	var first =  count * 5;

	/*if(islogin==0 && first ==0)
	{
		$.ajax(
			{
				type:"POST",
				url:_url+'posts/refresh_post/'+user_id,
				data:'first='+first,

				success:function(response)
				{
					$('#post_loading').html('');
					$('#post_body').prepend(response);
				}
			}) ;
	} 
	if(islogin==1)
	{*/
		$.ajax(
			{
				type:"POST",
				url:_url+'posts/refresh_post/'+user_id,
				data:'first='+first,

				success:function(response)
				{
					$('#post_loading').html('');
					$('#post_body').prepend(response);
				}
			}) ;
	//}
}
function refresh_new_post(element,count)
{
	$('#post_loading').html('<img src="'+_url+'/img/loader/loader.gif" style="margin-right: 280px;">');
	var first =  count * 5;
	$.ajax(
		{
			type:"POST",
			url:_url+'posts/refresh_post',
			data:'first='+first,

			success:function(response)
			{
				$('#post_loading').html('');
				$('#post_body').html(response);
			}
		}) ;
}

function refresh_question(element,user_id,count,user_type)
{
	$('#question_loading').html('<img src="'+_url+'/img/loader/loader.gif" >');
	var first =  count * 5;
	$.ajax(
		{
			type:"POST",
			url:_url+'questions/refresh_question/'+user_id+'/'+user_type,
			data:'first='+first,

			success:function(response)
			{
				$('#question_loading').html('');
				$('#question_body').prepend(response);
			}
		}) ;
}


function refresh_article(element,user_id,count,user_type)
{
	$('#article_loading').html('<img src="'+_url+'/img/loader/loader.gif" >');
	var first =  count * 5;
	$.ajax(
		{
			type:"POST",
			url:_url+'articles/refresh_article/'+user_id+'/'+user_type,
			data:'first='+first,

			success:function(response)
			{
				$('#article_loading').html('');
				$('#article_body').prepend(response);
			}
		}) ;
}

function refresh_events(user_id,count,user_type)
{
	$('#event_loading').html('<img src="'+_url+'/img/loader/loader.gif" >');
	//alert(count);
	var first =  count * 5;
	$.ajax(
		{
			type:"POST",
			url:_url+'charityevents/refresh_events/'+user_id+'/'+user_type,
			data:'first='+first,

			success:function(response)
			{
				$('#event_loading').html('');
				$('#event_body').prepend(response);
			}
		}) ;
}

function show_gallery(id)
{
	$('#gallery_loading').html('<img src="'+_url+'/img/loader/loader.gif" >');
	$.ajax(
		{
			type:"POST",
			url:_url+'galleryimages/show_gallery/'+id,
			data:'',

			success:function(response)
			{
				$('#gallery_loading').html('');
				$('#gallery_location').html(response);
			}
		}) ;
}

function send_privacy_email(user_id,location,text,post_id)
{

	$.ajax(
		{
			type: "POST",
			url: _url+'sendemails/send_email',
			data: 'user_id='+user_id+'&location='+location+'&text='+text+'&post_id='+post_id,
			cache: false,
			success: function(html)
			{
				$('#ajax_result').html(html);
			}

		});

}

function refresh_notification(count)
{
	if(count > 0) $("#notification_loading").html('<img src="'+_url+'/img/loader/5.gif" >');
	var first =  count * 10;
	$.ajax(
		{
			type:"POST",
			url:_url+'users/get_notofication_list',
			data:'first='+first,
			success:function(response)
			{
				if(count<=0)
				{
					$('#notification_body').html(response);
				}else $('#notification_body').append(response);
				if(count > 0) $("#notification_loading").empty();
			}
		}) ;
}
/*
follow and not_follow
*/
function follow(id,user_type)
{
	$.ajax(
		{
			type:"POST",
			url:_url+'follows/follow',
			data:'id='+id+'&user_type='+user_type,
			dataType: "json",
			success:function(response)
			{
				// hide table row on success
				if(response.success == true)
				{
					$('#follow_btn_'+id).remove();
					var not_follow_btn=$("<div class='btn red' onclick='not_follow("+id+","+user_type+");' id='not_follow_btn_"+id+"'><span>"+_no_follow+"</span><span class='icon icon-angle-circled-left'></span></div>");
					$("#extraBtn_"+id).append(not_follow_btn);
					send_privacy_email(id,'onfollow','',0);

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

function journal_follow(id,user_type)
{
	$.ajax(
		{
			type:"POST",
			url:_url+'follows/follow',
			data:'id='+id+'&user_type='+user_type,
			dataType: "json",
			success:function(response)
			{
				// hide table row on success
				if(response.success == true)
				{
					$('#follow_btn_'+id).remove();
					var not_follow_btn=$("<a style='color:red' href='javascript:void(0)' onclick='journal_not_follow("+id+","+user_type+");' id='not_follow_btn_"+id+"'>"+_no_follow+"</a>");
					$("#extraBtn_"+id).append(not_follow_btn);
					send_privacy_email(id,'onfollow','',0);

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

function not_follow(id,user_type)
{
	$.ajax(
		{
			type:"POST",
			url:_url+'follows/not_follow',
			data:'id='+id+'&user_type='+user_type,
			dataType: "json",
			success:function(response)
			{
				// hide table row on success
				if(response.success == true)
				{
					$('#not_follow_btn_'+id).remove();
					var follow_btn=$("<div class='btn green' onclick='follow("+id+","+user_type+");' id='follow_btn_"+id+"'><span>"+_you_follow+"</span><span class='icon icon-angle-circled-left'></span></div>");
					$("#extraBtn_"+id).append(follow_btn);

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

function journal_not_follow(id,user_type)
{
	$.ajax(
		{
			type:"POST",
			url:_url+'follows/not_follow',
			data:'id='+id+'&user_type='+user_type,
			dataType: "json",
			success:function(response)
			{
				// hide table row on success
				if(response.success == true)
				{
					$('#not_follow_btn_'+id).remove();
					var follow_btn=$("<a href='javascript:void(0)' onclick='journal_follow("+id+","+user_type+");' id='follow_btn_"+id+"'>"+_you_follow+"</a>");
					$("#extraBtn_"+id).append(follow_btn);

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



function refresh_charity_post(element,count,user_id,islogin)
{
	$('#post_loading').html('<img src="'+_url+'/img/loader/loader.gif" >');
	var first =  count * 5;

	/*if(islogin==0 && first ==0)
	{
		$.ajax(
			{
				type:"POST",
				url:_url+'posts/refresh_charity_post/'+user_id,
				data:'first='+first,

				success:function(response)
				{
					$('#post_loading').html('');
					$('#post_body').prepend(response);
				}
			}) ;
	}
	if(islogin==1)
	{*/
		$.ajax(
			{
				type:"POST",
				url:_url+'posts/refresh_charity_post/'+user_id,
				data:'first='+first,

				success:function(response)
				{
					$('#post_loading').html('');
					$('#post_body').prepend(response);
				}
			}) ;
//	} 

}
function refresh_charity_new_post(element,count)
{
	$('#post_loading').html('<img src="'+_url+'/img/loader/loader.gif" style="margin-right: 280px;">');
	var first =  count * 5;
	$.ajax(
		{
			type:"POST",
			url:_url+'posts/refresh_charity_post',
			data:'first='+first,

			success:function(response)
			{
				$('#post_loading').html('');
				$('#post_body').html(response);
			}
		}) ;
}

function delete_post_confirm(id)
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
						delete_post(id);
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
function delete_post(id,parent_id_arr)
{
	$("#delete_post_loading_"+id).html('<img src="'+_url+'/img/loader/5.gif" >');

	$.ajax(
		{
			type: "POST",
			url: _url+'posts/post_delete',
			data: 'post_id='+id,
			dataType: "json",
			success: function(response)
			{
				$("#delete_post_loading_"+id).empty();
				if(response.success == true)
				{
					$('#post_'+id).slideUp('slow').hide();
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

function show_doctor_search_courts(id,court_id)
{
	var current_url='';
	if(court_id==0)
	{
		current_url = _url+'courts/get_search_courts/doctor/'+id;
	}
	else if(court_id>0)
	{
		current_url = _url+'courts/get_search_courts/doctor/'+id+'/'+court_id;
	}
	$("#doctor_court_loading").html('<img src="'+_url+'/img/loader/5.gif" >');
	$.ajax(
		{
			type:"POST",
			url:current_url,
			data:'',
			success:function(response)
			{
				$("#doctor_court_load_place").html(response);

				$("#doctor_court_loading").empty();
				var myTarget = $(".selectOption");
				$(".selectOptionOptions li",myTarget).click(function(e)
					{
						var parentSelectOption = $(this).parent().parent();
						$(".selectOptionData input[type=text]",parentSelectOption).val( $(this).text().trim());
						$(".selectOptionData input[type=hidden]",parentSelectOption).val( $(this).val());								
					});
					
					$("#court_id").select2({
						"language": "fa"
					});
					
			}

		});
}


function show_doctor_search_cities(id,city_id)
{
	var current_url='';
	if(city_id==0)
	{
		current_url = _url+'cities/get_search_cities/doctor/'+id;
	}
	else if(city_id>0)
	{
		current_url = _url+'cities/get_search_cities/doctor/'+id+'/'+city_id;
	}
	$("#doctor_city_loading").html('<img src="'+_url+'/img/loader/5.gif" >');
	$.ajax(
		{
			type:"POST",
			url:current_url,
			data:'',
			success:function(response)
			{
				$("#doctor_city_load_place").html(response);
				$("#doctor_city_loading").empty();
				var myTarget = $(".selectOption");
				$(".selectOptionOptions li",myTarget).click(function(e)
					{
						var parentSelectOption = $(this).parent().parent();
						$(".selectOptionData input[type=text]",parentSelectOption).val( $(this).text().trim());
						$(".selectOptionData input[type=hidden]",parentSelectOption).val( $(this).val());
					});
				/*if(city_id==0)
				show_locals($('#city_load_place'+' option:selected').val(),0);*/
				$("#city_id").select2({
					"language": "fa"
				});					
			}

		});
}

function show_doctor_search_locals(id,local_id)
{
	var current_url='';
	if(local_id==0)
	{
		current_url = _url+'locals/get_search_locals/doctor/'+id;
	}
	else if(local_id>0)
	{
		current_url = _url+'locals/get_search_locals/doctor/'+id+'/'+local_id;
	}
	$("#doctor_local_loading").html('<img src="'+_url+'/img/loader/5.gif" >');
	$.ajax(
		{
			type:"POST",
			url:current_url,
			data:'',
			success:function(response)
			{
				$("#doctor_local_load_place").html(response);
				$("#doctor_local_loading").empty();
				var myTarget = $(".selectOption");
				$(".selectOptionOptions li",myTarget).click(function(e)
					{
						var parentSelectOption = $(this).parent().parent();
						$(".selectOptionData input[type=text]",parentSelectOption).val( $(this).text());
						$(".selectOptionData input[type=hidden]",parentSelectOption).val( $(this).val());
					});
				$("#local_id").select2({
					"language": "fa"
				});	
			}

		});
}
function show_charity_search_courts(id,court_id)
{
	var current_url='';
	if(court_id==0)
	{
		current_url = _url+'courts/get_search_courts/charity/'+id;
	}
	else if(court_id>0)
	{
		current_url = _url+'courts/get_search_courts/charity/'+id+'/'+court_id;
	}
	$("#charity_court_loading").html('<img src="'+_url+'/img/loader/5.gif" >');
	$.ajax(
		{
			type:"POST",
			url:current_url,
			data:'',
			success:function(response)
			{
				$("#charity_court_load_place").html(response);
				$("#charity_court_loading").empty();
				var myTarget = $(".selectOption");
				$(".selectOptionOptions li",myTarget).click(function(e)
					{
						var parentSelectOption = $(this).parent().parent();
						$(".selectOptionData input[type=text]",parentSelectOption).val( $(this).text().trim());
						$(".selectOptionData input[type=hidden]",parentSelectOption).val( $(this).val());
					});
				$("#charity_court_id").select2({
					"language": "fa"
				});	
			}

		});
}


function show_charity_search_cities(id,city_id)
{
	var current_url='';
	if(city_id==0)
	{
		current_url = _url+'cities/get_search_cities/charity/'+id;
	}
	else if(city_id>0)
	{
		current_url = _url+'cities/get_search_cities/charity/'+id+'/'+city_id;
	}
	$("#charity_city_loading").html('<img src="'+_url+'/img/loader/5.gif" >');
	$.ajax(
		{
			type:"POST",
			url:current_url,
			data:'',
			success:function(response)
			{
				$("#charity_city_load_place").html(response);
				$("#charity_city_loading").empty();
				var myTarget = $(".selectOption");
				$(".selectOptionOptions li",myTarget).click(function(e)
					{
						var parentSelectOption = $(this).parent().parent();
						$(".selectOptionData input[type=text]",parentSelectOption).val( $(this).text().trim());
						$(".selectOptionData input[type=hidden]",parentSelectOption).val( $(this).val());
					});
				/*if(city_id==0)
				show_locals($('#city_load_place'+' option:selected').val(),0);*/
				$("#charity_city_id").select2({
					"language": "fa"
				});
			}

		});
}

function show_charity_search_locals(id,local_id)
{
	var current_url='';
	if(local_id==0)
	{
		current_url = _url+'locals/get_search_locals/charity/'+id;
	}
	else if(local_id>0)
	{
		current_url = _url+'locals/get_search_locals/charity/'+id+'/'+local_id;
	}
	$("#charity_local_loading").html('<img src="'+_url+'/img/loader/5.gif" >');
	$.ajax(
		{
			type:"POST",
			url:current_url,
			data:'',
			success:function(response)
			{
				$("#charity_local_load_place").html(response);
				$("#charity_local_loading").empty();
				var myTarget = $(".selectOption");
				$(".selectOptionOptions li",myTarget).click(function(e)
					{
						var parentSelectOption = $(this).parent().parent();
						$(".selectOptionData input[type=text]",parentSelectOption).val( $(this).text());
						$(".selectOptionData input[type=hidden]",parentSelectOption).val( $(this).val());
					});
				
				$("#charity_local_id").select2({
					"language": "fa"
				});
			}

		});
		
}



function search_home(count)
{
	//alert(count);
	var first =  count * 5;
	$("#result_search_loading").html('<img src="'+_url+'/img/loader/loader.gif" >');

	$.ajax(
		{
			type:"POST",
			url:_url+'users/ajax_search',
			data:'first='+first,
			success:function(response)
			{
				$('#search_result_body').append(response);
				$("#result_search_loading").empty();
			}
		}) ;
}
function checkdir(body,post_id)
{

	if(body.charAt(0).charCodeAt(0) < 200 )
	{
		$('#postcontent_'+post_id).css('direction','ltr');
		$('#postcontent_'+post_id).css('text-align','left');
	} else
	{
		$('#postcontent_'+post_id).css('direction','rtl');
		$('#postcontent_'+post_id).css('text-align','right');
	}
}

function delete_answer_confirm(id)
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
						delete_answer(id);
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
function delete_answer(id)
{
	$("#delete_subject_loading_"+id).html('<img src="'+_url+'/img/loader/5.gif" >');

	$.ajax(
		{
			type: "POST",
			url: _url+'discussionanswers/answer_delete',
			data: 'answer_id='+id,
			dataType: "json",
			success: function(response)
			{
				$("#delete_subject_loading_"+id).empty();
				if(response.success == true)
				{
					$('#answer_'+id).slideUp('slow').hide(function(){$(this).remove()});
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

function check_direction(str,item_name)
{
	//var str = $('#item').val();  //this is your text box
	var firstChar = str.substr(0,1);
	//alert(firstChar);
	var characters = ['ا','ب','پ','ت','س','ج','چ','ح','خ','د','ذ','ر','ز','ژ','س','ش','ص','ض','ط','ظ','ع','غ','ف','ق','ک','گ','ل','م','ن','و','ه','ی'];
	function checkPersian()
	{
		var result = false;
		for (i = 0 ; i<32 ; i++)
		{
			if (characters[i] == firstChar)
			{
				result = true;
			}
		}
		return result;
	}
	if (checkPersian())
	{
		$(item_name).css('text-align','right');
	} else
	{
		$(item_name).css('text-align','left');
	}
}
function get_span_arr(item)
{

	var tarr = [];
	$(item).each(function()
		{
			tarr.push($(this).find('input').attr('title'));
		});

	return tarr;
}

function add_to_basket(product_id,user_id,basket_loading)
{
	if(user_id==0)
	{
		show_warning_msg(_not_login_in_site);
		return;
	}

	$(basket_loading).show();


	$.ajax(
		{
			type:"POST",
			url:_url+'products/add_to_basket',
			data:'product_id='+product_id,
			dataType: "json",
			success:function(response)
			{
				// hide table row on success
				if(response.success == true)
				{

					var main_counter = $('#main_counter span').text();
					if(main_counter=='')
					{
						main_counter = 0;
					}
					main_counter = parseInt(main_counter)+ 1;

					if(main_counter==1)
					{
						var span = "<span class='counter' >"+main_counter+"</span>";
						$('#main_counter').html(span);
						$('#mobile_counter').html(span);
					}
					else
					{
						$('#main_counter span').text(main_counter);
						$('#mobile_counter span').text(main_counter);
					}
					show_success_msg(response.message);
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

function refresh_article_tags(count,tag)
{
	$("#tag_loading").html('<img src="'+_url+'/img/loader/loader.gif" >');
	if(tag=='undefined')
	{
		tag='';
	}
	var first =  count * 5;
	$.ajax(
		{
			type:"POST",
			url:_url+'articles/refresh_tag',
			data:'first='+first+'&tag='+tag,
			success:function(response)
			{
				$('#tag_body').prepend(response);
				$("#tag_loading").html('');
			}
		}) ;
}

function refresh_article_search(count,title,title_en,publish_year,author)
{
	$("#search_loading").html('<img src="'+_url+'/img/loader/loader.gif" >');
	var first =  count * 5;
	$.ajax(
		{
			type:"POST",
			url:_url+'articles/refresh_search',
			data:'first='+first+'&title='+title+'&title_en='+title_en+'&publish_year='+publish_year+'&author='+author,
			success:function(response)
			{
				$('#search_body').prepend(response);
				$("#search_loading").html('');
			}
		}) ;
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
function initMap(lat,lng,location,ucontentString,utitle) {
		var uluru = {lat: lat, lng: lng};
		var map = new google.maps.Map(document.getElementById(location), {
				zoom: 15,
				center: uluru
			});

		var infowindow = new google.maps.InfoWindow({
				content: ucontentString,
				maxWidth: 200
			});

		var marker = new google.maps.Marker({
				position: uluru,
				map: map,
				title: utitle
			});
		marker.addListener('click', function() {
				infowindow.open(map, marker);
			});
	}