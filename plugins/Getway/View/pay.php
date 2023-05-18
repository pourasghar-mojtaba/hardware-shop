<?php
session_start();
if ( !$_POST )
 { 
	exit();
 }
require_once("../../site_path.php");
require_once("../../configs/config.php");

Safe_HTTP_Header();

$bank_id = $db->escape(_Clean_Input($_POST['bank_id']));
function remove_session()
{ unset($_SESSION['buy'.$ip]);
  unset($_SESSION['cart']);
  $_SESSION['buy'.$ip]['buy_model']=serialize($_SESSION['buy'.$ip]['buy_model']);
  //exit;
 // die();
}
$app->model_name="order";
$app->action="before_filter";
$app->invoke();

if (isset($_SESSION['buy'.$ip]['buy_model'])) {
	 $_SESSION['buy'.$ip]['buy_model']=@unserialize($_SESSION['buy'.$ip]['buy_model']);
	}
$ret_arr=$_SESSION['buy'.$ip]['buy_model']->first_pay_online();
if(!$ret_arr[0])
{
  if($ret_arr[2]!='')
  echo "<script>showmsg('<span style=color:#F00>  ".$ret_arr[2]." </span>');</script>";
  else
  echo "<script>showmsg('<span style=color:#F00>  ".$app->lang('buy_not_successed')." </span>');</script>";
  remove_session();
}

$orderId=$ret_arr[1];
$_SESSION['buy'.$ip]['buy_model']=serialize($_SESSION['buy'.$ip]['buy_model']);

$class=get_class(unserialize($_SESSION['buy'.$ip]['buy_model']));
 
 $bank=new bank;
//========================== **** bank mellat **** =========================//
if($bank_id==1)  // bank mellat
{
	echo "<script>show_success_msg('".$app->lang('first_info_inserted')." ".$app->lang('connect_to_mellat_bank')."')</script>"; 
	// mellat gateway
	require_once(__SITE_PATH.'/inc/bank_lib/mellat/nusoap.php');
	require_once(__SITE_PATH.'/inc/bank_lib/mellat/functions.php');
	
	$client = new nusoap_client('https://pgws.bpm.bankmellat.ir/pgwchannel/services/pgw?wsdl');
	$namespace='http://interfaces.core.sw.bps.com/';
	
	// Check for an error
	$err = $client->getError();
	if ($err) {
		echo "<script>showmsg('<span style=color:#F00>  ".$err." </span>');</script>";
		remove_session();
	}
		
	$localDate =date("ymd"); //date("YYMMDD");
	$localTime =date("His"); //date("HHIISS");
	$additionalData = '';
	$callBackUrl = __SITE_URL.'/order/callback?bank_id='.$bank_id.'&mode='.$class;
	$payerId = '0';
	$parameters = array(
		'terminalId' => $MELLAT_TERMINALID,
		'userName' => $MELLAT_USERNAME,
		'userPassword' => $MELLAT_USERPASSWORD,
		'orderId' => $orderId,
		'amount' => $_SESSION['buy'.$ip]['buy_sum_amnt']+$_SESSION['buy'.$ip]['buy_post'],
		'localDate' => $localDate,
		'localTime' => $localTime,
		'additionalData' => $additionalData,
		'callBackUrl' => $callBackUrl,
		'payerId' => $payerId);
	
	remove_session();
	// Call the SOAP method
	$result = $client->call('bpPayRequest', $parameters, $namespace);
	// Check for a fault
	if ($client->fault) 
	{
		echo "<script>showmsg('<span style=color:#F00>  ".$result." </span>');</script>";
	}
	else 
	{
		// Check for errors
		$resultStr  = $result;
		$err = $client->getError();
		if ($err) 
		{
			echo "<script>showmsg('<span style=color:#F00>  ".$err." </span>');</script>";
		}
		else
		{
			// Display the result	
			$res = explode (',',$resultStr);
			$ResCode = $res[0];
			if($ResCode!=0)
			{
				 $bank->bank_id=$bank_id;
				 $bank->bank_msg_id=$ResCode;
				 $r=$bank->get_bank_msg();
				 print_r($r);
				 if(!empty($r))
				 {
					foreach($r as $key=>$val)
					{
						$msg= $val['msg'];
						echo "<script>showmsg('<span style=color:#F00>  ".$r['msg']." </span>');</script>";
					} 
				 }
				
				
			}
			//echo "ResCode=".$ResCode;
			//echo "res[1]=".$res[1];
			
			if ($ResCode == "0")
			 {
				// Update table, Save RefId
				/*echo "<script language='javascript' type='text/javascript'>postRefId('" . $res[1] . "');</script>";*/
				echo"
				
				<script language='javascript' type='text/javascript'>	
					 
						var form = document.createElement('form');
						form.setAttribute('method', 'POST');
						form.setAttribute('action', 'https://pgw.bpm.bankmellat.ir/pgwchannel/startpay.mellat');		 
						form.setAttribute('target', '_self');
						var hiddenField = document.createElement('input');			  
						hiddenField.setAttribute('name', 'RefId');
						hiddenField.setAttribute('value', '" . $res[1] . "');
						form.appendChild(hiddenField);
			
						document.body.appendChild(form);		 
						form.submit();
						document.body.removeChild(form);
						
					 
				</script>
				
				";
			} //$ResCode == "0"
			
		}// end Display the result
		
	}// end Check for errors
	
}

//========================== **** bank mellat **** =========================//







?>

