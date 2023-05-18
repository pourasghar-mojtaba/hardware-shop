<?php
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');
/**
 * Settings Controller
 *
 * @property Setting $Setting
 * @property PaginatorComponent $Paginator
 */
class SettingsController extends AppController {

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
		$this->Setting->recursive = 0;
		$this->set('settings', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Setting->exists($id)) {
			throw new NotFoundException(__('Invalid setting'));
		}
		$options = array('conditions' => array('Setting.' . $this->Setting->primaryKey => $id));
		$this->set('setting', $this->Setting->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Setting->create();
			if ($this->Setting->save($this->request->data)) {
				$this->Flash->success(__('The setting has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The setting could not be saved. Please, try again.'));
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
		  
		$this->set('title_for_layout',__('site_setting'));
		if($this->request->is('post') || $this->request->is('put'))
		{
			$this->request->data=Sanitize::clean($this->request->data);
			$this->request->data['Setting']['site_description']=trim($this->request->data['Setting']['site_description']);
			$this->request->data['Setting']['site_keywords']=trim($this->request->data['Setting']['site_keywords']);
			$this->request->data['Setting']['site_title']=trim($this->request->data['Setting']['site_title']);
			$ret= $this->Setting->updateAll(
			    array( 'Setting.site_description' =>'"'.$this->request->data['Setting']['site_description'].'"',
					   'Setting.site_keywords' =>'"'.$this->request->data['Setting']['site_keywords'].'"' ,
					   'Setting.site_title' =>'"'.$this->request->data['Setting']['site_title'].'"' 
				),
    			array('Setting.language_id' => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID))
				
			  );
			
			if($ret)
			{
				$this->Redirect->flashSuccess(__('the_setting_has_been_saved'));
			}
			else
			{
				$this->Redirect->flashWarning(__('the_setting_could_not_be_saved'));
			}
		}
		
		$this->request->data = $this->Setting->_getSetting($this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)); 
		 
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Setting->id = $id;
		if (!$this->Setting->exists()) {
			throw new NotFoundException(__('Invalid setting'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Setting->delete()) {
			$this->Flash->success(__('The setting has been deleted.'));
		} else {
			$this->Flash->error(__('The setting could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
?>