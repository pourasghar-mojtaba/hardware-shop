<?php
/**
 */
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');


class BlogcommentsController extends BlogAppController {

/**
 * Controller name
 *
 * @var string
 */
 
 public function beforeFilter() {
	parent::beforeFilter();
	$this->Auth->allow('refresh_comment','add_comment');
}



function add_comment(){
 	
	$response['success'] = false;
	$response['message'] = null;
	
	$User_Info= $this->Session->read('User_Info');
	if(empty($User_Info)){
		$response['success'] = FALSE;
		$response['message'] = __('first_login_for_add_comment');
	}
	else{
		if($this->request->data['Blogcomment']['captcha'] != $this->Session->read('captcha'))
		{
			$response['success'] = FALSE;
			$response['message'] = __('incorrect_captcha');
			$this->set('ajaxData', json_encode($response));
			$this->render('/Elements/BlogComments/Ajax/ajax_result', 'ajax');
			return FALSE;
		}
		
		$this->request->data['Blogcomment']['user_id']=$User_Info['id'];
		
		$this->request->data=Sanitize::clean($this->request->data);
		
		$commant= $this->request->data['Blogcomment']['comment'];
		$blog_id= $this->request->data['Blogcomment']['blog_id'];
		
		$this->Blogcomment->create();
		try{
			if($this->Blogcomment->save($this->request->data)){
				$response['success'] = TRUE;
				
				// update blog comment count
				$ret = $this->Blogcomment->Blog->updateAll(
					array('Blog.num_new_comment'=> 'Blog.num_new_comment + 1' ,
					      'Blog.num_comment'=> 'Blog.num_comment + 1' ),   //fields to update
					array('Blog.id'=> $blog_id )  //condition
				);	
			}						
			
		} catch (Exception $e) {
			$response['success'] = FALSE;
		}
		
		$response['message'] = $response['success'] ? __('add_comment_success') : __('add_comment_notsuccess');
	}
		  
	
	
	$this->set('ajaxData',  json_encode($response));
	$this->render('/Elements/BlogComments/Ajax/ajax_result', 'ajax');
	
 }
 

function refresh_comment($blog_id){
 	
	$this->Blogcomment->recursive = -1;
	
	$blog_id= Sanitize::clean($blog_id);
	$User_Info= $this->Session->read('User_Info');
	$options['fields'] = array(
			'Blogcomment.id',
			'Blogcomment.comment',
			'Blogcomment.created',
			'User.id',
			'User.name',
			'User.user_name',
			'User.sex' ,
			'User.image'
		   );
		   
	$options['joins'] = array(
		array('table' => 'users',
			'alias' => 'User',
			'type' => 'INNER',
			'conditions' => array(
			'Blogcomment.user_id = `User`.id ',
			) 				
		)
		);
 			   
	$options['conditions'] = array(	
			'Blogcomment.blog_id ' => $blog_id,
			'Blogcomment.status ' => 1
	);	   
	$options['order'] = array(
		'Blogcomment.id'=>'desc'
	);
	
	
	$response = $this->Blogcomment->find('all',$options); 
	
	$this->set('comments', $response);
	
	$this->render('/Elements/BlogComments/Ajax/refresh_comment', 'ajax');	
	
 } 
 
public function delete_commentblog() {
   $response['success'] = false;
   $response['message'] = null;
   
   $blogcomment_id=Sanitize::clean($_REQUEST['blogcomment_id']);
    
   $this->Blogcomment->recursive = -1;
   
   try{
   		if($this->Blogcomment->delete($blogcomment_id)){
			$response['success'] =  TRUE;
		}				 
   } catch (Exception $e) {
   		$response['success'] =  FALSE;
   } 
      
   $response['message'] = $response['success'] ? '' : __('blogcomment_not_deleted');
   $this->set('ajaxData',  json_encode($response));
   $this->render('/Elements/BlogComments/Ajax/ajax_result', 'ajax');  
} 


function admin_index($blog_id)
	{
		//$this->Blogcomment->recursive = - 1;
		if(isset($_REQUEST['filter']))
		{
			$limit = $_REQUEST['filter'];
		}
		else $limit = 10;

		if(isset($this->request->data['Blogcomment']['search']))
		{
			$this->request->data = Sanitize::clean($this->request->data);
			$this->paginate = array(
				'fields'=>array(
					'User.id',
					'User.name',
					'User.user_name',
					'Blogcomment.id',
					'Blogcomment.comment',
					'Blogcomment.status',
					'Blogcomment.created'
				),
				'joins' =>array(
				    array('table'=> 'users',
						'alias'     => 'User',
						'type'      => 'Inner',
						'conditions' => array(
							'User.id = Blogcomment.user_id ',
						)
					)),
				'conditions' => array('Blogcomment.comment LIKE'=> '%'.$this->request->data['Blogcomment']['search'].'%'),
				'limit'     => $limit,
				'order'                          => array(
					'Blogcomment.id'=> 'desc'
				)
			);
		}
		else
		{
			$this->paginate = array(
				/*'joins'=>array(

				),*/
				'fields'=>array(
					'User.id',
					'User.name',
					'User.user_name',
					'Blogcomment.id',
					'Blogcomment.comment',
					'Blogcomment.status',
					'Blogcomment.created'
				),
				'joins' =>array(
				    array('table'=> 'users',
						'alias'     => 'User',
						'type'      => 'Inner',
						'conditions' => array(
							'User.id = Blogcomment.user_id ',
						)
					)),
				'conditions' => array('Blogcomment.blog_id '=> $blog_id),	
				'limit' => $limit,
				'order'      => array(
					'Blogcomment.id'=> 'desc'
				)
			);
		}
		$blogcomments = $this->paginate('Blogcomment');
		$this->set(compact('blogcomments'));
		
		
		$this->Blogcomment->Blog->recursive = - 1;
		$options = array();
		$options['fields'] = array(
			'Blog.id',
			'Blog.title'
		);
		$options['conditions'] = array(
			"Blog.id"=> $blog_id
		);

		$blog = $this->Blogcomment->Blog->find('first',$options);
		$this->set(compact('blog'));
		
		$ret       = $this->Blogcomment->Blog->updateAll(
			array('Blog.num_new_comment'=>0 ),   //fields to update
			array('Blog.id'=> $blog_id )  //condition
		);
		$this->set('blog_id',$blog_id);
	}
	
