// JavaScript Document

function check_field()
{
	 
	var user_name =$('#user_name').val();
	if(user_name.trim()=='')
	{
		adminMessage($("#user_name").parent(),_enter_user_name,'red',true);
		return false;
	}	 	
	 
	var mobile =$('#mobile').val();
	if(mobile.trim()=='')
	{
		adminMessage($("#mobile").parent(),_enter_mobile,'red',true);
		return false;
	}	 

	if($('#password').val().length<6)
	{
		adminMessage($("#password").parent(),_enter_valid_length,'red',true);
		return false;
	}

	if($("#cpassword").val() != $("#password").val())
	{
		adminMessage($("#password").parent(),_the_passwords_not_equal,'red',true);
		return false;
	}

	return true;
}

function check_forget_fields()
{
	
	if ($("#Radiomail").is(':checked')) {
 
		var email =$('#forget_email').val();
		if(email.trim()=='')
		{
			show_error_msg(_enter_email);
			return false;
		}

		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

		if (!emailReg.test( $('#forget_email').val() ) )
		{		
			show_error_msg(_enter_valid_email);
			return false;
		}
	}
	
	if ($("#Radiosms").is(':checked')) {
		var mobile =$('#forget_mobile').val();
		if(mobile.trim()=='')
		{
			show_error_msg(_enter_mobile);
			return false;
		}	
	}



	return true;
}
function check_complete_field()
{
	if($('#user_name').val()=='')
	{
		adminMessage($("#user_name").parent(),_enter_user_name,'red',true);
		return false;
	}
	var userReg = /^[0-9a-zA-Z_]+$/;

	if (!userReg.test( $('#user_name').val() ) )
	{
		adminMessage($("#user_name").parent(),_enter_valid_user_name,'red',true);
		return false;
	}
	return true;
}

function check_email()
{

	var email = $('#email').val();
	if(email=='')
	{
		return false;
	}
	$.ajax(
		{
			type:"POST",
			data:'email='+email,
			dataType: "json",
			url:_url+"users/check_email",
			success:function(response)
			{
				if(response.success == true)
				{
					if( response.message )
					{
						adminMessage($('#email').parent(),response.message,'green',true);
						error=true;
					}
				}
				else
				{
					if( response.message )
					{
						adminMessage($('#email').parent(),response.message,'red',true);
						error=false;
					}
				}
			}

		});

}
function check_user_name()
{

	var user_name = $('#user_name').val();
	if(user_name=='')
	{
		return false;
	}
	$.ajax(
		{
			type:"POST",
			data:'user_name='+user_name,
			dataType: "json",
			url:_url+"users/check_user_name",
			success:function(response)
			{
				if(response.success == true)
				{
					if( response.message )
					{
						adminMessage($('#user_name').parent(),response.message,'green',true);
						error=true;
					}
				}
				else
				{
					if( response.message )
					{
						adminMessage($('#user_name').parent(),response.message,'red',true);
						error=false;
					}
				}
			}

		});

}



function submitForm(aaa)
{
	$(aaa).parent().submit();
}

