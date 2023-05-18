<?php
/**
 */
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class OrderitemsController extends ProductAppController {

  var $name = 'Orderitems';
  var $components = array('Httpupload');

   public function beforeFilter() {
	parent::beforeFilter();
	$this->_add_admin_member_permision(array('admin_order_print','admin_items_list'));
 }



function get_order_item(){

	$this->Orderitem->recursive = -1;

	$order_id = Sanitize::clean($_REQUEST['order_id']);
	$sale_reference_id = Sanitize::clean($_REQUEST['sale_reference_id']);

	$User_Info= $this->Session->read('User_Info');

	$response=$this->Orderitem->query("
			select 
					Orderitem.id  ,
					Orderitem.item_count  ,
					Product.title,
					Product.price,
					Product.product_type,
					Product.id
				
					from orderitems as Orderitem
					
					inner join products as Product
							on Product.id = Orderitem.product_id

					where  Orderitem.order_id =  ".$order_id."					   		 
					order by Orderitem.id desc
				  

	");

	$this->set(array(
		'order_items' => $response,
		'_serialize' => array('order_items')
		));
	 $this->set('order_id',$order_id);
	 $this->set('sale_reference_id',$sale_reference_id);
	$this->render('/Elements/Orderitems/Ajax/get_order_item', 'ajax');

 }

public function admin_creditor(){

	$this->Orderitem->recursive = -1;
	if(isset($_REQUEST['filter'])){
		$limit = $_REQUEST['filter'];
	}else $limit = 10;

	if(isset($this->request->data['orderitems'])){
		$orderitems = Sanitize::clean($this->request->data['orderitems']);

		if(!empty($orderitems)){



			/*foreach($orderitems as $key=>$orderitem){
			    $item_array = explode(';',$orderitem);
				$id = $item_array[0];
				$user_id = $item_array[0];

				$options=array();
				$options['fields'] = array(
					'Orderitem.user_price',
					'Orderitem.admin_price'
				);
				$options['conditions'] = array(
					'Orderitem.id' => $id
				);
				$item = $this->Orderitem->find('first',$options);
				$user_price += $item['Orderitem']['user_price'];
				$admin_price += $item['Orderitem']['admin_price'];
			}*/
			$status = $this->request->data['status'];

			$this->loadModel('Settlement');
			$this->Settlement->recursive = -1;

			foreach($orderitems as $key=>$orderitem){

				 $user_price =0;
			     $admin_price =0;



				 $item_array = explode(';',$orderitem);
				 $id = $item_array[0];
				 $user_id = $item_array[1];

				 $options=array();
				 $options['fields'] = array(
				 	'Orderitem.user_price',
				 	'Orderitem.admin_price'
				 );
				 $options['conditions'] = array(
			 		'Orderitem.id' => $id
				 );
				 $item = $this->Orderitem->find('first',$options);
				 $user_price += $item['Orderitem']['user_price'];
				 $admin_price += $item['Orderitem']['admin_price'];

				 $options=array();
				 $options['conditions'] = array(
					'Settlement.user_id' => $user_id ,
					'Settlement.pay_price' => 0
				 );
				 $count = $this->Settlement->find('count',$options);

				 if($count>1){
				 	$this->Settlement->User->recursive = -1;
					$options=array();
					 $options['fields'] = array(
						'User.name',
					 );
					 $options['conditions'] = array(
						'User.id' => $user_id
					 );
					 $user = $this->Settlement->User->find('first',$options);
					 $this->Session->setFlash(__('the_settle_of_user').' '.$user['User']['name'].' '.__('with_settle').' '.__('is_open'), 'admin_error');
   					 $this->redirect($this->referer(array('action' => 'creditor')));
				 }
				 if($count == 1){
				 	 $options=array();
					 $options['fields'] = array(
						'Settlement.id',
					 );
					 $options['conditions'] = array(
						'Settlement.user_id' => $user_id ,
						'Settlement.pay_price' => 0
					 );
					 $settlement = $this->Settlement->find('first',$options);
					 $settlement_id=$settlement['Settlement']['id'];
					 $this->Settlement->recursive = -1;
					 $ret= $this->Settlement->updateAll(
		 			    array('Settlement.payable_price' => 'Settlement.payable_price + "'.$user_price.'"' ,
						      'Settlement.admin_price' => 'Settlement.admin_price + "'.$admin_price.'"'
		 				),   //fields to update
		  			    array( 'Settlement.id' => $settlement_id )  //condition
		 			 );

					 if($ret)
					 {
			 			$ret= $this->Orderitem->updateAll(
			 			    array('Orderitem.status' => '"'.Sanitize::clean($status).'"' ,
			 				      'Orderitem.settlement_id' => '"'.$settlement_id.'"'
			 				),   //fields to update
			  			    array( 'Orderitem.id' => $id )  //condition
			 			 );
			 		 }
					 else{
						$this->Session->setFlash(__('the_settlement_not_saved'),'admin_error');
   					    $this->redirect($this->referer(array('action' => 'creditor')));
					 }

				 }
				 elseif($count == 0){
				 	$this->request->data = array();
					$this->request->data['Settlement']['user_id']= $user_id;
					$this->request->data['Settlement']['payable_price']= $user_price;
					$this->request->data['Settlement']['admin_price']= $admin_price;

					$this->Settlement->create();
					if($this->Settlement->save($this->request->data))
					{
						$settlement_id=$this->Settlement->getLastInsertID();
						$ret= $this->Orderitem->updateAll(
						    array('Orderitem.status' => '"'.Sanitize::clean($status).'"' ,
							      'Orderitem.settlement_id' => '"'.$settlement_id.'"'
							),   //fields to update
						    array( 'Orderitem.id' => $id )  //condition
						 );
					}
					else{
						$this->Session->setFlash(__('the_settlement_not_saved'),'admin_error');
   					    $this->redirect($this->referer(array('action' => 'creditor')));
					}


				 }


			}
		}
	}

	if(isset($this->request->data['Orderitem']['search'])){
		$this->request->data=Sanitize::clean($this->request->data);
		$this->paginate = array(
			'fields'=>array(
				'Orderitem.id',
				'Orderitem.order_id',
				'Orderitem.item_count',
				'Orderitem.sum_price',
				'Orderitem.status',
				'Orderitem.created',
				'Product.id as product_id',
				'Product.title',
				'Product.image',
				'User.id',
				'User.name',
				'User.user_name',
			),
			'joins'=>array(
			   array('table' => 'products',
				'alias' => 'Product',
				'type' => 'LEFT',
				'conditions' => array(
				'Product.id = Orderitem.product_id',
				)
			   ),
               array('table' => 'users',
				 'alias' => 'User',
				 'type' => 'inner',
				 'conditions' => array(
				 'User.id = Orderitem.owner_id ',
				 )
			   )

			 ),
			'conditions' => array('User.name LIKE' => '%'.$this->request->data['Orderitem']['search'].'%' ,'Orderitem.status'=>array(3,4)),
			'limit' => $limit,
			'order' => array(
				'Orderitem.id' => 'desc'
			)
		);
	}
	else
	{

		$this->paginate = array(
			'fields'=>array(
				'Orderitem.id',
				'Orderitem.order_id',
				'Orderitem.item_count',
				'Orderitem.sum_price',
				'Orderitem.status',
				'Orderitem.created',
				'Product.id as product_id',
				'Product.title',
				'Product.image',
				'User.id',
				'User.name',
				'User.user_name',
				),
			'joins'=>array(
			 array('table' => 'products',
				'alias' => 'Product',
				'type' => 'LEFT',
				'conditions' => array(
				'Product.id = Orderitem.product_id',
				)
			   ),
               array('table' => 'users',
				 'alias' => 'User',
				 'type' => 'inner',
				 'conditions' => array(
				 'User.id = Orderitem.owner_id ',
				 )
			   )
			 ),
			'conditions' => array('Orderitem.status'=>array(3,4)),
			'limit' => $limit,
			'order' => array(
				'Orderitem.id' => 'desc'
			)
		);
	}
	$order_items = $this->paginate('Orderitem');
	$this->set(compact('order_items'));

}
public function ordered_list(){
	$this->set('title_for_layout',__('product_ordered_info'));
	$this->set('description_for_layout',__('product_ordered_info'));
	$this->set('keywords_for_layout',__('product_ordered_info'));

	$User_Info= $this->Session->read('User_Info');

	$this->Orderitem->recursive = -1;
	if(isset($_REQUEST['filter'])){
		$limit = $_REQUEST['filter'];
	}else $limit = 10;

	if(isset($this->request->data['orders'])){
		$orders = Sanitize::clean($this->request->data['orders']);

		if(!empty($orders)){
			foreach($orders as $key=>$order_id){
				$ret= $this->Orderitem->updateAll(
				    array('Orderitem.status' => '"'.Sanitize::clean($this->request->data['status']).'"'
					),   //fields to update
				    array( 'Orderitem.order_id' => $order_id )  //condition
				 );
			}
		}
	}

	if(isset($this->request->data['Order']['search'])){
		$this->request->data=Sanitize::clean($this->request->data);
		$this->paginate = array(
			'fields'=>array(
				'Orderitem.order_id',
				'sum(Orderitem.item_count) as item_count',
				'sum(Orderitem.sum_price) as sum_price',
				'User.id',
				'User.name',
				'User.user_name',
				'Orderitem.created'
			),
			'joins'=>array(
			   array('table' => 'users',
				 'alias' => 'User',
				 'type' => 'inner',
				 'conditions' => array(
				 'User.id = Orderitem.user_id ',
				 )
			   ),
			   array('table' => 'orders',
				 'alias' => 'Order',
				 'type' => 'inner',
				 'conditions' => array(
				 'Order.id = Orderitem.order_id ',
				 )
			   )

			 )
			 ,
			'conditions' => array(/*'Orderitem.status'=>1,*/'owner_id'=>$User_Info['id'],'Order.sale_reference_id LIKE' => '%'.$this->request->data['Order']['search'].'%' ,'Order.sale_reference_id <> '=>0),
			'limit' => $limit,
			'order' => array(
				'Orderitem.order_id' => 'desc'
			),
			'group' => array(
				'Orderitem.order_id' ,'Orderitem.owner_id'
			)
		);
	}
	else
	{
		$this->paginate = array(
			'fields'=>array(
				'Orderitem.order_id',
				'sum(Orderitem.item_count) as item_count',
				'sum(Orderitem.sum_price) as sum_price',
				'User.id',
				'User.name',
				'User.user_name',
				'Orderitem.created'
			),
			'joins'=>array(
			   array('table' => 'users',
				 'alias' => 'User',
				 'type' => 'inner',
				 'conditions' => array(
				 'User.id = Orderitem.user_id ',
				 )
			   ),
			   array('table' => 'orders',
				 'alias' => 'Order',
				 'type' => 'inner',
				 'conditions' => array(
				 'Order.id = Orderitem.order_id ',
				 )
			   )

			 )
			 ,
			'conditions' => array(/*'Orderitem.status'=>1,*/'owner_id'=>$User_Info['id'],'Order.sale_reference_id <> '=>0),
			'limit' => $limit,
			'order' => array(
				'Orderitem.order_id' => 'desc'
			),
			'group' => array(
				'Orderitem.order_id' ,'Orderitem.owner_id'
			)
		);
	}
	$orders = $this->paginate('Orderitem');
	$this->set(compact('orders'));

}

public function admin_settle_list(){

	$this->Orderitem->recursive = -1;
	if(isset($_REQUEST['filter'])){
		$limit = $_REQUEST['filter'];
	}else $limit = 10;

	if(isset($this->request->data['Order']['search'])){
		$this->request->data=Sanitize::clean($this->request->data);
		$this->paginate = array(
			'fields'=>array(
				'sum(Orderitem.admin_price) as admin_price',
				'sum(Orderitem.user_price) as user_price',
				'User.id',
				'User.name',
				'User.user_name'
			),
			'joins'=>array(
			   array('table' => 'users',
				 'alias' => 'User',
				 'type' => 'inner',
				 'conditions' => array(
				 'User.id = Orderitem.owner_id',
				 )
			   )

			 )
			 ,
			'conditions' => array('Orderitem.status'=>array(4,5),'User.name LIKE' => '%'.$this->request->data['Orderitem']['search'].'%' ),
			'limit' => $limit,
			'order' => array(
				'Orderitem.order_id' => 'desc'
			),
			'group' => array(
				'Orderitem.order_id' ,'Orderitem.owner_id'
			)
		);
	}
	else
	{
		$this->paginate = array(
			'fields'=>array(
				'sum(Orderitem.admin_price) as admin_price',
				'sum(Orderitem.user_price) as user_price',
				'User.id',
				'User.name',
				'User.user_name'
			),
			'joins'=>array(
			   array('table' => 'users',
				 'alias' => 'User',
				 'type' => 'inner',
				 'conditions' => array(
				 'User.id = Orderitem.owner_id ',
				 )
			   )

			 )
			 ,
			'conditions' => array('Orderitem.status'=>array(4,5)),
			'limit' => $limit,
			'order' => array(
				'Orderitem.order_id' => 'desc'
			),
			'group' => array(
				'Orderitem.owner_id'
			)
		);
	}
	$order_items = $this->paginate('Orderitem');
	//pr($this->paginate);exit();
	$this->set(compact('order_items'));
}

public function send_ordered_list(){
	$this->set('title_for_layout',__('send_ordered_list'));
	$this->set('description_for_layout',__('send_ordered_list'));
	$this->set('keywords_for_layout',__('send_ordered_list'));

	$User_Info= $this->Session->read('User_Info');

	$this->Orderitem->recursive = -1;
	if(isset($_REQUEST['filter'])){
		$limit = $_REQUEST['filter'];
	}else $limit = 10;

	if(isset($this->request->data['Orderitem']['search'])){
		$this->request->data=Sanitize::clean($this->request->data);
		$this->paginate = array(
			'fields'=>array(
				'Orderitem.id',
				'Orderitem.order_id',
				'Orderitem.item_count',
				'Orderitem.sum_price',
				'Orderitem.status',
				'Orderitem.created',
				'Product.id as product_id',
				'Product.title',
				'Product.image',
				'User.name',
			),
			'joins'=>array(
			   array('table' => 'products',
				'alias' => 'Product',
				'type' => 'LEFT',
				'conditions' => array(
				'Product.id = Orderitem.product_id',
				)
			   )
			   ,
			   array('table' => 'users',
				'alias' => 'User',
				'type' => 'LEFT',
				'conditions' => array(
				'User.id = Orderitem.user_id',
				)
			   )
			 ),
			'conditions' => array('Orderitem.status'=>array(3,4,5),'Product.title LIKE' => '%'.$this->request->data['Orderitem']['search'].'%' ,'Orderitem.owner_id'=>$User_Info['id']),
			'limit' => $limit,
			'order' => array(
				'Orderitem.id' => 'desc'
			)
		);
	}
	else
	{

		$this->paginate = array(
			'fields'=>array(
				'Orderitem.id',
				'Orderitem.order_id',
				'Orderitem.item_count',
				'Orderitem.sum_price',
				'Orderitem.status',
				'Orderitem.created',
				'Product.id as product_id',
				'Product.title',
				'Product.image',
				'User.name',
				),
			'joins'=>array(
			 array('table' => 'products',
				'alias' => 'Product',
				'type' => 'LEFT',
				'conditions' => array(
				'Product.id = Orderitem.product_id',
				)
			   ),
			   array('table' => 'users',
				'alias' => 'User',
				'type' => 'LEFT',
				'conditions' => array(
				'User.id = Orderitem.user_id',
				)
			   )
			 ),
			'conditions' => array('Orderitem.status'=>array(3,4,5),'Orderitem.owner_id'=>$User_Info['id']),
			'limit' => $limit,
			'order' => array(
				'Orderitem.id' => 'desc'
			)
		);
	}
	$order_items = $this->paginate('Orderitem');
	$this->set(compact('order_items'));

}
function items_list($order_id){

	$this->set('title_for_layout',__('order_item_list').$order_id);
	$this->set('description_for_layout',__('order_item_list').$order_id);
	$this->set('keywords_for_layout',__('order_item_list').$order_id);

	$User_Info= $this->Session->read('User_Info');

	$this->Orderitem->recursive = -1;
	if(isset($_REQUEST['filter'])){
		$limit = $_REQUEST['filter'];
	}else $limit = 10;

	if(isset($this->request->data['orders'])){
		$orders = Sanitize::clean($this->request->data['orders']);

		if(!empty($orders)){
			foreach($orders as $key=>$id){
				$ret= $this->Orderitem->updateAll(
				    array('Orderitem.status' => '"'.Sanitize::clean($this->request->data['status']).'"'
					),   //fields to update
				    array( 'Orderitem.id' => $id )  //condition
				 );
			}
		}
	}

	if(isset($this->request->data['Orderitem']['search'])){
		$this->request->data=Sanitize::clean($this->request->data);
		$this->paginate = array(
			'fields'=>array(
				'Orderitem.id',
				'Orderitem.item_count',
				'Orderitem.sum_price',
				'Orderitem.status',
				'Orderitem.created',
				'Product.id as product_id',
				'Product.title',
				'Product.image'
			),
			'joins'=>array(
			   array('table' => 'products',
				'alias' => 'Product',
				'type' => 'LEFT',
				'conditions' => array(
				'Product.id = Orderitem.product_id',
				)
			   )

			 ),
			'conditions' => array('Product.title LIKE' => '%'.$this->request->data['Orderitem']['search'].'%' ,'Orderitem.order_id'=>$order_id,'Orderitem.user_id'=>$User_Info['id']),
			'limit' => $limit,
			'order' => array(
				'Orderitem.id' => 'desc'
			)
		);
	}
	else
	{

		$this->paginate = array(
			'fields'=>array(
				'Orderitem.id',
				'Orderitem.item_count',
				'Orderitem.sum_price',
				'Orderitem.status',
				'Orderitem.created',
				'Product.id as product_id',
				'Product.title',
				'Product.image'
				),
			'joins'=>array(
			 array('table' => 'products',
				'alias' => 'Product',
				'type' => 'LEFT',
				'conditions' => array(
				'Product.id = Orderitem.product_id',
				)
			   )
			 ),
			'conditions' => array('Orderitem.order_id'=>$order_id,'Orderitem.user_id'=>$User_Info['id']),
			'limit' => $limit,
			'order' => array(
				'Orderitem.id' => 'desc'
			)
		);
	}
	$order_items = $this->paginate('Orderitem');
	$this->set(compact('order_items'));
}

function ordered_items_list($order_id){

	$this->set('title_for_layout',__('order_item_list').$order_id);
	$this->set('description_for_layout',__('order_item_list').$order_id);
	$this->set('keywords_for_layout',__('order_item_list').$order_id);

	$User_Info= $this->Session->read('User_Info');

	$this->Orderitem->recursive = -1;
	if(isset($_REQUEST['filter'])){
		$limit = $_REQUEST['filter'];
	}else $limit = 10;

	if(isset($this->request->data['orders'])){
		$orders = Sanitize::clean($this->request->data['orders']);

		if(!empty($orders)){
			foreach($orders as $key=>$id){
				$ret= $this->Orderitem->updateAll(
				    array('Orderitem.status' => '"'.Sanitize::clean($this->request->data['status']).'"'
					),   //fields to update
				    array( 'Orderitem.id' => $id )  //condition
				 );
			}
		}
	}

	if(isset($this->request->data['Orderitem']['search'])){
		$this->request->data=Sanitize::clean($this->request->data);
		$this->paginate = array(
			'fields'=>array(
				'Orderitem.id',
				'Orderitem.item_count',
				'Orderitem.sum_price',
				'Orderitem.status',
				'Orderitem.created',
				'Product.id as product_id',
				'Product.title',
				'Product.image'
			),
			'joins'=>array(
			   array('table' => 'products',
				'alias' => 'Product',
				'type' => 'LEFT',
				'conditions' => array(
				'Product.id = Orderitem.product_id',
				)
			   )

			 ),
			'conditions' => array('Product.title LIKE' => '%'.$this->request->data['Orderitem']['search'].'%' ,'Orderitem.order_id'=>$order_id,'Orderitem.owner_id'=>$User_Info['id']),
			'limit' => $limit,
			'order' => array(
				'Orderitem.id' => 'desc'
			)
		);
	}
	else
	{

		$this->paginate = array(
			'fields'=>array(
				'Orderitem.id',
				'Orderitem.item_count',
				'Orderitem.sum_price',
				'Orderitem.status',
				'Orderitem.created',
				'Product.id as product_id',
				'Product.title',
				'Product.image'
				),
			'joins'=>array(
			 array('table' => 'products',
				'alias' => 'Product',
				'type' => 'LEFT',
				'conditions' => array(
				'Product.id = Orderitem.product_id',
				)
			   )
			 ),
			'conditions' => array('Orderitem.order_id'=>$order_id,'Orderitem.owner_id'=>$User_Info['id']),
			'limit' => $limit,
			'order' => array(
				'Orderitem.id' => 'desc'
			)
		);
	}
	$order_items = $this->paginate('Orderitem');
	$this->set(compact('order_items'));
}

function admin_items_list($order_id){

	$this->Orderitem->recursive = -1;
	if(isset($_REQUEST['filter'])){
		$limit = $_REQUEST['filter'];
	}else $limit = 10;

	$this->set('title_for_layout',__d(__PRODUCT_LOCALE,'order_item_list').' '.$order_id);
	$this->set('description_for_layout',__d(__PRODUCT_LOCALE,'order_item_list').' '.$order_id);
	$this->set('keywords_for_layout',__d(__PRODUCT_LOCALE,'order_item_list').' '.$order_id);

	if(isset($this->request->data['Orderitem']['search'])){

		$this->request->data=Sanitize::clean($this->request->data);
		$this->paginate = array(
			'fields'=>array(
				'Orderitem.id',
				'Orderitem.item_count',
				'Orderitem.sum_price',
				'Orderitem.status',
				'Orderitem.created',
				'Product.id as product_id',
				'Producttranslation.title',
				'(select image from productimages where product_id = Product.id limit 0,1 ) as image'
			),
			'joins'=>array(
			   array('table' => 'products',
				'alias' => 'Product',
				'type' => 'LEFT',
				'conditions' => array(
				'Product.id = Orderitem.product_id',
				)
			   ),
				array('table' => 'producttranslations',
					'alias' => 'Producttranslation',
					'type' => 'left',
					'conditions' => array(
						'Product.id = Producttranslation.product_id',
						"Producttranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
					)
				)

			 ),
			'conditions' => array('Producttranslation.title LIKE' => '%'.$this->request->data['Orderitem']['search'].'%' ,'Orderitem.order_id'=>$order_id),
			'limit' => $limit,
			'order' => array(
				'Orderitem.id' => 'desc'
			)
		);
	}
	else
	{

		$this->paginate = array(
			'fields'=>array(
				'Orderitem.id',
				'Orderitem.item_count',
				'Orderitem.sum_price',
				'Orderitem.status',
				'Orderitem.created',
				'Product.id as product_id',
				'Producttranslation.title',
				'(select image from productimages where product_id = Product.id limit 0,1 ) as image'
				),
			'joins'=>array(
			 array('table' => 'products',
				'alias' => 'Product',
				'type' => 'LEFT',
				'conditions' => array(
				'Product.id = Orderitem.product_id',
				)
			   ),
				array('table' => 'producttranslations',
					'alias' => 'Producttranslation',
					'type' => 'left',
					'conditions' => array(
						'Product.id = Producttranslation.product_id',
						"Producttranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
					)
				)
			 ),
			'conditions' => array('Orderitem.order_id'=>$order_id),
			'limit' => $limit,
			'order' => array(
				'Orderitem.id' => 'desc'
			)
		);
	}
	$order_items = $this->paginate('Orderitem');

	$this->set(compact('order_items'));
	$this->set('order_id',$order_id);
}

function order_print($order_id){
	$this->set('title_for_layout',__('order_item_list').$order_id);
	$this->set('description_for_layout',__('order_item_list').$order_id);
	$this->set('keywords_for_layout',__('order_item_list').$order_id);

	$User_Info= $this->Session->read('User_Info');

	$options=array();
    $this->Orderitem->recursive=-1;
    $options['fields'] = array(
		'Orderitem.id',
		'Orderitem.item_count',
		'Orderitem.sum_price',
		'Producttranslation.title',
		'Product.price',
	   );
   $options['joins'] = array(
	 array('table' => 'products',
	   		'alias' => 'Product',
	   		'type' => 'INNER',
	   		'conditions' => array(
	   		'Product.id = Orderitem.product_id'
			)
		),
	   array('table' => 'producttranslations',
		   'alias' => 'Producttranslation',
		   'type' => 'left',
		   'conditions' => array(
			   'Product.id = Producttranslation.product_id',
			   "Producttranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
		   )
	   )
    );
   $options['conditions'] = array(
		'Orderitem.order_id' => $order_id,
		'Orderitem.owner_id' => $User_Info['id']
	);
   $order_items = $this->Orderitem->find('all',$options);
   if(empty($order_items)){
   	   $this->Session->setFlash(__('not_exist_this_order'), 'error');
   	   $this->redirect(array('action' => 'ordered_list'));
   }

   if(empty($order_items)){
   	   $this->Session->setFlash(__('not_exist_this_order'), 'error');
   	   $this->redirect(array('action' => 'ordered_list'));
   }

    $options=array();
	$this->loadModel('User');
    $this->User->recursive=-1;
    $options['fields'] = array(
		'User.id',
		'User.name',
		'User.sex',
		'User.mobile'
	   );
   $options['conditions'] = array(
		'User.id' => $User_Info['id']
	);
   $saler = $this->User->find('first',$options);

   $this->loadModel('Userdetail');
   $options=array();
   $this->Userdetail->recursive=-1;

   $options['fields'] = array(
		'Userdetail.address',
		'Userdetail.telephon',
		'Userdetail.post_code'
	   );
	$options['conditions'] = array(
		'Userdetail.user_id '=> $saler['User']['id']
	);
	$saler_detail= $this->Userdetail->find('first',$options);

	$options=array();
    $this->Orderitem->Order->recursive=-1;
    $options['fields'] = array(
		'User.id',
		'User.name',
		'User.sex',
		'User.mobile'
	   );
   $options['joins'] = array(
	 array('table' => 'users',
	   		'alias' => 'User',
	   		'type' => 'INNER',
	   		'conditions' => array(
	   		'User.id = Order.user_id'
			)
		)
    );
   $options['conditions'] = array(
		'Order.id' => $order_id
	);
   $user = $this->Orderitem->Order->find('first',$options);

   $this->loadModel('Userdetail');
   $options=array();
   $this->Userdetail->recursive=-1;

   $options['fields'] = array(
		'Userdetail.address',
		'Userdetail.telephon',
		'Userdetail.post_code'
	   );
	$options['conditions'] = array(
		'Userdetail.user_id '=> $user['User']['id']
	);
	$user_detail= $this->Userdetail->find('first',$options);

    $options  = array();
	$this->Orderitem->Order->recursive = -1;
	$options['fields'] = array(
		'Order.id',
		'Order.created'
	);
	$options['conditions'] = array(
		'Order.id' => $order_id
	);
	$order = $this->Orderitem->Order->find('first',$options);

    $this->set('saler_detail',$saler_detail);
	$this->set('saler',$saler);

	$this->set('user_detail',$user_detail);
	$this->set('user',$user);

    $this->set('order_items',$order_items);
    $this->set('order',$order);
}

function admin_order_print($order_id){

	 $this->layout = 'print';

	$options=array();
    $this->Orderitem->recursive=-1;
    $options['fields'] = array(
		'Orderitem.id',
		'Orderitem.item_count',
		'Orderitem.sum_price',
		'Producttranslation.title',
		'Product.price',
	   );
   $options['joins'] = array(
	 array('table' => 'products',
	   		'alias' => 'Product',
	   		'type' => 'INNER',
	   		'conditions' => array(
	   		'Product.id = Orderitem.product_id'
			)
		),array('table' => 'producttranslations',
		'alias' => 'Producttranslation',
		'type' => 'left',
		'conditions' => array(
			'Product.id = Producttranslation.product_id',
			"Producttranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
		)
	)
    );
   $options['conditions'] = array(
		'Orderitem.order_id' => $order_id
	);
   $order_items = $this->Orderitem->find('all',$options);

   if(empty($order_items)){
	   $this->Redirect->flashWarning(__d(__PRODUCT_LOCALE,'not_exist_this_order'),__SITE_URL.'admin');
   }

	$options=array();
    $this->Orderitem->Order->recursive=-1;
    $options['fields'] = array(
		'User.id',
		'User.name',
		'User.sex',
		'User.mobile'
	   );
   $options['joins'] = array(
	 array('table' => 'users',
	   		'alias' => 'User',
	   		'type' => 'INNER',
	   		'conditions' => array(
	   		'User.id = Order.user_id'
			)
		)
    );
   $options['conditions'] = array(
		'Order.id' => $order_id
	);
   $user = $this->Orderitem->Order->find('first',$options);

   $this->loadModel(__PRODUCT_PLUGIN.'.Userdetail');
   $options=array();
   $this->Userdetail->recursive=-1;

   $options['fields'] = array(
		'Userdetail.address',
		'Userdetail.telephon',
		'Userdetail.post_code'
	   );
	$options['conditions'] = array(
		'Userdetail.user_id '=> $user['User']['id']
	);
	$user_detail= $this->Userdetail->find('first',$options);

    $options  = array();
	$this->Orderitem->Order->recursive = -1;
	$options['fields'] = array(
		'Order.id',
		'Order.created'
	);
	$options['conditions'] = array(
		'Order.id' => $order_id
	);
	$order = $this->Orderitem->Order->find('first',$options);

	$this->set('user_detail',$user_detail);
	$this->set('user',$user);

    $this->set('order_items',$order_items);
    $this->set('order',$order);
}

function sale_list(){

	$this->set('title_for_layout',__('sale_list'));
	$this->set('description_for_layout',__('sale_list'));
	$this->set('keywords_for_layout',__('sale_list'));

	$User_Info= $this->Session->read('User_Info');

	$this->Orderitem->recursive = -1;
	if(isset($_REQUEST['filter'])){
		$limit = $_REQUEST['filter'];
	}else $limit = 10;

	if(isset($this->request->data['Orderitem']['search'])){
		$this->request->data=Sanitize::clean($this->request->data);
		$this->paginate = array(
			'fields'=>array(
				'Orderitem.id',
				'Orderitem.item_count',
				'Orderitem.sum_price',
				'Orderitem.created',
				'time(Orderitem.created) as time',
				'Product.id as product_id',
				'Product.title',
				'Product.image'
			),
			'joins'=>array(
			   array('table' => 'products',
				'alias' => 'Product',
				'type' => 'Inner',
				'conditions' => array(
				'Product.id = Orderitem.product_id',
				)
			   ),
			   array('table' => 'orders',
				'alias' => 'Order',
				'type' => 'Inner',
				'conditions' => array(
				'Order.id = Orderitem.order_id',
				'Order.bankmessage_id = 0',
				)
			   )

			 ),
			'conditions' => array('Product.title LIKE' => '%'.$this->request->data['Orderitem']['search'].'%' ,'Orderitem.owner_id'=>$User_Info['id']),
			'limit' => $limit,
			'order' => array(
				'Orderitem.id' => 'desc'
			)
		);
	}
	else
	{
		$this->paginate = array(
			'fields'=>array(
				'Orderitem.id',
				'Orderitem.item_count',
				'Orderitem.sum_price',
				'Orderitem.created',
				'time(Orderitem.created) as time',
				'Product.id as product_id',
				'Product.title',
				'Product.image'
				),
			'joins'=>array(
			 array('table' => 'products',
				'alias' => 'Product',
				'type' => 'Inner',
				'conditions' => array(
				'Product.id = Orderitem.product_id',
				)
			   ),
			   array('table' => 'orders',
				'alias' => 'Order',
				'type' => 'Inner',
				'conditions' => array(
				'Order.id = Orderitem.order_id',
				'Order.bankmessage_id = 0',
				)
			   )
			 ),
			'conditions' => array('Orderitem.owner_id'=>$User_Info['id']),
			'limit' => $limit,
			'order' => array(
				'Orderitem.id' => 'desc'
			)
		);
	}
	$order_items = $this->paginate('Orderitem');
	$this->set(compact('order_items'));

}


}
