<?php
App::uses('AppController', 'Controller');

class GalleriesController extends GalleryAppController
{
	/**
	* Components
	*
	* @var array
	*/
	public $components = array('Paginator','Httpupload','CmsAcl'=>array('allUsers'=>array('index')));
	public $helpers = array('AdminHtml'=>array('action'=>'Gallery'));
	/**
	* admin_index method
	*
	* @return void
	*/

	public
	function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('search','view');
	}

	public
	function admin_index()
	{
		$this->Gallery->recursive = -1;
		$this->set('title_for_layout',__d(__GALLERY_LOCALE,'gallery_list'));
		if(isset($_REQUEST['filter'])){
			$limit = $_REQUEST['filter'];
		}
		else $limit = 10;

		if(isset($this->request->data['Gallery']['search'])){
			$this->request->data = Sanitize::clean($this->request->data);
			$this->paginate = array(
				'fields'=>array(
					'Gallerycategory.title',
					'Gallery.id',
					'Gallery.title',
					'Gallery.mini_detail',
					'Gallery.status',
					'Gallery.created',
				),
				'joins'=>array(array('table' => 'gallerytranslations',
					'alias' => 'Gallerytranslation',
					'type' => 'left',
					'conditions' => array(
					'Gallery.id = Gallerytranslation.gallery_id ',
					)
				 )),
				'conditions' => array('Gallerytranslation.title LIKE'=> ''.$this->request->data['Gallery']['search'].'%','Gallerytranslation.language_id'=> $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID) ),
				'limit'     => $limit,
				'order'                     => array(
					'Gallery.id'=> 'desc'
				)
			);
		}
		else
		{
			$this->paginate = array(
				'fields'=>array(
					'Gallery.id',
					'Gallerytranslation.title',
					'(select count(*) from galleryimages where gallery_id = Gallery.id) as imagecount',
					'Gallery.status',
					'Gallery.created',
				),
				'joins'=>array(array('table' => 'gallerytranslations',
					'alias' => 'Gallerytranslation',
					'type' => 'left',
					'conditions' => array(
					'Gallery.id = Gallerytranslation.gallery_id ',
					)
				 )),
				'conditions' => array('Gallerytranslation.language_id'=> $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID) ),
				'limit'=> $limit,
				'order' => array(
					'Gallery.id'=> 'desc'
				)
			);
		}
		$galleries = $this->paginate('Gallery');
		$this->set(compact('galleries'));
	}


	/**
	* admin_add method
	*
	* @return void
	*/
	public
	function admin_add()
	{
		$this->set('title_for_layout',__d(__GALLERY_LOCALE,'add_gallery'));
		if($this->request->is('post')){

			$datasource = $this->Gallery->getDataSource();
			try
			{
				$datasource->begin();

				if(!$this->Gallery->save($this->request->data))
					throw new Exception(__d(__GALLERY_LOCALE,'the_gallery_could_not_be_saved_Please_try_again'));
				$gallery_id = $this->Gallery->getLastInsertID();
				/*
				* @gallery translate
				*/

				$this->Gallery->Gallerytranslation->recursive = - 1;
				$this->request->data['Gallerytranslation']['gallery_id'] = $gallery_id;
				$this->request->data['Gallerytranslation']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
				$this->request->data['Gallerytranslation']['title'] = trim($this->request->data['Gallerytranslation']['title']);
				$this->Gallery->Gallerytranslation->create();
				if(!$this->Gallery->Gallerytranslation->save($this->request->data))
					throw new Exception(__d(__BLOG_LOCALE,'the_gallery_could_not_be_saved_Please_try_again'));

				/*
				* gallery translate
				*/


				if(!empty($this->request->data['Galleryimage']['image'])){

					$this->Gallery->Galleryimage->recursive = -1;


					foreach($this->request->data['Galleryimage']['image'] as $key => $value){
						if(trim($value['name']) == '')
						{
							unset($this->request->data['Galleryimage']['image'][$key]);
							unset($this->request->data['Galleryimage']['title'][$key]);
						}
					}
					$data = array();
					$datatranslate = array();
					$image_list = array();

					$this->loadModel('Galleryimagetranslation');
					$this->Galleryimagetranslation->recursive = -1;

					foreach($this->request->data['Galleryimage']['image'] as $key => $value){
						$output = $this->_picture($value,$key);
						if(!$output['error']) $image = $output['filename'];
						else
						{
							$image = '';
							if(!empty($image_list))
							{
								foreach($image_list as $img){
									@unlink(__GALLERY_IMAGE_PATH."/".$img);
									@unlink(__GALLERY_IMAGE_PATH."/".__UPLOAD_THUMB."/".$img);
								}
							}
							throw new Exception($output['message'].'  '.__d(__GALLERY_LOCALE,'image_name').' '.$value['name']);
						}

						$image_list[] = $image;

						$data = array('Galleryimage' => array(
								'image'     => $image ,
								'gallery_id'=> $gallery_id
							));
						$this->Gallery->Galleryimage->create();
						if(!$this->Gallery->Galleryimage->save($data))
							throw new Exception(__d(__GALLERY_LOCALE,'the_gallery_image_not_saved'));

						$galleryimage_id = $this->Gallery->Galleryimage->getLastInsertID();

						$datatranslate = array('Galleryimagetranslation' => array(
								'title'      => $this->request->data['Galleryimage']['title'][$key],
								'galleryimage_id' => $galleryimage_id,
								'language_id'=> $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
							));
						$this->Galleryimagetranslation->create();
						if(!$this->Galleryimagetranslation->save($datatranslate))
							throw new Exception(__d(__GALLERY_LOCALE,'the_gallery_image_not_saved'));
					}

				}

				$datasource->commit();

				$this->Redirect->flashSuccess(__d(__GALLERY_LOCALE,'the_gallery_has_been_saved'),array('action'=>'index'));
			} catch(Exception $e){
				$datasource->rollback();
				$this->Redirect->flashWarning($e->getMessage(),array('action'=>'index'));
			}

		}


	}

	/**
	* admin_edit method
	*
	* @throws NotFoundException
	* @param string $id
	* @return void
	*/
	public
	function admin_edit($id = null)
	{
		$this->set('title_for_layout',__d(__GALLERY_LOCALE,'edit_gallery'));
		if(!$this->Gallery->exists($id)){
			$this->Redirect->flashWarning(__d(__GALLERY_LOCALE,'invalid_gallery'));
		}
		if($this->request->is(array('post', 'put'))){

			$datasource = $this->Gallery->getDataSource();
			try
			{
				$datasource->begin();

				if(!$this->Gallery->save($this->request->data))
				throw new Exception(__d(__GALLERY_LOCALE,'the_gallery_could_not_be_saved_Please_try_again'));


				$this->Gallery->Gallerytranslation->recursive = - 1;
				$options = array();
				$options['conditions'] = array(
					"Gallerytranslation.gallery_id"=> $id,
					"Gallerytranslation.language_id"=>$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
				);
				$count = $this->Gallery->Gallerytranslation->find('count',$options);
				/*
				* @gallery translate
				*/
				if($count==0){
					$this->Gallery->Gallerytranslation->recursive = - 1;
					$this->request->data['Gallerytranslation']['gallery_id'] = $id;
					$this->request->data['Gallerytranslation']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
					$this->request->data['Gallerytranslation']['title'] = trim($this->request->data['Gallerytranslation']['title']);
					$this->Gallery->create();
					if(!$this->Gallery->Gallerytranslation->save($this->request->data))
						throw new Exception(__d(__BLOG_LOCALE,'the_gallery_could_not_be_saved'));
				}else
				{
					$ret= $this->Gallery->Gallerytranslation->updateAll(
					    array('Gallerytranslation.title' =>'"'.trim($this->request->data['Gallerytranslation']['title']).'"',
							  ),
		    			array('Gallerytranslation.gallery_id'=>$id,'language_id'=>$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID))

					  );
					if(!$ret){

						throw new Exception(__d(__BLOG_LOCALE,'the_gallery_could_not_be_saved'));
					}
				}
				/*
				* gallery translate
				*/


				// image opration

				$options = array();
				$this->Gallery->Galleryimage->recursive=-1;
				$options['fields'] = array(
					'Galleryimage.id',
					'Galleryimagetranslation.title',
					'Galleryimage.image'
				);
				$options['joins'] = array(
				  array(
			        'table' => 'galleryimagetranslations',
					'alias' => 'Galleryimagetranslation',
					'type' => 'left',
					'conditions' => array(
						'Galleryimage.id = Galleryimagetranslation.galleryimage_id ',
						'Galleryimagetranslation.language_id  = '.$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID),
						)
				   )
				  ) ;
				$options['conditions'] = array(
					'Galleryimage.gallery_id'=> $id
				);
				$galleryimages = $this->Gallery->Galleryimage->find('all',$options);
				$this->loadModel('Galleryimagetranslation');
				//pr($galleryimages);pr($this->request->data);exit();

				if(!empty($galleryimages))
				{
					if(!empty($this->request->data['Galleryimage']['id'])){
						foreach($galleryimages as $galleryimage){
							if(!in_array($galleryimage['Galleryimage']['id'],$this->request->data['Galleryimage']['id'])){
								if(!$this->Gallery->Galleryimage->delete($galleryimage['Galleryimage']['id']))
								throw new Exception(__d(__GALLERY_LOCALE,'the_gallery_image_not_saved'));
								else
								{
									@unlink(__GALLERY_IMAGE_PATH."/".$galleryimage['Galleryimage']['image']);
									@unlink(__GALLERY_IMAGE_PATH."/".__UPLOAD_THUMB."/".$galleryimage['Galleryimage']['image']);
								}
							}
						}
					}
					else{
						foreach($galleryimages as $galleryimage){
							if(!$this->Gallery->Galleryimage->delete($galleryimage['Galleryimage']['id']))
							throw new Exception(__d(__GALLERY_LOCALE,'the_gallery_image_not_saved'));
							else
							{
								@unlink(__GALLERY_IMAGE_PATH."/".$galleryimage['Galleryimage']['image']);
								@unlink(__GALLERY_IMAGE_PATH."/".__UPLOAD_THUMB."/".$galleryimage['Galleryimage']['image']);
							}
						}
					}
				}


				if(!empty($this->request->data['Galleryimage']['id']))
				{

					foreach($this->request->data['Galleryimage']['id'] as $key => $value){

						if($this->request->data['Galleryimage']['image'][$key]['size'] > 0)
						{

							@unlink(__GALLERY_IMAGE_PATH."/".$this->request->data['Galleryimage']['old_image'][$key]);
							@unlink(__GALLERY_IMAGE_PATH."/".__UPLOAD_THUMB."/".$this->request->data['Galleryimage']['old_image'][$key]);
							$output = $this->_picture($this->request->data['Galleryimage']['image'][$key],$key);
							if(!$output['error']) $image = $output['filename'];
							else
							{
								$image = '';
								if(!empty($image_list))
								{
									foreach($image_list as $img){
										@unlink(__GALLERY_IMAGE_PATH."/".$img);
										@unlink(__GALLERY_IMAGE_PATH."/".__UPLOAD_THUMB."/".$img);
									}
								}
								throw new Exception($output['message'].'  '.__d(__GALLERY_LOCALE,'image_name').' '.$this->request->data['Galleryimage']['image'][$key]['name']);
							}

							$image_list[] = $image;
						}
						else $image = $this->request->data['Galleryimage']['old_image'][$key];

						$ret   = $this->Gallery->Galleryimage->updateAll(
							array('Galleryimage.image'=> '"'.$image.'"'	),   //fields to update
							array('Galleryimage.id'=> $value )  //condition
						);
						if(!$ret)
						{
							throw new Exception(__d(__GALLERY_LOCALE,'the_gallery_image_not_saved'));
						}


						$this->Galleryimagetranslation->recursive = - 1;
						$options = array();
						$options['conditions'] = array(
							"Galleryimagetranslation.galleryimage_id"=> $value,
							"Galleryimagetranslation.language_id"=>$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
						);
						$count = $this->Galleryimagetranslation->find('count',$options);
						/*
						* @gallery translate
						*/
						if($count==0){
							$GalleryimagetranslationData = array();
							$this->Galleryimagetranslation->recursive = - 1;
							$GalleryimagetranslationData['Galleryimagetranslation']['galleryimage_id'] = $value;
							$GalleryimagetranslationData['Galleryimagetranslation']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
							$GalleryimagetranslationData['Galleryimagetranslation']['title'] = trim($this->request->data['Galleryimage']['title'][$key]);
							$this->Galleryimagetranslation->create();

							if(!$this->Galleryimagetranslation->save($GalleryimagetranslationData))
								throw new Exception(__d(__BLOG_LOCALE,'the_gallery_could_not_be_saved'));
						}else

						$ret   = $this->Galleryimagetranslation->updateAll(
							array('Galleryimagetranslation.title'=> '"'.$this->request->data['Galleryimage']['title'][$key].'"'
							),   //fields to update
							array('Galleryimagetranslation.galleryimage_id'=> $value,'Galleryimagetranslation.language_id'=>$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID) )  //condition
						);
						if(!$ret)
						{
							throw new Exception(__d(__GALLERY_LOCALE,'the_gallery_image_not_saved'));
						}
					}
				}




				if(!empty($this->request->data['Galleryimage']['id']))
				{
					foreach($this->request->data['Galleryimage']['id'] as $key => $value){
						unset($this->request->data['Galleryimage']['title'][$key]);
						unset($this->request->data['Galleryimage']['image'][$key]);
					}
				}



				$data = array();
				if(!empty($this->request->data['Galleryimage']['image']))
				{

					foreach($this->request->data['Galleryimage']['image'] as $key => $value){
						$output = $this->_picture($value,$key);
						if(!$output['error']) $image = $output['filename'];
						else
						{
							$image = '';
							if(!empty($image_list))
							{
								foreach($image_list as $img){
									@unlink(__GALLERY_IMAGE_PATH."/".$img);
									@unlink(__GALLERY_IMAGE_PATH."/".__UPLOAD_THUMB."/".$img);
								}
							}
							throw new Exception($output['message'].'  '.__d(__GALLERY_LOCALE,'image_name').' '.$value['name']);
						}

						$image_list[] = $image;

						$data = array('Galleryimage' => array(
								'image'     => $image ,
								'gallery_id'=> $id
							));
						$this->Gallery->Galleryimage->create();
						if(!$this->Gallery->Galleryimage->save($data))
							throw new Exception(__d(__GALLERY_LOCALE,'the_gallery_image_not_saved'));

						$galleryimage_id = $this->Gallery->Galleryimage->getLastInsertID();

						$datatranslate = array('Galleryimagetranslation' => array(
								'title'      => $this->request->data['Galleryimage']['title'][$key],
								'galleryimage_id' => $galleryimage_id,
								'language_id'=> $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
							));
						$this->Galleryimagetranslation->create();
						if(!$this->Galleryimagetranslation->save($datatranslate))
							throw new Exception(__d(__GALLERY_LOCALE,'the_gallery_image_not_saved'));

					}

				}


				// image opration


				$datasource->commit();
				$this->Redirect->flashSuccess(__d(__GALLERY_LOCALE,'the_gallery_has_been_saved'),array('action'=>'index'));

			} catch(Exception $e)
			{
				$datasource->rollback();
				$this->Redirect->flashWarning($e->getMessage(),array('action'=>'index'));
			}

		}
		else
		{
			$this->_set_gallery($id);

			$this->Gallery->Galleryimage->recursive = -1;
			$options=array();
			$options['fields'] = array(
					'Galleryimage.id',
					'Galleryimagetranslation.title',
					'Galleryimage.image'
				   );
			$options['joins'] = array(
			  array(
		        'table' => 'galleryimagetranslations',
				'alias' => 'Galleryimagetranslation',
				'type' => 'left',
				'conditions' => array(
					'Galleryimage.id = Galleryimagetranslation.galleryimage_id ',
					'Galleryimagetranslation.language_id  = '.$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID),
					)
			   )
			  ) ;
			$options['conditions'] = array(
				'Galleryimage.gallery_id' => $id
				);
			$galleryimages = $this->Gallery->Galleryimage->find('all',$options);
		    $this->set('galleryimages', $galleryimages);
		}


	}

	function _set_gallery($id)
	{
		$this->Gallery->recursive = - 1;
		$this->Gallery->id = $id;
		if(!$this->Gallery->exists()){
			$this->Session->setFlash(__('invalid_id_for_gallery'));
			return;
		}

		/*
		* Test allowing to not override submitted data
		*/
		if(empty($this->request->data)){

			$this->Gallery->recursive = - 1;
			$options = array();
			$options['fields'] = array(
				'Gallery.id',
				'Gallerytranslation.title',
				'Gallery.status',
				'Gallery.created',
			);
			$options['joins'] = array(

				array('table'     => 'gallerytranslations',
					'alias'     => 'Gallerytranslation',
					'type'      => 'left',
					'conditions' => array(
						'Gallery.id = Gallerytranslation.gallery_id'
					)
				)
			);

			$options['conditions'] = array(
				"Gallery.id"=> $id,
				"Gallerytranslation.language_id"=>$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
			);

			$gallery      = $this->Gallery->find('first',$options);

			//$this->request->data = $this->Gallery->findById($id);
		}
		if(empty($gallery)){
			$gallery = array(
				"Gallery" => array(
					"id" => $id,
					"status"=>1,
				),
				"Gallerytranslation" => array(
					"title" => "",
				)
			);
		}
		$this->set('gallery', $gallery);
		$this->request->data = $gallery;

		return $gallery;
	}

	/**
	* admin_delete method
	*
	* @throws NotFoundException
	* @param string $id
	* @return void
	*/
	public
	function admin_delete($id = null)
	{
		$this->Gallery->id = $id;
		if(!$this->Gallery->exists()){
			$this->Redirect->flashWarning(__d(__GALLERY_LOCALE,'invalid_gallery'));
		}
		$this->Gallery->Galleryimage->recursive = -1;
		$options['fields'] = array(
			'Galleryimage.id',
			'Galleryimage.image'
		   );

		$options['conditions'] = array(
			'Galleryimage.gallery_id'=>$id
		);
		$images = $this->Gallery->Galleryimage->find('all',$options);
		if($this->Gallery->delete()){
			if(!empty($images)){
			 	foreach($images as $img){
					@unlink(__GALLERY_IMAGE_PATH."/".$img['Galleryimage']['image']);
					@unlink(__GALLERY_IMAGE_PATH."/".__UPLOAD_THUMB."/".$img['Galleryimage']['image']);
				}
			 }

			$this->Gallery->Galleryimage->deleteAll(array('Galleryimage.gallery_id'=>$id),FALSE);

			$this->Redirect->flashSuccess(__d(__GALLERY_LOCALE,'the_gallery_has_been_deleted'));
		}
		else
		{
			$this->Redirect->flashWarning(__d(__GALLERY_LOCALE,'the_gallery_could_not_be_deleted_please_try_again'));
		}
		return $this->redirect(array('action'=> 'index'));
	}


	function _picture($data,$index)
	{
		App::uses('Sanitize', 'Utility');

		$output = array();

		if($data['size'] > 0)
		{
			$ext      = $this->Httpupload->get_extension($data['name']);
			$filename = md5(rand().$_SERVER['REMOTE_ADDR']);
			if(file_exists(__GALLERY_IMAGE_PATH.$filename.'.'.$ext))				$filename = md5(rand().$_SERVER[REMOTE_ADDR]);

			$this->Httpupload->setmodel('Galleryimage');
			$this->Httpupload->setuploadindex($index);
			$this->Httpupload->setuploaddir(__GALLERY_IMAGE_PATH);
			$this->Httpupload->setuploadname('image');
			$this->Httpupload->settargetfile($filename.'.'.$ext);
			$this->Httpupload->setmaxsize(__UPLOAD_IMAGE_MAX_SIZE);
			$this->Httpupload->setimagemaxsize(__UPLOAD_IMAGE_MAX_WIDTH,__UPLOAD_IMAGE_MAX_HEIGHT);
			$this->Httpupload->allowExt = __UPLOAD_IMAGE_EXTENSION;
			$this->Httpupload->create_thumb = true;
			$this->Httpupload->thumb_folder = __UPLOAD_THUMB;
			$this->Httpupload->thumb_width = 180;
			$this->Httpupload->thumb_height = 120;
			if(!$this->Httpupload->upload())
			{
				return array('error'   =>true,'filename'=>'','message' =>$this->Httpupload->get_error());
			}
			$filename .= '.'.$ext;

		}
		else return array('error'   =>true,'filename'=>'','message' =>'');

		return array('error'   =>false,'filename'=>$filename);
	}


	function index($category_id){

		$this->Gallery->Gallerycategory->recursive=-1;
		$options['fields'] = array(
				'Gallerycategory.id',
				'Gallerycategory.title'
			   );
		$options['conditions'] = array(
			"OR" => array('Gallerycategory.id'=> $category_id,'Gallerycategory.slug'=> $category_id)
			);
		$category = $this->Gallery->Gallerycategory->find('first',$options);

		$this->set('title_for_layout',__d(__GALLERY,'galleries').' '.$category['Gallerycategory']['title']);
		$this->set('description_for_layout',$category['Gallerycategory']['title']);
		$this->set('keywords_for_layout',$category['Gallerycategory']['title']);

		$options = array();
		$this->Gallery->recursive = - 1;
		$options['fields'] = array(
			'Gallery.id',
			'Gallery.title',
			'Gallery.mini_detail',
			'(select image from galleryimages where gallery_id = Gallery.id limit 0,1)as image'
		);
		$options['conditions'] = array(
			'Gallery.status'=> 1,
			'Gallery.gallery_category_id'=> $category['Gallerycategory']['id']
		);
		$options['order'] = array(
			'Gallery.id'=>'desc'
		);
		//$options['limit'] = 5;
		$galleries = $this->Gallery->find('all',$options);
		$this->set('galleries',$galleries);
		$this->set('category',$category);
	}


	public function search()
	{
		//$this->request->data = Sanitize::clean($this->request->data);

		$itemspp_filter='';
		$categoryid_filter='';
		$search_galleries='';

		if(!empty($_GET['search']))
			$search_galleries = Sanitize::clean($_GET['search']);

		if(!empty($_GET['itemspp_filter']))
			$itemspp_filter = Sanitize::clean($_GET['itemspp_filter']);
		if(!empty($_GET['categoryid_filter']))
			$categoryid_filter = Sanitize::clean($_GET['categoryid_filter']);


		$this->set('itemspp_filter',$itemspp_filter);
		$this->set('categoryid_filter',$categoryid_filter);


		$gallerycategory = $this->Gallery->_getCategories(0);
		$this->set('gallerycategory',$gallerycategory);
		// ---------------------------------------------------------------
		$_limit=20;
		if($itemspp_filter=='1')
			$_limit=6;


		if(!empty($_REQUEST['page']))
		{
			$page = $_REQUEST['page'];
		}
		else $page = 1;

		if(isset($page)){
			$first = ($page - 1) * $_limit;
		}
		else $first = 0;


		$_Order='ASC';


		$this->loadModel('Galleryimage');
		$this->Gallery->recursive = -1;

		$options['fields'] = array(
			'Gallery.id',
			'Gallery.title',
			'(select image from  galleryimages where gallery_id = Gallery.id limit 0,1) as image',
			'Gallerycategory.title as CatTitle',
			'Gallerycategory.id',
		   );



		if($categoryid_filter!='')
		{
			$categories = $this->Gallery->_getCategories($categoryid_filter);
			$ids= array($categoryid_filter);
			if(!empty($categories)){
				foreach($categories as $category){
					$ids[]=$category['id'];
				}
			}


			$options['conditions'] = array(
				'OR' => array(
		            'Gallerycategory.id'=> $categoryid_filter,
		            'Gallerycategory.id IN'=> $ids,
		        )

			);
		}

		if($search_galleries!='')
		{
			if(!empty($options['conditions'])){
				array_push($options['conditions'],array('Gallery.title like '=> '%'.$search_galleries.'%'));
			}else{
				$options['conditions'] = array('Gallery.title like '=> '%'.$search_galleries.'%');
			}
		}


		$options['joins'] = array(
			array(
				'table' => 'gallerycategories',
				'alias' => 'Gallerycategory',
				'type' => 'LEFT',
				'conditions' => array('Gallery.gallery_category_id = Gallerycategory.id')
			)
		);

		$total_count = $this->Gallery->find('count',$options);

		$options['limit'] = $_limit;
		$options['offset'] = $first;

		$galleries = $this->Gallery->find('all',$options);
		$this->set('galleries',$galleries);
		$this->set('total_count',$total_count);
		$this->set('limit',$_limit);


		$options = array();
		$this->Gallery->recursive = - 1;
		$options['fields'] = array(
			'Gallery.id',
			'Gallery.title',
			'Gallery.mini_detail',
			'(select image from galleryimages where gallery_id = Gallery.id limit 0,1)as image'
		);
		$options['conditions'] = array(
			'Gallery.status'=> 1
		);
		$options['order'] = array(
			'Gallery.id'=>'desc'
		);
		$options['limit'] = 5;
		$lastgalleries = $this->Gallery->find('all',$options);
		$this->set('lastgalleries',$lastgalleries);

		$this->set('title_for_layout','محصولات');
		$this->set('description_for_layout','محصولات');
	}


	public function view(){
		$this->Gallery->recursive = -1;

		$options = array();
		$options['fields'] = array(
			'Gallery.id',
			'Gallerytranslation.title'
		);

		$options['joins'] = array(
			array('table'     => 'gallerytranslations',
				'alias'     => 'Gallerytranslation',
				'type'      => 'left',
				'conditions' => array(
					'Gallery.id = Gallerytranslation.gallery_id'
				  )
				),
			array('table'     => 'languages',
				'alias'     => 'Language',
				'type'      => 'left',
				'conditions' => array(
					'Language.id = Gallerytranslation.language_id'
				)
			  )
		);

		$options['conditions'] = array(
			'Gallery.status'=> 1,
			'Language.code'=>$this->Session->read('Config.language')
		);
		$options['order'] = array(
			'Gallery.id'=>'asc'
		);
		$galleries = $this->Gallery->find('all',$options);

		//--------------------------------------------------------
		$options = array();
		$this->Gallery->Galleryimage->recursive = - 1;
		$options['fields'] = array(
			'Galleryimage.image',
			'Galleryimage.gallery_id',
			'Galleryimagetranslation.title'
		);

		$options['joins'] = array(
			array('table'     => 'galleryimagetranslations',
				'alias'     => 'Galleryimagetranslation',
				'type'      => 'left',
				'conditions' => array(
					'Galleryimage.id = Galleryimagetranslation.galleryimage_id'
				  )
				),
			array('table'     => 'languages',
				'alias'     => 'Language',
				'type'      => 'left',
				'conditions' => array(
					'Language.id = Galleryimagetranslation.language_id'
				)
			  )
		);

		$options['conditions'] = array(
			'Language.code'=>$this->Session->read('Config.language')
		);
		$options['order'] = array(
			'Galleryimage.id'=>'asc'
		);
		//$options['limit'] = 5;
		$galleryimages = $this->Gallery->Galleryimage->find('all',$options);

		$this->set('galleryimages',$galleryimages);
		$this->set('galleries',$galleries);
		$this->set('title_for_layout',__d(__GALLERY_LOCALE,'last_galleries'));
		$this->set('description_for_layout',__d(__GALLERY_LOCALE,'last_galleries'));
	}

}
?>
