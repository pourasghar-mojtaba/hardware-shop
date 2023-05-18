<?php


App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class ProductcategoriesController extends ProductAppController
{

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('view','get_child_productcategories','getcategories');
	}

	/**
	 * Controller name
	 *
	 * @var string
	 */
	public $name = 'Productcategories';
	public $helpers = array('AdminHtml' => array('action' => 'Productcategory'));

	/**
	 * This controller does not use a model
	 *
	 * @var array
	 */
	public $uses = array();

	/**
	 * Displays a view
	 *
	 * @param mixed What product_category to display
	 * @return void
	 */

	public
	function getcategories($parent_id)
	{
		$options = array();
		$this->Productcategory->recursive = -1;
		$options['fields'] = array(
			'Productcategorytranslation.title',
			'Productcategory.id',
			'Productcategory.slug',
			'Productcategory.parent_id',
		);
		$options['joins'] = array(
			array('table' => 'productcategorytranslations',
				'alias' => 'Productcategorytranslation',
				'type' => 'inner',
				'conditions' => array(
					'Productcategory.id = Productcategorytranslation.product_category_id'
				)
			),
			array('table' => 'languages',
				'alias' => 'CatLanguage',
				'type' => 'inner',
				'conditions' => array(
					'CatLanguage.id = Productcategorytranslation.language_id'
				)
			)
		);
		$options['conditions'] = array(
			'Productcategory.status' => 1,
			'CatLanguage.code' => $this->Session->read('Config.language'),
			'parent_id'=> $parent_id
		);
		$query = $this->Productcategory->find('all',$options);

		return $query;
	}

	function admin_index()
	{
		$this->set('title_for_layout', __d(__PRODUCT_LOCALE, 'category_list'));
		if (isset($_REQUEST['filter'])) {
			$limit = $_REQUEST['filter'];
		} else $limit = 10;

		$productcategories = $this->_indexgetCategories(0);
		$this->set(compact('productcategories'));
	}


	function admin_add()
	{
		$this->set('title_for_layout', __d(__PRODUCT_LOCALE, 'add_category'));
		if ($this->request->is('post')) {

			$data = Sanitize::clean($this->request->data);

			$file = $data['Productcategory']['image'];

			if ($file['size'] > 0) {
				$output = $this->_categoty_picture();
				if (!$output['error']) {
					$cover_image = $output['filename'];
				} else {
					$cover_image = '';
				}
			} else    $cover_image = "";

			$this->request->data['Productcategory']['image'] = $cover_image;
			$this->Productcategory->create();
			if ($this->Productcategory->save($this->request->data)) {
				$product_category_id = $this->Productcategory->getLastInsertID();
				$this->Productcategory->Productcategorytranslation->recursive = -1;

				$this->request->data['Productcategorytranslation']['product_category_id'] = $product_category_id;
				$this->request->data['Productcategorytranslation']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
				$this->request->data['Productcategorytranslation']['title'] = trim($this->request->data['Productcategorytranslation']['title']);
				$this->Productcategory->Productcategorytranslation->create();
				if ($this->Productcategory->Productcategorytranslation->save($this->request->data))
					$this->Redirect->flashSuccess(__d(__PRODUCT_LOCALE, 'the_product_category_has_been_saved'), array('action' => 'index'));
				else
					$this->Redirect->flashWarning(__d(__PRODUCT_LOCALE, 'the_product_category_could_not_be_saved'), array('action' => 'index'));
			} else {
				@unlink(__PRODUCT_IMAGE_PATH . "/" . $cover_image);
				@unlink(__PRODUCT_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $cover_image);
				$this->Redirect->flashWarning(__d(__PRODUCT_LOCALE, 'the_product_category_could_not_be_saved'), array('action' => 'index'));
			}
		}
		$productcategories = $this->Productcategory->_getCategories(0, $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID));
		$this->set(compact('productcategories'));
	}


	function _categoty_picture()
	{
		App::uses('Sanitize', 'Utility');

		$output = array();
		$data = Sanitize::clean($this->request->data);
		$file = $data['Productcategory']['image'];

		if ($file['size'] > 0) {
			$ext = $this->Httpupload->get_extension($file['name']);
			$filename = md5(rand() . $_SERVER['REMOTE_ADDR']);
			if (file_exists(__PRODUCT_IMAGE_PATH . $filename . '.' . $ext))
				$filename = md5(rand() . $_SERVER[REMOTE_ADDR]);

			$this->Httpupload->setmodel('Productcategory');
			$this->Httpupload->setuploaddir(__PRODUCT_IMAGE_PATH);
			$this->Httpupload->setuploadname('image');
			$this->Httpupload->settargetfile($filename . '.' . $ext);
			$this->Httpupload->setmaxsize(__UPLOAD_IMAGE_MAX_SIZE);
			//$this->Httpupload->create_thumb = true;
			$this->Httpupload->thumb_folder = __UPLOAD_THUMB;
			$this->Httpupload->thumb_width = 200;
			$this->Httpupload->thumb_height = 200;
			$this->Httpupload->setimagemaxsize(__UPLOAD_IMAGE_MAX_WIDTH, __UPLOAD_IMAGE_MAX_HEIGHT);
			$this->Httpupload->allowExt = __UPLOAD_IMAGE_EXTENSION;
			if (!$this->Httpupload->upload()) {
				return array('error' => true, 'filename' => '', 'message' => $this->Httpupload->get_error());
			}
			$filename .= '.' . $ext;

		}
		return array('error' => false, 'filename' => $filename);
	}


	function admin_edit($id = null)
	{
		$this->set('title_for_layout', __d(__PRODUCT_LOCALE, 'edit_category'));
		$this->Productcategory->id = $id;
		if (!$this->Productcategory->exists()) {
			$this->Redirect->flashWarning(__d(__PRODUCT_LOCALE, 'invalid_id_for_product_category'), array('action' => 'index'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {

			$this->Productcategory->recursive = -1;
			$options = array();
			$options['fields'] = array(
				'Productcategory.id',
				'Productcategory.image'
			);
			$options['conditions'] = array(
				"Productcategory.id" => $id
			);

			$categotry = $this->Productcategory->find('first', $options);

			$data = Sanitize::clean($this->request->data);

			$file = $data['Productcategory']['image'];

			if ($file['size'] > 0) {
				$output = $this->_categoty_picture();
				if (!$output['error']) {
					$cover_image = $output['filename'];
				} else {
					$cover_image = '';
				}
			} else $cover_image = $categotry['Productcategory']['image'];
			$this->request->data['Productcategory']['image'] = $cover_image;

			if ($this->Productcategory->save($this->request->data)) {


				$this->Productcategory->Productcategorytranslation->recursive = - 1;
				$options = array();
				$options['conditions'] = array(
					"Productcategorytranslation.product_category_id"=> $id,
					"Productcategorytranslation.language_id"=>$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
				);
				$count = $this->Productcategory->Productcategorytranslation->find('count',$options);
				/*
				* @blog translate
				*/
				if($count==0){
					$this->Productcategory->Productcategorytranslation->recursive = - 1;
					$this->request->data['Productcategorytranslation']['product_category_id'] = $id;
					$this->request->data['Productcategorytranslation']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
					$this->request->data['Productcategorytranslation']['title'] = trim($this->request->data['Productcategorytranslation']['title']);
					$this->Productcategory->create();
					if(!$this->Productcategory->Productcategorytranslation->save($this->request->data))
						$this->Redirect->flashWarning(__d(__PRODUCT_LOCALE, 'the_product_category_could_not_be_saved'), array('action' => 'index'));
				}else
				{
					$ret= $this->Productcategory->Productcategorytranslation->updateAll(
						array('Productcategorytranslation.title' =>'"'.trim($this->request->data['Productcategorytranslation']['title']).'"'
						),
						array('Productcategorytranslation.product_category_id'=>$id,'language_id'=>$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID))
					);
					if(!$ret){
						$this->Redirect->flashWarning(__d(__PRODUCT_LOCALE, 'the_product_category_could_not_be_saved'), array('action' => 'index'));
					}
				}
				/*
				* blog translate
				*/

				if ($file['size'] > 0) {
					@unlink(__PRODUCT_IMAGE_PATH . "/" . $categotry['Productcategory']['image']);
					@unlink(__PRODUCT_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $categotry['Productcategory']['image']);
				}
				$this->Redirect->flashSuccess(__d(__PRODUCT_LOCALE, 'the_product_category_has_been_saved'), array('action' => 'index'));
			} else {
				@unlink(__PRODUCT_IMAGE_PATH . "/" . $cover_image);
				@unlink(__PRODUCT_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $cover_image);
				$this->Redirect->flashWarning(__d(__PRODUCT_LOCALE, 'the_product_category_could_not_be_saved'), array('action' => 'index'));
			}
		}

		//$options = array('conditions' => array('Productcategory.' . $this->Productcategory->primaryKey => $id));

		$options = array();
		$options['fields'] = array(
			'Productcategory.id',
			'Productcategory.arrangment',
			'Productcategory.status',
			'Productcategory.image',
			'Productcategory.parent_id',
			'Productcategory.created',
			'Productcategorytranslation.title',
			'Productcategory.slug',
		);
		$options['joins'] = array(
			array('table' => 'productcategorytranslations',
				'alias' => 'Productcategorytranslation',
				'type' => 'left',
				'conditions' => array(
					'Productcategory.id = Productcategorytranslation.product_category_id',
					"Productcategorytranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
				)
			)
		);

		$options['conditions'] = array(
			"Productcategory.id" => $id,
		);


		$this->request->data = $this->Productcategory->find('first', $options);
		//$this->set($category,$this->request->data);
		$productcategories = $this->Productcategory->_getCategories(0, $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID));
		$this->set(compact('productcategories'));
	}

	function admin_delete($id = null)
	{
		$this->Productcategory->id = $id;
		if (!$this->Productcategory->exists()) {
			$this->Redirect->flashWarning(__d(__PRODUCT_LOCALE, 'invalid_id_for_product_category'), array('action' => 'index'));
		}
		$this->Productcategory->Product->recursive = -1;

		$options['conditions'] = array(
			'Product.product_category_id' => $id
		);
		$count = $this->Productcategory->Product->find('count', $options);
		if ($count > 0) {
			$this->Redirect->flashWarning(__d(__PRODUCT_LOCALE, 'invalid_id_for_product_category'), array('action' => 'index'));
		}
		$category = $this->Productcategory->findById($id);
		if ($this->Productcategory->delete($id)) {
			$this->Productcategory->Productcategorytranslation->deleteAll(array('Productcategorytranslation.product_category_id' => $id), false);
			@unlink(__PRODUCT_IMAGE_PATH . "/" . $category['Productcategory']['image']);
			@unlink(__PRODUCT_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $category['Productcategory']['image']);
			$this->Redirect->flashSuccess(__d(__PRODUCT_LOCALE, 'delete_product_category_success'), array('action' => 'index'));
		} else {
			$this->Redirect->flashWarning(__d(__PRODUCT_LOCALE, 'delete_product_category_not_success'), array('action' => 'index'));
		}
	}


	/**
	 * get all childeren of category
	 * @param undefined $parent_id
	 *
	 */
	public function _indexgetCategories($parent_id)
	{
		$this->Productcategory->recursive = -1;
		$category_data = array();

		$query=	$this->Productcategory->find('all',array('conditions' => array('parent_id' => $parent_id)));

		foreach ($query as $result) {
			$category_data[] = array(
				'id' => $result['Productcategory']['id'],
				'arrangment' => $result['Productcategory']['arrangment'],
				'status' => $result['Productcategory']['status'],
				'slug' => $result['Productcategory']['slug'],
				'created' => $result['Productcategory']['created'],
				'title' => $this->_indexgetPath($result['Productcategory']['id'], 'title')/*,
				'slug' => $this->_indexgetPath($result['Productcategory']['id'], 'slug')*/

			);
			$category_data = array_merge($category_data, $this->_indexgetCategories($result['Productcategory']['id']));
		}
		return $category_data;
	}

	/**
	 * get name from category
	 * @param undefined $category_id
	 *
	 */
	public function _indexgetPath($category_id, $title)
	{

		$options = array();
		$options['fields'] = array(
			'Productcategory.id',
			'Productcategory.arrangment',
			'Productcategory.status',
			'Productcategory.parent_id',
			'Productcategory.created',
			'Productcategorytranslation.title',
			'Productcategory.slug',
		);
		$options['joins'] = array(
			array('table' => 'productcategorytranslations',
				'alias' => 'Productcategorytranslation',
				'type' => 'left',
				'conditions' => array(
					'Productcategory.id = Productcategorytranslation.product_category_id',
					"Productcategorytranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
				)
			)
		);

		$options['conditions'] = array(
			"Productcategory.id" => $category_id,
		);

		//$query = $this->Productcategory->find('all', array('conditions' => array('id' => $category_id)));
		$query = $this->Productcategory->find('all', $options);

		foreach ($query as $category_info) {
			if ($category_info['Productcategory']['parent_id']) {
				return $this->_indexgetPath($category_info['Productcategory']['parent_id'], $title) .
					" > " . $category_info['Productcategorytranslation'][$title];
			} else {
				return $category_info['Productcategorytranslation'][$title];
			}
		}
	}


	function get_main_productcategories()
	{
		$options['fields'] = array(
			'Productcategory.id',
			'Productcategory.parent_id',
			'Productcategory.title as title'
		);
		$options['conditions'] = array(
			'Productcategory.status' => 1,
			'Productcategory.parent_id' => 0
		);
		$options['order'] = array(
			'Productcategory.arrangment' => 'asc'
		);
		$productcategories = $this->Productcategory->find('all', $options);
		return $productcategories;
	}

	function get_child_productcategories($id = null)
	{
		$options['fields'] = array(
			'Productcategory.id',
			'Productcategory.title as title'
		);
		$options['conditions'] = array(
			'Productcategory.status' => 1,
			'Productcategory.parent_id' => $id
		);
		$options['order'] = array(
			'Productcategory.arrangment' => 'asc'
		);
		$productcategories = $this->Productcategory->find('all', $options);
		return $productcategories;
	}


}

?>
