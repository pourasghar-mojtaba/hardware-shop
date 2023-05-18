<?php
if (eregi("order_callback.php", $_SERVER['PHP_SELF']))
 { 
	exit();
 }
   
?>

<title>city tomb <?php echo   $app->lang('gateway') ?> </title>


<meta name='keywords' content='<?php echo   $td['meta'] ?>' />


<link rel="stylesheet" href="<?php echo __THEME_URL.'/css/order.css'; ?>" type="text/css" />


</head>
<body>
<div class="header" style="height:40px;margin-top:5px;">
	   <?php
		 include(__VIEW_PATH.'/search_form.php');
		?>
	  
	<div class="logo-small"></div>

</div>
<?php
		 
		 $tomb_user=new tomb_user;
		 if (!$tomb_user->logged_in())
		 {
			 echo "<script>showmsg('<span style=color:#F00> ".$app->lang('login_in_site')." </span>');</script>";
			 exit; 
		 }
 ?>

<!-- header end-->


  
<?php

 
 $RefId=$db->escape(_Clean_Input($_POST['RefId']));
 $ResCode=$db->escape(_Clean_Input($_POST['ResCode']));
 $SaleOrderId=$db->escape(_Clean_Input($_POST['SaleOrderId']));
 $SaleReferenceId= $db->escape(_Clean_Input($_POST['SaleReferenceId']));
 $orderId=$SaleOrderId;
 
 $bank_id=$db->escape(_Clean_Input($_REQUEST['bank_id']));
 
 $model = $db->escape(_Clean_Input($_REQUEST['mode']));
 if(class_exists($model))
 { 
 	$className= new $model;
 }
 else
 {
	 echo "<script>showmsg('<span style=color:#F00> ".$app->lang('error_in_bankdata')." </span>');</script>";
	 exit; 
 }
 
 
 function update_order()
 {
	global $ResCode,$RefId,$SaleReferenceId,$orderId,$className;	
	$className->bank_msg_id=$ResCode;
	$className->refid=$RefId;
	$className->sale_reference_id=$SaleReferenceId;
	$className->order_id= $orderId;
	$className->update_order();	
	exit(); 
 }
 $bank=new bank;
 $bank->bank_id=$bank_id;
 $result=$bank->get_bank();
 if($result['bank_name']=='')
 {
	echo "<script>showmsg('<span style=color:#F00> ".$app->lang('there_is_no_bank')." </span>');</script>";
	exit; 
 }
  
 
 
//========================== **** bank mellat **** =========================//  
if($bank_id==1)   // bank mellat
 {
   
   require_once(__SITE_PATH.'/inc/bank_lib/mellat/nusoap.php');
   require_once(__SITE_PATH.'/inc/bank_lib/mellat/functions.php');
	
   if($ResCode!=0)
	{
		$bank->bank_id=$bank_id;
		$bank->bank_msg_id=$ResCode;
		$result=$bank->get_bank_msg();
		echo "<script>showmsg('<span style=color:#F00> ".$result['msg']." </span>');</script>";
				
		update_order();
	}
	
  $callverify=verifySoap($orderId,$SaleReferenceId,$MELLAT_TERMINALID,$MELLAT_USERNAME,$MELLAT_USERPASSWORD);
	if ($callverify!=0)
	{
		 $callinquiry  =inquirySoap($orderId,$SaleReferenceId,$MELLAT_TERMINALID,$MELLAT_USERNAME,$MELLAT_USERPASSWORD);
		 if ($callinquiry == 0 )
		  {		
			 $callsettle = settleSoap($orderId,$SaleReferenceId,$MELLAT_TERMINALID,$MELLAT_USERNAME,$MELLAT_USERPASSWORD);
			  if ($callsettle == 0 )
			   {
					echo "<script>show_success_msg('".$app->lang('buy_successed')."<br>".$app->lang('transaction_id')."=$SaleReferenceId ');</script>";
					update_order(); 
			   }
			   else
			   { 
					 echo "<script>showmsg('<span style=color:#F00> ".$app->lang('approval_of_final_deposit_in_bank_operations_were_performed')."</span>');</script>";
					 update_order();
			   } // enf of settleSoap
	
		  } // end of inquirySoap if
		  else
		  {
	 		echo "<script>showmsg('<span style=color:#F00> ".$app->lang('transaction_needs_to_follow_up')."<br>".$app->lang('transaction_id')."=$SaleReferenceId</span>');</script>";
			$callreverse = reverseSoap($orderId,$SaleReferenceId,$MELLAT_TERMINALID,$MELLAT_USERNAME,$MELLAT_USERPASSWORD);
			 if ($callreverse == 0 )
			 {
				echo "<script>show_success_msg('".$app->lang('money_was_paid_back_operation')."<br>".$app->lang('transaction_id')."=$SaleReferenceId ');</script>";
				update_order(); 
			 }  
			 else
			 {
				 echo "<script>showmsg('<span style=color:#F00> ".$app->lang('buy_not_successed')." </span>');</script>";
				 update_order();
			 }
		  }
	} // end of verifySoap
	else
	{
		$callsettle = settleSoap($orderId,$SaleReferenceId,$MELLAT_TERMINALID,$MELLAT_USERNAME,$MELLAT_USERPASSWORD);
		if ($callsettle == 0 )
		{
			echo "<script>show_success_msg('".$app->lang('buy_successed')."<br>".$app->lang('transaction_id')."=$SaleReferenceId ');</script>";
			update_order();
		}  // settleSoap
		else
		{	
			echo "<script>showmsg('<span style=color:#F00> ".$app->lang('transaction_needs_to_follow_up')."<br>".$app->lang('transaction_id')."=$SaleReferenceId</span>');</script>";
			$callreverse = reverseSoap($orderId,$SaleReferenceId,$MELLAT_TERMINALID,$MELLAT_USERNAME,$MELLAT_USERPASSWORD);
			 if ($callreverse == 0 )
			 {
				echo "<script>show_success_msg('".$app->lang('money_was_paid_back_operation')."<br>".$app->lang('transaction_id')."=$SaleReferenceId ');</script>";
				update_order();
			 }  
			 else
			 {
				 echo "<script>showmsg('<span style=color:#F00> ".$app->lang('buy_not_successed')." </span>');</script>";
				 update_order();
			 }
		  }
	}
	
	
	
 }// check bank
//========================== **** bank mellat **** =========================//  
?>



 
 

<script>

//=================================================================

$('#pay').click(function (){

	
	var order_type = $('input[name=order_type]:checked', '#pay_form').val();
	
	if(order_type!='with_bank' && order_type!='with_fish')
	 {
	  showmsg('  <span style= color:#F00; ><?php echo   $app->lang('select_order_type') ?> </span>  ');
	  return;
	 }
	var bank_id = $('input[name=bank_id]:checked', '#pay_form').val();
	if(bank_id==null)
	{
	 showmsg('  <span style= color:#F00; ><?php echo   $app->lang('select_bank') ?> </span>  ');
	 return;
	}
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
	
	
});
//==================================================================
 

</script>