$(document).ready(
	function()
	{
		$("form#loginform").submit(function()
			{

				var email = $('#login_email').val();
				var password=$('#login_password').val();
				var login_captcha=$('#login_captcha').val();
				var remember_me = 0;

				if($('#remember_me').attr('checked')=='checked')	  remember_me = 1;
				$('#login_btn').attr('disabled','disabled');
				$('#register_ajax_loader').show();
				var values = $(this).serialize();
				$.ajax(
					{
						type:"POST",
						url:_url+'users/login',
						data:values,
						dataType: "json",
						success:function(response)
						{
							// hide loading image
							$('#register_ajax_loader').hide();

							if(response.success == true)
							{
								window.location.href=response.url;
							}
							if(response.visible_captcha == true)
							{
								$('#visible_captcha').fadeIn(400);
								$('#visible_captcha_box').fadeIn(400);
							}
							// show respsonse message
							if( response.message && response.success ==true)
							{
								$.Zebra_Dialog(response.message,
									{
										'type':     'confirmation',
										'title':    _message,
										'modal': true ,
										'auto_close': 1500 ,
										'buttons':  [
											{
												caption: _close, callback: function()
												{
												}
											}
										]
									});



							}
							if( response.message && response.success ==false)
							{

								$.Zebra_Dialog(response.message,
									{
										'type':     'error',
										'title':    _warning,
										'modal': true ,
										'buttons':  [
											{
												caption: _close, callback: function()
												{
												}
											}
										]
									});
							}


							$('#login_btn').removeAttr('disabled');
						}
					});
				return false;
			});
			
		$("form#msform").submit(function()
			{

				var email = $('#login_email').val();
				var password=$('#login_password').val();
				var login_captcha=$('#login_captcha').val();
				var remember_me = 0;

				if($('#remember_me').attr('checked')=='checked')	  remember_me = 1;
				$('#login_btn').attr('disabled','disabled');
				$('#register_ajax_loader').show();
				var values = $(this).serialize();
				$.ajax(
					{
						type:"POST",
						url:_url+'users/login?redirect_url='+window.location.href,
						data:values,
						dataType: "json",
						success:function(response)
						{
							// hide loading image
							$('#register_ajax_loader').hide();

							if(response.success == true)
							{
								window.location.href=response.url;
							}
							if(response.visible_captcha == true)
							{
								$('#visible_captcha').fadeIn(400);
								$('#visible_captcha_box').fadeIn(400);
							}
							// show respsonse message
							if( response.message && response.success ==true)
							{
								$.Zebra_Dialog(response.message,
									{
										'type':     'confirmation',
										'title':    _message,
										'modal': true ,
										'auto_close': 1500 ,
										'buttons':  [
											{
												caption: _close, callback: function()
												{
												}
											}
										]
									});



							}
							if( response.message && response.success ==false)
							{

								$.Zebra_Dialog(response.message,
									{
										'type':     'error',
										'title':    _warning,
										'modal': true ,
										'buttons':  [
											{
												caption: _close, callback: function()
												{
												}
											}
										]
									});
							}


							$('#login_btn').removeAttr('disabled');
						}
					});
				return false;
			});

		function check_captcha()
		{
			var captcha = $('#captcha').val();
			if(captcha=='')
			{
				return false;
			}
			$.ajax(
				{
					type:"POST",
					url:_url+'users/check_captcha',
					data:'captcha='+captcha,
					dataType: "json",
					success:function(response)
					{
						if(response.success == true)
						{
							if( response.message )
							error=true;
						}
						else
						{
							if( response.message )
							jQuery('#captcha').validationEngine('showPrompt',response.message,false,'captcha');
							error=false;
						}

						// show respsonse message
						if( response.message )
						{

						}
					}
				});
			return error;
		}

		$('#captcha').focusout(function()
			{

				check_captcha();
			});

		function valid_item()
		{
			if (!check_email()) return false;
			return true;
		}

		$('#email').focusout(function()
			{
				check_email();
			});

		$('#user_name').focusout(function()
			{
				check_user_name();
			});



		$('#country_select').change(function()
			{
				show_courts($(this).val(),0);
			})


		$('#court_select').change(function()
			{
				show_cities($(this).val(),0);
			})

		$('#city_select').change(function()
			{
				show_locals($(this).val(),0);
			})

		$("input[name='register_type']").click(function() {
				if ($(this).val() == '0') {
					$("#with_email").fadeIn().show();
					$("#with_sms").fadeOut().hide();
				} else if ($(this).val() == '1') {
					$("#with_sms").fadeIn().show();
					$("#with_email").fadeOut().hide();
				} 
			});

	});

function show_courts(id,court_id,city_id,local_id)
{
	//console.log($(this).val());
	$("#court_loading").html('<img src="'+_url+'/img/loader/5.gif" >');
	$.ajax(
		{
			type:"POST",
			url:_url+'courts/get_courts/'+id+'/'+court_id,
			data:'',
			success:function(response)
			{
				$("#court_select").html(response);
				$("#court_loading").empty();
				show_cities($('#court_select option:selected').val(),city_id,local_id);
			}

		});
}

function show_cities(id,city_id,local_id)
{
	//console.log($(this).val());
	$("#city_loading").html('<img src="'+_url+'/img/loader/5.gif" >');
	$.ajax(
		{
			type:"POST",
			url:_url+'cities/get_cities/'+id+'/'+city_id,
			data:'',
			success:function(response)
			{
				$("#city_select").html(response);
				$("#city_loading").empty();
				show_locals($('#city_select option:selected').val(),local_id);
			}

		});
}

function show_locals(id,local_id)
{
	$("#local_loading").html('<img src="'+_url+'/img/loader/5.gif" >');
	$.ajax(
		{
			type:"POST",
			url:_url+'locals/get_locals/'+id+'/'+local_id,
			data:'',
			success:function(response)
			{
				$("#local_select").html(response);
				$("#local_loading").empty();
			}

		});
}

//-------------------------------------
function get_plan(plan_type)
{
	$("#plan_loading").html('<img src="'+_url+'/img/loader/5.gif" >');
	$("#plan_location").html("");
	$.ajax(
		{
			type:"POST",
			url:_url+'plans/getplans/'+plan_type,
			data:'',
			success:function(response)
			{
				$("#plan_location").html(response);
				$("#plan_loading").empty();
			}

		});
}
$(document).ready(
	function()
	{
		/*$("#gold_plan").click(function(){
		get_plan(2);
		});*/
		
		$("#silver_plan").click(function(){
				get_plan(1);
			});
		
		$("#free_plan").click(function(){
				get_plan(0);
			});
	});