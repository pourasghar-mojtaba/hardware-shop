<?php
/**
*/
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class SlidersController extends SliderAppController
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
		$this->Auth->allow('view');
		$this->_add_admin_member_permision(array());
	}



	/**
	*
	*
	*/
	function admin_index()
	{
		$this->set('title_for_layout',__d(__SLIDER_LOCALE,'slider_list'));
		//$this->Slider->recursive = - 1;
		if(isset($_REQUEST['filter']))
		{
			$limit = $_REQUEST['filter'];
		}
		else $limit = 10;

		if(isset($this->request->data['Slider']['search']))
		{
			$this->request->data = Sanitize::clean($this->request->data);
			$this->paginate = array(
				'fields'    =>array(
					'Slider.id',
					'Slidertranslation.title',
					'Slidertranslation.url',
					'Slider.arrangment',
					'Slider.status',
					'Slider.created',
					'Slidertranslation.image',
				),
				'joins'=>array(

					array('table'     => 'slidertranslations',
						  'alias'     => 'Slidertranslation',
						  'type'      => 'LEFT',
						  'conditions' => array(
						   'Slidertranslation.slider_id = Slider.id '
						)
					)

				),
				'conditions' => array('Slidertranslation.title LIKE'=> '%'.$this->request->data['Slider']['search'].'%','Slidertranslation.language_id'=> $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)),
				'limit'     => $limit,
				'order'                          => array(
					'Slider.id'=> 'desc'
				)
			);
		}
		else
		{
			$this->paginate = array(

				'fields'=>array(
					'Slider.id',
					'Slidertranslation.title',
					'Slidertranslation.url',
					'Slider.arrangment',
					'Slider.status',
					'Slider.created',
					'Slidertranslation.image',
				),
				'joins'=>array(

					array('table'     => 'slidertranslations',
						  'alias'     => 'Slidertranslation',
						  'type'      => 'LEFT',
						  'conditions' => array(
						   'Slidertranslation.slider_id = Slider.id '
						)
					)

				),
				'conditions' => array('Slidertranslation.language_id'=> $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)),
				'limit' => $limit,
				'order'      => array(
					'Slider.id'=> 'desc'
				)
			);
		}
		$sliders = $this->paginate('Slider');
		$this->set(compact('sliders'));
	}

	/**
	*
	*
	*/
	function admin_add()
	{
		$this->set('title_for_layout',__d(__SLIDER_LOCALE,'add_slider'));
		$this->Slider->recursive = - 1;
		if($this->request->is('post')){
			$datasource = $this->Slider->getDataSource();
			try
			{
				$datasource->begin();
				$data = Sanitize::clean($this->request->data);
				$file = $data['Slidertranslation']['image'];

				if($file['size'] > 0)
				{
					$output = $this->_slider_picture();
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

				$this->request->data['Slider']['user_id'] = $User_Info['id'];


				$this->request->data = Sanitize::clean($this->request->data);
				$this->Slider->create();
				if(!$this->Slider->save($this->request->data))
					throw new Exception(__d(__SLIDER_LOCALE,'the_slider_could_not_be_saved'));
				$slider_id = $this->Slider->getLastInsertID();

				/**
				 @slider translate
				*/

				$this->Slider->Slidertranslation->recursive = - 1;
				$this->request->data['Slidertranslation']['slider_id'] = $slider_id;
				$this->request->data['Slidertranslation']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
				$this->request->data['Slidertranslation']['title'] = trim($this->request->data['Slidertranslation']['title']);
				$this->request->data['Slidertranslation']['detail'] = trim($this->request->data['Slidertranslation']['detail']);
				$this->request->data['Slidertranslation']['image'] = $cover_image;
				$this->Slider->Slidertranslation->create();
				if(!$this->Slider->Slidertranslation->save($this->request->data))
					throw new Exception(__d(__SLIDER_LOCALE,'the_slider_could_not_be_saved'));

				/**
				* slider translate
				*/

				$datasource->commit();
				$this->Redirect->flashSuccess(__d(__SLIDER_LOCALE,'the_slider_has_been_saved'),array('action'=>'index'));

			} catch(Exception $e){
				$datasource->rollback();
				@unlink(__SLIDER_IMAGE_PATH."/".$cover_image);
				$this->Redirect->flashWarning($e->getMessage(),array('action'=>'index'));
			}
		}


	}



	function _slider_picture()
	{
		App::uses('Sanitize', 'Utility');

		$output = array();
		$data = Sanitize::clean($this->request->data);
		$file = $data['Slidertranslation']['image'];

		if($file['size'] > 0){
			$ext      = $this->Httpupload->get_extension($file['name']);
			$filename = md5(rand().$_SERVER['REMOTE_ADDR']);
			if(file_exists(__SLIDER_IMAGE_PATH.$filename.'.'.$ext))                $filename = md5(rand().$_SERVER[REMOTE_ADDR]);

			$this->Httpupload->setmodel('Slidertranslation');
			$this->Httpupload->setuploaddir(__SLIDER_IMAGE_PATH);
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
	function _set_slider($id)
	{
		$this->Slider->recursive = - 1;
		$this->Slider->id = $id;
		if(!$this->Slider->exists()){
			$this->Session->setFlash(__('invalid_id_for_slider'));
			return;
		}

		/*
		* Test allowing to not override submitted data
		*/
		if(empty($this->request->data)){

			$this->Slider->recursive = - 1;
			$options = array();
			$options['fields'] = array(
				'Slider.id',
				'Slidertranslation.title',
				'Slidertranslation.url',
				'Slidertranslation.detail',
				'Slidertranslation.image',
				'Slider.arrangment',
				'Slider.status',
				'Slider.created',

			);
 			$options['joins'] = array(
				array('table'     => 'slidertranslations',
					'alias'     => 'Slidertranslation',
					'type'      => 'left',
					'conditions' => array(
						'Slider.id = Slidertranslation.slider_id',
						"Slidertranslation.language_id"=>$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
					)
				)
			);
			$options['conditions'] = array(
				"Slider.id"=> $id,
			);

			$slider= $this->Slider->find('first',$options);

			//$this->request->data = $this->Slider->findById($id);
		}
		if(empty($slider)){

			$options = array();
			$options['fields'] = array(
				'Slider.id',
				'Slider.title',
				'Slider.sliderlocation_id',
				'Slider.image',
				'Slider.status',
				'Slider.link',
				'Slider.created',

			);

			$options['conditions'] = array(
				"Slider.id"=> $id,
			);

			$slider_first= $this->Slider->find('first',$options);

			$slider = array(
				"Slider" => array(
					"id" => $id,
					"title"=>"",
					"sliderlocation_id"=>$slider_first['Slider']['sliderlocation_id'],
					"image"=>"",
					"status"=>$slider_first['Slider']['status'],
					"link"=>$slider_first['Slider']['link'],
				),
			);
		}
		$this->set('slider', $slider);
		$this->request->data = $slider;

		return $slider;
	}

	/**
	*
	* @param undefined $id
	*
	*/
	function admin_edit($slider_id = null)
	{
		$this->set('title_for_layout',__d(__SLIDER_LOCALE,'edit_slider'));
		$this->Slider->id = $slider_id;
		if(!$this->Slider->exists()){
			$this->Session->setFlash(__('invalid_id_for_slider'));
			return;
		}

		if($this->request->is('post') || $this->request->is('put')){

			$datasource = $this->Slider->getDataSource();
			try
			{
				$datasource->begin();

				$this->Slider->Slidertranslation->recursive = - 1;
				$options = array();
				$options['fields'] = array(
					'Slidertranslation.image'
				);
				$options['conditions'] = array(
					"Slidertranslation.slider_id"=> $slider_id,
					"Slidertranslation.language_id"=>$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
				);

				$slidertranslation = $this->Slider->Slidertranslation->find('first',$options);


				$User_Info = $this->Session->read('AdminUser_Info');

				//$this->request->data['Slider']['status'] = 0;

				$this->request->data['Slider']['id'] = $slider_id;
				$this->request->data = Sanitize::clean($this->request->data);
				$data = Sanitize::clean($this->request->data);

				$file = $data['Slidertranslation']['image'];

				if($file['size'] > 0)
				{
					$output = $this->_slider_picture();
					if(!$output['error']){
						$cover_image = $output['filename'];
					}
					else
					{
						$cover_image = '';
					}
				}
				elseif (empty($slidertranslation)) $cover_image = null; else  $cover_image = $slidertranslation['Slidertranslation']['image'];
				$this->request->data['Slider']['user_id'] = $User_Info['id'];

				if(!$this->Slider->save($this->request->data))
					throw new Exception(__d(__SLIDER_LOCALE,'the_slider_could_not_be_saved'));


				$this->Slider->Slidertranslation->recursive = - 1;
				$options = array();
				$options['conditions'] = array(
					"Slidertranslation.slider_id"=> $slider_id,
					"Slidertranslation.language_id"=>$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
				);
				$count = $this->Slider->Slidertranslation->find('count',$options);
				/*
				* @slider translate
				*/
				if($count==0){
					$this->Slider->Slidertranslation->recursive = - 1;
					$this->request->data['Slidertranslation']['slider_id'] = $slider_id;
					$this->request->data['Slidertranslation']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
					$this->request->data['Slidertranslation']['title'] = trim($this->request->data['Slidertranslation']['title']);
					$this->request->data['Slidertranslation']['detail'] = trim($this->request->data['Slidertranslation']['detail']);
					$this->request->data['Slidertranslation']['image'] = $cover_image;
					$this->Slider->Slidertranslation->create();
					if(!$this->Slider->Slidertranslation->save($this->request->data))
						throw new Exception(__d(__SLIDER_LOCALE,'the_slider_could_not_be_saved'));
				}else
				{
					$ret= $this->Slider->Slidertranslation->updateAll(
					    array('Slidertranslation.title' =>'"'.trim($this->request->data['Slidertranslation']['title']).'"',
					          'Slidertranslation.detail' =>'"'.trim($this->request->data['Slidertranslation']['detail']) .'"',
					          'Slidertranslation.url' =>'"'.trim($this->request->data['Slidertranslation']['url']) .'"',
							  'Slidertranslation.image' =>'"'.$cover_image.'"'
							  ),
		    			array('Slidertranslation.slider_id'=>$slider_id,'language_id'=>$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID))

					  );
					if(!$ret){

						throw new Exception(__d(__SLIDER_LOCALE,'the_slider_could_not_be_saved'));
					}
				}
				/*
				* slider translate
				*/

				$datasource->commit();

				if($file['size'] > 0 && $count > 0)
				{
					@unlink(__SLIDER_IMAGE_PATH."/".$slidertranslation['Slidertranslation']['image']);
				}

				$this->Redirect->flashSuccess(__d(__SLIDER_LOCALE,'the_slider_has_been_saved'),array('action'=>'index'));

			} catch(Exception $e)
			{
				$datasource->rollback();
				if($file['size'] > 0)
				{
					@unlink(__SLIDER_IMAGE_PATH."/".$cover_image);
				}
				$this->Redirect->flashWarning($e->getMessage(),array('action'=>'index'));
			}


		}


		$this->_set_slider($slider_id);

	}


	function admin_manager()
	{

	}

	function admin_delete($id = null)
	{
		$this->Slider->id = $id;
		if(!$this->Slider->exists()){
			$this->Redirect->flashWarning(__d(__SLIDER_LOCALE,'invalid_id_for_slider'),array('action'=>'index'));
		}
		$this->Slider->Slidertranslation->recursive = -1;
		$options['fields'] = array(
			'Slidertranslation.image'
		   );

		$options['conditions'] = array(
			'Slidertranslation.slider_id'=>$id
		);
		$images = $this->Slider->Slidertranslation->find('all',$options);
		if($this->Slider->delete($id)){

			if(!empty($images)){
			 	foreach($images as $img){
					@unlink(__SLIDER_IMAGE_PATH."/".$img['Slidertranslation']['image']);
				}
			 }

			$this->Slider->Slidertranslation->deleteAll(array('Slidertranslation.slider_id'=>$id),FALSE);
			$this->Redirect->flashSuccess(__d(__SLIDER_LOCALE,'delete_slider_success'),array('action'=>'index'));
		}
		else
		{
			$this->Redirect->flashWarning(__d(__SLIDER_LOCALE,'delete_slider_not_success'),array('action'=>'index'));
		}

	}



	function home_slider()
	{
		$this->Slider->recursive = - 1;
		$sliders   = $this->Slider->query("SELECT
			Slider.id,
			Slider.title,
			Slider.little_detail,
			Slider.image
			from sliders as Slider
			WHERE Slider.status = 1			 
			ORDER BY Slider.pinsts desc , Slider.id desc
			limit 0,10");

		return $sliders;
	}



	function main_page_sliders()
	{


		$this->Slider->recursive = - 1;
		$sliders   = $this->Slider->query("SELECT
			Slider.id,
			Slider.title,
			Slider.little_detail,
			Slider.image
			from sliders as Slider
			WHERE Slider.status = 1
			ORDER BY Slider.id desc
			limit 0,3");

		$this->set(compact('sliders'));


		$options = array();
		$options['conditions'] = array(
			'Slider.status '=> 1
		);
		return $sliders;
	}



}
?>
