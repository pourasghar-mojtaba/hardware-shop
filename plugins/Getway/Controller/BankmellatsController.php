<?php
/**
 */
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class BankmellatsController extends GetwayAppController {

  var $name = 'Bankmellats';
  var $components = array('Httpupload');

/**
 * Controller name
 *
	 
 /**
* follow to anoher user
* @param undefined $id
* 
*/


public function beforeFilter() {
	parent::beforeFilter();
	$this->Auth->allow('call','callback','app_call');
}



function call()
{
   
   $response['success'] = false;
   $response['message'] = null;
   $step=0;
   $User_Info= $this->Session->read('User_Info');
   $Pay_Info= $this->Session->read('Pay_Info');
   
   App::import('Vendor','nusoap', array('file'=>'nusoap'.DS.'lib'.DS.'nusoap.php'));
   $client = new nusoap_client("https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl"); 
   $namespace='http://interfaces.core.sw.bps.com/';
   // Check for an error
	$err = $client->getError();
	if ($err) {
		$step=10;
		Controller::loadModel('Errorlog');
        $this->Errorlog->get_log('BankmellatsController',' step='.$step.' , '.$err);
        $response['success'] = false;
		$response['message']=__('cant_connect_to_bankmellat_getway');
		$this->set('ajaxData', json_encode($response));
		$this->render('Getway.Elements/Bankmellats/Ajax/ajax_result','ajax');
		return FALSE;
		
	}
    
    $localDate =date("ymd"); //date("YYMMDD");
	$localTime =date("His"); //date("HHIISS");
	$additionalData = '';
	$callBackUrl = __SITE_URL.'getway/bankmellats/callback/'.$Pay_Info['model'].'/'.$Pay_Info['row_id'].'?cn='.$_REQUEST['cn'].'&ac='.$_REQUEST['ac'].'&token='.$Pay_Info['token'];
	$payerId = '0';
	$parameters = array(
		'terminalId' => __MELLAT_TERMINALID,
		'userName' => __MELLAT_USERNAME,
		'userPassword' => __MELLAT_USERPASSWORD,
		'orderId' => $Pay_Info['orderid'],
		'amount' => $Pay_Info['sum_price']+$Pay_Info['other_price'],
		'localDate' => $localDate,
		'localTime' => $localTime,
		'additionalData' => $additionalData,
		'callBackUrl' => $callBackUrl,
		'payerId' => $payerId);
    
    //print_r($parameters);
    
	// Call the SOAP method
	$result = $client->call('bpPayRequest', $parameters, $namespace);
    //print_r($result);
	// Check for a fault
	if ($client->fault) 
	{
		$step=20;
		$row_id = $Pay_Info['row_id'];
		$this->Session->delete('Pay_Info');
		Controller::loadModel('Errorlog');
        $this->Errorlog->get_log('BankmellatsController',' step='.$step.' , '.$result['faultcode'].' , '.$result['faultstring']);
        $response['success'] = false;
		$response['message']=__('cant_send_parameters_to_bankmellat_getway');
		$this->set('ajaxData', json_encode($response));
		$this->render('Getway.Elements/Bankmellats/Ajax/ajax_result','ajax');
		//$this->Redirect->flashWarning(__('can_not_connect_to_getway'),$this->_error_zpay_url(0,$row_id,-1,$cn,$ac));
		return FALSE;
	}
	else 
	{
		// Check for errors
		$resultStr  = $result;
		$err = $client->getError();
		if ($err) 
		{
			$step=30;
			Controller::loadModel('Errorlog');
	        $this->Errorlog->get_log('BankmellatsController',' step='.$step.' , '.$err);
	        $response['success'] = false;
			$response['message']=__('cant_get_response_from_bankmellat_getway');
			$this->set('ajaxData', json_encode($response));
			$this->render('Getway.Elements/Bankmellats/Ajax/ajax_result','ajax');
			return FALSE;
		}
		else
		{
			// Display the result	
			$res = explode (',',$resultStr);
			$ResCode = $res[0];
			if($ResCode!=0)
			{
				 $this->loadModel('Bankmessag');
        		 $this->Bankmessag->recursive = -1;

				 $options['conditions'] = array(
					'Bankmessag.bank_id' => 1 ,
					'Bankmessag.id' => $ResCode
				 );
				$message = $this->Bankmessag->find('first',$options);
				if(!empty($message)){
					$step=40;
					Controller::loadModel('Errorlog');
			        $this->Errorlog->get_log('BankmellatsController',' step='.$step.' , '.$message['Bankmessag']['message']);
			        $response['success'] = false;
					$response['message']=$message['Bankmessag']['message'];
					$this->set('ajaxData', json_encode($response));
					$this->render('Getway.Elements/Bankmellats/Ajax/ajax_result','ajax');
					return FALSE;
				} 
			  }
			
			if ($ResCode == "0")
			 {
				// Update table, Save RefId
				$response['success'] = TRUE;
				$response['value']=$res[1];
				$this->set('ajaxData', json_encode($response));
				$this->render('Getway.Elements/Bankmellats/Ajax/ajax_result','ajax');
				return FALSE;
			} //$ResCode == "0"
			
		}// end Display the result
		
	}// end Check for errors
   
   
   $response['success'] = false;
   $response['message']=__('you_can_send_3email');
   $this->set('ajaxData', json_encode($response));
   $this->render('Getway.Elements/Bankmellats/Ajax/ajax_result','ajax');
}

function app_call()
{
   $info = $_REQUEST['info'];
   
   $response['success'] = false;
   $response['message'] = null;
   $step=0;
   /*$User_Info= $this->Session->read('User_Info');
   $Pay_Info= $this->Session->read('Pay_Info');*/
   
   App::import('Vendor','nusoap', array('file'=>'nusoap'.DS.'lib'.DS.'nusoap.php'));
   $client = new nusoap_client("https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl"); 
   $namespace='http://interfaces.core.sw.bps.com/';
   // Check for an error
	$err = $client->getError();
	if ($err) {
		$step=10;
		Controller::loadModel('Errorlog');
        $this->Errorlog->get_log('BankmellatsController',' step='.$step.' , '.$err);
        $response['success'] = false;
		$response['message']=__('cant_connect_to_bankmellat_getway');
		$this->set('ajaxData', json_encode($response));
		$this->render('Getway.Elements/Bankmellats/Ajax/ajax_result','ajax');
		return FALSE;
		
	}
    
    $localDate =date("ymd"); //date("YYMMDD");
	$localTime =date("His"); //date("HHIISS");
	$additionalData = '';
	$callBackUrl = __SITE_URL.'getway/bankmellats/app_callback/'.$info['Token']['model'].'/'.$info['Token']['row_id'].'?cn='.$_REQUEST['cn'].'&ac='.$_REQUEST['ac'];
	$payerId = '0';
	$parameters = array(
		'terminalId' => __MELLAT_TERMINALID,
		'userName' => __MELLAT_USERNAME,
		'userPassword' => __MELLAT_USERPASSWORD,
		'orderId' => $info['Token']['orderid'],
		'amount' => $info['Token']['sum_price']+$info['Token']['other_price'],
		'localDate' => $localDate,
		'localTime' => $localTime,
		'additionalData' => $additionalData,
		'callBackUrl' => $callBackUrl,
		'payerId' => $payerId);
    
    //print_r($parameters);
    
	// Call the SOAP method
	$result = $client->call('bpPayRequest', $parameters, $namespace);
    //print_r($result);
	// Check for a fault
	if ($client->fault) 
	{
		$step=20;
		Controller::loadModel('Errorlog');
        $this->Errorlog->get_log('BankmellatsController',' step='.$step.' , '.$result['faultcode'].' , '.$result['faultstring']);
        $response['success'] = false;
		$response['message']=__('cant_send_parameters_to_bankmellat_getway');
		$this->set('ajaxData', json_encode($response));
		$this->render('Getway.Elements/Bankmellats/Ajax/ajax_result','ajax');
		return FALSE;
	}
	else 
	{
		// Check for errors
		$resultStr  = $result;
		$err = $client->getError();
		if ($err) 
		{
			$step=30;
			Controller::loadModel('Errorlog');
	        $this->Errorlog->get_log('BankmellatsController',' step='.$step.' , '.$err);
	        $response['success'] = false;
			$response['message']=__('cant_get_response_from_bankmellat_getway');
			$this->set('ajaxData', json_encode($response));
			$this->render('Getway.Elements/Bankmellats/Ajax/ajax_result','ajax');
			return FALSE;
		}
		else
		{
			// Display the result	
			$res = explode (',',$resultStr);
			$ResCode = $res[0];
			if($ResCode!=0)
			{
				 $this->loadModel('Bankmessag');
        		 $this->Bankmessag->recursive = -1;

				 $options['conditions'] = array(
					'Bankmessag.bank_id' => 1 ,
					'Bankmessag.id' => $ResCode
				 );
				$message = $this->Bankmessag->find('first',$options);
				if(!empty($message)){
					$step=40;
					Controller::loadModel('Errorlog');
			        $this->Errorlog->get_log('BankmellatsController',' step='.$step.' , '.$message['Bankmessag']['message']);
			        $response['success'] = false;
					$response['message']=$message['Bankmessag']['message'];
					$this->set('ajaxData', json_encode($response));
					$this->render('Getway.Elements/Bankmellats/Ajax/ajax_result','ajax');
					return FALSE;
				} 
			  }
			
			if ($ResCode == "0")
			 {
				// Update table, Save RefId
				$response['success'] = TRUE;
				$response['value']=$res[1];
				$this->set('ajaxData', json_encode($response));
				$this->render('Getway.Elements/Bankmellats/Ajax/ajax_result','ajax');
				return FALSE;
			} //$ResCode == "0"
			
		}// end Display the result
		
	}// end Check for errors
   
   
   $response['success'] = false;
   $response['message']=__('you_can_send_3email');
   $this->set('ajaxData', json_encode($response));
   $this->render('Getway.Elements/Bankmellats/Ajax/ajax_result','ajax');
}

/**
* 
* @param undefined $model
* 
*/
function callback($model,$row_id){
	
	$step=0;
	$this->loadModel('Bankmessag');
	$this->Bankmessag->recursive = -1;
	$result_value=FALSE;
    
	$this->set('title_for_layout',__('bankmellat_getway'));
	$this->set('description_for_layout',__('bankmellat_getway'));
	$this->set('keywords_for_layout',__('bankmellat_getway')); 
	
	
	$Pay_Info = $this->Session->read('Pay_Info');

	if($_REQUEST['token'] != $Pay_Info['token']){
		$this->Session->delete('Pay_Info');
		$this->Redirect->flashWarning(__('not_exist_pasy_info'),$this->_update_order(0,0,$row_id,-1,$_REQUEST['cn'],$_REQUEST['ac']));
	}
	if($_REQUEST['cn'] != $Pay_Info['cn']){
		$this->Session->delete('Pay_Info');
		$this->Redirect->flashWarning(__('not_exist_pasy_info'),$this->_update_order(0,0,$row_id,-1,$_REQUEST['cn'],$_REQUEST['ac']));
	}
	if($_REQUEST['ac'] != $Pay_Info['ac']){
		$this->Session->delete('Pay_Info');
		$this->Redirect->flashWarning(__('not_exist_pasy_info'),$this->_update_order(0,0,$row_id,-1,$_REQUEST['cn'],$_REQUEST['ac']));
	}
	
    				
	if($this->request->is('post') || $this->request->is('put')) 
	{
		 $RefId=Sanitize::clean($_POST['RefId']);
		 $ResCode=Sanitize::clean($_POST['ResCode']);
		 $SaleOrderId=Sanitize::clean($_POST['SaleOrderId']);
		 $SaleReferenceId= Sanitize::clean($_POST['SaleReferenceId']);
		 $orderId=$SaleOrderId;
		 
		 $datasource = $this->Bankmellat->getDataSource();
		try{
		    $datasource->begin();
			
			 if($ResCode!=0)
				{
					$options['conditions'] = array(
						'Bankmessag.bank_id' => 1 ,
						'Bankmessag.id' => $ResCode
					);
					$message = $this->Bankmessag->find('first',$options);
					$step=20;
				    throw new Exception($message['Bankmessag']['message']);						 				
				}
				
				$callverify=$this->verifySoap($orderId,$SaleReferenceId,__MELLAT_TERMINALID,__MELLAT_USERNAME,__MELLAT_USERPASSWORD);
				if ($callverify!=0)
				{
					 $callinquiry =$this->inquirySoap($orderId,$SaleReferenceId,__MELLAT_TERMINALID,__MELLAT_USERNAME,__MELLAT_USERPASSWORD);
					 if ($callinquiry == 0 )
					  {		
						 $callsettle = $this->settleSoap($orderId,$SaleReferenceId,__MELLAT_TERMINALID,__MELLAT_USERNAME,__MELLAT_USERPASSWORD);
						  if ($callsettle == 0 )
						   {
								$step=30;
								$this->Session->setFlash(__('buy_successed'),'success');
								$result_value=TRUE;
								
						   }
						   else
						   { 
								$step=40;
								throw new Exception(__('approval_of_final_deposit_in_bank_operations_were_performed'));
						   } // enf of settleSoap
				
					  } // end of inquirySoap if
					  else
					  {

						$callreverse = $this->reverseSoap($orderId,$SaleReferenceId,__MELLAT_TERMINALID,__MELLAT_USERNAME,__MELLAT_USERPASSWORD);
						 if ($callreverse == 0 )
						 {
							$step=60;
							$this->Session->setFlash(__('money_was_paid_back_operation'),'success');
							$result_value=TRUE;
							
						 }  
						 else
						 {						 
							 $step=70;
							 throw new Exception(__('buy_not_successed'));	 
						 }
					  }
				} // end of verifySoap
				else
				{
					$callsettle = $this->settleSoap($orderId,$SaleReferenceId,__MELLAT_TERMINALID,__MELLAT_USERNAME,__MELLAT_USERPASSWORD);
					if ($callsettle == 0 )
					{					
						$step=80;
						$this->Session->setFlash(__('buy_successed'),'success');
						$result_value=TRUE;
						
					}  // settleSoap
					else
					{	
						$callreverse = $this->reverseSoap($orderId,$SaleReferenceId,__MELLAT_TERMINALID,__MELLAT_USERNAME,__MELLAT_USERPASSWORD);
						 if ($callreverse == 0 )
						 {						
							$step=100;
							$this->Session->setFlash(__('money_was_paid_back_operation'),'success');
							$result_value=TRUE;
							
						 }  
						 else
						 {
							 $step=110;
							 throw new Exception(__('buy_not_successed'));	 
						 }
					  }
				}
			 
			$datasource->commit();	
		} catch(Exception $e) {
		    $datasource->rollback();
			Controller::loadModel('Errorlog');
			$this->Errorlog->get_log('BankmellatsController','callback,step = '.$step.' , '.$e->getMessage().',ResCode='.$ResCode.',RefId='.$RefId.',SaleReferenceId='.$SaleReferenceId.',orderId='.$orderId.',model='.$model.',row_id='.$row_id );	
			$this->Session->setFlash($e->getMessage(),'error');	
			$result_value=FALSE;
			$this->set('result_value',  FALSE);
		 }
		 
		$this->set('result_value',  $result_value);
		$this->set('transaction_id',  $SaleReferenceId);
		$this->set('order_id',  $row_id);
		
		$this->_update_order($ResCode,$SaleReferenceId,$row_id,-1,$_REQUEST['cn'],$_REQUEST['ac']);
		 
	}
	
	 

}
 
 function _update_order($res_code,$ref_id,$row_id,$status,$coltroller,$action)
 {
	$random = rand(1000,1000000);
	$this->Session->write('CallBack_Info',array(
			'bankmessage_id' => $res_code ,
			'refid' => $ref_id ,
			'status'=> $status,
			'row_id'=>$row_id,
			'token' =>$random
		));
	$this->set('back_url', __SITE_URL.$coltroller.'/'.$action.'/?token='.$random);
 }
 
 function _update_order1($ResCode,$RefId,$SaleReferenceId,$orderId,$model,$id)
 {
    
    $Pay_Info= $this->Session->read('Pay_Info');
	 try{       
        	$sum_rcvd_amnt=$Pay_Info['sum_price']+$Pay_Info['other_price'];
			
			$this->loadModel($model);
            $this->$model->recursive = -1;

        	$ret= $this->$model->updateAll(
        	    array( $model.'.sum_rcvd_amnt' => '"'.$sum_rcvd_amnt.'"'  ,
        		       $model.'.bankmessage_id' => '"'.$ResCode.'"' , 
        			   $model.'.refid' => '"'.$RefId.'"' ,
        			   $model.'.sale_reference_id' => '"'.$SaleReferenceId.'"' ,
        			   $model.'.sale_order_id' => '"'.$orderId.'"' ,
        			   $model.'.bank_id' => '1'		
        		),   //fields to update
        	    array( $model.'.id' => $id )  //condition
        	  );
      if($model=='Order' && $SaleReferenceId!=0 && $SaleReferenceId!=''){
		  	$this->loadModel('Orderitem');
            $this->Orderitem->recursive = -1;
			
			$ret= $this->Orderitem->updateAll(
			    array('Orderitem.status' => '1'),   //fields to update
			    array('Orderitem.order_id' => $id)  //condition
			  );
			/*$this->Orderitem->query("
				select
				 Orderitem.owner_id 
				from  order_items as Orderitem
				where Orderitem.order_id = ".$id."
				group by Orderitem.owner_id
			");*/
			
			$options=array();
        	$options['fields'] = array(
        		'User.id',
				'User.name',
				'User.user_name',
				'User.email'
        	);
        	$options['conditions'] = array(
        		'Orderitem.order_id' => $id	
        	);
			$options['joins'] = array(
				array('table' => 'users',
					'alias' => 'User',
					'type' => 'inner',
					'conditions' => array(
					'User.id = Orderitem.owner_id ',
					)
				)
			);	
			$options['group'] = 'Orderitem.owner_id';
        	$owners = $this->Orderitem->find('all',$options);  
			
			$this->loadModel('Notification');
			$this->Notification->recursive = -1;
			$User_Info= $this->Session->read('User_Info');
			
			if(!empty($owners)){
				foreach($owners as $owner){
					_send_email($owner['User']['id'],$owner['User']['name'],$owner['User']['email'],$id);
					
					$this->request->data['Notification']['notification_id']= $id;
					$this->request->data['Notification']['from_user_id']= $User_Info['id'];
					$this->request->data['Notification']['to_user_id']= $owner['User']['id'];
					$this->request->data['Notification']['notification_type']= 5;
					$this->Notification->save($this->request->data);
				}
			}
			
	  }     
    } catch(Exception $e) {
        
			Controller::loadModel('Errorlog');
			$this->Errorlog->get_log('BankmellatsController','_update_order, '.$e->getMessage() );	
            return FALSE;
	}
    /*if(!$ret){
        return FALSE;
    } */
    return TRUE;     
 }

function _send_email($user_id,$name,$email,$order_id){
	try{
		$Email = new CakeEmail();
		$Email->template('order_sendemail', 'sendemail_layout');
		$Email->subject(__('new_order_created_for_you'));
		$Email->emailFormat('html');
		$Email->to($register_email);
		$Email->from(array(__Email => __Email_Name));
		$Email->viewVars(array('name'=>$name,'email'=>$email));
		$Email->send();
	} catch (Exception $e) {
		
	}
}

//call verify via nusoap
/**
* 
* @param undefined $orderId
* @param undefined $saleReferenceId
* @param undefined $terminalId
* @param undefined $userName
* @param undefined $userPassword
* 
*/
 function verifySoap($orderId,$saleReferenceId,$terminalId,$userName,$userPassword)
 {
    $saleReferenceId = $saleReferenceId;
    $orderId=$orderId;
    
    App::import('Vendor','nusoap', array('file'=>'nusoap'.DS.'lib'.DS.'nusoap.php'));
	$client = new nusoap_client('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');
	$namespace='http://interfaces.core.sw.bps.com/';
	// Check for an error
	$err = $client->getError();
	if ($err) {
		//echo "<script>showmsg('<span style=color:#F00>  ".$err." </span>');</script>";
		return false;
	}
	
	$parameters = array(
	'terminalId' => $terminalId,
	'userName' => $userName,
	'userPassword' => $userPassword,
	'orderId' => $orderId,
	'saleOrderId' => $orderId,
	'saleReferenceId' => $saleReferenceId);

	// Call the SOAP method
	$result = $client->call('bpVerifyRequest', $parameters, $namespace);

	// Check for a fault
	if ($client->fault) 
	{
		//echo "<script>showmsg('<span style=color:#F00>  ".$result." </span>');</script>";
		return false;
	 }
	else 
	{
	 $resultStr = $result;		
	 $err = $client->getError();
	 if ($err)
	  {
		//echo "<script>showmsg('<span style=color:#F00>  ".$err." </span>');</script>";
		return false;
	  } 		
	  else 
	  {
	    // Display the result				
		$resp=$resultStr;				
		return $resp;				
	   }
	}
												
 }
  
  //call inquiry via nusoap
  /**
  * 
  * @param undefined $orderId
  * @param undefined $saleReferenceId
  * @param undefined $terminalId
  * @param undefined $userName
  * @param undefined $userPassword
  * 
*/
 function inquirySoap($orderId,$saleReferenceId,$terminalId,$userName,$userPassword)
 {
	$saleReferenceId = $saleReferenceId;
   	$orderId=$orderId;
	App::import('Vendor','nusoap', array('file'=>'nusoap'.DS.'lib'.DS.'nusoap.php'));
	$client = new nusoap_client('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');
	$namespace='http://interfaces.core.sw.bps.com/';
		// Check for an error
		$err = $client->getError();
		if ($err) {
			// Display the error
			//echo "<script>showmsg('<span style=color:#F00>  ".$err." </span>');</script>";
			return false;
			// At this point, you know the call that follows will fail
		}

		$parameters = array(
		 'terminalId' => $terminalId,
		'userName' => $userName,
		'userPassword' => $userPassword,
		'orderId' => $orderId,
		'saleOrderId' => $orderId,
		'saleReferenceId' => $saleReferenceId);

		// Call the SOAP method
		$result = $client->call('bpInquiryRequest', $parameters, $namespace);

		// Check for a fault
		if ($client->fault) 
		{
			//echo "<script>showmsg('<span style=color:#F00>  ".$result." </span>');</script>";
			return false;
		}
		else 
		{
		  $resultStr = $result;
		  $err = $client->getError();
		  if ($err) 
		  {
			// Display the error
		    //echo "<script>showmsg('<span style=color:#F00>  ".$err." </span>');</script>";
		    return false;
		  } 
		  else 
		  {					// Display the result
			$resp=$resultStr;							
			return $resp;				
		  }
		}
							
 }
 
  //call settle via nusoap
  /**
  * 
  * @param undefined $orderId
  * @param undefined $saleReferenceId
  * @param undefined $terminalId
  * @param undefined $userName
  * @param undefined $userPassword
  * 
*/
 function settleSoap($orderId,$saleReferenceId,$terminalId,$userName,$userPassword)
 {
   $saleReferenceId = $saleReferenceId;
   $orderId=$orderId;
    App::import('Vendor','nusoap', array('file'=>'nusoap'.DS.'lib'.DS.'nusoap.php'));
	$client = new nusoap_client('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');
	$namespace='http://interfaces.core.sw.bps.com/';

	// Check for an error
	$err = $client->getError();
	if ($err) {
	//echo "<script>showmsg('<span style=color:#F00>  ".$err." </span>');</script>";
	return false;
	}
			
	$parameters = array(
	 'terminalId' => $terminalId,
	'userName' => $userName,
	'userPassword' => $userPassword,
	'orderId' => $orderId,
	'saleOrderId' => $orderId,
	'saleReferenceId' => $saleReferenceId);	

	// Call the SOAP method
	$result = $client->call('bpSettleRequest', $parameters, $namespace);
	// Check for a fault
	if ($client->fault) {
		//echo "<script>showmsg('<span style=color:#F00>  ".$result." </span>');</script>";
		return false;
	 }
	 else 
	 {
		// Check for errors
		$resultStr = $result;
		
		$err = $client->getError();
		if ($err) 
		{
			//echo "<script>showmsg('<span style=color:#F00>  ".$err." </span>');</script>";
			return false;
		} 
		else 
		{
			$resp=$resultStr;					
			return $resp;
					
		}
	}
 }
 
 
 //call reverse via nusoap
 /**
 * 
 * @param undefined $orderId
 * @param undefined $saleReferenceId
 * @param undefined $terminalId
 * @param undefined $userName
 * @param undefined $userPassword
 * 
*/
 function reverseSoap($orderId,$saleReferenceId,$terminalId,$userName,$userPassword)
 {
   $saleReferenceId = $saleReferenceId;
   $orderId=$orderId;
    App::import('Vendor','nusoap', array('file'=>'nusoap'.DS.'lib'.DS.'nusoap.php'));
	$client = new nusoap_client('https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl');
	$namespace='http://interfaces.core.sw.bps.com/';
	// Check for an error
	$err = $client->getError();
	if ($err) {
		// Display the error
		return false;
		//echo "<script>showmsg('<span style=color:#F00>  ".$err." </span>');</script>";
	}
			
	$parameters = array(
	 'terminalId' => $terminalId,
	'userName' => $userName,
	'userPassword' => $userPassword,
	'orderId' => $orderId,
	'saleOrderId' => $orderId,
	'saleReferenceId' => $saleReferenceId);

	// Call the SOAP method
	$result = $client->call('bpReversalRequest', $parameters, $namespace);
	// Check for a fault
	if ($client->fault) {
		//echo "<script>showmsg('<span style=color:#F00>  ".$result." </span>');</script>";
		return false;
	 }
	 else 
	 {
		// Check for errors
		$resultStr = $result;
		$err = $client->getError();
		if ($err) 
		{
			// Display the error
			//echo "<script>showmsg('<span style=color:#F00>  ".$err." </span>');</script>";
			return false;
		} 
		else 
		{
		// Display the result
			$resp=$resultStr;						
			return $resp;
		}
	}
					

							
 }

 
}
