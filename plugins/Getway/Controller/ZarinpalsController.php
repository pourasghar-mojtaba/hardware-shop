<?php
/**
*/
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class ZarinpalsController extends GetwayAppController
{

	var $name       = 'Zarinpals';
	var $components = array('Httpupload');


	public
	function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('callback');
	}


	function callback($model,$row_id)
	{

		$Pay_Info = $this->Session->read('Pay_Info');

		if($_REQUEST['token'] != $Pay_Info['token']){
			$this->Session->delete('Pay_Info');
			$this->Redirect->flashWarning(__('not_exist_pasy_info'),$this->_update_order(0,$row_id,-1,$_REQUEST['cn'],$_REQUEST['ac']));
		}
		if($_REQUEST['cn'] != $Pay_Info['cn']){
			$this->Session->delete('Pay_Info');
			$this->Redirect->flashWarning(__('not_exist_pasy_info'),$this->_update_order(0,$row_id,-1,$_REQUEST['cn'],$_REQUEST['ac']));
		}
		if($_REQUEST['ac'] != $Pay_Info['ac']){
			$this->Session->delete('Pay_Info');
			$this->Redirect->flashWarning(__('not_exist_pasy_info'),$this->_update_order(0,$row_id,-1,$_REQUEST['cn'],$_REQUEST['ac']));
		}

		$MerchantID = __MERCHANT_ID;
		$Amount     = $Pay_Info['sum_price']; //Amount will be based on Toman
		$Authority  = $_GET['Authority'];

		try
		{
			$status= '';
			$RefId='';
			if($_GET['Status'] == 'OK'){
				
				App::import('Vendor','nusoap', array('file'=>'nusoap'.DS.'lib'.DS.'nusoap.php'));
				$client = new nusoap_client('https://www.zarinpal.com/pg/services/WebGate/wsdl', 'wsdl');
				$client->soap_defencoding = 'UTF-8';
				$result = $client->call('PaymentVerification', [
		            [
		                'MerchantID'     => $MerchantID,
		                'Authority'      => $Authority,
		                'Amount'         => $Amount,
		            ],
		        ]);
				
				if(!empty($result)){
					$status  = $result['Status'];
					$RefId = $result['RefID'];
				}
				if($result['Status'] == 100){
					$this->Session->setFlash(__('transation_success'),'success');
					$this->set('result_value',  TRUE);
				}
				else
				{
					throw new Exception(__('transation_failed'));
				}
			}
			else
			{				
				throw new Exception(__('transaction_canceled_by_user'));
			}
		} catch(Exception $e)
		{
			
			Controller::loadModel('Errorlog');
			$this->Errorlog->get_log('ZarinpalsController','callback,'.$e->getMessage().',RefId='.$RefId.',model='.$model.',row_id='.$row_id.',status='.$status );
			$this->Session->setFlash($e->getMessage(),'error');
			$this->set('result_value',  FALSE);
		}

		$this->Session->delete('Pay_Info');
		$this->set('transaction_id',  $RefId);
		$this->_update_order($RefId,$row_id,$status,$_REQUEST['cn'],$_REQUEST['ac']);
	}

	function _update_order($ref_id,$row_id,$status,$coltroller,$action)
	{
		$random = rand(1000,1000000);
		$this->Session->write('CallBack_Info',array(
				'refid' => $ref_id ,
				'status'=> $status,
				'row_id'=>$row_id,
				'token' =>$random
			));
		$this->set('back_url', __SITE_URL.$coltroller.'/'.$action.'/?token='.$random);
	}



}
