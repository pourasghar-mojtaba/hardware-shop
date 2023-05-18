<?php
/**
 */
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class ProductcommentsController extends ProductAppController {

  var $name = 'Productcomments';
  var $components = array('Httpupload');



	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('refresh_comments'));
	}



 function refresh_comments($id=0){

	$this->Productcomment->recursive = -1;

	if(isset($_REQUEST['first'])){
		$first= Sanitize::clean($_REQUEST['first']);
	}else $first = 0;

	$end=5;

	$User_Info= $this->Session->read('User_Info');


	$response=$this->Productcomment->query("
		select 
			Productcomment.id ,
			Productcomment.body,
			Productcomment.created,
			User.id,
			User.image,
			User.name,
			User.user_name
			
		from productcomments as Productcomment	
			inner join users as User
					on User.id = Productcomment.user_id
		where Productcomment.product_id = ".$id."		
		  and Productcomment.statuscode = 1
			order by Productcomment.id desc
			limit ".$first." ,".$end."

	");


	$this->set(array('productcomments' => $response));

	$this->render('/Elements/Productcomments/Ajax/refresh_comments', 'ajax');

 }


 function send_comment(){

	$response['success'] = false;
	$response['message'] = null;

	$User_Info= $this->Session->read('User_Info');

	$this->request->data['Productcomment']['user_id']=$User_Info['id'];
	$this->request->data['Productcomment']['statuscode']= 0;
	$this->request->data['Productcomment']['parent_id']= 0;
	$this->request->data['Productcomment']['product_id']= $_POST['product_id'];
	$this->request->data['Productcomment']['body']= $_POST['comment_input'];

	$this->Productcomment->create();

	$this->request->data=Sanitize::clean($this->request->data);


	try{
		if($this->Productcomment->save($this->request->data)){
			$ret= $this->Productcomment->Product->updateAll(
				    array( 'Product.comment' =>'Product.comment + 1'),
				    array( 'Product.id' => $this->request->data['Productcomment']['product_id'] )  //condition
		   		);
			$response['success'] = TRUE;
		}
	} catch (Exception $e) {
		$response['success'] = FALSE;
	}

	$response['message'] = $response['success'] ?  __('send_comment_success_view_after_ok') : __('send_comment_notsuccess');

	$this->set('ajaxData',  json_encode($response));
	$this->render('/Elements/Productcomments/Ajax/ajax_result', 'ajax');
 }

 function getnewcommentcount(){
 	$count = $this->Productcomment->find('count', array('conditions' => array('Productcomment.statuscode' => 0)));
	return $count;
 }


 /**/

 public function comment_list($id=NULL){

		$this->Productcomment->Product->recursive = -1;
		$options=array();
		$options['fields'] = array(
			'Product.id',
			'Product.title'
		);
		$options['conditions'] = array(
			'Product.id' => $id
		);
		$product = $this->Productcomment->Product->find('first',$options);

		if(empty($product))
		{
			$this->redirect(__SITE_URL);
		}

		$this->set('title_for_layout',__('comments').' '.$product['Product']['title']);
		$this->set('description_for_layout', $product['Product']['title']);
		$this->set('keywords_for_layout' , $product['Product']['title']);


		$User_Info= $this->Session->read('User_Info');

		$this->Productcomment->recursive = -1;
		if(isset($_REQUEST['filter'])){
			$limit = $_REQUEST['filter'];
		}else $limit = 10;


			$this->paginate = array(
				'fields'=>array(
					'Productcomment.id',
					'Productcomment.body',
					'Productcomment.created',
					'Productcomment.status',
					'Productcomment.product_id',
					'User.id',
					'User.name',
				),
				'joins'=>array(

				   array('table' => 'products',
					 'alias' => 'Product',
					 'type' => 'INNER',
					 'conditions' => array(
					 'Product.id = Productcomment.product_id ',
					 )
				   ),
				   array('table' => 'users',
					 'alias' => 'User',
					 'type' => 'INNER',
					 'conditions' => array(
					 'User.id = Productcomment.user_id ',
					 )
				   )
				 ) ,
				 'conditions' => array('Productcomment.product_id'=>$id,'Product.user_id'=>$User_Info['id']),
				'limit' => $limit,
				'order' => array(
					'Productcomment.id' => 'desc'
				)
			);

		$productcomments = $this->paginate('Productcomment');
		$this->set(compact('productcomments'));

		$users = $this->Productcomment->query("
			select 
				User.id,
				User.name,
				User.sex,
				User.image,
				User.user_name,
				User.cover_image,
				User.cover_x,
				User.cover_y,
				User.cover_zoom,
				User.user_type
				
			from users as User	
			where User.id = ".$User_Info['id']." 	
		");
		$user = $users[0];
		$this->set('user',$user);
	}
	/**
	*
	* @param undefined $id
	* @param undefined $product_id
	*
*/
 function delete($id = null,$product_id)
	{
	 if($this->Productcomment->delete($id))
		{
			$ret= $this->Productcomment->Product->updateAll(
				    array( 'Product.comment' =>'Product.comment - 1'),
				    array( 'Product.id' => Sanitize::clean($product_id) )  //condition
		   		);
			$this->Session->setFlash(__('delete_comment_success'), 'success');
			$this->redirect(__SITE_URL.'productcomments/comment_list/'.$product_id);
		}
		else
		{
			$this->Session->setFlash(__('delete_comment_not_success'), 'error');
			$this->redirect(__SITE_URL.'productcomments/comment_list/'.$product_id);
		}

	}
/**
*
* @param undefined $id
* @param undefined $product_id
*
*/
 function active_comment($id = null,$product_id)
	{

	  $ret= $this->Productcomment->updateAll(
		    array( 'Productcomment.statuscode' => '1' ),   //fields to update
		    array( 'Productcomment.id' => $id )  //condition
		);
	  if($ret)
		{
			$this->Session->setFlash(__('active_comment_success'), 'success_panel');
			$this->redirect(__SITE_URL.'productcomments/comment_list/'.$product_id);
		}
		else
		{
			$this->Session->setFlash(__('active_comment_not_success'), 'error_panel');
			$this->redirect(__SITE_URL.'productcomments/comment_list/'.$product_id);
		}

	}



}
