<?php


App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class ProjectcategoriesController extends ProjectAppController {

/*public function beforeFilter() {
	parent::beforeFilter();
	$this->Auth->allow('view','get_child_projectcategories');
}*/

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Projectcategories';
	public $helpers = array('AdminHtml'=>array('action'=>'Projectcategory'));

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

/**
 * Displays a view
 *
 * @param mixed What project_category to display
 * @return void
 */

 function admin_index()
	{
		$this->set('title_for_layout',__d(__PROJECT_LOCALE,'category_list'));
		if(isset($_REQUEST['filter'])){
			$limit = $_REQUEST['filter'];
		}else $limit = 10;
				
		$projectcategories = $this->_indexgetCategories(0);
		$this->set(compact('projectcategories'));
	}
	
	
  function admin_add(){
  	$this->set('title_for_layout',__d(__PROJECT_LOCALE,'add_category'));
	if($this->request->is('post'))
		{				
			
			$data = Sanitize::clean($this->request->data);
			 
			$file = $data['Projectcategory']['image'];
		 
			if($file['size'] > 0)
			{
				$output = $this->_categoty_picture();
				if(!$output['error']){
					$cover_image = $output['filename'];
				}
				else
				{
					$cover_image = '';
				}
			}
			else 	$cover_image = "";
			
			$this->request->data['Projectcategory']['image'] = $cover_image;
			$this->Projectcategory->create();
			if($this->Projectcategory->save($this->request->data))
			{				
				$this->Redirect->flashSuccess(__d(__PROJECT_LOCALE,'the_project_category_has_been_saved'),array('action'=>'index'));
			}
			else
			{				
				@unlink(__PROJECT_IMAGE_PATH."/".$cover_image);
				@unlink(__PROJECT_IMAGE_PATH."/".__UPLOAD_THUMB."/".$cover_image);
				$this->Redirect->flashWarning(__d(__PROJECT_LOCALE,'the_project_category_could_not_be_saved'),array('action'=>'index'));
			}
		}		
		 $projectcategories = $this->Projectcategory->_getCategories(0);
		 $this->set(compact('projectcategories'));
  }	
  
  
  function _categoty_picture()
	{
		App::uses('Sanitize', 'Utility');

		$output = array();
		$data = Sanitize::clean($this->request->data);
		$file = $data['Projectcategory']['image'];

		if($file['size'] > 0){
			$ext      = $this->Httpupload->get_extension($file['name']);
			$filename = md5(rand().$_SERVER['REMOTE_ADDR']);
			if(file_exists(__PROJECT_IMAGE_PATH.$filename.'.'.$ext))                
				$filename = md5(rand().$_SERVER[REMOTE_ADDR]);

			$this->Httpupload->setmodel('Projectcategory');
			$this->Httpupload->setuploaddir(__PROJECT_IMAGE_PATH);
			$this->Httpupload->setuploadname('image');
			$this->Httpupload->settargetfile($filename.'.'.$ext);
			$this->Httpupload->setmaxsize(__UPLOAD_IMAGE_MAX_SIZE);
			//$this->Httpupload->create_thumb = true;
			$this->Httpupload->thumb_folder = __UPLOAD_THUMB;
			$this->Httpupload->thumb_width = 200;
			$this->Httpupload->thumb_height = 200;
			$this->Httpupload->setimagemaxsize(__UPLOAD_IMAGE_MAX_WIDTH,__UPLOAD_IMAGE_MAX_HEIGHT);
			$this->Httpupload->allowExt = __UPLOAD_IMAGE_EXTENSION;
			if(!$this->Httpupload->upload()){
				return array('error'   =>true,'filename'=>'','message' =>$this->Httpupload->get_error());
			}
			$filename .= '.'.$ext;

		}
		return array('error'   =>false,'filename'=>$filename);
	}


	function admin_edit($id = null)
	{
		$this->set('title_for_layout',__d(__PROJECT_LOCALE,'edit_category'));
		$this->Projectcategory->id = $id;
		if(!$this->Projectcategory->exists())
		{
			$this->Redirect->flashWarning(__d(__PROJECT_LOCALE,'invalid_id_for_project_category'),array('action'=>'index'));
		}	
			
		if($this->request->is('post') || $this->request->is('put'))
		{			
			
			$this->Projectcategory->recursive = - 1;
			$options = array();
			$options['fields'] = array(
				'Projectcategory.id',
				'Projectcategory.title',
				'Projectcategory.image'
			);
			$options['conditions'] = array(
				"Projectcategory.id"=> $id
			);

			$categotry  = $this->Projectcategory->find('first',$options);
			
			$data = Sanitize::clean($this->request->data);

			$file = $data['Projectcategory']['image'];

			if($file['size'] > 0)
			{
				$output = $this->_categoty_picture();
				if(!$output['error']){
					$cover_image = $output['filename'];
				}
				else
				{
					$cover_image = '';
				}
			}
			else $cover_image = $categotry['Projectcategory']['image'];
			$this->request->data['Projectcategory']['image'] = $cover_image;
			
			if($this->Projectcategory->save($this->request->data))
			{
				if($file['size'] > 0)
				{
					@unlink(__PROJECT_IMAGE_PATH."/".$categotry['Projectcategory']['image']);
					@unlink(__PROJECT_IMAGE_PATH."/".__UPLOAD_THUMB."/".$categotry['Projectcategory']['image']);
				}
				$this->Redirect->flashSuccess(__d(__PROJECT_LOCALE,'the_project_category_has_been_saved'),array('action'=>'index'));
			}
			else
			{
			   @unlink(__PROJECT_IMAGE_PATH."/".$cover_image);
			   @unlink(__PROJECT_IMAGE_PATH."/".__UPLOAD_THUMB."/".$cover_image);
			   $this->Redirect->flashWarning(__d(__PROJECT_LOCALE,'the_project_category_could_not_be_saved'),array('action'=>'index'));
			}
		}		

		$options = array('conditions' => array('Projectcategory.' . $this->Projectcategory->primaryKey=> $id));
		$this->request->data = $this->Projectcategory->find('first', $options);
		//$this->set($category,$this->request->data);
		$projectcategories = $this->Projectcategory->_getCategories(0);
		$this->set(compact('projectcategories'));		
	}	

function admin_delete($id = null){		
		$this->Projectcategory->id = $id;
		if(!$this->Projectcategory->exists())
		{
			$this->Redirect->flashWarning(__d(__PROJECT_LOCALE,'invalid_id_for_project_category'),array('action'=>'index'));
		}
		$this->Projectcategory->Project->recursive = -1;
        
        $options['conditions'] = array(
			'Project.project_category_id' => $id
		);
		$count = $this->Projectcategory->Project->find('count',$options);
		if($count>0){  
			$this->Redirect->flashWarning(__d(__PROJECT_LOCALE,'invalid_id_for_project_category'),array('action'=>'index'));
        }
    	$category = $this->Projectcategory->findById($id);			
		if($this->Projectcategory->delete($id))
		{			
			@unlink(__PROJECT_IMAGE_PATH."/".$category['Projectcategory']['image']);
			@unlink(__PROJECT_IMAGE_PATH."/".__UPLOAD_THUMB."/".$category['Projectcategory']['image']);
			$this->Redirect->flashSuccess(__d(__PROJECT_LOCALE,'delete_project_category_success'),array('action'=>'index'));
		}else
		{
			$this->Redirect->flashWarning(__d(__PROJECT_LOCALE,'delete_project_category_not_success'),array('action'=>'index'));
		}
  }
		
	
/**
 * get all childeren of category
 * @param undefined $parent_id
 * 
*/ 
  public function _indexgetCategories($parent_id) {	
    $this->Projectcategory->recursive = -1;
	$category_data = array();		
	$query=	$this->Projectcategory->find('all',array('conditions' => array('parent_id' => $parent_id)));

			foreach ($query as $result) {
				$category_data[] = array(
					'id'    => $result['Projectcategory']['id'],
					'arrangment'    => $result['Projectcategory']['arrangment'],
					'status'    => $result['Projectcategory']['status'],
					'created'    => $result['Projectcategory']['created'],
					'title' => $this->_indexgetPath($result['Projectcategory']['id'],'title'),
					'slug' => $this->_indexgetPath($result['Projectcategory']['id'],'slug')
					 
				);
	         $category_data = array_merge($category_data, $this->_indexgetCategories($result['Projectcategory']['id']));
			}	
		return $category_data;
	}
/**
* get name from category
* @param undefined $category_id
* 
*/	
 public function _indexgetPath($category_id,$title) {
		$query=	$this->Projectcategory->find('all',array('conditions' => array('id' => $category_id)));

		foreach ($query as $category_info) {
		if ($category_info['Projectcategory']['parent_id']) {
			return $this->_indexgetPath($category_info['Projectcategory']['parent_id'],$title) .
			 " > " .$category_info['Projectcategory'][$title];			 
		} else {
			return $category_info['Projectcategory'][$title];
		}
		}
}	
	
	
function get_main_projectcategories()
{
	$options['fields'] = array(
			'Projectcategory.id',
			'Projectcategory.parent_id',
			'Projectcategory.title as title'
		);
	$options['conditions'] = array(
		'Projectcategory.status'=>1,
		'Projectcategory.parent_id'=>0
	);
	$options['order'] = array(
		'Projectcategory.arrangment'=>'asc'
	);
	$projectcategories = $this->Projectcategory->find('all',$options);
	return $projectcategories;
}	
	
function get_child_projectcategories($id=null)
{
	$options['fields'] = array(
			'Projectcategory.id',
			'Projectcategory.title as title'
		);
	$options['conditions'] = array(
		'Projectcategory.status'=>1 ,
		'Projectcategory.parent_id'=>$id
	);
	$options['order'] = array(
		'Projectcategory.arrangment'=>'asc'
	);
	$projectcategories = $this->Projectcategory->find('all',$options);
	return $projectcategories;
}	


 	
	
	
}
?>