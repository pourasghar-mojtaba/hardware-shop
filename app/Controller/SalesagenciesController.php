<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');
/**
* Salesagencies Controller
*
* @property Salesagency $Salesagency
* @property PaginatorComponent $Paginator
*/
class SalesagenciesController extends AppController
{

	public function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow(array('send'));
	 }

	public $components = array('Paginator', 'Httpupload');

	public function send(){
		$error = false;
		//$this -> render('/Pages/contact_us');
		//$this->autoRender = false;
		if($this->request->is('post'))
		{
			if(md5($this->request->data['Salesagency']['captcha'].'DYhG93b') != $this->Session->read('encoded_captcha'))
			{
				$this->Redirect->flashWarning(__('incorrect_captcha'),'/salesagencies/send');
				return FALSE;
			}
			$this->request->data = Sanitize::clean($this->request->data);

			$data = Sanitize::clean($this->request->data);
			$file = $data['Salesagency']['file'];
			if ($file['size'] > 0) {
				$output = $this->_upload_file();
				if (!$output['error']) $this->request->data['Salesagency']['file'] = $output['filename'];
				else $this->request->data['Salesagency']['file'] = '';
			} else $this->request->data['Salesagency']['file'] = '';

			$this->Salesagency->create();
			if($this->Salesagency->save($this->request->data))
			{
				//$this->Session->setFlash(__('send_message_not_successfully'),'success');
				$this->Redirect->flashSuccess(__('granting_sale_successfully'),'/salesagencies/send');
			}
			else
			{
				//$this->Session->setFlash(__('granting_sale_successfully'),'error');
				$this->Redirect->flashWarning(__('granting_sale_not_successfully'),'/salesagencies/send');
			}

		}

		$this->set('title_for_layout',__('granting_sales_agency'));
		$this->set('description_for_layout',__('granting_sales_agency'));
		$this->set('keywords_for_layout',__('granting_sales_agency'));
	}

	function _upload_file()
	{
		App::uses('Sanitize', 'Utility');

		$output = array();
		$data = Sanitize::clean($this->request->data);
		$file = $data['Salesagency']['file'];

		if ($file['size'] > 0) {
			$ext = $this->Httpupload->get_extension($file['name']);
			$filename = md5(rand() . $_SERVER['REMOTE_ADDR']);
			if (file_exists(__SALES_AGENCY_PATH . $filename . '.' . $ext)) $filename = md5(rand() . $_SERVER[REMOTE_ADDR]);

			$this->Httpupload->setmodel('Salesagency');
			$this->Httpupload->setuploaddir(__SALES_AGENCY_PATH);
			$this->Httpupload->setuploadname('file');
			$this->Httpupload->settargetfile($filename . '.' . $ext);
			$this->Httpupload->allowExt = __UPLOAD_File_EXT;
			if (!$this->Httpupload->upload()) {
				return array('error' => true, 'filename' => '', 'message' => $this->Httpupload->get_error());
			}
			$filename .= '.' . $ext;

		}
		return array('error' => false, 'filename' => $filename);
	}


	public
	function admin_index()
	{
		$this->set('title_for_layout',__('salesagencies'));
		$this->Salesagency->recursive = - 1;
		if(isset($_REQUEST['filter']))
		{
			$limit = $_REQUEST['filter'];
		}
		else $limit = 50;

		if(isset($this->request->data['Salesagency']['search']))
		{
			$this->request->data = Sanitize::clean($this->request->data);
			$this->paginate = array(
				'fields'                    =>array(
					'Salesagency.id',
					'Salesagency.name',
					'Salesagency.message',
					'Salesagency.mobile',
					'Salesagency.file',
					'Salesagency.email',
					'Salesagency.form_type',
					'Salesagency.subject',
					'Salesagency.created'
				),
				'conditions' => array('Salesagency.name LIKE' => ''.$this->request->data['Salesagency']['search'].'%' ),
				'limit'     => $limit,
				'order'                          => array(
					'Salesagency.id'=> 'desc'
				)
			);
		}
		else
		{
			$this->paginate = array(
				'fields'                    =>array(
					'Salesagency.id',
					'Salesagency.name',
					'Salesagency.message',
					'Salesagency.mobile',
					'Salesagency.file',
					'Salesagency.email',
					'Salesagency.form_type',
					'Salesagency.subject',
					'Salesagency.created'
				),
				'limit'     => $limit,
				'order'                          => array(
					'Salesagency.id'=> 'desc'
				)
			);
		}
		$salesagencies = $this->paginate('Salesagency');
		$this->set(compact('salesagencies'));
	}

	/**
	* admin_view method
	*
	* @throws NotFoundException
	* @param string $id
	* @return void
	*/
	public
	function admin_view($id = null)
	{
		if(!$this->Salesagency->exists($id)){
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('Salesagency.' . $this->Salesagency->primaryKey=> $id));
		$this->set('user', $this->Salesagency->find('first', $options));
	}


	public
	function admin_delete($id = null)
	{
		$this->Salesagency->id = $id;
		if(!$this->Salesagency->exists()){
			$this->Redirect->flashWarning(__('invalid_message'));
		}
		$result = $this->Salesagency->findById($id);
		if($this->Salesagency->delete()){
			$filename = $result['Salesagency']['file'];
			@unlink(__SALES_AGENCY_PATH . $filename);
			$this->Redirect->flashSuccess(__('the_message_has_been_deleted'));
		}
		else
		{
			$this->Redirect->flashWarning(__('the_message_could_not_be_deleted_please_try_again'));
		}
		return $this->redirect(array('action'=> 'index'));
	}

	public
	function captcha_image()
	{
		/*App::import('Vendor', 'captcha/captcha');
		$captcha = new captcha();
		$captcha->show_captcha();*/
		App::import('Vendor', 'jdf');
		$timezone = 0;//برای 3:30 عدد 12600 و برای 4:30 عدد 16200 را تنظیم کنید
		$now      = date("Y-m-d", $time + $timezone);
		$time     = date("H:i:s", $time + $timezone);
		list($year, $month, $day) = explode('-', $now);
		list($hour, $minute, $second) = explode(':', $time);
		$timestamp   = mktime($hour, $minute, $second, $month, $day, $year);
		$jalali_date = jdate("Y/m/d - H:i",$timestamp);
		pr($jalali_date);
		$this->autoRender = false;
	}

}
?>
