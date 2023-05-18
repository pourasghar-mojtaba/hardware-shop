<?php
App::uses('AppController', 'Controller');

class MessagesController extends ManagerAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
    public $helpers = array('AdminHtml'=>array('action'=>'Message'));
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Message->recursive = 0;
		$this->set('title_for_layout',__('message'));
		if(isset($_REQUEST['filter'])){
			$limit = $_REQUEST['filter'];
		}else $limit = 10;
				
		if(isset($this->request->data['Message']['search'])){
			$this->request->data=Sanitize::clean($this->request->data);
			$this->paginate = array(
'conditions' => array('Message.message LIKE' => ''.$this->request->data['Message']['search'].'%' ),
				'fields'=>array(
					'User.name',
					'Message.id',
					'Message.message',
					'Message.status',
					'Message.created',
				),
				'joins'=>array(array('table' => 'users',
					'alias' => 'User',
					'type' => 'inner',
					'conditions' => array(
					'Message.user_id = User.id ',
					)
				 )),
				'limit' => $limit,
				'order' => array(
					'Message.id' => 'desc'
				)
			);
		}
		else
		{
			$this->paginate = array(
				'fields'=>array(
					'User.name',
					'Message.id',
					'Message.message',
					'Message.status',
					'Message.created',
				),
				'joins'=>array(array('table' => 'users',
					'alias' => 'User',
					'type' => 'inner',
					'conditions' => array(
					'Message.user_id = User.id ',
					)
				 )),
				'limit' => $limit,
				'order' => array(
					'Message.id' => 'desc'
				)
			);
		}		
		$messages = $this->paginate('Message');
		$this->set(compact('messages'));
	}


/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		$this->set('title_for_layout',__d('manager','add_managermessage'));
		if ($this->request->is('post')) {
			$this->Message->create();
			if ($this->Message->save($this->request->data)) {
				$this->Redirect->flashSuccess(__d('manager','the_managermessage_has_been_saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Redirect->flashWarning(__d('manager','the_managermessage_could_not_be_saved_Please_try_again'));
			}
		}
		$this->loadModel('User');
		$this->User->recursive = -1;
		$users = $this->User->find('list');
		$this->set(compact('users'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->set('title_for_layout',__d('manager','edit_managermessage'));
		if (!$this->Message->exists($id)) {
			$this->Redirect->flashWarning(__d('manager','invalid_managermessage'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Message->save($this->request->data)) {
				$this->Redirect->flashSuccess(__d('manager','the_managermessage_has_been_saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Redirect->flashWarning(__d('manager','the_managermessage_could_not_be_saved_Please_try_again'));
			}
		} else {
			$options = array('conditions' => array('Message.' . $this->Message->primaryKey => $id));
			$this->request->data = $this->Message->find('first', $options);
		}
		$this->loadModel('User');
		$this->User->recursive = -1;
		$users = $this->User->find('list');
		$this->set(compact('users'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Message->id = $id;
		if (!$this->Message->exists()) {
			$this->Redirect->flashWarning(__d('manager','invalid_managermessage'));
		}
		if ($this->Message->delete()) {
			$this->Redirect->flashSuccess(__d('manager','the_managermessage_has_been_deleted'));
		} else {
			$this->Redirect->flashWarning(__d('manager','the_managermessage_could_not_be_deleted_please_try_again'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
?>