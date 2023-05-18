<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');
/**
* Contactmessages Controller
*
* @property Contactmessage $Contactmessage
* @property PaginatorComponent $Paginator
*/
class ContactmessagesController extends AppController
{
	
	public function beforeFilter() {
		parent::beforeFilter();
		
		$this->Auth->allow(array('sendmessage')); 
	 }
	
	 
	
	public function sendmessage(){
		$error = false;
		//$this -> render('/Pages/contact_us');
		$this->autoRender = false;
		if($this->request->is('post'))
		{
			
			 
			
			
			if(md5($this->request->data['Contactmessage']['captcha'].'DYhG93b') != $this->Session->read('encoded_captcha'))
			{
				$this->Redirect->flashWarning(__('incorrect_captcha'),'/pages/contact_us');
				return FALSE;
			}

			$this->request->data = Sanitize::clean($this->request->data);

			$this->Contactmessage->create();
			if($this->Contactmessage->save($this->request->data))
			{
				//$this->Session->setFlash(__('send_message_not_successfully'),'success');
				$this->Redirect->flashSuccess(__('send_message_successfully'),'/pages/contact_us');
			}
			else
			{
				//$this->Session->setFlash(__('send_message_successfully'),'error');
				$this->Redirect->flashWarning(__('send_message_not_successfully'),'/pages/contact_us');
			}
						
		}

		$this->set('title_for_layout',__('register'));
		$this->set('description_for_layout',__('register'));
		$this->set('keywords_for_layout',__('register'));
	}
	
	 
	public
	function admin_index()
	{
		$this->set('title_for_layout',__('users'));
		$this->Contactmessage->recursive = - 1;
		if(isset($_REQUEST['filter']))
		{
			$limit = $_REQUEST['filter'];
		}
		else $limit = 50;

		if(isset($this->request->data['Contactmessage']['search']))
		{
			$this->request->data = Sanitize::clean($this->request->data);
			$this->paginate = array(
				'fields'                    =>array(
					'Contactmessage.id',
					'Contactmessage.name',
					'Contactmessage.message',
					'Contactmessage.email',
					'Contactmessage.subject',
					'Contactmessage.created'
				),
				'conditions' => array('Contactmessage.name LIKE' => ''.$this->request->data['Contactmessage']['search'].'%' ),
				'limit'     => $limit,
				'order'                          => array(
					'Contactmessage.id'=> 'desc'
				)
			);
		}
		else
		{
			$this->paginate = array(
				'fields'                    =>array(
					'Contactmessage.id',
					'Contactmessage.name',
					'Contactmessage.message',
					'Contactmessage.email',
					'Contactmessage.subject',
					'Contactmessage.created'
				),
				'limit'     => $limit,
				'order'                          => array(
					'Contactmessage.id'=> 'desc'
				)
			);
		}
		$contactmessages = $this->paginate('Contactmessage');
		$this->set(compact('contactmessages'));
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
		if(!$this->Contactmessage->exists($id)){
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('Contactmessage.' . $this->Contactmessage->primaryKey=> $id));
		$this->set('user', $this->Contactmessage->find('first', $options));
	}

	 
	public
	function admin_delete($id = null)
	{
		$this->Contactmessage->id = $id;
		if(!$this->Contactmessage->exists()){
			$this->Redirect->flashWarning(__('invalid_message'));
		}
		if($this->Contactmessage->delete()){
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