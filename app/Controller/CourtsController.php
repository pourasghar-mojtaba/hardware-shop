<?php
/**
 * Courts Controller
 *
 * @property Court $Court
 */
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class CourtsController extends AppController {

	var $name = 'Courts';

	function admin_index()
	{
		$this->Court->recursive = -1;
		if(isset($_REQUEST['filter'])){
			$limit = $_REQUEST['filter'];
		}else $limit = 10;
				
		if(isset($this->request->data['Court']['search'])){
			$this->request->data=Sanitize::clean($this->request->data);
			$this->paginate = array(
				'fields'=>array(
					'Court.id',
					'Court.name',
					'Court.status',
					'Court.created',
					'Country.name',
				),
				'joins'=>array(array('table' => 'countries',
					'alias' => 'Country',
					'type' => 'LEFT',
					'conditions' => array(
					'Country.id = Court.country_id ',
					)
				 )),
				'conditions' => array('Court.name LIKE' => ''.$this->request->data['Court']['search'].'%' ),
				'limit' => $limit,
				'order' => array(
					'Court.id' => 'desc'
				)
			);
		}
		else
		{
			$this->paginate = array(
				'fields'=>array(
					'Court.id',
					'Court.name',
					'Court.status',
					'Court.created',
					'Country.name',
				),
				'joins'=>array(array('table' => 'countries',
					'alias' => 'Country',
					'type' => 'LEFT',
					'conditions' => array(
					'Country.id = Court.country_id ',
					)
				 )),
				'limit' => $limit,
				'order' => array(
					'Court.id' => 'desc'
				)
			);
		}		
		$courts = $this->paginate('Court');
		$this->set(compact('courts'));
	}


	function admin_add()
	{
		$this->Court->recursive = -1;
		if($this->request->is('post'))
		{
			$this->request->data=Sanitize::clean($this->request->data);
			$this->Court->create();
			if($this->Court->save($this->request->data))
			{
				$this->Session->setFlash(__('the_court_has_been_saved'), 'admin_success');
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('the_court_could_not_be_saved'));
			}
		}
		 
		$this->Court->Country->recursive = -1;
		$options['fields'] = array(
			'Country.id',
			'Country.name'
		);
		$options['order'] = array(
			'Country.name'=>'asc'	
		);
		$countries = $this->Court->Country->find('all',$options);
		$this->set(compact('countries'));
	}

/**
* 
* @param undefined $id
* 
*/
	function _set_court($id)
	{
		$this->Court->recursive = -1;
		$this->Court->id = $id;
		if(!$this->Court->exists())
		{
			$this->Session->setFlash(__('invalid_id_for_court'));
			return;
		}
	    
	    /*
	    * Test allowing to not override submitted data
	    */
	    if(empty($this->request->data))
	    {
	    	$this->request->data = $this->Court->findById($id);
	    }
	    
	    $this->set('court', $this->request->data);
	    
	    return $this->request->data;
	}


	function admin_edit($id = null)
	{
		$this->Court->id = $id;
		if(!$this->Court->exists())
		{
			$this->Session->setFlash(__('invalid_id_for_court'));
			return;
		}
		
		if($this->request->is('post') || $this->request->is('put'))
		{
			$this->request->data=Sanitize::clean($this->request->data);
			if($this->Court->save($this->request->data))
			{
				$this->Session->setFlash(__('the_court_has_been_saved'), 'admin_success');
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('the_court_could_not_be_saved'));
			}
		}
		
		$this->_set_court($id);
		$this->Court->Country->recursive = -1;
		$options['fields'] = array(
			'Country.id',
			'Country.name'
		);
		$options['order'] = array(
			'Country.name'=>'asc'	
		);
		$countries = $this->Court->Country->find('all',$options);
		$this->set(compact('countries'));
	}

	function admin_delete($id = null)
	{
		$this->Court->id = $id;
		if(!$this->Court->exists())
		{
			//$this->Session->setFlash(__('invalid_id_for_court'));
			$this->Session->setFlash(__('invalid_id_for_court'), 'admin_error');
			$this->redirect(array('action' => 'index'));
		}
		
		if($this->Court->delete($id))
		{
			$this->Session->setFlash(__('delete_court_success'), 'admin_success');
			$this->redirect(array('action' => 'index'));
		}
		else
		{
			$this->Session->setFlash(__('delete_court_not_success'), 'admin_error');
			$this->redirect($this->referer(array('action' => 'index')));
		}
		
	}
	
	function admin_get_courts($id,$court_id = null){
	   $this->Court->recursive=-1;
	   $options['fields'] = array(
		'Court.id ',
		'Court.name'
	   );
			   
		$options['conditions'] = array(
			'Court.country_id'=>$id 
		);
		$options['order'] = array(
			'Court.name'=>'asc'	
		);
		$response = $this->Court->find('all',$options);
		$this->set(array('courts' => $response));
		$this->set(array('court_id' => $court_id));
 
		$this->render('/Elements/Courts/Ajax/get_courts', 'ajax');
	}
	
	function get_courts($id,$court_id = null){
	   $this->Court->recursive=-1;
	   $options['fields'] = array(
		'Court.id ',
		'Court.name'
	   );
			   
		$options['conditions'] = array(
			'Court.country_id'=>$id ,
			'Court.status' => 1
		);
		$options['order'] = array(
			'Court.name'=>'asc'	
		);
		 
		$response = $this->Court->find('all',$options);
		$this->set(array('courts' => $response));
		$this->set(array('court_id' => $court_id));
 
		$this->render('/Elements/Courts/Ajax/get_courts', 'ajax');
	}
	
	function get_search_courts($name='',$id,$court_id = null){
	   $this->Court->recursive=-1;
	   $options['fields'] = array(
		'Court.id ',
		'Court.name'
	   );
			   
		$options['conditions'] = array(
			'Court.country_id'=>$id ,
			'Court.status' => 1
		);
		$options['order'] = array(
			'Court.name'=>'asc'	
		);
		 
		$response = $this->Court->find('all',$options);
		$this->set(array('courts' => $response));
		$this->set(array('court_id' => $court_id));
 		$this->set('name',$name);
		$this->render('/Elements/Courts/Ajax/get_search_courts', 'ajax');
	}
	
}
?>