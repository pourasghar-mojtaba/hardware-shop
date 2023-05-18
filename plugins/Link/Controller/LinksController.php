<?php


App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class LinksController extends LinkAppController {

/*public function beforeFilter() {
	parent::beforeFilter();
	$this->Auth->allow('view','get_child_links');
}*/

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Links';
	public $helpers = array('AdminHtml'=>array('action'=>'Link'));

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

/**
 * Displays a view
 *
 * @param mixed What link to display
 * @return void
 */

 function admin_index()
	{
		
		$this->set('title_for_layout',__d(__LINK_LOCALE,'link_list'));
		//$this->Link->recursive = - 1;
		if(isset($_REQUEST['filter']))
		{
			$limit = $_REQUEST['filter'];
		}
		else $limit = 10;

		if(isset($this->request->data['Link']['search']))
		{
			$this->request->data = Sanitize::clean($this->request->data);
			$this->paginate = array(
				'fields'    =>array(
					'Link.id',
					'Link.title',
					'Link.link',
					'Link.link_type',
					'Link.arrangment',
					'Link.status',
					'Link.created'
				),
				'conditions' => array('Link.title LIKE'=> '%'.$this->request->data['Link']['search'].'%'),
				'limit'     => $limit,
				'order'                          => array(
					'Link.id'=> 'desc'
				)
			);
		}
		else
		{
			$this->paginate = array(
				/*'joins'=>array(

				),*/
				'fields'    =>array(
					'Link.id',
					'Link.title',
					'Link.link',
					'Link.link_type',
					'Link.arrangment',
					'Link.status',
					'Link.created'
				),
				'limit' => $limit,
				'order'      => array(
					'Link.id'=> 'desc'
				)
			);
		}
		$links = $this->paginate('Link');
		$this->set(compact('links'));
	}
	
	
  function admin_add(){
  	$this->set('title_for_layout',__d(__LINK_LOCALE,'add_link'));
	if($this->request->is('post'))
		{				
			
			$data = Sanitize::clean($this->request->data);
			 
			$this->Link->create();
			if($this->Link->save($this->request->data))
			{				
				$this->Redirect->flashSuccess(__d(__LINK_LOCALE,'the_link_has_been_saved'),array('action'=>'index'));
			}
			else
			{				
				@unlink(__LINK_IMAGE_PATH."/".$cover_image);
				@unlink(__LINK_IMAGE_PATH."/".__UPLOAD_THUMB."/".$cover_image);
				$this->Redirect->flashWarning(__d(__LINK_LOCALE,'the_link_could_not_be_saved'),array('action'=>'index'));
			}
		}		
		 
  }	
  
 


	function admin_edit($id = null)
	{
		$this->set('title_for_layout',__d(__LINK_LOCALE,'edit_link'));
		$this->Link->id = $id;
		if(!$this->Link->exists())
		{
			$this->Redirect->flashWarning(__d(__LINK_LOCALE,'invalid_id_for_link'),array('action'=>'index'));
		}	
			
		if($this->request->is('post') || $this->request->is('put'))
		{			
			
			if($this->Link->save($this->request->data))
			{
				$this->Redirect->flashSuccess(__d(__LINK_LOCALE,'the_link_has_been_saved'),array('action'=>'index'));
			}
			else
			{
			   $this->Redirect->flashWarning(__d(__LINK_LOCALE,'the_link_could_not_be_saved'),array('action'=>'index'));
			}
		}		

		$options = array('conditions' => array('Link.' . $this->Link->primaryKey=> $id));
		$this->request->data = $this->Link->find('first', $options);
		//$this->set($link,$this->request->data);
		 		
	}	

function admin_delete($id = null){		
		$this->Link->id = $id;
		if(!$this->Link->exists())
		{
			$this->Redirect->flashWarning(__d(__LINK_LOCALE,'invalid_id_for_link'),array('action'=>'index'));
		}		
		if($this->Link->delete($id))
		{		
			$this->Redirect->flashSuccess(__d(__LINK_LOCALE,'delete_link_success'),array('action'=>'index'));
		}else
		{
			$this->Redirect->flashWarning(__d(__LINK_LOCALE,'delete_link_not_success'),array('action'=>'index'));
		}
  }
		
	
	
	
function get_main_links()
{
	$options['fields'] = array(
			'Link.id',
			'Link.parent_id',
			'Link.title as title'
		);
	$options['conditions'] = array(
		'Link.status'=>1,
		'Link.parent_id'=>0
	);
	$options['order'] = array(
		'Link.arrangment'=>'asc'
	);
	$links = $this->Link->find('all',$options);
	return $links;
}	
		


 	
	
	
}
?>