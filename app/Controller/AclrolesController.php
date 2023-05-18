<?php
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');
/**
 * Aclroles Controller
 *
 * @property Aclrole $Aclrole
 * @property PaginatorComponent $Paginator
 */
class AclrolesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');


	function admin_active_permission(){
 	
	$response['success'] = false;
	$response['message'] = null;
	
	
	$this->request->data['Aclrole']['role_id']= $_REQUEST['role_id'];
	$this->request->data['Aclrole']['aclitem_id']=$_REQUEST['aclitem_id'];
	
	$this->request->data=Sanitize::clean($this->request->data);
	
	$this->Aclrole->create();
	try{
		$this->Aclrole->save($this->request->data);
		$response['success'] = TRUE;
	} catch (Exception $e) {
		$response['success'] = FALSE;
	}
		  
	$response['message'] = $response['success'] ?  : __('add_permission_notsuccess');
	
	$this->set('ajaxData',  json_encode($response));
	$this->render('/Elements/ajax_result', 'ajax');
	
 }
 
 
 function admin_inactive_permission(){
 	
	$response['success'] = false;
	$response['message'] = null;
	
	try{
		$this->Aclrole->deleteAll(array('Aclrole.role_id' =>$_REQUEST['role_id'] , 'Aclrole.aclitem_id' => $_REQUEST['aclitem_id']), false);
		$response['success'] = TRUE;
	} catch (Exception $e) {
		$response['success'] = FALSE;
	}
		  
	$response['message'] = $response['success'] ?  : __('delete_permission_notsuccess');
	
	$this->set('ajaxData',  json_encode($response));
	$this->render('/Elements/ajax_result', 'ajax');
	
 }

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Aclrole->recursive = 0;
		$this->set('aclroles', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Aclrole->exists($id)) {
			throw new NotFoundException(__('Invalid aclrole'));
		}
		$options = array('conditions' => array('Aclrole.' . $this->Aclrole->primaryKey => $id));
		$this->set('aclrole', $this->Aclrole->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Aclrole->create();
			if ($this->Aclrole->save($this->request->data)) {
				$this->Flash->success(__('The aclrole has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The aclrole could not be saved. Please, try again.'));
			}
		}
		$roles = $this->Aclrole->Role->find('list');
		$aclitems = $this->Aclrole->Aclitem->find('list');
		$this->set(compact('roles', 'aclitems'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Aclrole->exists($id)) {
			throw new NotFoundException(__('Invalid aclrole'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Aclrole->save($this->request->data)) {
				$this->Flash->success(__('The aclrole has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The aclrole could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Aclrole.' . $this->Aclrole->primaryKey => $id));
			$this->request->data = $this->Aclrole->find('first', $options);
		}
		$roles = $this->Aclrole->Role->find('list');
		$aclitems = $this->Aclrole->Aclitem->find('list');
		$this->set(compact('roles', 'aclitems'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Aclrole->id = $id;
		if (!$this->Aclrole->exists()) {
			throw new NotFoundException(__('Invalid aclrole'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Aclrole->delete()) {
			$this->Flash->success(__('The aclrole has been deleted.'));
		} else {
			$this->Flash->error(__('The aclrole could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
?>