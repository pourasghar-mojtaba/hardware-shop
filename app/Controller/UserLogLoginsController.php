<?php
App::uses('AppController', 'Controller');
/**
 * UserLogLogins Controller
 *
 * @property UserLogLogin $UserLogLogin
 * @property PaginatorComponent $Paginator
 */
class UserLogLoginsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->UserLogLogin->recursive = 0;
		$this->set('userLogLogins', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->UserLogLogin->exists($id)) {
			throw new NotFoundException(__('Invalid user log login'));
		}
		$options = array('conditions' => array('UserLogLogin.' . $this->UserLogLogin->primaryKey => $id));
		$this->set('userLogLogin', $this->UserLogLogin->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->UserLogLogin->create();
			if ($this->UserLogLogin->save($this->request->data)) {
				$this->Flash->success(__('The user log login has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The user log login could not be saved. Please, try again.'));
			}
		}
		$users = $this->UserLogLogin->User->find('list');
		$this->set(compact('users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->UserLogLogin->exists($id)) {
			throw new NotFoundException(__('Invalid user log login'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->UserLogLogin->save($this->request->data)) {
				$this->Flash->success(__('The user log login has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The user log login could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('UserLogLogin.' . $this->UserLogLogin->primaryKey => $id));
			$this->request->data = $this->UserLogLogin->find('first', $options);
		}
		$users = $this->UserLogLogin->User->find('list');
		$this->set(compact('users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->UserLogLogin->id = $id;
		if (!$this->UserLogLogin->exists()) {
			throw new NotFoundException(__('Invalid user log login'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->UserLogLogin->delete()) {
			$this->Flash->success(__('The user log login has been deleted.'));
		} else {
			$this->Flash->error(__('The user log login could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
?>