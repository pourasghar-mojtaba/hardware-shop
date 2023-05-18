<?php
/**
*/
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class BannersController extends BannerAppController
{

	var $helpers = array('Cms');
	var $components = array('Cms','Httpupload');
	/**
	* Controller name
	*

	/**
	* follow to anoher user
	* @param undefined $id
	*
	*/

	public
	function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('view','get_last_banner','get_my_banner','last','tags','admin_user_search','main_page_banners','home_banner');
		$this->_add_admin_member_permision(array('admin_pin','admin_unpin'));
	}


	
	/**
	*
	*
	*/
	function admin_index()
	{
		$this->set('title_for_layout',__d(__BANNER_LOCALE,'banner_list'));
		//$this->Banner->recursive = - 1;
		if(isset($_REQUEST['filter']))
		{
			$limit = $_REQUEST['filter'];
		}
		else $limit = 10;

		if(isset($this->request->data['Banner']['search']))
		{
			$this->request->data = Sanitize::clean($this->request->data);
			$this->paginate = array(
				'fields'    =>array(
					'User.name',
					'Banner.id',
					'Bannertranslation.title',
					'Banner.status',
					'Banner.created',
					'Bannertranslation.image',
				),
				'joins'=>array(
				
					array('table'     => 'bannertranslations',
						  'alias'     => 'Bannertranslation',
						  'type'      => 'LEFT',
						  'conditions' => array(
						   'Bannertranslation.banner_id = Banner.id ' 
						)
					)
					
				),
				'conditions' => array('Bannertranslation.title LIKE'=> '%'.$this->request->data['Banner']['search'].'%','Bannertranslation.language_id'=> $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)),
				'limit'     => $limit,
				'order'                          => array(
					'Banner.id'=> 'desc'
				)
			);
		}
		else
		{
			$this->paginate = array(

				'fields'=>array(
					'User.name',
					'Banner.id',
					'Bannertranslation.title',
					'Banner.status',
					'Banner.created',
					'Bannertranslation.image',
				),
				'joins'=>array(
				
					array('table'     => 'bannertranslations',
						  'alias'     => 'Bannertranslation',
						  'type'      => 'LEFT',
						  'conditions' => array(
						   'Bannertranslation.banner_id = Banner.id ' 
						)
					)
					
				),
				'conditions' => array('Bannertranslation.language_id'=> $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)),
				'limit' => $limit,
				'order'      => array(
					'Banner.id'=> 'desc'
				)
			);
		}
		$banners = $this->paginate('Banner');
		$this->set(compact('banners'));
	}

	/**
	*
	*
	*/
	function admin_add()
	{
		$this->set('title_for_layout',__d(__BANNER_LOCALE,'add_banner')); 
		$this->Banner->recursive = - 1;
		if($this->request->is('post')){
			$datasource = $this->Banner->getDataSource();
			try
			{
				$datasource->begin();
				$data = Sanitize::clean($this->request->data);
				$file = $data['Bannertranslation']['image'];
			 
				if($file['size'] > 0)
				{
					$output = $this->_banner_picture();
					if(!$output['error']){
						$cover_image = $output['filename'];
					}
					else
					{
						$cover_image = '';
					}
				}
				else 	$cover_image = "";

				$User_Info   = $this->Session->read('AdminUser_Info');
				 
				$this->request->data['Banner']['user_id'] = $User_Info['id'];
				
				
				$this->request->data = Sanitize::clean($this->request->data);
				$this->Banner->create();
				if(!$this->Banner->save($this->request->data))					
					throw new Exception(__d(__BANNER_LOCALE,'the_banner_could_not_be_saved'));
				$banner_id = $this->Banner->getLastInsertID();
				
				/** 
				 @banner translate  
				*/ 
				
				$this->Banner->Bannertranslation->recursive = - 1;
				$this->request->data['Bannertranslation']['banner_id'] = $banner_id;
				$this->request->data['Bannertranslation']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
				$this->request->data['Bannertranslation']['title'] = trim($this->request->data['Bannertranslation']['title']);
				$this->request->data['Bannertranslation']['image'] = $cover_image;
				$this->Banner->Bannertranslation->create();
				if(!$this->Banner->Bannertranslation->save($this->request->data))					
					throw new Exception(__d(__BLOG_LOCALE,'the_banner_could_not_be_saved'));
					
				/** 
				* banner translate 
				*/

				$datasource->commit();
				$this->Redirect->flashSuccess(__d(__BANNER_LOCALE,'the_banner_has_been_saved'),array('action'=>'index'));

			} catch(Exception $e){
				$datasource->rollback();
				@unlink(__BANNER_IMAGE_PATH."/".$cover_image);
				$this->Redirect->flashWarning($e->getMessage(),array('action'=>'index'));
			}
		}

		$this->set('bannerlocations',$this->_getLocations());
	}
	
	private function _getLocations(){
		$this->Banner->Bannerlocation->recursive = - 1;
		$options = array();
		$options['fields'] = array(
			'Bannerlocation.id',
			'Bannerlocation.location', 
		);

		$options['conditions'] = array(
			"Bannerlocation.status"=> 1,				
		);

		$bannerlocations= $this->Banner->Bannerlocation->find('list',$options);
		return $bannerlocations;
	}
	
	
	function _banner_picture()
	{
		App::uses('Sanitize', 'Utility');

		$output = array();
		$data = Sanitize::clean($this->request->data);
		$file = $data['Bannertranslation']['image'];

		if($file['size'] > 0){
			$ext      = $this->Httpupload->get_extension($file['name']);
			$filename = md5(rand().$_SERVER['REMOTE_ADDR']);
			if(file_exists(__BANNER_IMAGE_PATH.$filename.'.'.$ext))                $filename = md5(rand().$_SERVER[REMOTE_ADDR]);

			$this->Httpupload->setmodel('Bannertranslation');
			$this->Httpupload->setuploaddir(__BANNER_IMAGE_PATH);
			$this->Httpupload->setuploadname('image');
			$this->Httpupload->settargetfile($filename.'.'.$ext);
			$this->Httpupload->setmaxsize(4194304);
			$this->Httpupload->create_thumb = FALSE;
			//$this->Httpupload->setimagemaxsize(1400,400);
			$this->Httpupload->allowExt = __UPLOAD_IMAGE_EXTENSION;
			if(!$this->Httpupload->upload()){
				return array('error'   =>true,'filename'=>'','message' =>$this->Httpupload->get_error());
			}
			$filename .= '.'.$ext;

		}
		return array('error'   =>false,'filename'=>$filename);
	}

	/**
	*
	* @param undefined $id
	*
	*/
	function _set_banner($id)
	{
		$this->Banner->recursive = - 1;
		$this->Banner->id = $id;
		if(!$this->Banner->exists()){
			$this->Session->setFlash(__('invalid_id_for_banner'));
			return;
		}

		/*
		* Test allowing to not override submitted data
		*/
		if(empty($this->request->data)){
			
			$this->Banner->recursive = - 1;
			$options = array();
			$options['fields'] = array(
				'Banner.id',
				'Bannertranslation.title',
				'Banner.bannerlocation_id',
				'Bannertranslation.image',
				'Banner.status',
				'Banner.link',
				'Banner.created',
 
			);
 			$options['joins'] = array(
				array('table'     => 'bannertranslations',
					'alias'     => 'Bannertranslation',
					'type'      => 'left',
					'conditions' => array(
						'Banner.id = Bannertranslation.banner_id',
						"Bannertranslation.language_id"=>$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
					)
				)
			);
			$options['conditions'] = array(
				"Banner.id"=> $id,							
			);

			$banner= $this->Banner->find('first',$options);
			
			//$this->request->data = $this->Banner->findById($id);
		}
		if(empty($banner)){
			
			$options = array();
			$options['fields'] = array(
				'Banner.id',
				'Banner.title',
				'Banner.bannerlocation_id',
				'Banner.image',
				'Banner.status',
				'Banner.link',
				'Banner.created',
 
			);
 
			$options['conditions'] = array(
				"Banner.id"=> $id,								
			);

			$banner_first= $this->Banner->find('first',$options);
			
			$banner = array(
				"Banner" => array(
					"id" => $id,
					"title"=>"",
					"bannerlocation_id"=>$banner_first['Banner']['bannerlocation_id'],
					"image"=>"",
					"status"=>$banner_first['Banner']['status'],
					"link"=>$banner_first['Banner']['link'],
				),
			);
		}			
		$this->set('banner', $banner);
		$this->request->data = $banner;

		return $banner;
	}

	/**
	*
	* @param undefined $id
	*
	*/
	function admin_edit($banner_id = null)
	{
		$this->set('title_for_layout',__d(__BANNER_LOCALE,'edit_banner')); 
		$this->Banner->id = $banner_id;
		if(!$this->Banner->exists()){
			$this->Session->setFlash(__('invalid_id_for_banner'));
			return;
		}

		if($this->request->is('post') || $this->request->is('put')){

			$datasource = $this->Banner->getDataSource();
			try
			{
				$datasource->begin();

				$this->Banner->Bannertranslation->recursive = - 1;
				$options = array();
				$options['fields'] = array(
					'Bannertranslation.image'
				);
				$options['conditions'] = array(
					"Bannertranslation.banner_id"=> $banner_id,
					"Bannertranslation.language_id"=>$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
				);

				$bannertranslation = $this->Banner->Bannertranslation->find('first',$options);


				$User_Info = $this->Session->read('AdminUser_Info');
				 
				//$this->request->data['Banner']['status'] = 0;
 
				$this->request->data['Banner']['id'] = $banner_id;
				$this->request->data = Sanitize::clean($this->request->data);
				$data = Sanitize::clean($this->request->data);

				$file = $data['Bannertranslation']['image'];

				if($file['size'] > 0)
				{
					$output = $this->_banner_picture();
					if(!$output['error']){
						$cover_image = $output['filename'];
					}
					else
					{
						$cover_image = '';
					}
				}
				else $cover_image = $bannertranslation['Bannertranslation']['image'];
				$this->request->data['Banner']['user_id'] = $User_Info['id'];
												 
				if(!$this->Banner->save($this->request->data))					
					throw new Exception(__d(__BANNER_LOCALE,'the_banner_could_not_be_saved'));
					
				
				$this->Banner->Bannertranslation->recursive = - 1;
				$options = array();
				$options['conditions'] = array(
					"Bannertranslation.banner_id"=> $banner_id,
					"Bannertranslation.language_id"=>$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
				);
				$count = $this->Banner->Bannertranslation->find('count',$options);
				/*
				* @banner translate  
				*/ 
				if($count==0){
					$this->Banner->Bannertranslation->recursive = - 1;
					$this->request->data['Bannertranslation']['banner_id'] = $banner_id;
					$this->request->data['Bannertranslation']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
					$this->request->data['Bannertranslation']['title'] = trim($this->request->data['Bannertranslation']['title']);
					$this->request->data['Bannertranslation']['image'] = $cover_image;
					$this->Banner->create();
					if(!$this->Banner->Bannertranslation->save($this->request->data))					
						throw new Exception(__d(__BLOG_LOCALE,'the_banner_could_not_be_saved'));
				}else
				{
					$ret= $this->Banner->Bannertranslation->updateAll(
					    array('Bannertranslation.title' =>'"'.trim($this->request->data['Bannertranslation']['title']).'"',
							  'Bannertranslation.image' =>'"'.$cover_image.'"'
							  ),
		    			array('Bannertranslation.banner_id'=>$banner_id,'language_id'=>$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID))
						
					  );
					if(!$ret){
						
						throw new Exception(__d(__BLOG_LOCALE,'the_banner_could_not_be_saved'));
					}
				}	
				/*
				* banner translate
				*/
					
				$datasource->commit();

				if($file['size'] > 0 && $count > 0)
				{
					@unlink(__BANNER_IMAGE_PATH."/".$bannertranslation['Bannertranslation']['image']);
				}

				$this->Redirect->flashSuccess(__d(__BANNER_LOCALE,'the_banner_has_been_saved'),array('action'=>'index'));

			} catch(Exception $e)
			{
				$datasource->rollback();
				if($file['size'] > 0)
				{
					@unlink(__BANNER_IMAGE_PATH."/".$cover_image);
				}
				$this->Redirect->flashWarning($e->getMessage(),array('action'=>'index'));
			}


		}


		$this->_set_banner($banner_id);
		$this->set('bannerlocations',$this->_getLocations());
	}


	function admin_manager()
	{

	}

	function admin_delete($id = null)
	{
		$this->Banner->id = $id;
		if(!$this->Banner->exists()){
			$this->Redirect->flashWarning(__d(__BANNER_LOCALE,'invalid_id_for_banner'),array('action'=>'index'));
		}
		$this->Banner->Bannertranslation->recursive = -1;
		$options['fields'] = array(
			'Bannertranslation.image'
		   );
				   
		$options['conditions'] = array(
			'Bannertranslation.banner_id'=>$id
		);
		$images = $this->Banner->Bannertranslation->find('all',$options);
		if($this->Banner->delete($id)){
			
			if(!empty($images)){
			 	foreach($images as $img){
					@unlink(__BANNER_IMAGE_PATH."/".$img['Bannertranslation']['image']);
				}
			 }
			 
			$this->Banner->Bannertranslation->deleteAll(array('Bannertranslation.banner_id'=>$id),FALSE); 		
			$this->Redirect->flashSuccess(__d(__BANNER_LOCALE,'delete_banner_success'),array('action'=>'index'));
		}
		else
		{
			$this->Redirect->flashWarning(__d(__BANNER_LOCALE,'delete_banner_not_success'),array('action'=>'index'));
		}

	}

			
	
	function home_banner()
	{
		$this->Banner->recursive = - 1;
		$banners   = $this->Banner->query("SELECT
			Banner.id,
			Banner.title,
			Banner.little_detail,
			Banner.image
			from banners as Banner
			WHERE Banner.status = 1			 
			ORDER BY Banner.pinsts desc , Banner.id desc
			limit 0,10");

		return $banners;
	}
	
	
	
	function main_page_banners()
	{
		 

		$this->Banner->recursive = - 1;
		$banners   = $this->Banner->query("SELECT
			Banner.id,
			Banner.title,
			Banner.little_detail,
			Banner.image
			from banners as Banner
			WHERE Banner.status = 1
			ORDER BY Banner.id desc
			limit 0,3");

		$this->set(compact('banners'));


		$options = array();
		$options['conditions'] = array(
			'Banner.status '=> 1
		);
		return $banners;
	}
	
	

}
?>