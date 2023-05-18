<?php
App::uses('AppController', 'Controller');
/**
 * Roles Controller
 *
 * @property Role $Role
 * @property PaginatorComponent $Paginator
 */
class SiteinformationsController extends AppController {

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
		$this->Siteinformation->recursive = 0;
		$this->set('title_for_layout',__('siteinformations'));
		if(isset($_REQUEST['filter'])){
			$limit = $_REQUEST['filter'];
		}else $limit = 10;
				
		if(isset($this->request->data['Siteinformation']['search'])){
			$this->request->data=Sanitize::clean($this->request->data);
			$this->paginate = array(
'conditions' => array('Siteinformation.referer_host LIKE' => ''.$this->request->data['Siteinformation']['search'].'%' ),
				'limit' => $limit,
				'order' => array(
					'Siteinformation.id' => 'desc'
				)
			);
		}
		else
		{
			$this->paginate = array(
			 
				'limit' => $limit,
				'order' => array(
					'Siteinformation.id' => 'desc'
				)
			);
		}		
		$siteinformations = $this->paginate('Siteinformation');
		$this->set(compact('siteinformations'));
	}

 
}
?>