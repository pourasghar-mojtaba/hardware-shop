<?php


App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class PricesController extends PriceAppController {

/*public function beforeFilter() {
	parent::beforeFilter();
	$this->Auth->allow('view','get_child_prices');
}*/

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Prices';
	public $helpers = array('AdminHtml'=>array('action'=>'Price'));

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

/**
 * Displays a view
 *
 * @param mixed What price to display
 * @return void
 */

 function admin_index()
	{
		
		$this->set('title_for_layout',__d(__PRICE_LOCALE,'price_list'));
		//$this->Price->recursive = - 1;
		if(isset($_REQUEST['filter']))
		{
			$limit = $_REQUEST['filter'];
		}
		else $limit = 10;

		if(isset($this->request->data['Price']['search']))
		{
			$this->request->data = Sanitize::clean($this->request->data);
			$this->paginate = array(
				'fields'    =>array(
					'Price.id',
					'Price.title',
					'Price.buy_price',
					'Price.sel_price',
					'Price.price_date',
					'Price.arrangment',
					'Price.status',
					'Price.created'
				),
				'conditions' => array('Price.title LIKE'=> '%'.$this->request->data['Price']['search'].'%'),
				'limit'     => $limit,
				'order'                          => array(
					'Price.id'=> 'desc'
				)
			);
		}
		else
		{
			$this->paginate = array(
				/*'joins'=>array(

				),*/
				'fields'    =>array(
					'Price.id',
					'Price.title',
					'Price.buy_price',
					'Price.sel_price',
					'Price.price_date',
					'Price.arrangment',
					'Price.status',
					'Price.created'
				),
				'limit' => $limit,
				'order'      => array(
					'Price.id'=> 'desc'
				)
			);
		}
		$prices = $this->paginate('Price');
		$this->set(compact('prices'));
	}
	
	
  function admin_add(){
  	$this->set('title_for_layout',__d(__PRICE_LOCALE,'add_price'));
	if($this->request->is('post'))
		{				
			
			$data = Sanitize::clean($this->request->data);
			 
			$this->Price->create();
			if($this->Price->save($this->request->data))
			{				
				$this->Redirect->flashSuccess(__d(__PRICE_LOCALE,'the_price_has_been_saved'),array('action'=>'index'));
			}
			else
			{				
				@unprice(__PRICE_IMAGE_PATH."/".$cover_image);
				@unprice(__PRICE_IMAGE_PATH."/".__UPLOAD_THUMB."/".$cover_image);
				$this->Redirect->flashWarning(__d(__PRICE_LOCALE,'the_price_could_not_be_saved'),array('action'=>'index'));
			}
		}		
		 
  }	
  
 


	function admin_edit($id = null)
	{
		$this->set('title_for_layout',__d(__PRICE_LOCALE,'edit_price'));
		$this->Price->id = $id;
		if(!$this->Price->exists())
		{
			$this->Redirect->flashWarning(__d(__PRICE_LOCALE,'invalid_id_for_price'),array('action'=>'index'));
		}	
			
		if($this->request->is('post') || $this->request->is('put'))
		{			
			
			if($this->Price->save($this->request->data))
			{
				$this->Redirect->flashSuccess(__d(__PRICE_LOCALE,'the_price_has_been_saved'),array('action'=>'index'));
			}
			else
			{
			   $this->Redirect->flashWarning(__d(__PRICE_LOCALE,'the_price_could_not_be_saved'),array('action'=>'index'));
			}
		}		

		$options = array('conditions' => array('Price.' . $this->Price->primaryKey=> $id));
		$this->request->data = $this->Price->find('first', $options);
		//$this->set($price,$this->request->data);
		 		
	}	

function admin_delete($id = null){		
		$this->Price->id = $id;
		if(!$this->Price->exists())
		{
			$this->Redirect->flashWarning(__d(__PRICE_LOCALE,'invalid_id_for_price'),array('action'=>'index'));
		}		
		if($this->Price->delete($id))
		{		
			$this->Redirect->flashSuccess(__d(__PRICE_LOCALE,'delete_price_success'),array('action'=>'index'));
		}else
		{
			$this->Redirect->flashWarning(__d(__PRICE_LOCALE,'delete_price_not_success'),array('action'=>'index'));
		}
  }
		
	
	
	
function get_main_prices()
{
	$options['fields'] = array(
			'Price.id',
			'Price.parent_id',
			'Price.title as title'
		);
	$options['conditions'] = array(
		'Price.status'=>1,
		'Price.parent_id'=>0
	);
	$options['order'] = array(
		'Price.arrangment'=>'asc'
	);
	$prices = $this->Price->find('all',$options);
	return $prices;
}	
		


 	
	
	
}
?>