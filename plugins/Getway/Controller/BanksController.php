<?php
/**
*/
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class BanksController extends GetwayAppController
{

	var $name       = 'Banks';
	var $components = array('Httpupload');

	public
	function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('pay','app_pay','zpay');
	}

	/**
	*
	* @param undefined $token
	*
	*/
	function pay($token)
	{

		$this->Bank->recursive = - 1;
		$banks = $this->Bank->find('all');
		$this->set(compact('banks'));

		$this->set('title_for_layout',__d(__GATEWAY_LOCALE,'select_getway'));
		$this->set('description_for_layout',__d(__GATEWAY_LOCALE,'select_getway'));
		$this->set('keywords_for_layout',__d(__GATEWAY_LOCALE,'select_getway'));

		$cn       = Sanitize::clean($_REQUEST['cn']);
		$ac       = Sanitize::clean($_REQUEST['ac']);

		$Pay_Info = $this->Session->read('Pay_Info');

		if($token != $Pay_Info['token'])
		{
			$this->Session->delete('Pay_Info');
			$this->Redirect->flashWarning(__('not_exist_pasy_info'),$this->_error_zpay_url(0,$Pay_Info['row_id'],-1,$cn,$ac));
		}
		if($cn != $Pay_Info['cn'])
		{
			$this->Session->delete('Pay_Info');
			$this->Redirect->flashWarning(__('not_exist_pasy_info'),$this->_error_zpay_url(0,$Pay_Info['row_id'],-1,$cn,$ac));
		}
		if($ac != $Pay_Info['ac'])
		{
			$this->Session->delete('Pay_Info');
			$this->Redirect->flashWarning(__('not_exist_pasy_info'),$this->_error_zpay_url(0,$Pay_Info['row_id'],-1,$cn,$ac));
		}

		$this->set('token',$token);

		$this->set('cn',$cn);
		$this->set('ac',$ac);

	}

	function app_pay($token)
	{

		$this->set('title_for_layout',__('getway'));
		$this->set('description_for_layout',__('getway'));
		$this->set('keywords_for_layout',__('getway'));

		$token = Sanitize::clean($token);

		$this->loadModel('Token');
		$this->Token->recursive = - 1;
		$info = $this->Token->find('first', array('conditions' => array('Token.token'=> $token)));
		$this->set('info',$info);
		$this->set('token',$token);
	}

	function zpay($token)
	{

		//$this->autoRender = false;

		$this->Bank->recursive = - 1;
		$banks    = $this->Bank->find('all');
		$this->set(compact('banks'));

		$this->set('title_for_layout',__('getway'));
		$this->set('description_for_layout',__('getway'));
		$this->set('keywords_for_layout',__('getway'));

		$cn       = Sanitize::clean($_REQUEST['cn']);
		$ac       = Sanitize::clean($_REQUEST['ac']);

		$Pay_Info = $this->Session->read('Pay_Info');

		if($token != $Pay_Info['token'])
		{
			$this->Session->delete('Pay_Info');
			$this->Redirect->flashWarning(__('not_exist_pasy_info'),$this->_error_zpay_url(0,$Pay_Info['row_id'],-1,$cn,$ac));
		}
		if($cn != $Pay_Info['cn'])
		{
			$this->Session->delete('Pay_Info');
			$this->Redirect->flashWarning(__('not_exist_pasy_info'),$this->_error_zpay_url(0,$Pay_Info['row_id'],-1,$cn,$ac));
		}
		if($ac != $Pay_Info['ac'])
		{
			$this->Session->delete('Pay_Info');
			$this->Redirect->flashWarning(__('not_exist_pasy_info'),$this->_error_zpay_url(0,$Pay_Info['row_id'],-1,$cn,$ac));
		}

		$MerchantID = __MERCHANT_ID; //Required
		$Amount     = $Pay_Info['sum_price']; //Amount will be based on Toman - Required
		$Description= $Pay_Info['title']; // Required
		$Email      = ''; // Optional
		$Mobile     = ''; // Optional
		$CallbackURL= __SITE_URL.'getway/zarinpals/callback/'.$Pay_Info['model'].'/'.$Pay_Info['row_id'].'?cn='.$_REQUEST['cn'].'&ac='.$_REQUEST['ac'].'&token='.$Pay_Info['token'];

		App::import('Vendor','nusoap', array('file'=>'nusoap'.DS.'lib'.DS.'nusoap.php'));
		$client = new nusoap_client('https://www.zarinpal.com/pg/services/WebGate/wsdl', 'wsdl');
		$client->soap_defencoding = 'UTF-8';
		$result = $client->call('PaymentRequest', [
	        [
	            'MerchantID'     => $MerchantID,
	            'Amount'         => $Amount,
	            'Description'    => $Description,
	            'Email'          => $Email,
	            'Mobile'         => $Mobile,
	            'CallbackURL'    => $CallbackURL,
	        ],
	    ]);
		$this->set('back_url','');
		//Redirect to URL You can do it also by creating a form
		if ($result['Status'] == 100)
		{
			//Header('Location: https://www.zarinpal.com/pg/StartPay/'.$result->Authority);
			//$this->redirect('Location: https://www.zarinpal.com/pg/StartPay/'.$result['Authority']);
			$this->set('back_url','https://www.zarinpal.com/pg/StartPay/'.$result['Authority'].'/ZarinGate');
		}
		else
		{
			$row_id = $Pay_Info['row_id'];
			$this->Session->delete('Pay_Info');
			Controller::loadModel('Errorlog');
			$this->Errorlog->get_log('ZarinpalsController','zpay, '.$result['Status'].' | '.$result['Status']);

			$this->Redirect->flashWarning(__('can_not_connect_to_getway'),$this->_error_zpay_url(0,$row_id,-1,$cn,$ac));
		}

	}

	private function _error_zpay_url($ref_id,$row_id,$status,$coltroller,$action){
		$random = rand(1000,1000000);
		$this->Session->write('CallBack_Info',array(
				'refid' => $ref_id ,
				'status'=> $status,
				'row_id'=>$row_id,
				'token' =>$random
			));
		return __SITE_URL.$coltroller.'/'.$action.'/?token='.$random;
	}


}
