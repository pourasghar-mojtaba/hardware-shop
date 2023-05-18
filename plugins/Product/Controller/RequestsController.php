<?php
/**
 */
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class RequestsController extends ProductAppController {

  var $name = 'Requests';
  var $components = array('Httpupload');

  public function beforeFilter() {
	parent::beforeFilter();
	$this->Auth->allow(array('app_preper_pay_request','admin_requested_list','preper_pay_request'));
	$this->_add_member_permision(array('order_list','end_request'));
 }


function order_list()
	{
		$User_Info= $this->Session->read('User_Info');
		$this->Request->recursive = -1;
		if(isset($_REQUEST['filter'])){
			$limit = $_REQUEST['filter'];
		}else $limit = 10;
		$this->paginate = array(
			'fields'=>array(
				'Request.id',
				'Request.refid',
				'Request.description',
				'Request.created',
				'Request.status',
				'Request.sum_price',
				'Bankmessag.message',
				'(select sum(item_count) from requestitems where request_id = Request.id) as item_count',
			),
			'joins'=>array(
			   array('table' => 'bankmessags',
				 'alias' => 'Bankmessag',
				 'type' => 'LEFT',
				 'conditions' => array(
				 'Bankmessag.id = Request.bankmessage_id ',
				 )
			   )

			 )
			 ,
			'conditions' => array('user_id'=>$User_Info['id']),
			'limit' => $limit,
			'request' => array(
				'Request.id' => 'desc'
			)
		);

		$requests = $this->paginate('Request');
		$this->set(compact('requests'));
		$this->set('limit',$limit);
		$this->set('total_count',count($requests));

		$this->set('title_for_layout',__d(__PRODUCT_LOCALE,'product_request_info'));
		$this->set('description_for_layout',__d(__PRODUCT_LOCALE,'product_request_info'));
		$this->set('keywords_for_layout',__d(__PRODUCT_LOCALE,'product_request_info'));

	}


 function admin_index()
	{
	$this->set('title_for_layout',__d(__PRODUCT_LOCALE,'product_request_info'));
	$this->set('description_for_layout',__d(__PRODUCT_LOCALE,'product_request_info'));
	$this->set('keywords_for_layout',__d(__PRODUCT_LOCALE,'product_request_info'));

	$User_Info= $this->Session->read('User_Info');

	$this->Request->recursive = -1;
	if(isset($_REQUEST['filter'])){
		$limit = $_REQUEST['filter'];
	}else $limit = 10;

	if(isset($this->request->data['requests'])){
		$requests = Sanitize::clean($this->request->data['requests']);

		if(!empty($requests)){
			foreach($requests as $key=>$id){
				$ret= $this->Request->updateAll(
				    array('Request.status' => '"'.Sanitize::clean($this->request->data['status']).'"'
					),   //fields to update
				    array( 'Request.id' => $id )  //condition
				 );
			}
		}
	}

	if(isset($this->request->data['Request']['search'])){
		$this->request->data=Sanitize::clean($this->request->data);
		$this->paginate = array(
			'fields'=>array(
				'Request.id',
				'Request.refid',
				'Request.description',
				'Request.created',
				'Request.sum_price',
				'Request.items_count',
				'Request.status',
				'Bankmessag.message',
				'Bank.bank_name',
			),
			'joins'=>array(
			   array('table' => 'bankmessags',
					 'alias' => 'Bankmessag',
					 'type' => 'LEFT',
					 'conditions' => array(
					 'Bankmessag.id = Request.bankmessage_id ',
					 )
			    ),

				array('table' => 'banks',
					 'alias' => 'Bank',
					 'type' => 'LEFT',
					 'conditions' => array(
					 'Bank.id = Request.bank_id ',
					 )
			    )

			 ),
			'conditions' => array('Request.refid LIKE' => '%'.$this->request->data['Request']['search'].'%'  ),
			'limit' => $limit,
			'request' => array(
				'Request.id' => 'desc'
			)
		);
	}
	else
	{
		$this->paginate = array(
			'fields'=>array(
				'Request.id',
				'Request.refid',
				'Request.description',
				'Request.created',
				'Request.sum_price',
				'Request.items_count',
				'Request.status',
				'Bankmessag.message',
				'Bank.bank_name',
			),
			'joins'=>array(

			   array('table' => 'bankmessags',
					 'alias' => 'Bankmessag',
					 'type' => 'LEFT',
					 'conditions' => array(
					 'Bankmessag.id = Request.bankmessage_id ',
					 )
			    ),

				array('table' => 'banks',
					 'alias' => 'Bank',
					 'type' => 'LEFT',
					 'conditions' => array(
					 'Bank.id = Request.bank_id ',
					 )
			    )

			 )
			 ,

			'limit' => $limit,
			'request' => array(
				'Request.id' => 'desc'
			)
		);
	}


	$requests = $this->paginate('Request');

	$this->set(compact('requests'));

	}

/**
*
*
*/
function admin_add()
{
	if($this->request->is('post') || $this->request->is('put'))
	{
        $datasource = $this->Request->getDataSource();
        $User_Info= $this->Session->read('AdminUser_Info');
        try{
            $datasource->begin();

             //pr($this->request->data);throw new Exception();

             if(trim($this->request->data['Requestrate']['rate'])=='' || trim($this->request->data['Requestrate']['rate'])==0){
                throw new Exception(__d(__PRODUCT_LOCALE,'the_productrate_not_valid'));
             }

             if(!$this->Request->save($this->request->data))
			        throw new Exception(__d(__PRODUCT_LOCALE,'the_product_not_saved'));
             $product_id= $this->Request->getLastInsertID();

             if(!empty($this->request->data['Requestrate'])){
					foreach($this->request->data['Requestrate'] as $value)
					{
                        $data[]= array('Requestrate' => array(
									'product_id' => $product_id ,
									'user_id'=> $User_Info['id'],
									'rate'=> $value
								));
					}
                    if(!$this->Request->Requestrate->saveMany($data,array('deep' => true)))
			            throw new Exception(__d(__PRODUCT_LOCALE,'the_productrate_not_saved'));
				}
             if(!empty($this->request->data['Technicalinfoitemvalue']['value']))
             {
                foreach($this->request->data['Technicalinfoitemvalue']['value'] as $key => $value)
				{
					if(trim($value)==''){
						unset($this->request->data['Technicalinfoitemvalue']['value'][$key]);
						unset($this->request->data['Technicalinfoitemvalue']['technical_info_item_id'][$key]);
					}
				}
                $data = array();
                foreach($this->request->data['Technicalinfoitemvalue']['value'] as $key => $value)
					{
						$data[]= array('Technicalinfoitemvalue' => array(
									'value' => $value ,
									'technical_info_item_id'=> $this->request->data['Technicalinfoitemvalue']['technical_info_item_id'][$key],
									'product_id' => $product_id
								));
					}
                if(!$this->Request->Technicalinfoitemvalue->saveMany($data,array('deep' => true)))
			            throw new Exception(__d(__PRODUCT_LOCALE,'the_technicalinfoitemvalue_not_saved'));
             }


             if(isset($_POST['new_tags'])&& !empty($_POST['new_tags'])){
					$tags=$_POST['new_tags'];//explode('#',$this->request->data['Requestrelatetag']['tag']);
					$tags=array_filter($tags,'strlen');
					$this->loadModel('Requesttag');
					if(!empty($tags)){
						foreach($tags as $tag)
						{
							$this->request->data['Requesttag']['title']= $tag;
							$this->Requesttag->create();

							if($this->Requesttag->save($this->request->data))
							{
								$tag_id[]=$this->Requesttag->getLastInsertID();
							}
                            else throw new Exception(__d(__PRODUCT_LOCALE,'the_tag_not_saved'));
						}
					}

				}
				$data = array();
				if(isset($this->request->data['Requestrelatetag']['product_tag_id'])){
					foreach($this->request->data['Requestrelatetag']['product_tag_id'] as $id)
					{
						$dt=array('Requestrelatetag' => array('product_id' => $product_id,'product_tag_id'=>$id));
						array_push($data,$dt);
					}
				}

				if(!empty($tag_id))
					{
						foreach($tag_id as $tid)
						{
							$dt=array('Requestrelatetag' => array('product_id' => $product_id,'product_tag_id'=>$tid));
							array_push($data,$dt);
						}

					}

				if(!empty($this->request->data['Requestrelatetag']['product_tag_id']) || !empty($tag_id))
				{
					$this->Request->Requestrelatetag->create();
					if(!$this->Request->Requestrelatetag->saveMany($data))
                            throw new Exception(__d(__PRODUCT_LOCALE,'the_product_tag_not_saved'));
				}

            // /*pr($this->request->data);*/pr($_FILES);throw new Exception();

                if(!empty($this->request->data['Requestimage']['image']))
                 {

                    foreach($this->request->data['Requestimage']['image'] as $key => $value)
    				{
    					if(trim($value['name'])==''){
    						unset($this->request->data['Requestimage']['image'][$key]);
    						unset($this->request->data['Requestimage']['title'][$key]);
    					}
    				}
                    $data = array();
                    $image_list=array();
                    foreach($this->request->data['Requestimage']['image'] as $key => $value)
					{
						$output=$this->_picture($value,$key);
        				if(!$output['error']) $image=$output['filename'];
        				else {
                                $image='';
                                if(!empty($image_list)){
                                    foreach($image_list as $img)
                                    {
                                        @unlink(__PRODUCT_IMAGE_PATH."/".$img);
					                    @unlink(__PRODUCT_IMAGE_PATH."/".__UPLOAD_THUMB."/".$img);
                                    }
                                }
                                throw new Exception($output['message'].'  '.__d(__PRODUCT_LOCALE,'نام تصویر ').$value['name']);
                             }

                        $image_list[]=$image;

                        $data[]= array('Requestimage' => array(
									'image' => $image ,
									'title'=> $this->request->data['Requestimage']['title'][$key],
									'product_id' => $product_id
								));
					}
                    if(!$this->Request->Requestimage->saveMany($data,array('deep' => true)))
			            throw new Exception(__d(__PRODUCT_LOCALE,'the_product_image_not_saved'));
                 }



            $datasource->commit();

            $this->Session->setFlash(__d(__PRODUCT_LOCALE,'the_product_has_been_saved'), 'admin_success');
			$this->redirect(array('action' => 'index'));
        } catch(Exception $e) {
            $datasource->rollback();
            $this->Session->setFlash($e->getMessage(),'admin_error');
        }
	}
	$this->set('technicalinfos',$this->_get_Technicalinfo());


}


/**
*
* @param undefined $id
*
*/
function admin_edit($id = null)
{
	$this->Request->recursive = -1;
	$this->Request->id = $id;
	if(!$this->Request->exists())
	{
		$this->Session->setFlash(__d(__PRODUCT_LOCALE,'invalid_id_for_product'));
		$this->redirect(array('action' => 'index'));
	}

	$User_Info= $this->Session->read('AdminUser_Info');

	if($this->request->is('post') || $this->request->is('put'))
	{

	   $datasource = $this->Request->getDataSource();
		try{
		    $datasource->begin();


            if(trim($this->request->data['Requestrate']['rate'])=='' || trim($this->request->data['Requestrate']['rate'])==0){
                throw new Exception(__d(__PRODUCT_LOCALE,'the_productrate_not_valid'));
             }


			if(!$this->Request->save($this->request->data))
			        throw new Exception(__d(__PRODUCT_LOCALE,'the_product_not_saved'));


			$ret= $this->Request->Requestrate->updateAll(
			    array('Requestrate.rate' => '"'.$this->request->data['Requestrate']['rate'].'"'
				),   //fields to update
			    array( 'Requestrate.product_id' => $id )  //condition
			  );
			  if(!$ret){
			  	throw new Exception(__d(__PRODUCT_LOCALE,'the_productrate_not_saved'));
			  }
			// pr($this->request->data); throw new Exception();
		// tecnical item oprtion
			 if(!$this->Request->Technicalinfoitemvalue->deleteAll(array('Technicalinfoitemvalue.product_id'=>$id),FALSE))
                 throw new Exception(__d(__PRODUCT_LOCALE,'the_technicalinfoitemvalue_not_saved'));

			 if(!empty($this->request->data['Technicalinfoitemvalue']['value']))
             {
                foreach($this->request->data['Technicalinfoitemvalue']['value'] as $key => $value)
				{
					if(trim($value)==''){
						unset($this->request->data['Technicalinfoitemvalue']['value'][$key]);
						unset($this->request->data['Technicalinfoitemvalue']['technical_info_item_id'][$key]);
					}
				}
                $data = array();
                foreach($this->request->data['Technicalinfoitemvalue']['value'] as $key => $value)
					{
						$data[]= array('Technicalinfoitemvalue' => array(
									'value' => $value ,
									'technical_info_item_id'=> $this->request->data['Technicalinfoitemvalue']['technical_info_item_id'][$key],
									'product_id' => $id
								));
					}
                if(!$this->Request->Technicalinfoitemvalue->saveMany($data,array('deep' => true)))
			            throw new Exception(__d(__PRODUCT_LOCALE,'the_technicalinfoitemvalue_not_saved'));
             }
		// tecnical item oprtion

			 // tag oprtion

                if(!$this->Request->Requestrelatetag->deleteAll(array('Requestrelatetag.product_id'=>$id),FALSE))
					throw new Exception(__d(__PRODUCT_LOCALE,'the_tag_not_saved'));

					if(isset($_POST['new_tags'])&& !empty($_POST['new_tags'])){
						$tags=$_POST['new_tags'];//explode('#',$this->request->data['Requestrelatetag']['tag']);
						$tags=array_filter($tags,'strlen');
						$this->loadModel('Requesttag');
						if(!empty($tags)){
							foreach($tags as $tag)
							{
								$this->request->data['Requesttag']['title']= $tag;
								$this->Requesttag->create();

								if($this->Requesttag->save($this->request->data))
								{
									$tag_id[]=$this->Requesttag->getLastInsertID();
								}else throw new Exception(__d(__PRODUCT_LOCALE,'the_tag_not_saved'));
							}
						}

					}
					$data = array();
					if(isset($this->request->data['Requestrelatetag']['product_tag_id'])){
						foreach($this->request->data['Requestrelatetag']['product_tag_id'] as $tagid)
						{
							$dt=array('Requestrelatetag' => array('product_id' => $id,'product_tag_id'=>$tagid));
							array_push($data,$dt);
						}
					}

					if(!empty($tag_id))
						{
							foreach($tag_id as $tid)
							{
								$dt=array('Requestrelatetag' => array('product_id' => $id,'product_tag_id'=>$tid));
								array_push($data,$dt);
							}

						}
					//pr($data);throw new Exception();

					if($this->request->data['Requestrelatetag']['product_tag_id'] || !empty($tag_id))
					{
                        if(!$this->Request->Requestrelatetag->saveMany($data,array('deep' => true)))
							throw new Exception(__d(__PRODUCT_LOCALE,'the_product_tag_not_saved'));
					}
			 // tag opration


			 // image opration

				$options=array();
                $this->Request->Requestimage->recursive=-1;
            	$options['fields'] = array(
            			'Requestimage.id',
            			'Requestimage.title',
            			'Requestimage.image'
            		   );
            	$options['conditions'] = array(
            		'Requestimage.product_id' => $id
            		);
            	$productimages = $this->Request->Requestimage->find('all',$options);
				//pr($this->request->data);throw new Exception();
				if(!empty($productimages)){
				foreach($productimages as $productimage)
				{
					if(!in_array($productimage['Requestimage']['id'],$this->request->data['Requestimage']['id']))
					{
						if(!$this->Request->Requestimage->delete($productimage['Requestimage']['id']))
							throw new Exception(__d(__PRODUCT_LOCALE,'the_productimage_not_saved'));
						else
						{
							@unlink(__PRODUCT_IMAGE_PATH."/".$productimage['Requestimage']['image']);
					        @unlink(__PRODUCT_IMAGE_PATH."/".__UPLOAD_THUMB."/".$productimage['Requestimage']['image']);
						}
					}
				}
			  }


				if(!empty($this->request->data['Requestimage']['id'])){
					foreach($this->request->data['Requestimage']['id'] as $key => $value)
					{

					  if($this->request->data['Requestimage']['image'][$key]['size']>0){

						@unlink(__PRODUCT_IMAGE_PATH."/".$this->request->data['Requestimage']['old_image'][$key]);
					    @unlink(__PRODUCT_IMAGE_PATH."/".__UPLOAD_THUMB."/".$this->request->data['Requestimage']['old_image'][$key]);
					  	$output=$this->_picture($this->request->data['Requestimage']['image'][$key],$key);
        				if(!$output['error']) $image=$output['filename'];
        				else {
                                $image='';
                                if(!empty($image_list)){
                                    foreach($image_list as $img)
                                    {
                                        @unlink(__PRODUCT_IMAGE_PATH."/".$img);
					                    @unlink(__PRODUCT_IMAGE_PATH."/".__UPLOAD_THUMB."/".$img);
                                    }
                                }
                                throw new Exception($output['message'].'  '.__d(__PRODUCT_LOCALE,'نام تصویر ').$this->request->data['Requestimage']['image'][$key]['name']);
                             }

                        $image_list[]=$image;
					  }else $image = $this->request->data['Requestimage']['old_image'][$key];

					  $ret= $this->Request->Requestimage->updateAll(
					    array('Requestimage.title' => '"'.$this->request->data['Requestimage']['title'][$key].'"' ,
							  'Requestimage.image' => '"'.$image.'"'
						),   //fields to update
					    array( 'Requestimage.id' => $value )  //condition
					  );
					  if(!$ret){
					  	throw new Exception(__d(__PRODUCT_LOCALE,'the_productimage_not_saved'));
						  }
					}
			    }




                if(!empty($this->request->data['Requestimage']['id'])){
					foreach($this->request->data['Requestimage']['id'] as $key => $value)
					{
						unset($this->request->data['Requestimage']['title'][$key]);
						unset($this->request->data['Requestimage']['image'][$key]);
					}
				}



				 $data = array();
				if(!empty($this->request->data['Requestimage']['image'])){

					foreach($this->request->data['Requestimage']['image'] as $key => $value)
					{
						$output=$this->_picture($value,$key);
        				if(!$output['error']) $image=$output['filename'];
        				else {
                                $image='';
                                if(!empty($image_list)){
                                    foreach($image_list as $img)
                                    {
                                        @unlink(__PRODUCT_IMAGE_PATH."/".$img);
					                    @unlink(__PRODUCT_IMAGE_PATH."/".__UPLOAD_THUMB."/".$img);
                                    }
                                }
                                throw new Exception($output['message'].'  '.__d(__PRODUCT_LOCALE,'نام تصویر ').$value['name']);
                             }

                        $image_list[]=$image;

                        $data[]= array('Requestimage' => array(
									'image' => $image ,
									'title'=> $this->request->data['Requestimage']['title'][$key],
									'product_id' => $id
						));
					}
					//pr($data);throw new Exception();
					if(!empty($data)){
						if(!$this->Request->Requestimage->saveMany($data,array('deep' => true)))
					        throw new Exception(__d(__PRODUCT_LOCALE,'the_productimage_not_saved'));
					}
				}


			 // image opration


		    $datasource->commit();
			$this->Session->setFlash(__d(__PRODUCT_LOCALE,'the_technicalinfoitem_has_been_saved'), 'admin_success');
			$this->redirect(array('action' => 'index'));
		} catch(Exception $e) {
			    $datasource->rollback();
				$this->Session->setFlash($e->getMessage(),'admin_error');
		}

	}


	$options['conditions'] = array(
		'Request.id' => $id
		);
	$product = $this->Request->find('first',$options);
    $this->set('product', $product);

	$options=array();

	$options['conditions'] = array(
		'Requestrate.user_id' => $User_Info['id']
		);
	$productrate = $this->Request->Requestrate->find('first',$options);
    $this->set('productrate', $productrate);

    $this->set('technicalinfos',$this->_get_Technicalinfo());

    $options=array();

	$options['fields'] = array(
			'Technicalinfoitemvalue.id',
			'Technicalinfoitemvalue.value',
			'Technicalinfoitemvalue.technical_info_item_id',
			'Technicalinfoitem.item'
		   );
     $options['joins'] = array(
    		array('table' => 'technicalinfoitems',
        		'alias' => 'Technicalinfoitem',
        		'type' => 'INNER',
        		'conditions' => array(
        		'Technicalinfoitem.id = Technicalinfoitemvalue.technical_info_item_id'
    		)
		)
    );
    $options['conditions'] = array(
		'Technicalinfoitemvalue.product_id' => $id
		);
	$technicalinfoitemvalues = $this->Request->Technicalinfoitemvalue->find('all',$options);
    $this->set('technicalinfoitemvalues', $technicalinfoitemvalues);

    $options=array();
	$options['fields'] = array(
			'Requestimage.id',
			'Requestimage.title',
			'Requestimage.image'
		   );
	$options['conditions'] = array(
		'Requestimage.product_id' => $id
		);
	$productimages = $this->Request->Requestimage->find('all',$options);
    $this->set('productimages', $productimages);

	$options=array();
	$options['fields'] = array(
			'Requestrelatetag.id',
			'Requesttag.title',
			'Requesttag.id'
		   );
     $options['joins'] = array(
    		array('table' => 'producttags',
        		'alias' => 'Requesttag',
        		'type' => 'INNER',
        		'conditions' => array(
        		'Requesttag.id = Requestrelatetag.product_tag_id'
    		)
		)
    );
    $options['conditions'] = array(
		'Requestrelatetag.product_id' => $id
		);
	$productrelatetags = $this->Request->Requestrelatetag->find('all',$options);
    $this->set('productrelatetags', $productrelatetags);

    $this->set('technicalinfos',$this->_get_Technicalinfo());

	$this->set('categories',$this->_getback_categories($product['Request']['product_category_id']));
}



function admin_delete($id = null)
{
   $options=array();
   $this->Request->Requestitem->recursive= -1;
   $options['fields'] = array(
		'Requestitem.product_id',
		'Requestitem.item_count'
   );
  $options['conditions'] = array(
		'Requestitem.request_id' => $id
   );
  $requestitems = $this->Request->Requestitem->find('all',$options);

   if($this->Request->delete($id)){

	  $this->loadModel('Product');
	  $this->Product->recursive = -1;

	  if(!empty($requestitems)){
	  	foreach($requestitems as $requestitem){
		  $ret= $this->Product->updateAll(
			  array( 'Product.request' =>'Product.request - '.$requestitem['Requestitem']['item_count'],
			         'Product.num' =>'Product.num + '.$requestitem['Requestitem']['item_count']),
			  array( 'Product.id' => $requestitem['Requestitem']['product_id'] )  //condition
	   	  );
		}
	  }

	  $this->Session->setFlash(__d(__PRODUCT_LOCALE,'the_request_deleted'), 'admin_success');
   }
   else $this->Session->setFlash(__d(__PRODUCT_LOCALE,'the_request_not_deleted'), 'admin_error');
   $this->redirect($this->referer(array('action' => 'index')));
}


public function admin_requested_list(){

	$this->Request->recursive = -1;
	if(isset($_REQUEST['filter'])){
		$limit = $_REQUEST['filter'];
	}else $limit = 10;

	if(isset($this->request->data['Request']['search'])){
		$this->request->data=Sanitize::clean($this->request->data);
		$this->paginate = array(
			'fields'=>array(
				'Request.id',
				'Request.refid',
				'Request.description',
				'Request.created',
				'Request.sum_price',
				'Bankmessag.message',
				'(select sum(item_count) from requestitems where request_id = Request.id) as item_count',
				'(select sum(item_count) from requestitems where request_id = Request.id and status = 2) as send_count',
				'(select sum(item_count) from requestitems where request_id = Request.id and status = 3) as accept_count',
				'(select sum(item_count) from requestitems where request_id = Request.id and status not in (2,3)) as not_accept_count'
			),
			'joins'=>array(
			   array('table' => 'bankmessags',
				 'alias' => 'Bankmessag',
				 'type' => 'LEFT',
				 'conditions' => array(
				 'Bankmessag.id = Request.bankmessage_id ',
				 )
			   )

			 ),
			'conditions' => array('Request.refid LIKE' => '%'.$this->request->data['Request']['search'].'%'),
			'limit' => $limit,
			'request' => array(
				'Request.id' => 'desc'
			)
		);
	}
	else
	{
		$this->paginate = array(
			'fields'=>array(
				'Request.id',
				'Request.refid',
				'Request.description',
				'Request.created',
				'Request.sum_price',
				'Bankmessag.message',
				'(select sum(item_count) from requestitems where request_id = Request.id) as item_count',
				'(select sum(item_count) from requestitems where request_id = Request.id and status = 2) as send_count',
				'(select sum(item_count) from requestitems where request_id = Request.id and status = 3) as accept_count',
				'(select sum(item_count) from requestitems where request_id = Request.id and status not in (2,3)) as not_accept_count'
			),
			'joins'=>array(
			   array('table' => 'bankmessags',
				 'alias' => 'Bankmessag',
				 'type' => 'LEFT',
				 'conditions' => array(
				 'Bankmessag.id = Request.bankmessage_id ',
				 )
			   )

			 )
			 ,
			//'conditions' => array('user_id'=>$User_Info['id']),
			'limit' => $limit,
			'request' => array(
				'Request.id' => 'desc'
			)
		);
	}


	$requests = $this->paginate('Request');
	$this->set(compact('requests'));

}


function preper_pay_request($request_id=NULL){

	$User_Info= $this->Session->read('User_Info');
	$this->Session->write('back_to_basket',1);

	if(empty($User_Info)){
		$this->redirect(__SITE_URL.'users/login');
	}

	$this->loadModel('Userdetail');
	$userDetail = $this->Userdetail->_getUserData($User_Info['id']);
	if (empty($userDetail)){
		$this->redirect(__SITE_URL.'users/edit_address');
	}

	$this->Session->delete('back_to_basket');

	$this->Request->recursive = -1;
	$this->request->data = array();

	/*Controller::loadModel('Siteinformation');
	$setting=$this->Siteinformation->get_setting();
	$percent = $setting['Siteinformation']['percent'];*/
	$percent = 0;
	$info = $this->Request->find('first', array('conditions' => array('Request.user_id' => $User_Info['id'],'Request.id'=>$request_id)));

	if(!empty($info)){
		$id=$info['Request']['id'];

		$this->Request->Requestitem->recursive = -1;
		$request_item = $this->Request->Requestitem->find('all', array('fields'=>array('(SUM(Requestitem.item_count)) as qty'),'conditions' => array('Requestitem.request_id' => $id)));

		$long = strtotime(date('Y-m-d H:i:s'));
		$random= rand(1000,1000000);

		$this->Session->write('Pay_Info',array(
			'title' => __d(__PRODUCT_LOCALE,'product_request_info') ,
			'sum_price' => $info['Request']['sum_price'],
			'other_price' => 0 ,
			'sum_item' => $request_item['0']['0']['qty'],
			'requestid' => $long,
			'model'=> 'Request' ,
			'token'=>$random,
			'row_id'=>$id,
			'cn'=>'requests',
			'ac'=>'end_request'

		));
		$this->redirect('/getway/banks/pay/'.$random.'?cn=requests&ac=end_request');
	}
    else
	{

		if(empty($_SESSION['Basket_Info'])){
			$this->redirect(__SITE_URL.__SHOP.'/products/search');
		}
		else{
			$datasource = $this->Request->getDataSource();
			try{
	    		$datasource->begin();

				$this->loadModel('Product');
				$this->Product->recursive = -1;

				/*foreach($_SESSION['Basket_Info'] as $product_id => $quantity) {
					$this->Product->recursive = -1;
					$options=array();
					$options['fields'] = array(
						'Product.id',
						'Product.title',
						'Product.price',
						'Product.user_id',
						'Product.num'
					);
					$options['conditions'] = array(
						'Product.id' => $product_id
					);
					$product = $this->Product->find('first',$options);

					if($product['Product']['num'] - $quantity < 0){
						throw new Exception(__d(__PRODUCT_LOCALE,'product').' « '.$product['Product']['title'].' » '.__d(__PRODUCT_LOCALE,'is_finished'));
					}

					$products[]=array(
						'id'=>$product['Product']['id'],
						'title'=>$product['Product']['title'],
						'price'=>$product['Product']['price'],
						'quantity'=>$quantity,
						'owner_id'=>$product['Product']['user_id']
					);
				}

				$total = 0;
				$sum_quantity = 0;

				foreach($products as $product){
					$total+= $product['price'] * $product['quantity'];
					$sum_quantity+= $product['quantity'];
				}*/

			 	//pr($_SESSION['Basket_Info']);exit();
				$total = 0;
				$sum_quantity = 0;
				foreach($_SESSION['Basket_Info'] as $product){
					$total+= $product['price'] * $product['num'];
					$sum_quantity+= $product['num'];
				}
				$total += 300000;
				$this->request->data['Request']['user_id']= $User_Info['id'];
				$this->request->data['Request']['bank_id']= 0;
				$this->request->data['Request']['sum_price']= $total;
				$this->request->data['Request']['items_count']= $sum_quantity;
				$this->request->data['Request']['bankmessage_id']= -1;
				$this->request->data['Request']['refid']= 0;

				$this->Request->create();
				if(!$this->Request->save($this->request->data))
					throw new Exception(__d(__PRODUCT_LOCALE,'the_request_not_saved'));

				$request_id=$this->Request->getLastInsertID();

				$data = array();
				$sum_price =0;
				foreach($_SESSION['Basket_Info'] as $product){

					$sum_price = $product['price'] * $product['num'];
					$admin_price = $sum_price * ($percent/100);
					$user_price = $sum_price - $admin_price;
					$dt=array();
					$dt=array('Requestitem' => array(
						'request_id' => $request_id,
						'product_id' => $product['id'],
						'item_count'=>$product['num'],
						'sum_price'=>$sum_price,
						'admin_price'=>$admin_price,
						'user_price'=>$user_price,
					));
					array_push($data,$dt);
				}

				if(!$this->Request->Requestitem->saveMany($data,array('deep' => true)))
					throw new Exception(__d(__PRODUCT_LOCALE,'the_request_items_not_saved'));

				/*foreach($products as $product){
					$ret= $this->Product->updateAll(
					    array( 'Product.request' =>'Product.request + '.$product['quantity'],
						       'Product.num' =>'Product.num - '.$product['quantity']),
					    array( 'Product.id' => $product['id'] )  //condition
			   		);
					if(!$ret){
						throw new Exception(__d(__PRODUCT_LOCALE,'the_request_items_not_saved'));
					}
				}	*/

				$long = strtotime(date('Y-m-d H:i:s'));
				$random= rand(1000,1000000);

				$this->Session->write('Pay_Info',array(
					'title' => __d(__PRODUCT_LOCALE,'product_request_info') ,
					'sum_price' => $total,
					'other_price' => 0 ,
					'sum_item' => $sum_quantity,
					'requestid' => $long,
					'model'=> 'Request' ,
					'token'=>$random,
					'row_id'=>$request_id,
					'cn'=>'requests',
					'ac'=>'end_request'

				));

				$datasource->commit();

				$this->Session->delete('Basket_Info');
				$this->redirect('/getway/banks/pay/'.$random.'?cn=requests&ac=end_request');

	            //$this->Session->setFlash(__d(__PRODUCT_LOCALE,'the_product_has_been_saved'), 'success_panel');
				//$this->redirect(array('action' => 'product_list'));
	        } catch(Exception $e) {
	            $datasource->rollback();
	            $this->Session->setFlash($e->getMessage(),'error');
				$this->redirect(__SITE_URL.'products/basket');
	        }

		}

	}

 }


 function end_request()
	{
		$this->autoRender = false;
		$CallBack_Info = $this->Session->read('CallBack_Info');
		pr($CallBack_Info);
		$token = $_REQUEST['token'];
		$step = 0;

		try
		{

			if(empty($CallBack_Info)){
				$step = 10;
				throw new Exception(__d(__PRODUCT_LOCALE,'not_exist_requests_information'));
			}

			if($token != $CallBack_Info['token'])
			{
				$step = 20;
				throw new Exception(__d(__PRODUCT_LOCALE,'not_exist_requests_information'));
			}

			if($CallBack_Info['refid'] > 0)
			{
				//pr($CallBack_Info);exit();
				$this->Request->recursive = -1;
				/*$ret = $this->Request->query("
					update requests as Request set
					   Request.refid = '".$CallBack_Info['refid']."' ,
					   Request.status = 1
					   where Request.id = ".$CallBack_Info['row_id']."
				");*/

				$ret = $this->Request->updateAll(
					array('Request.refid' => '"' . $CallBack_Info['refid'] . '"'),   //fields to update
					array('Request.id' => $CallBack_Info['row_id'])  //condition
				);

				/*if(!$ret){
					throw new Exception(__d(__PRODUCT_LOCALE,'save_user_panel_not_succeed'));
				}*/


				$this->Redirect->flashSuccess(__d(__PRODUCT_LOCALE,'save_request_sucessed'),array('action'    =>'purchases','controller'=>'requests'));
			}
			else
			{

				$options = array();
				$this->loadModel('Requestitem');
				$this->Requestitem->recursive = - 1;

				$options['fields'] = array(
					'Requestitem.product_id' ,
					'Requestitem.item_count'
				);
				$options['conditions'] = array(
					'Requestitem.request_id'=> $CallBack_Info['row_id']
				);
				$items = $this->Requestitem->find('all',$options);

				$this->loadModel('Product');
				$this->Product->recursive = - 1;
				//pr($items);exit;
				if(!empty($items)){

					foreach($items as $item){
						$ret= $this->Product->updateAll(
						    array( 'Product.request' =>'Product.request - '.$item['Requestitem']['item_count'],
							       'Product.num' =>'Product.num + '.$item['Requestitem']['item_count']),
						    array( 'Product.id' => $item['Requestitem']['product_id'] )  //condition
				   		);
						if(!$ret){
							$step = 40;
							throw new Exception(__d(__PRODUCT_LOCALE,'the_back_product_operation_has_error'));
						}
					}
				}

				$this->Request->deleteAll(array('Request.id'=>$CallBack_Info['row_id']),FALSE);
				throw new Exception(__d(__PRODUCT_LOCALE,'save_request_not_sucessed'));
			}


		} catch(Exception $e){
			Controller::loadModel('Errorlog');
			$this->Session->delete('CallBack_Info');
			//$this->Errorlog->get_log('RequestsController','end_request, '.$e->getMessage().' step = '.$step );
			$this->Redirect->flashWarning($e->getMessage(),array('action'    =>'purchases','controller'=>'requests'));
		}

		$this->Session->delete('CallBack_Info');
		$this->redirect(__SITE_URL);
	}






}
