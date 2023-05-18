<?php
/**
 * Cities Controller
 *
 * @property City $City
 */
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class CitiesController extends AppController {

	var $name = 'Cities';
	public
	function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow(array('get_cities'));
	}


	function admin_index()
	{
		$this->City->recursive = -1;
		if(isset($_REQUEST['filter'])){
			$limit = $_REQUEST['filter'];
		}else $limit = 10;

		if(isset($this->request->data['City']['search'])){
			$this->request->data=Sanitize::clean($this->request->data);
			$this->paginate = array(
				'fields'=>array(
					'City.id',
					'City.name',
					'City.status',
					'City.created',
					'Court.name',
					'Country.name',
				),
				'joins'=>array(
					array('table' => 'courts',
						'alias' => 'Court',
						'type' => 'LEFT',
						'conditions' => array(
						'Court.id = City.court_id ',
						)
				   ),
				   array('table' => 'countries',
						'alias' => 'Country',
						'type' => 'LEFT',
						'conditions' => array(
						'Country.id = Court.country_id ',
						)
				   )
				 ),
				'conditions' => array('City.name LIKE' => ''.$this->request->data['City']['search'].'%' ),
				'limit' => $limit,
				'order' => array(
					'City.id' => 'desc'
				)
			);
		}
		else
		{
			$this->paginate = array(
				'fields'=>array(
					'City.id',
					'City.name',
					'City.status',
					'City.created',
					'Court.name',
					'Country.name',
				),
				'joins'=>array(
					array('table' => 'courts',
						'alias' => 'Court',
						'type' => 'LEFT',
						'conditions' => array(
						'Court.id = City.court_id ',
						)
				 	),
					array('table' => 'countries',
						'alias' => 'Country',
						'type' => 'LEFT',
						'conditions' => array(
						'Country.id = Court.country_id ',
						)
					 )
				 ),
				'limit' => $limit,
				'order' => array(
					'City.id' => 'desc'
				)
			);
		}
		$cities = $this->paginate('City');
		$this->set(compact('cities'));
	}


	function admin_add()
	{
		$this->City->recursive = -1;
		if($this->request->is('post'))
		{
			$this->request->data=Sanitize::clean($this->request->data);
			$this->City->create();
			if($this->City->save($this->request->data))
			{
				$this->Session->setFlash(__('the_city_has_been_saved'), 'admin_success');
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('the_city_could_not_be_saved'));
			}
		}

		$this->City->Court->Country->recursive = -1;
		$options['fields'] = array(
			'Country.id',
			'Country.name'
		);
		$options['order'] = array(
			'Country.name'=>'asc'
		);
		$countries = $this->City->Court->Country->find('all',$options);
		$this->set(compact('countries'));
	}

/**
*
* @param undefined $id
*
*/
	function _set_city($id)
	{
		$this->City->recursive = -1;
		$this->City->id = $id;
		if(!$this->City->exists())
		{
			$this->Session->setFlash(__('invalid_id_for_city'));
			return;
		}

	    /*
	    * Test allowing to not override submitted data
	    */
	    if(empty($this->request->data))
	    {
	    	$options['fields'] = array(
			 'City.court_id',
			 'City.name',
			 'City.status',
			 'Country.id',
		    );
			$options['joins'] = array(
				array('table' => 'courts',
					'alias' => 'Court',
					'type' => 'INNER',
					'conditions' => array(
					'Court.id = City.court_id ',
					)
				) ,
				array('table' => 'countries',
					'alias' => 'Country',
					'type' => 'INNER',
					'conditions' => array(
					'Country.id = Court.country_id ',
					)
				)
			);
			$options['conditions'] = array(
				'City.id'=> $id
			);
			$this->request->data= $this->City->find('first',$options);
	    }

	    $this->set('city', $this->request->data);

	    return $this->request->data;
	}


	function admin_edit($id = null)
	{
		$this->City->id = $id;
		if(!$this->City->exists())
		{
			$this->Session->setFlash(__('invalid_id_for_city'));
			return;
		}

		if($this->request->is('post') || $this->request->is('put'))
		{
			$this->request->data=Sanitize::clean($this->request->data);
			if($this->City->save($this->request->data))
			{
				$this->Session->setFlash(__('the_city_has_been_saved'), 'admin_success');
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('the_city_could_not_be_saved'));
			}
		}

		$this->_set_city($id);
		$this->City->Court->Country->recursive = -1;
		$options['fields'] = array(
			'Country.id',
			'Country.name'
		);
		$options['order'] = array(
			'Country.name'=>'asc'
		);
		$countries = $this->City->Court->Country->find('all',$options);
		$this->set(compact('countries'));
	}

	function admin_delete($id = null)
	{
		$this->City->id = $id;
		if(!$this->City->exists())
		{
			//$this->Session->setFlash(__('invalid_id_for_city'));
			$this->Session->setFlash(__('invalid_id_for_city'), 'admin_error');
			$this->redirect(array('action' => 'index'));
		}

		if($this->City->delete($id))
		{
			$this->Session->setFlash(__('delete_city_success'), 'admin_success');
			$this->redirect(array('action' => 'index'));
		}
		else
		{
			$this->Session->setFlash(__('delete_city_not_success'), 'admin_error');
			$this->redirect($this->referer(array('action' => 'index')));
		}

	}


	function admin_get_cities($id,$city_id = null){
	   $this->City->recursive=-1;
	   $options['fields'] = array(
		'City.id ',
		'City.name'
	   );

		$options['conditions'] = array(
			'City.court_id'=>$id
		);
		$options['order'] = array(
			'City.name'=>'asc'
		);
		$response = $this->City->find('all',$options);
		$this->set(array('cities' => $response));
		$this->set(array('city_id' => $city_id));

		$this->render('/Elements/Cities/Ajax/get_cities', 'ajax');
	}

	function get_cities($id,$city_id = null){
	   $this->City->recursive=-1;
	   $options['fields'] = array(
		'City.id ',
		'City.name'
	   );

		$options['conditions'] = array(
			'City.court_id'=>$id ,
			'City.status' => 1
		);
		$options['order'] = array(
			'City.name'=>'asc'
		);

		$response = $this->City->find('all',$options);
		$this->set(array('cities' => $response));
		$this->set(array('city_id' => $city_id));

		$this->render('/Elements/Cities/Ajax/get_cities', 'ajax');
	}

	function get_search_cities($name='',$id,$city_id = null){
	   $this->City->recursive=-1;
	   $options['fields'] = array(
		'City.id ',
		'City.name'
	   );

		$options['conditions'] = array(
			'City.court_id'=>$id ,
			'City.status' => 1
		);
		$options['order'] = array(
			'City.name'=>'asc'
		);

		$response = $this->City->find('all',$options);
		$this->set(array('cities' => $response));
		$this->set(array('city_id' => $city_id));
 	    $this->set('name',$name);
		$this->render('/Elements/Cities/Ajax/get_search_cities', 'ajax');
	}

}
?>
