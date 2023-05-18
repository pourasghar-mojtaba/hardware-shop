<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class CatalogsController extends CatalogAppController {

/*public function beforeFilter() {
	parent::beforeFilter();
	$this->Auth->allow('view','get_child_catalogs');
}*/

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Catalogs';
	public $helpers = array('AdminHtml'=>array('action'=>'Catalog'));

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

/**
 * Displays a view
 *
 * @param mixed What catalog to display
 * @return void
 */

 function admin_index()
	{
		
		$this->set('title_for_layout',__d(__CATALOG_LOCALE,'catalog_list'));
		//$this->Catalog->recursive = - 1;
		if(isset($_REQUEST['filter']))
		{
			$limit = $_REQUEST['filter'];
		}
		else $limit = 10;

		if(isset($this->request->data['Catalog']['search']))
		{
			$this->request->data = Sanitize::clean($this->request->data);
			$this->paginate = array(
				'fields'    =>array(
					'Catalog.id',
					'Catalog.title',
					'Catalog.file',
					'Catalog.arrangment',
					'Catalog.status',
					'Catalog.created'
				),
				'conditions' => array('Catalog.title LIKE'=> '%'.$this->request->data['Catalog']['search'].'%'),
				'limit'     => $limit,
				'order'                          => array(
					'Catalog.id'=> 'desc'
				)
			);
		}
		else
		{
			$this->paginate = array(
				/*'joins'=>array(

				),*/
				'fields'    =>array(
					'Catalog.id',
					'Catalog.title',
					'Catalog.file',
					'Catalog.arrangment',
					'Catalog.status',
					'Catalog.created'
				),
				'limit' => $limit,
				'order'      => array(
					'Catalog.id'=> 'desc'
				)
			);
		}
		$catalogs = $this->paginate('Catalog');
		$this->set(compact('catalogs'));
	}
	
	
  function admin_add(){
  	$this->set('title_for_layout',__d(__CATALOG_LOCALE,'add_catalog'));
	if($this->request->is('post'))
		{				
			
			$data = Sanitize::clean($this->request->data);
			 
			$file = $data['Catalog']['file'];
		 
			if($file['size'] > 0)
			{
				$output = $this->_catalog_file();
				if(!$output['error']){
					$cover_file = $output['filename'];
				}
				else
				{
					$this->Redirect->flashWarning($output['message'],array('action'=>'index'));
					$cover_file = '';
				}
			}
			else 	$cover_file = "";
			
			$this->request->data['Catalog']['file'] = $cover_file;
			$this->Catalog->create();
			if($this->Catalog->save($this->request->data))
			{				
				$this->Redirect->flashSuccess(__d(__CATALOG_LOCALE,'the_catalog_has_been_saved'),array('action'=>'index'));
			}
			else
			{				
				@unlink(__CATALOG_FILE_PATH."/".$cover_file);
				@unlink(__CATALOG_FILE_PATH."/".__UPLOAD_THUMB."/".$cover_file);
				$this->Redirect->flashWarning(__d(__CATALOG_LOCALE,'the_catalog_could_not_be_saved'),array('action'=>'index'));
			}
		}		
		 
  }	
  
  
  function _catalog_file()
	{
		App::uses('Sanitize', 'Utility');

		$output = array();
		$data = Sanitize::clean($this->request->data);
		$file = $data['Catalog']['file'];

		if($file['size'] > 0){
			$ext      = $this->Httpupload->get_extension($file['name']);
			$filename = md5(rand().$_SERVER['REMOTE_ADDR']);
			if(file_exists(__CATALOG_FILE_PATH.$filename.'.'.$ext))                
				$filename = md5(rand().$_SERVER[REMOTE_ADDR]);

			$this->Httpupload->setmodel('Catalog');
			$this->Httpupload->setuploaddir(__CATALOG_FILE_PATH);
			$this->Httpupload->setuploadname('file');
			$this->Httpupload->settargetfile($filename.'.'.$ext);
			$this->Httpupload->setmaxsize(__UPLOAD_FILE_MAX_SIZE);
			$this->Httpupload->allowExt = __UPLOAD_File_EXT;
			if(!$this->Httpupload->upload()){
				return array('error'   =>true,'filename'=>'','message' =>$this->Httpupload->get_error());
			}
			$filename .= '.'.$ext;

		}
		return array('error'   =>false,'filename'=>$filename);
	}


	function admin_edit($id = null)
	{
		$this->set('title_for_layout',__d(__CATALOG_LOCALE,'edit_catalog'));
		$this->Catalog->id = $id;
		if(!$this->Catalog->exists())
		{
			$this->Redirect->flashWarning(__d(__CATALOG_LOCALE,'invalid_id_for_catalog'),array('action'=>'index'));
		}	
			
		if($this->request->is('post') || $this->request->is('put'))
		{			
			
			$this->Catalog->recursive = - 1;
			$options = array();
			$options['fields'] = array(
				'Catalog.id',
				'Catalog.title',
				'Catalog.file'
			);
			$options['conditions'] = array(
				"Catalog.id"=> $id
			);

			$categotry  = $this->Catalog->find('first',$options);
			
			$data = Sanitize::clean($this->request->data);

			$file = $data['Catalog']['file'];

			if($file['size'] > 0)
			{
				$output = $this->_catalog_file();
				 
				if(!$output['error']){
					$cover_file = $output['filename'];
				}
				else
				{
					$cover_file = '';
					$this->Redirect->flashWarning($output['message'],array('action'=>'index'));
				}
			}
			else $cover_file = $categotry['Catalog']['file'];
			$this->request->data['Catalog']['file'] = $cover_file;
			
			if($this->Catalog->save($this->request->data))
			{
				if($file['size'] > 0)
				{
					@unlink(__CATALOG_FILE_PATH."/".$categotry['Catalog']['file']);
					@unlink(__CATALOG_FILE_PATH."/".__UPLOAD_THUMB."/".$categotry['Catalog']['file']);
				}
				$this->Redirect->flashSuccess(__d(__CATALOG_LOCALE,'the_catalog_has_been_saved'),array('action'=>'index'));
			}
			else
			{
			   @unlink(__CATALOG_FILE_PATH."/".$cover_file);
			   @unlink(__CATALOG_FILE_PATH."/".__UPLOAD_THUMB."/".$cover_file);
			   $this->Redirect->flashWarning(__d(__CATALOG_LOCALE,'the_catalog_could_not_be_saved'),array('action'=>'index'));
			}
		}		

		$options = array('conditions' => array('Catalog.' . $this->Catalog->primaryKey=> $id));
		$this->request->data = $this->Catalog->find('first', $options);
		//$this->set($catalog,$this->request->data);
		 		
	}	

function admin_delete($id = null){		
		$this->Catalog->id = $id;
		if(!$this->Catalog->exists())
		{
			$this->Redirect->flashWarning(__d(__CATALOG_LOCALE,'invalid_id_for_catalog'),array('action'=>'index'));
		}

    	$catalog = $this->Catalog->findById($id);			
		if($this->Catalog->delete($id))
		{			
			@unlink(__CATALOG_FILE_PATH."/".$catalog['Catalog']['file']);
			@unlink(__CATALOG_FILE_PATH."/".__UPLOAD_THUMB."/".$catalog['Catalog']['file']);
			$this->Redirect->flashSuccess(__d(__CATALOG_LOCALE,'delete_catalog_success'),array('action'=>'index'));
		}else
		{
			$this->Redirect->flashWarning(__d(__CATALOG_LOCALE,'delete_catalog_not_success'),array('action'=>'index'));
		}
  }
		
	
	
	
function get_main_catalogs()
{
	$options['fields'] = array(
			'Catalog.id',
			'Catalog.parent_id',
			'Catalog.title as title'
		);
	$options['conditions'] = array(
		'Catalog.status'=>1,
		'Catalog.parent_id'=>0
	);
	$options['order'] = array(
		'Catalog.arrangment'=>'asc'
	);
	$catalogs = $this->Catalog->find('all',$options);
	return $catalogs;
}	
		


 	
	
	
}
?>