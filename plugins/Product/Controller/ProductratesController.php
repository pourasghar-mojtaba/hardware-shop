<?php
/**
 */
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class ProductratesController extends ProductAppController {

  var $name = 'Productrates';
  var $components = array('Httpupload');



	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('refresh_likes'));
	}



 function refresh_likes($id=0){

	$this->Productrate->recursive = -1;

	if(isset($_REQUEST['first'])){
		$first= Sanitize::clean($_REQUEST['first']);
	}else $first = 0;

	$end=5;

	$User_Info= $this->Session->read('User_Info');


	$response=$this->Productrate->query("
		select 
			Productrate.id ,
			Productrate.created,
			User.id,
			User.image,
			User.name,
			User.user_name
			
		from productrates as Productrate	
			inner join users as User
					on User.id = Productrate.user_id
		where Productrate.product_id = ".$id."		
		 
			order by Productrate.id desc
			limit ".$first." ,".$end."

	");


	$this->set(array('productrates' => $response));

	$this->render('/Elements/Productrates/Ajax/refresh_likes', 'ajax');

 }

function save_rate(){

	$response['success'] = false;
	$response['message'] = null;

	$User_Info= $this->Session->read('User_Info');
	$vote = $_REQUEST['vote'];
	$product_id = $_REQUEST['product_id'];
	$this->Productrate->recursive = -1;
	$rate = $this->Productrate->find('first', array('conditions' => array('Productrate.user_id' => $User_Info['id'])));

	if(!empty($rate)){
		// update rate , update sum_like
		$this->request->data['Productrate']['id']= $rate['Productrate']['id'];
		$this->request->data['Productrate']['rate']= $vote;
		$this->request->data=Sanitize::clean($this->request->data);

		try{
			if($this->Productrate->save($this->request->data)){
				$ret= $this->Productrate->Product->updateAll(
					    array( 'Product.sum_like' =>'Product.sum_like - '.$rate['Productrate']['rate']),
					    array( 'Product.id' => $product_id )  //condition
			   		);
				$ret= $this->Productrate->Product->updateAll(
					    array( 'Product.sum_like' =>'Product.sum_like + '.Sanitize::clean($vote)),
					    array( 'Product.id' => $product_id )  //condition
			   		);
				$response['success'] = TRUE;
			}
		} catch (Exception $e) {
			$response['success'] = FALSE;
		}

	}else{
		// insert rate  ,update like
		$this->request->data['Productrate']['user_id']=$User_Info['id'];
		$this->request->data['Productrate']['product_id']= $product_id;
		$this->request->data['Productrate']['rate']= $vote;
		$this->Productrate->create();

		$this->request->data=Sanitize::clean($this->request->data);

		try{
			if($this->Productrate->save($this->request->data)){
				$ret= $this->Productrate->Product->updateAll(
					    array( 'Product.like' =>'Product.like + 1'),
					    array( 'Product.id' => $product_id )  //condition
			   		);
				$ret= $this->Productrate->Product->updateAll(
					    array( 'Product.sum_like' =>'Product.sum_like + '.Sanitize::clean($vote)),
					    array( 'Product.id' => $product_id )  //condition
			   		);
				$response['success'] = TRUE;
			}
		} catch (Exception $e) {
			$response['success'] = FALSE;
		}
	}



	$response['message'] = $response['success'] ?  __('send_rate_success') : __('send_rate_notsuccess');

	$this->set('ajaxData',  json_encode($response));
	$this->render('/Elements/Productcomments/Ajax/ajax_result', 'ajax');
 }


}
