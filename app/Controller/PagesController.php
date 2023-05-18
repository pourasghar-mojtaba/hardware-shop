<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class PagesController extends AppController
{

	public $components = array('CmsAcl'=>array('allUsers'=>array('about','contact_us')));
	public $uses = array();

	public function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow(array('about','contact_us','service','representative_of_world_famous_brands','pre_purchase_advice','employment','customer_club'));
	 }

	public
	function display()
	{
		$path = func_get_args();

		$count= count($path);
		if(!$count)
		{
			return $this->redirect('/');
		}
		$page             = $subpage          = $title_for_layout = null;

		if(!empty($path[0]))
		{
			$page = $path[0];
		}
		if(!empty($path[1]))
		{
			$subpage = $path[1];
		}
		if(!empty($path[$count - 1]))
		{
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));

		try
		{
			$this->render(implode('/', $path));
		} catch(MissingViewException $e)
		{
			if(Configure::read('debug'))
			{
				throw $e;
			}
			throw new NotFoundException();
		}
	}
	function admin_index()
	{
		//$this->Page->recursive = - 1;
		if(isset($_REQUEST['filter']))
		{
			$limit = $_REQUEST['filter'];
		}
		else $limit = 10;

		$this->paginate = array(
			'fields'=>array(
				'Page.id',
				'Page.title',
				'Page.body',
				'Page.meta',
				'Page.keyword',
				'Page.arrangment',
				'Page.status',
				'Page.created'
			),
			'limit' => $limit,
			'order'  => array(
				'Page.id'=> 'desc'
			)
		);

		$pages = $this->paginate('Page');
		$this->set(compact('pages'));
	}


	function admin_add()
	{
		if($this->request->is('post')){
			$this->Page->create();
			if($this->Page->save($this->request->data)){
				$this->Redirect->flashSuccess(__('the_page_has_been_saved'),array('action'=> 'index'));
			}
			else
			{
				$this->Redirect->flashWarning(__('the_page_could_not_be_saved'),array('action'=> 'index'));
			}
		}

		$pages = $this->_getCategories(0);
		$this->set(compact('pages'));

	}


	function admin_edit($id = null)
	{
		$this->set('title_for_layout',__('edit_page'));
		$this->Page->id = $id;
		if(!$this->Page->exists()){
			$this->Session->setFlash(__('invalid_id_for_page'));
			return;
		}

		if($this->request->is('post') || $this->request->is('put')){
			$this->request->data = Sanitize::clean($this->request->data);

			$ret= $this->Page->updateAll(
			    array('Page.title' =>'"'.$this->request->data['Page']['title'].'"',
					  'Page.body' =>'"'.$this->request->data['Page']['body'].'"'  ),
    			array('Page.id'=>$id,'language_id'=>$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID))

			  );
			if($ret){

				$this->Redirect->flashSuccess(__('the_page_has_been_saved'));
			}
			else
			{
				$this->Redirect->flashWarning(__('the_page_could_not_be_saved'));
			}
		}
		$this->request->data = $this->Page->find('first',array('conditions'=>array('Page.id'=>$id,'language_id'=>$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID))));
	}

	function admin_delete($id = null)
	{
		$this->Page->id = $id;
		if(!$this->Page->exists()){
			$this->Session->setFlash(__('invalid_id_for_page'), 'admin_error');
			$this->redirect(array('action'=> 'index'));
		}

		if($this->Page->delete($id)){
			$this->Session->setFlash(__('delete_page_success'), 'admin_success');
			$this->redirect(array('action'=>'index'));
		}
		else
		{
			$this->Session->setFlash(__('delete_page_not_success'), 'admin_error');
			$this->redirect($this->referer(array('action'=> 'index')));
		}
	}

	public function view($id){

	    $page = $this->Page->_getPageInfo($id);
		$this->set(compact('page'));

		$this->set('title_for_layout',$page['Page']['title']);
		$this->set('description_for_layout',str_replace('#',',',$page['Page']['meta']));
		$this->set('keywords_for_layout',str_replace('#',',',$page['Page']['keyword']) );

	}

	public function service(){

		$page = $this->Page->_getPageInfo(3,$this->Session->read('Config.language'));
		$this->set(compact('page'));

		$this->set('title_for_layout',$page['Page']['title']);
		$this->set('description_for_layout',str_replace('#',',',$page['Page']['meta']));
		$this->set('keywords_for_layout',str_replace('#',',',$page['Page']['keyword']) );

	}

	public function about(){


		$page = $this->Page->_getPageInfo(1,$this->Session->read('Config.language'));
		$this->set(compact('page'));

		$this->set('title_for_layout',$page['Page']['title']);
		$this->set('description_for_layout',str_replace('#',',',$page['Page']['meta']));
		$this->set('keywords_for_layout',str_replace('#',',',$page['Page']['keyword']) );

	}

	public function contact_us(){
		$page = $this->Page->_getPageInfo(2,$this->Session->read('Config.language'));
		$this->set(compact('page'));

		$this->set('title_for_layout',$page['Page']['title']);
		$this->set('description_for_layout',str_replace('#',',',$page['Page']['meta']));
		$this->set('keywords_for_layout',str_replace('#',',',$page['Page']['keyword']) );

	}

	public function representative_of_world_famous_brands(){
		$page = $this->Page->_getPageInfo(4,$this->Session->read('Config.language'));
		$this->set(compact('page'));

		$this->set('title_for_layout',$page['Page']['title']);
		$this->set('description_for_layout',str_replace('#',',',$page['Page']['meta']));
		$this->set('keywords_for_layout',str_replace('#',',',$page['Page']['keyword']) );

	}
	public function employment(){
		$page = $this->Page->_getPageInfo(4,$this->Session->read('Config.language'));
		$this->set(compact('page'));

		$this->set('title_for_layout',$page['Page']['title']);
		$this->set('description_for_layout',str_replace('#',',',$page['Page']['meta']));
		$this->set('keywords_for_layout',str_replace('#',',',$page['Page']['keyword']) );

	}

	public function pre_purchase_advice(){
		$page = $this->Page->_getPageInfo(5,$this->Session->read('Config.language'));
		$this->set(compact('page'));

		$this->set('title_for_layout',$page['Page']['title']);
		$this->set('description_for_layout',str_replace('#',',',$page['Page']['meta']));
		$this->set('keywords_for_layout',str_replace('#',',',$page['Page']['keyword']) );

	}
	public function customer_club(){
		$page = $this->Page->_getPageInfo(6,$this->Session->read('Config.language'));
		$this->set(compact('page'));

		$this->set('title_for_layout',$page['Page']['title']);
		$this->set('description_for_layout',str_replace('#',',',$page['Page']['meta']));
		$this->set('keywords_for_layout',str_replace('#',',',$page['Page']['keyword']) );

	}

}
?>
