<?php
	//echo "mojtaba";
	echo $this->Html->css('/getway/css/getway');
	echo $this->Html->css('/getway/css/profile');
	$Pay_Info= $this->Session->read('Pay_Info');
	$User_Info= $this->Session->read('User_Info');


?>
<div class="pageContainer container-fluid" style="padding-bottom: 0px;">

    <div class="clear"></div>

    <div class="midContent">

		<div class="col-md-12 shop">

		   <?php /*echo $this->element('product_menu');*/ ?>

		   <div class="col-md-12">
		      <?php echo $this->Session->flash(); ?>
		        <section id="hp-ssod">
		            <div class="shadow_box" style="margin-top: 30px;margin-bottom:30px;" >


						 <div class="settingContent">
						 	<div class="col-sm-9 settingForms col-md-offset-1" style="margin-top: 10px;">
						         <form id="pay_form" name="pay_form">
									<div id="generalSetting">
										<div class="col-md-6">
											 <div id="title" class="col-md-3"> <?php echo __('title') ?> : </div>
											 <div id="title" class="col-md-6"><?php echo $Pay_Info['title']; ?></div>
							    		</div>

										<div class="col-md-6">
											 <div id="title" class="col-md-3"> <?php echo __d(__GATEWAY_LOCALE,'sum_price'); ?> : </div>
											 <div id="title" class="col-md-6"><?php echo number_format($Pay_Info['sum_price']).' '.__('rial'); ?></div>
							    		</div>

										<div class="col-md-6">
											 <div id="title" class="col-md-3"> <?php echo __('name') ?> : </div>
											 <div id="title" class="col-md-6"><?php echo $User_Info['name']; ?></div>
							    		</div>

										<div class="col-md-6">
											 <div id="title" class="col-md-3"> <?php echo __('other_price') ?> : </div>
											 <div id="title" class="col-md-6"><?php echo $Pay_Info['other_price']; ?></div>
							    		</div>

										<div class="col-md-6">
											 <div id="title" class="col-md-3"> <?php echo __('sum_item') ?> : </div>
											 <div id="title" class="col-md-6"><?php echo $Pay_Info['sum_item']; ?></div>
							    		</div>
										<div class="clear"></div>
										<div class="col-md-12">
											 <div id="title" class="col-md-3"> <?php echo __('online_pay') ?> : </div>
											 <div id="title" class="col-md-6" style="text-align: center">
											 	<?php
												  //pr($banks);
												  if(!empty($banks)){
												  	 foreach($banks as $key=>$value)
													 {
														if($value['Bank']['active']==1)
														{
															$image=$value['Bank']['image'];
															echo "
														 <a href='JavaScript:void(0);' onClick='set_bank(this);' id='".$value['Bank']['id']."'
														  title='".$value['Bank']['bank_name']."'>
														";
														  echo $this->Html->image('/getway/img/icons/'.$image,array('width'=>64,'height'=>64));
														  echo "</a>";
														}
														else
														{
															$ext = pathinfo($value['Bank']['image'], PATHINFO_EXTENSION);
															$image= substr( $value['Bank']['image'],0,strlen($value['Bank']['image'])-4).'_gray.'.$ext;
														    echo $this->Html->image('/getway/img/icons/'.$image,array('width'=>64,'height'=>64,'title'=>$value['Bank']['bank_name']));
														}

													 }
												  }

												 ?>
											 </div>
							    		</div>
										<div class="col-md-12">
											 <div id="title" class="col-md-5"> <?php echo __('selecting_bank') ?> : </div>
											 <div id="title" class="col-md-5" ><div id="bank_name"><?php echo __('select_bank') ?></div></div>
							    		</div>
										<br />
										<div class="clear"></div>
										<div class="col-md-12" style="margin-top: 10px;">
						                    <button type="button" class="green myFormComponent button primary" id="pay" style="margin-bottom: 15px;">
						                        <span class="text"><?php echo __d(__GATEWAY_LOCALE,'pay'); ?></span>
						                        <span class="icon icon-left-open"></span>
						                    </button>
											<div style="float:right" id="pay_preview"></div>
							                <div style="float:right" id="pay_loading"></div>
						                </div>
						    		</div>
								</form>
						    </div>

						 </div>

 					</div>
		        </section>
		   </div>
		   <div class="clear"></div>

        </div>

    </div>
</div>


<script>

function set_bank(obj)
{
	$('#bank_name').html(obj.title);
	$('#bank_id').remove();
	var form = document.getElementById("pay_form");
	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("name", "bank_id");
	hiddenField.setAttribute("id", "bank_id");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("value", obj.id);
	form.appendChild(hiddenField);
}

$('#pay').click(function (){

	var bank_id = $('input[name=bank_id]', '#pay_form').val();

	if(bank_id==null)
	{
	  show_warning_msg("<?php echo __('select_bank'); ?>");
	  return;
	}


    if(bank_id==1){
         bank_url=_url+'getway/bankmellats/call?cn='+'<?php echo $cn; ?>'+'&ac='+'<?php echo $ac; ?>';
    }
    /*switch(bank_id)
    {
        case 1:
           bank_url=_url+'getway/bankmellats/call';
          break;
        case 2:
          //
          break;
        default:
          //
    }*/

    $("#pay_loading").html('<img width="24" src="'+_url+'img/loader/5.gif" >');
    $('#pay').attr('disabled','disabled');
	$.ajax({
			type: "POST",
			url: bank_url,
			data: '',
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
						show_warning_msg(response.message);
					}
				}

				$('#ajax_result').html(response);
				$('#pay').removeAttr('disabled');
				$("#pay_loading").empty();
			}

		  });



	/*
	$("#pay_loading").html('<img src="+<?php echo   __IMAGE_PATH ?>+"/loader.gif">');
	$.ajax({
		type: "POST",
		url: '<?php echo  __HOST_DIR?>/ajax/order/pay.php',
		data: 'bank_id='+bank_id,
		cache: false,
		success: function(html)
		{
		  $('#pay_preview').html(html);
		  $("#pay_loading").empty();
		}

	  });
	*/

});

</script>
