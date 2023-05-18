<?php
/**
 */
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class BankpasargadsController extends GetwayAppController
{

	var $name = 'Bankpasargads';
	var $components = array('Httpupload');
	var $PepPath = '';

	/**
	 * Controller name
	 *
	 *
	 * /**
	 * follow to anoher user
	 * @param undefined $id
	 *
	 */


	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('call', 'callback', 'app_call');
		$this->PepPath = ROOT . DS . 'plugins' . DS . 'Getway' . DS . 'Lib' . DS . 'Pep' . DS;
	}


	function call()
	{

		$response['success'] = true;
		$response['message'] = null;
		$Pay_Info = $this->Session->read('Pay_Info');


		require_once($this->PepPath . 'RSAProcessor.class.php');
		$processor = new RSAProcessor($this->PepPath . "certificate.xml", RSAKeyType::XMLFile);

		$response['merchantCode'] = __PASARGAD_USERNAME; // كد پذيرنده
		$response['terminalCode'] = __PASARGAD_TERMINALID; // كد ترمينال
		$response['amount'] = $Pay_Info['sum_price'] + $Pay_Info['other_price']; // مبلغ فاكتور
		$response['redirectAddress'] = __SITE_URL . 'getway/bankpasargads/callback/' . $Pay_Info['model'] . '/' . $Pay_Info['row_id'] . '?cn=' . $_REQUEST['cn'] . '&ac=' . $_REQUEST['ac'] . '&token=' . $Pay_Info['token'];

		$response['invoiceNumber'] = $Pay_Info['orderid']; //شماره فاكتور
		$response['timeStamp'] = date("Y/m/d H:i:s");
		$response['invoiceDate'] = date("Y/m/d H:i:s"); //تاريخ فاكتور
		$response['action'] = "1003";    // 1003 : براي درخواست خريد
		$data = "#" . $response['merchantCode'] . "#" . $response['terminalCode'] . "#" . $response['invoiceNumber'] . "#" . $response['invoiceDate'] . "#" . $response['amount'] . "#" . $response['redirectAddress'] . "#" . $response['action'] . "#" . $response['timeStamp'] . "#";
		$data = sha1($data, true);
		$data = $processor->sign($data); // امضاي ديجيتال
		$response['sign'] = base64_encode($data); // base64_encode


		$this->set('ajaxData', json_encode($response));
		$this->render('Getway.Elements/Bankmellats/Ajax/ajax_result', 'ajax');
	}

	function callback($model, $row_id)
	{
		require_once($this->PepPath . 'parser.php');
		$fields = array('invoiceUID' => $_GET['tref']);
		$result = post2https($fields, 'https://pep.shaparak.ir/CheckTransactionResult.aspx');
		$array = makeXMLTree($result);
		//var_dump($array);
		$transaction_id = '';
		$order_id = '';
		$back_url = __SITE_URL.'products';

		if ($array["resultObj"]["result"] == 'True') // true
		{
			$date = $_GET['iD'];
			$transaction_id = $array["resultObj"]["transactionReferenceID"];
			$order_id = $row_id;
			$result = $this->verify($row_id,$date);
			if ($result['actionResult']['result']=='True') {
				$back_url = $this->_update_order(0, $_GET['tref'], $row_id, -1, $_REQUEST['cn'], $_REQUEST['ac']);
				$this->Redirect->flashSuccess($result['actionResult']['resultMessage']);
			}else
			$this->Redirect->flashWarning($result['actionResult']['resultMessage']);
		}else{
			$this->Redirect->flashWarning(__d(__GATEWAY_LOCALE,'pay_action_not_done'));
		}

		$this->set(compact('transaction_id','order_id','back_url'));
	}

	function verify($row_id,$date)
	{
		require_once($this->PepPath . "RSAProcessor.class.php");
		require_once($this->PepPath . "parser.php");
		$Pay_Info = $this->Session->read('Pay_Info');
		$fields = array(
			'MerchantCode' => __PASARGAD_USERNAME,            //shomare ye moshtari e shoma.
			'TerminalCode' => __PASARGAD_TERMINALID,            //shomare ye terminal e shoma.
			'InvoiceNumber' => $Pay_Info['orderid'],            //shomare ye factor tarakonesh.
			'InvoiceDate' => $date, //tarikh e tarakonesh.
			'amount' => $Pay_Info['sum_price'] + $Pay_Info['other_price'],                    //mablagh e tarakonesh. faghat adad.
			'TimeStamp' => date("Y/m/d H:i:s"),    //zamane jari ye system.
			'sign' => ''                            //reshte ye ersali ye code shode. in mored automatic por mishavad.
		);

		$processor = new RSAProcessor($this->PepPath . "certificate.xml", RSAKeyType::XMLFile);

		$data = "#" . $fields['MerchantCode'] . "#" . $fields['TerminalCode'] . "#" . $fields['InvoiceNumber'] . "#" . $fields['InvoiceDate'] . "#" . $fields['amount'] . "#" . $fields['TimeStamp'] . "#";
		$data = sha1($data, true);
		$data = $processor->sign($data);
		$fields['sign'] = base64_encode($data); // base64_encode
		$sendingData = "MerchantCode=" . $fields['MerchantCode'] . "&TerminalCode=" . $fields['TerminalCode'] . "&InvoiceNumber=" . $fields['InvoiceNumber'] . "&InvoiceDate=" . $fields['InvoiceDate'] . "&amount=" . $fields['amount'] . "&TimeStamp=" . $fields['TimeStamp'] . "&sign=" . $fields['sign'];
		$verifyresult = post2https($fields, 'https://pep.shaparak.ir/VerifyPayment.aspx');
		$array = makeXMLTree($verifyresult);
		return  $array;
	}

	/**
	 *
	 * @param undefined $model
	 *
	 */
	function callback1($model, $row_id)
	{

		$step = 0;
		$this->loadModel('Bankmessag');
		$this->Bankmessag->recursive = -1;
		$result_value = FALSE;

		$this->set('title_for_layout', __('bankmellat_getway'));
		$this->set('description_for_layout', __('bankmellat_getway'));
		$this->set('keywords_for_layout', __('bankmellat_getway'));


		$Pay_Info = $this->Session->read('Pay_Info');

		if ($_REQUEST['token'] != $Pay_Info['token']) {
			$this->Session->delete('Pay_Info');
			$this->Redirect->flashWarning(__('not_exist_pasy_info'), $this->_update_order(0, 0, $row_id, -1, $_REQUEST['cn'], $_REQUEST['ac']));
		}
		if ($_REQUEST['cn'] != $Pay_Info['cn']) {
			$this->Session->delete('Pay_Info');
			$this->Redirect->flashWarning(__('not_exist_pasy_info'), $this->_update_order(0, 0, $row_id, -1, $_REQUEST['cn'], $_REQUEST['ac']));
		}
		if ($_REQUEST['ac'] != $Pay_Info['ac']) {
			$this->Session->delete('Pay_Info');
			$this->Redirect->flashWarning(__('not_exist_pasy_info'), $this->_update_order(0, 0, $row_id, -1, $_REQUEST['cn'], $_REQUEST['ac']));
		}


		if ($this->request->is('post') || $this->request->is('put')) {
			$RefId = Sanitize::clean($_POST['RefId']);
			$ResCode = Sanitize::clean($_POST['ResCode']);
			$SaleOrderId = Sanitize::clean($_POST['SaleOrderId']);
			$SaleReferenceId = Sanitize::clean($_POST['SaleReferenceId']);
			$orderId = $SaleOrderId;

			$datasource = $this->Bankmellat->getDataSource();
			try {
				$datasource->begin();

				if ($ResCode != 0) {
					$options['conditions'] = array(
						'Bankmessag.bank_id' => 1,
						'Bankmessag.id' => $ResCode
					);
					$message = $this->Bankmessag->find('first', $options);
					$step = 20;
					throw new Exception($message['Bankmessag']['message']);
				}

				$callverify = $this->verifySoap($orderId, $SaleReferenceId, __MELLAT_TERMINALID, __MELLAT_USERNAME, __MELLAT_USERPASSWORD);
				if ($callverify != 0) {
					$callinquiry = $this->inquirySoap($orderId, $SaleReferenceId, __MELLAT_TERMINALID, __MELLAT_USERNAME, __MELLAT_USERPASSWORD);
					if ($callinquiry == 0) {
						$callsettle = $this->settleSoap($orderId, $SaleReferenceId, __MELLAT_TERMINALID, __MELLAT_USERNAME, __MELLAT_USERPASSWORD);
						if ($callsettle == 0) {
							$step = 30;
							$this->Session->setFlash(__('buy_successed'), 'success');
							$result_value = TRUE;

						} else {
							$step = 40;
							throw new Exception(__('approval_of_final_deposit_in_bank_operations_were_performed'));
						} // enf of settleSoap

					} // end of inquirySoap if
					else {

						$callreverse = $this->reverseSoap($orderId, $SaleReferenceId, __MELLAT_TERMINALID, __MELLAT_USERNAME, __MELLAT_USERPASSWORD);
						if ($callreverse == 0) {
							$step = 60;
							$this->Session->setFlash(__('money_was_paid_back_operation'), 'success');
							$result_value = TRUE;

						} else {
							$step = 70;
							throw new Exception(__('buy_not_successed'));
						}
					}
				} // end of verifySoap
				else {
					$callsettle = $this->settleSoap($orderId, $SaleReferenceId, __MELLAT_TERMINALID, __MELLAT_USERNAME, __MELLAT_USERPASSWORD);
					if ($callsettle == 0) {
						$step = 80;
						$this->Session->setFlash(__('buy_successed'), 'success');
						$result_value = TRUE;

					}  // settleSoap
					else {
						$callreverse = $this->reverseSoap($orderId, $SaleReferenceId, __MELLAT_TERMINALID, __MELLAT_USERNAME, __MELLAT_USERPASSWORD);
						if ($callreverse == 0) {
							$step = 100;
							$this->Session->setFlash(__('money_was_paid_back_operation'), 'success');
							$result_value = TRUE;

						} else {
							$step = 110;
							throw new Exception(__('buy_not_successed'));
						}
					}
				}

				$datasource->commit();
			} catch (Exception $e) {
				$datasource->rollback();
				Controller::loadModel('Errorlog');
				$this->Errorlog->get_log('BankmellatsController', 'callback,step = ' . $step . ' , ' . $e->getMessage() . ',ResCode=' . $ResCode . ',RefId=' . $RefId . ',SaleReferenceId=' . $SaleReferenceId . ',orderId=' . $orderId . ',model=' . $model . ',row_id=' . $row_id);
				$this->Session->setFlash($e->getMessage(), 'error');
				$result_value = FALSE;
				$this->set('result_value', FALSE);
			}

			$this->set('result_value', $result_value);
			$this->set('transaction_id', $SaleReferenceId);
			$this->set('order_id', $row_id);

			$this->_update_order($ResCode, $SaleReferenceId, $row_id, -1, $_REQUEST['cn'], $_REQUEST['ac']);

		}


	}

	function _update_order($res_code, $ref_id, $row_id, $status, $coltroller, $action)
	{
		$random = rand(1000, 1000000);
		$this->Session->write('CallBack_Info', array(
			'bankmessage_id' => $res_code,
			'refid' => $ref_id,
			'status' => $status,
			'row_id' => $row_id,
			'token' => $random
		));
		return __SITE_URL . $coltroller . '/' . $action . '/?token=' . $random;
	}

	function _send_email($user_id, $name, $email, $order_id)
	{
		try {
			$Email = new CakeEmail();
			$Email->template('order_sendemail', 'sendemail_layout');
			$Email->subject(__('new_order_created_for_you'));
			$Email->emailFormat('html');
			$Email->to($register_email);
			$Email->from(array(__Email => __Email_Name));
			$Email->viewVars(array('name' => $name, 'email' => $email));
			$Email->send();
		} catch (Exception $e) {

		}
	}


}
