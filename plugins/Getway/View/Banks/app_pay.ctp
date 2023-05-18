<script>
	
	var _gotobank = true;
	
</script>
<?php
	echo $this->Html->css('/getway/css/getway');
?>
<div id="alert_place">
<?php
echo $this->Html->css('setting_'.$locale);
	
	if($token!=$info['Token']['token']){
		echo "
			<div class='box'>
			   ".__('not_exist_pasy_info')."
			</div>
			<script>	
				_gotobank = false;				
			</script>
		";
		return;
	}
	
?>

</div>	
	
	
 
<script>
	if(_gotobank){
		var bank_url=_url+"getway/bankmellats/app_call?cn="+"<?php echo $info['Token']['cn']; ?>"+"&ac="+"<?php echo $info['Token']['ac']; ?>";
		$.ajax({
			type: "POST",
			url: bank_url,
			data: 'info=<?php echo $info; ?>',
			dataType: "json",
			success: function(response)
			{
			 	if(response.success == true) {					
					var form = document.createElement('form');
						form.setAttribute('method', 'POST');
						form.setAttribute('action', 'https://bpm.shaparak.ir/pgwchannel/startpay.mellat');		 
						form.setAttribute('target', '_self');
						var hiddenField = document.createElement('input');			  
						hiddenField.setAttribute('name', 'RefId');
						hiddenField.setAttribute('value', response.value);
						form.appendChild(hiddenField);
			
						document.body.appendChild(form);		 
						form.submit();
						document.body.removeChild(form);
				}
				else
				{
					if( response.message )
					{
						show_error_msg(response.message);
						$('#alert_place').html("<div class='box'>"+"<?php echo __('not_exist_pasy_info'); ?>"+"</div>");
					}	
				}	
				
				$('#ajax_result').html(response);
				$('#pay').removeAttr('disabled');
				$("#pay_loading").empty();	
			}
		
		  });
	}
    
					  
 

</script>
    