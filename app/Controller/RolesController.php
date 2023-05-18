<?php
App::uses('AppController', 'Controller');
/**
 * Roles Controller
 *
 * @property Role $Role
 * @property PaginatorComponent $Paginator
 */
class RolesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
    public $helpers = array('AdminHtml'=>array('action'=>'Role'));
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Role->recursive = 0;
		$this->set('title_for_layout',__('roles'));
		if(isset($_REQUEST['filter'])){
			$limit = $_REQUEST['filter'];
		}else $limit = 10;
				
		if(isset($this->request->data['Role']['search'])){
			$this->request->data=Sanitize::clean($this->request->data);
			$this->paginate = array(
'conditions' => array('Role.name LIKE' => ''.$this->request->data['Role']['search'].'%' ,'Role.id not in'=>array(1,2)),
				'limit' => $limit,
				'order' => array(
					'Role.id' => 'desc'
				)
			);
		}
		else
		{
			$this->paginate = array(
			    'conditions' => array('Role.id not in (1,2)'),
				'limit' => $limit,
				'order' => array(
					'Role.id' => 'desc'
				)
			);
		}		
		$roles = $this->paginate('Role');
		$this->set(compact('roles'));
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Role->exists($id)) {
			throw new NotFoundException(__('Invalid role'));
		}
		$options = array('conditions' => array('Role.' . $this->Role->primaryKey => $id));
		$this->set('role', $this->Role->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		$this->set('title_for_layout',__('add_role'));
		if ($this->request->is('post')) {
			$this->Role->create();
			if ($this->Role->save($this->request->data)) {
				$this->Redirect->flashSuccess(__('the_role_has_been_saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Redirect->flashWarning(__('the_role_could_not_be_saved_Please_try_again'));
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
		$this->set('title_for_layout',__('edit_role'));
		if (!$this->Role->exists($id)) {
			$this->Redirect->flashWarning(__('invalid_role'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Role->save($this->request->data)) {
				$this->Redirect->flashSuccess(__('the_role_has_been_saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Redirect->flashWarning(__('the_role_could_not_be_saved_Please_try_again'));
			}
		} else {
			$options = array('conditions' => array('Role.' . $this->Role->primaryKey => $id));
			$this->request->data = $this->Role->find('first', $options);
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
		$this->Role->id = $id;
		if (!$this->Role->exists()) {
			$this->Redirect->flashWarning(__('invalid_role'));
		}
		if ($this->Role->delete()) {
			$this->Redirect->flashSuccess(__('the_role_has_been_deleted'));
		} else {
			$this->Redirect->flashWarning(__('the_role_could_not_be_deleted_please_try_again'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
?>