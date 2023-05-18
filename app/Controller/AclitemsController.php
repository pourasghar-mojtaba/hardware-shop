<?php
App::uses('AppController', 'Controller');
/**
 * Aclitems Controller
 *
 * @property Aclitem $Aclitem
 * @property PaginatorComponent $Paginator
 */
class AclitemsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->set('title_for_layout',__('permisions'));
		$this->Aclitem->recursive = 0;
		$role_id=$_REQUEST['role_id'];
		$options['fields'] = array(
			'Aclitem.*',
			'Aclrole.aclitem_id'
		 );
		$options['joins'] = array(
				array('table' => 'aclroles',
					'alias' => 'Aclrole',
					'type' => 'LEFT',
					'conditions' => array(
					'Aclrole.aclitem_id = Aclitem.id AND role_id = '.$role_id,
					)
				) 
				
			);		
		$options['conditions'] = array(
			'Aclitem.active'=>1
		);
		
		$options['order'] = array(
				'Aclitem.controller, Aclitem.action'=>'asc'
		);
		
		$aclitems = $this->Aclitem->find('all',$options);
		$this->set(compact('aclitems'));
		
		$options = array();
		$role_id=$_REQUEST['role_id'];
		$this->Aclitem->Aclrole->Role->recursive = 0;		
		$options['fields'] = array(
			'Role.name'
		   );
		$options['conditions'] = array(
		'Role.id '=> $role_id
		);	   
		$role= $this->Aclitem->Aclrole->Role->find('first',$options);
		$this->set(compact('role'));
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Aclitem->exists($id)) {
			throw new NotFoundException(__('Invalid aclitem'));
		}
		$options = array('conditions' => array('Aclitem.' . $this->Aclitem->primaryKey => $id));
		$this->set('aclitem', $this->Aclitem->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Aclitem->create();
			if ($this->Aclitem->save($this->request->data)) {
				$this->Flash->success(__('The aclitem has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The aclitem could not be saved. Please, try again.'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Aclitem->exists($id)) {
			throw new NotFoundException(__('Invalid aclitem'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Aclitem->save($this->request->data)) {
				$this->Flash->success(__('The aclitem has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The aclitem could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Aclitem.' . $this->Aclitem->primaryKey => $id));
			$this->request->data = $this->Aclitem->find('first', $options);
		}
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Aclitem->id = $id;
		if (!$this->Aclitem->exists()) {
			throw new NotFoundException(__('Invalid aclitem'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Aclitem->delete()) {
			$this->Flash->success(__('The aclitem has been deleted.'));
		} else {
			$this->Flash->error(__('The aclitem could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
?>