	function admin_edit($id = null,$blog_id)
	{
		$this->Blogcomment->id = $id;
		if(!$this->Blogcomment->exists())
		{
			$this->Redirect->flashWarning(__('invalid_id_for_blogcomment'),array('action'=>'index/'.$blog_id));
		}
		
		if($this->request->is('post') || $this->request->is('put'))
		{
			$this->request->data['Blogcomment']['comment'] = trim($this->request->data['Blogcomment']['comment']);
			$this->request->data=Sanitize::clean($this->request->data);
			if($this->Blogcomment->save($this->request->data))
			{
				$this->Redirect->flashSuccess(__('the_blogcomment_has_been_saved'),array('action'=>'index/'.$blog_id));
			}
			else
			{
				$this->Redirect->flashWarning(__('the_blogcomment_has_been_not_saved'),array('action'=>'index/'.$blog_id));
			}
		}
		

		$this->Blogcomment->recursive = -1;
		$options['fields'] = array(
			'Blogcomment.id',
			'Blogcomment.status',
			'Blogcomment.comment'
		);
		$options['conditions'] = array(
			"Blogcomment.id"=> $id
		);
		$blogcomment = $this->Blogcomment->find('first',$options);
		$this->set(compact('blogcomment'));
	}
	
	
	function admin_delete($id = null,$blog_id)
	{
		$this->Blogcomment->id = $id;
		if(!$this->Blogcomment->exists()){
			$this->Redirect->flashWarning(__('invalid_id_for_blogcomment'),array('action'=>'index/'.$blog_id));
		}
		if($this->Blogcomment->delete($id)){
			$ret       = $this->Blogcomment->Blog->updateAll(
				array('Blog.num_comment'=> 'num_comment-1'  ),   //fields to update
				array('Blog.id'=> $blog_id )  //condition
			);
			$this->Redirect->flashSuccess(__('delete_blogcomment_success'),array('action'=>'index/'.$blog_id));
		}
		else
		{
			$this->Redirect->flashWarning(__('delete_blog_not_success'),array('action'=>'index/'.$blog_id));
		}

	}
	
	
 

}
