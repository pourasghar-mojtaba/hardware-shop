<?php
App::uses('AppController', 'Controller');

class ProductsController extends ProductAppController
{
	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator', 'Httpupload', 'CmsAcl' => array('allUsers' => array('index')));
	public $helpers = array('AdminHtml' => array('action' => 'Product'));

	/**
	 * admin_index method
	 *
	 * @return void
	 */

	public
	function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow(array('view', 'add_to_basket', 'refresh_basket', 'delete_product_from_basket', 'search', 'basket', 'delete_from_basket', 'delete_quantity_basket', 'refresh_basket_preview'));
	}

	public
	function admin_index()
	{
		$this->Product->recursive = -1;
		$this->set('title_for_layout', __d(__PRODUCT_LOCALE, 'product_list'));
		if (isset($_REQUEST['filter'])) {
			$limit = $_REQUEST['filter'];
		} else $limit = 10;

		if (isset($this->request->data['Product']['search'])) {
			$this->request->data = Sanitize::clean($this->request->data);
			$this->paginate = array(
				'fields' => array(
					'Productcategorytranslation.title',
					'Product.id',
					'Producttranslation.title',
					'Producttranslation.mini_detail',
					'Product.status',
					'Product.num',
					'Product.created',
					'(select image from productimages where product_id = Product.id limit 0,1 ) as image'
				),
				'joins' => array(
					array('table' => 'productcategories',
						'alias' => 'Productcategory',
						'type' => 'left',
						'conditions' => array(
							'Product.product_category_id = Productcategory.id ',
						)
					),
					array('table' => 'productcategorytranslations',
						'alias' => 'Productcategorytranslation',
						'type' => 'left',
						'conditions' => array(
							'Productcategory.id = Productcategorytranslation.product_category_id',
							"Productcategorytranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
						)
					),
					array('table' => 'producttranslations',
						'alias' => 'Producttranslation',
						'type' => 'left',
						'conditions' => array(
							'Product.id = Producttranslation.product_id',
							"Producttranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
						)
					)
				),
				'conditions' => array('Producttranslation.title LIKE' => '' . $this->request->data['Product']['search'] . '%'),
				'limit' => $limit,
				'order' => array(
					'Product.id' => 'desc'
				)
			);
		} else {
			$this->paginate = array(
				'fields' => array(
					'Productcategorytranslation.title',
					'Product.id',
					'Producttranslation.title',
					'Producttranslation.mini_detail',
					'Product.status',
					'Product.num',
					'Product.created',
					'(select image from productimages where product_id = Product.id limit 0,1 ) as image'
				),
				'joins' => array(
					array('table' => 'productcategories',
						'alias' => 'Productcategory',
						'type' => 'left',
						'conditions' => array(
							'Product.product_category_id = Productcategory.id ',
						)
					),
					array('table' => 'productcategorytranslations',
						'alias' => 'Productcategorytranslation',
						'type' => 'left',
						'conditions' => array(
							'Productcategory.id = Productcategorytranslation.product_category_id',
							"Productcategorytranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
						)
					),
					array('table' => 'producttranslations',
						'alias' => 'Producttranslation',
						'type' => 'left',
						'conditions' => array(
							'Product.id = Producttranslation.product_id',
							"Producttranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
						)
					)
				),
				'limit' => $limit,
				'order' => array(
					'Product.id' => 'desc'
				)
			);
		}
		$products = $this->paginate('Product');
		$this->set(compact('products'));
	}


	/**
	 * admin_add method
	 *
	 * @return void
	 */
	public
	function admin_add()
	{
		$this->set('title_for_layout', __d(__PRODUCT_LOCALE, 'add_product'));
		if ($this->request->is('post')) {

			$datasource = $this->Product->getDataSource();
			try {
				$datasource->begin();
				$this->request->data['Product']['price'] = str_replace(',', '', $this->request->data['Product']['price']);
				if (!$this->Product->save($this->request->data))
					throw new Exception(__d(__PRODUCT_LOCALE, 'the_product_could_not_be_saved_Please_try_again'));
				$product_id = $this->Product->getLastInsertID();

				$Propertiesdata = array();

				foreach ($this->request->data['Productproperty']['property_id'] as $key => $value) {
					$Propertiesdata[] = array(
						'product_id' => $product_id,
						'property_id' => $this->request->data['Productproperty']['property_id'][$key],
						'property_value' => $this->request->data['Productproperty']['property_value'][$key]
					);
				}

				if (!$this->Product->Productproperty->saveMany($Propertiesdata, array('deep' => true)))
					throw new Exception(__d(__PRODUCT_LOCALE, 'the_product_could_not_be_saved'));

				/** @product translate */

				$this->Product->Producttranslation->recursive = -1;
				$this->request->data['Producttranslation']['product_id'] = $product_id;
				$this->request->data['Producttranslation']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
				$this->request->data['Producttranslation']['title'] = trim($this->request->data['Producttranslation']['title']);
				$this->request->data['Producttranslation']['mini_detail'] = trim($this->request->data['Producttranslation']['mini_detail']);
				$this->request->data['Producttranslation']['detail'] = trim($this->request->data['Producttranslation']['detail']);
				$this->Product->Producttranslation->create();

				if (!$this->Product->Producttranslation->save($this->request->data))
					throw new Exception(__d(__PRODUCT_LOCALE, 'the_product_could_not_be_saved'));

				/** product translate */


				if (!empty($this->request->data['Productimage']['image'])) {

					foreach ($this->request->data['Productimage']['image'] as $key => $value) {
						if (trim($value['name']) == '') {
							unset($this->request->data['Productimage']['image'][$key]);
							unset($this->request->data['Productimage']['title'][$key]);
						}
					}
					$data = array();
					$image_list = array();
					foreach ($this->request->data['Productimage']['image'] as $key => $value) {
						$output = $this->_picture($value, $key);
						if (!$output['error']) $image = $output['filename'];
						else {
							$image = '';
							if (!empty($image_list)) {
								foreach ($image_list as $img) {
									@unlink(__PRODUCT_IMAGE_PATH . "/" . $img);
									@unlink(__PRODUCT_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $img);
								}
							}
							throw new Exception($output['message'] . '  ' . __d(__PRODUCT_LOCALE, 'image_name') . ' ' . $value['name']);
						}

						$image_list[] = $image;
						$data = array();
						$data = array('Productimage' => array(
							'image' => $image,
							'product_id' => $product_id
						));

						App::uses('Productimage', __PRODUCT_PLUGIN . '.Model');
						$Productimage = new Productimage();

						if (!$Productimage->save($data))
							throw new Exception(__d(__PRODUCT_LOCALE, 'the_product_image_not_saved'));

						$product_image_id = $Productimage->getLastInsertID();

						$this->loadModel('Productimagetranslation');
						$this->Productimagetranslation->recursive = -1;

						$datatranslate = array('Productimagetranslation' => array(
							'title' => $this->request->data['Productimage']['title'][$key],
							'product_image_id' => $product_image_id,
							'language_id' => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
						));
						$this->Productimagetranslation->create();
						if (!$this->Productimagetranslation->save($datatranslate))
							throw new Exception(__d(__PRODUCT_LOCALE, 'the_product_image_not_saved'));

					}


				}
				//pr($datatranslate);exit();
				/* tags */
				$data = array();
				$dt = array();
				if (isset($_POST['new_tags']) && !empty($_POST['new_tags'])) {
					$tags = $_POST['new_tags'];//explode('#',$this->request->data['Productrelatetag']['tag']);
					$tags = array_filter($tags, 'strlen');
					$this->loadModel('Producttag');
					if (!empty($tags)) {

						foreach ($tags as $tag) {
							$tag = trim($tag);

							$options = array();
							$oldtag = array();

							$options['fields'] = array(
								'Producttag.id',
							);
							$options['conditions'] = array(
								'Producttag.title' => $tag
							);
							$oldtag = $this->Producttag->find('first', $options);

							if (empty($oldtag)) {
								$this->request->data['Producttag']['title'] = $tag;
								$this->request->data['Producttag']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
								$this->Producttag->create();

								if (!$this->Producttag->save($this->request->data)) {
									throw new Exception(__d(__PRODUCT_LOCALE, 'the_product_tag_not_saved'));
								}
								$tag_id[] = $this->Producttag->getLastInsertID();
							} else {
								$tag_id[] = $oldtag['Producttag']['id'];
							}

						}
					}

				}

				$data = array();
				if (isset($this->request->data['Productrelatetag']['product_tag_id'])) {
					foreach ($this->request->data['Productrelatetag']['product_tag_id'] as $tagid) {
						$dt = array('Productrelatetag' => array('product_id' => $product_id, 'product_tag_id' => $tagid, 'language_id' => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)));
						array_push($data, $dt);
					}
				}

				if (!empty($tag_id)) {
					foreach ($tag_id as $tid) {
						$dt = array('Productrelatetag' => array('product_id' => $product_id, 'product_tag_id' => $tid, 'language_id' => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)));
						array_push($data, $dt);
					}

				}

				if (!empty($this->request->data['Productrelatetag']['product_tag_id']) || !empty($tag_id)) {
					$this->Product->Productrelatetag->create();
					if (!$this->Product->Productrelatetag->saveMany($data))
						throw new Exception(__d(__PRODUCT_LOCALE, 'the_product_tag_not_saved'));
				}
				/* tags*/


				$datasource->commit();

				$this->Redirect->flashSuccess(__d(__PRODUCT_LOCALE, 'the_product_has_been_saved'), array('action' => 'index'));
			} catch (Exception $e) {
				$datasource->rollback();
				$this->Redirect->flashWarning($e->getMessage(), array('action' => 'index'));
			}

		}
		$this->loadModel(__PRODUCT_PLUGIN . '.Productcategory');
		$productcategories = $this->Productcategory->_getCategories(0, $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID));
		$this->set(compact('productcategories'));
		$this->_getProperties();
	}


	public function _getProperties()
	{

		$this->loadModel('Property');
		$this->Property->recursive = -1;

		$options['fields'] = array(
			'Property.id',
			'Property.name'
		);

		$options['order'] = array(
			'Property.id' => 'asc'
		);

		$properties = $this->Property->find('all', $options);
		$this->set('properties', $properties);

		$this->loadModel('Propertydetail');
		$this->Propertydetail->recursive = -1;

		$options['fields'] = array(
			'Propertydetail.id',
			'Propertydetail.property_id',
			'Propertydetail.value'
		);

		$options['order'] = '';

		$propertydetails = $this->Propertydetail->find('all', $options);
		$this->set('propertydetails', $propertydetails);
	}


	/**
	 * admin_edit method
	 *
	 * @param string $id
	 * @return void
	 * @throws NotFoundException
	 */
	public
	function admin_edit($id = null)
	{
		$this->set('title_for_layout', __d(__PRODUCT_LOCALE, 'edit_product'));
		if (!$this->Product->exists($id)) {
			$this->Redirect->flashWarning(__d(__PRODUCT_LOCALE, 'invalid_product'));
		}
		if ($this->request->is(array('post', 'put'))) {

			$this->loadModel('Productimagetranslation');
			$this->Productimagetranslation->recursive = -1;

			$datasource = $this->Product->getDataSource();
			try {
				$datasource->begin();

				$this->request->data['Product']['price'] = str_replace(',', '', $this->request->data['Product']['price']);
				if (!$this->Product->save($this->request->data))
					throw new Exception(__d(__PRODUCT_LOCALE, 'the_product_could_not_be_saved_Please_try_again'));



				$this->Product->Producttranslation->recursive = -1;
				$options = array();
				$options['fields'] = array(
					'Producttranslation.id',
				);
				$options['conditions'] = array(
					"Producttranslation.product_id" => $id,
					"Producttranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
				);

				$Producttranslation = $this->Product->Producttranslation->find('first', $options);

				/*
				* @product translate
				*/

				if (empty($Producttranslation)) {
					$this->Product->Producttranslation->recursive = -1;
					$this->request->data['Producttranslation']['product_id'] = $id;
					$this->request->data['Producttranslation']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
					$this->request->data['Producttranslation']['title'] = trim($this->request->data['Producttranslation']['title']);
					$this->request->data['Producttranslation']['mini_detail'] = trim($this->request->data['Producttranslation']['mini_detail']);
					$this->request->data['Producttranslation']['detail'] = trim($this->request->data['Producttranslation']['detail']);
					$this->Product->create();
					if (!$this->Product->Producttranslation->save($this->request->data))
						throw new Exception(__d(__PRODUCT_LOCALE, 'the_product_could_not_be_saved'));
				} else {
					$this->request->data['Producttranslation']['id'] = $Producttranslation['Producttranslation']['id'];
					$this->request->data['Producttranslation']['title'] = trim($this->request->data['Producttranslation']['title']);
					$this->request->data['Producttranslation']['mini_detail'] = trim($this->request->data['Producttranslation']['mini_detail']);
					$this->request->data['Producttranslation']['detail'] = trim($this->request->data['Producttranslation']['detail']);
					if (!$this->Product->Producttranslation->save($this->request->data))
						throw new Exception(__d(__PRODUCT_LOCALE, 'the_product_could_not_be_saved'));
				}
				//pr($this->request->data['Productproperty']);exit();
				$Propertiesdata = array();
				$i = 0;
				foreach ($this->request->data['Productproperty']['property_id'] as $T) {
					$Propertiesdata[] = array(
						'product_id' => $id,
						'property_id' => $this->request->data['Productproperty']['property_id'][$i],
						'property_value' => $this->request->data['Productproperty']['property_value'][$i]
					);
					$i++;
				}
				$this->Product->Productproperty->deleteAll(array('Productproperty.product_id' => $id));

				if (!$this->Product->Productproperty->saveMany($Propertiesdata, array('deep' => true)))
					throw new Exception(__d(__PRODUCT_LOCALE, 'the_product_could_not_be_saved'));

				// image opration

				$options = array();
				$this->Product->Productimage->recursive = -1;
				$options['fields'] = array(
					'Productimage.id',
					'Productimagetranslation.title',
					'Productimage.image'
				);
				$options['joins'] = array(
					array(
						'table' => 'productimagetranslations',
						'alias' => 'Productimagetranslation',
						'type' => 'left',
						'conditions' => array(
							'Productimage.id = Productimagetranslation.product_image_id ',
							'Productimagetranslation.language_id  = ' . $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID),
						)
					)
				);
				$options['conditions'] = array(
					'Productimage.product_id' => $id
				);
				$productimages = $this->Product->Productimage->find('all', $options);
				//pr($this->request->data);throw new Exception();
				if (!empty($productimages)) {
					foreach ($productimages as $productimage) {
						if (!in_array($productimage['Productimage']['id'], $this->request->data['Productimage']['id'])) {
							if (!$this->Product->Productimage->delete($productimage['Productimage']['id']))
								throw new Exception(__d(__PRODUCT_LOCALE, 'the_product_image_not_saved'));
							else {
								@unlink(__PRODUCT_IMAGE_PATH . "/" . $productimage['Productimage']['image']);
								@unlink(__PRODUCT_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $productimage['Productimage']['image']);
							}
						}
					}
				}


				if (!empty($this->request->data['Productimage']['id'])) {
					foreach ($this->request->data['Productimage']['id'] as $key => $value) {

						if ($this->request->data['Productimage']['image'][$key]['size'] > 0) {

							@unlink(__PRODUCT_IMAGE_PATH . "/" . $this->request->data['Productimage']['old_image'][$key]);
							@unlink(__PRODUCT_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $this->request->data['Productimage']['old_image'][$key]);
							$output = $this->_picture($this->request->data['Productimage']['image'][$key], $key);
							if (!$output['error']) $image = $output['filename'];
							else {
								$image = '';
								if (!empty($image_list)) {
									foreach ($image_list as $img) {
										@unlink(__PRODUCT_IMAGE_PATH . "/" . $img);
										@unlink(__PRODUCT_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $img);
									}
								}
								throw new Exception($output['message'] . '  ' . __d(__PRODUCT_LOCALE, 'image_name') . ' ' . $this->request->data['Productimage']['image'][$key]['name']);
							}

							$image_list[] = $image;
						} else $image = $this->request->data['Productimage']['old_image'][$key];

						$ret = $this->Product->Productimage->updateAll(
							array('Productimage.image' => '"' . $image . '"'),   //fields to update
							array('Productimage.id' => $value)  //condition
						);
						if (!$ret) {
							throw new Exception(__d(__PRODUCT_LOCALE, 'the_product_image_not_saved'));
						}

						$this->Productimagetranslation->recursive = -1;
						$options = array();
						$options['conditions'] = array(
							"Productimagetranslation.product_image_id" => $value,
							"Productimagetranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
						);
						$count = $this->Productimagetranslation->find('count', $options);

						if ($count == 0) {
							$ProductimagetranslationData = array();
							$this->Productimagetranslation->recursive = -1;
							$ProductimagetranslationData['Productimagetranslation']['product_image_id'] = $value;
							$ProductimagetranslationData['Productimagetranslation']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
							$ProductimagetranslationData['Productimagetranslation']['title'] = trim($this->request->data['Productimage']['title'][$key]);
							$this->Productimagetranslation->create();

							if (!$this->Productimagetranslation->save($ProductimagetranslationData))
								throw new Exception(__d(__BLOG_LOCALE, 'the_product_could_not_be_saved'));
						} else

							$ret = $this->Productimagetranslation->updateAll(
								array('Productimagetranslation.title' => '"' . $this->request->data['Productimage']['title'][$key] . '"'
								),   //fields to update
								array('Productimagetranslation.product_image_id' => $value, 'Productimagetranslation.language_id' => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID))  //condition
							);
						if (!$ret) {
							throw new Exception(__d(__PRODUCT_LOCALE, 'the_product_image_not_saved'));
						}


					}
				}


				if (!empty($this->request->data['Productimage']['id'])) {
					foreach ($this->request->data['Productimage']['id'] as $key => $value) {
						unset($this->request->data['Productimage']['title'][$key]);
						unset($this->request->data['Productimage']['image'][$key]);
					}
				}


				$data = array();
				if (!empty($this->request->data['Productimage']['image'])) {

					foreach ($this->request->data['Productimage']['image'] as $key => $value) {
						$output = $this->_picture($value, $key);
						if (!$output['error']) $image = $output['filename'];
						else {
							$image = '';
							if (!empty($image_list)) {
								foreach ($image_list as $img) {
									@unlink(__PRODUCT_IMAGE_PATH . "/" . $img);
									@unlink(__PRODUCT_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $img);
								}
							}
							throw new Exception($output['message'] . '  ' . __d(__PRODUCT_LOCALE, 'image_name') . ' ' . $value['name']);
						}

						$image_list[] = $image;

						$data = array('Productimage' => array(
							'image' => $image,
							'product_id' => $id
						));


						App::uses('Productimage', __PRODUCT_PLUGIN . '.Model');
						$Productimage = new Productimage();

						if (!$Productimage->save($data))
							throw new Exception(__d(__PRODUCT_LOCALE, 'the_product_image_not_saved'));

						$product_image_id = $Productimage->getLastInsertID();

						$datatranslate = array('Productimagetranslation' => array(
							'title' => $this->request->data['Productimage']['title'][$key],
							'product_image_id' => $product_image_id,
							'language_id' => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
						));
						$this->Productimagetranslation->create();
						if (!$this->Productimagetranslation->save($datatranslate))
							throw new Exception(__d(__PRODUCT_LOCALE, 'the_product_image_not_saved'));
					}
					//pr($data);throw new Exception();

				}


				// image opration


				/* tags */
				$data = array();
				$dt = array();
				if (isset($_POST['new_tags']) && !empty($_POST['new_tags'])) {
					$tags = $_POST['new_tags'];//explode('#',$this->request->data['Productrelatetag']['tag']);
					$tags = array_filter($tags, 'strlen');
					$this->loadModel('Producttag');
					if (!empty($tags)) {

						foreach ($tags as $tag) {
							$tag = trim($tag);

							$options = array();
							$oldtag = array();

							$options['fields'] = array(
								'Producttag.id',
							);
							$options['conditions'] = array(
								'Producttag.title' => $tag
							);
							$oldtag = $this->Producttag->find('first', $options);

							if (empty($oldtag)) {

								$this->request->data['Producttag']['title'] = $tag;
								$this->request->data['Producttag']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
								$this->Producttag->create();

								if (!$this->Producttag->save($this->request->data)) {
									throw new Exception(__d(__PRODUCT_LOCALE, 'the_product_tag_not_saved'));
								}
								$tag_id[] = $this->Producttag->getLastInsertID();

							} else {
								$tag_id[] = $oldtag['Producttag']['id'];
							}


						}
					}

				}

				$data = array();
				if (isset($this->request->data['Productrelatetag']['product_tag_id'])) {
					foreach ($this->request->data['Productrelatetag']['product_tag_id'] as $tagid) {
						$dt = array('Productrelatetag' => array('product_id' => $id, 'product_tag_id' => $tagid, 'language_id' => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)));
						array_push($data, $dt);
					}
				}

				if (!empty($tag_id)) {
					foreach ($tag_id as $tid) {
						$dt = array('Productrelatetag' => array('product_id' => $id, 'product_tag_id' => $tid, 'language_id' => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)));
						array_push($data, $dt);
					}

				}

				if (!empty($this->request->data['Productrelatetag']['product_tag_id']) || !empty($tag_id)) {
					$this->Product->Productrelatetag->create();
					if (!$this->Product->Productrelatetag->saveMany($data))
						throw new Exception(__d(__PRODUCT_LOCALE, 'the_product_tag_not_saved'));
				}
				/* tags*/


				$datasource->commit();
				$this->Redirect->flashSuccess(__d(__PRODUCT_LOCALE, 'the_product_has_been_saved'), array('action' => 'index'));

			} catch (Exception $e) {
				$datasource->rollback();
				$this->Redirect->flashWarning($e->getMessage(), array('action' => 'index'));
			}

		} else {
			$this->Product->recursive = -1;

			$options = array();
			$options['fields'] = array(
				'Product.id',
				'Product.product_category_id',
				'Product.slug',
				'Product.num',
				'Product.price',
				'Producttranslation.title',
				'Producttranslation.mini_detail',
				'Producttranslation.detail',
				'Product.status',
				'Product.created'
			);
			$options['joins'] = array(
				array('table' => 'producttranslations',
					'alias' => 'Producttranslation',
					'type' => 'left',
					'conditions' => array(
						'Product.id = Producttranslation.product_id',
						"Producttranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
					)
				)
			);
			$options['conditions'] = array(
				"Product.id" => $id,
			);

			$this->request->data = $this->Product->find('first', $options);
			$this->Product->Productimage->recursive = -1;
			$options = array();
			$options['fields'] = array(
				'Productimage.id',
				'Productimagetranslation.title',
				'Productimage.image'
			);
			$options['joins'] = array(
				array('table' => 'productimagetranslations',
					'alias' => 'Productimagetranslation',
					'type' => 'left',
					'conditions' => array(
						'Productimage.id = Productimagetranslation.product_image_id',
						"Productimagetranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
					)
				)
			);
			$options['conditions'] = array(
				'Productimage.product_id' => $id
			);
			$productimages = $this->Product->Productimage->find('all', $options);
			$this->set('productimages', $productimages);

			$this->Product->Productproperty->recursive = -1;
			$options = array();
			$options['fields'] = array(
				'Productproperty.product_id',
				'Productproperty.property_id',
				'Productproperty.property_value'
			);
			$options['conditions'] = array(
				'Productproperty.product_id' => $id
			);
			$productproperties = $this->Product->Productproperty->find('all', $options);
			$this->set('productproperties', $productproperties);
			$this->_getProperties();
			$options = array();
			$this->Product->Productrelatetag->recursive = -1;
			$options['fields'] = array(
				'Productrelatetag.id',
				'Producttag.title',
				'Producttag.id'
			);
			$options['joins'] = array(
				array('table' => 'producttags',
					'alias' => 'Producttag',
					'type' => 'INNER',
					'conditions' => array(
						'Producttag.id = Productrelatetag.product_tag_id'
					)
				)
			);
			$options['conditions'] = array(
				'Productrelatetag.product_id' => $id,
				'Producttag.language_id' => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
			);
			$productrelatetags = $this->Product->Productrelatetag->find('all', $options);
			$this->set('productrelatetags', $productrelatetags);
		}

		$this->loadModel(__PRODUCT_PLUGIN . '.Productcategory');
		$productcategories = $this->Productcategory->_getCategories(0, $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID));
		$this->set(compact('productcategories'));
	}

	/**
	 * admin_delete method
	 *
	 * @param string $id
	 * @return void
	 * @throws NotFoundException
	 */
	public
	function admin_delete($id = null)
	{
		$this->loadModel('Productimagetranslation');
		$this->Productimagetranslation->recursive = -1;

		$datasource = $this->Product->getDataSource();
		try {
			$datasource->begin();
			$this->Product->id = $id;
			if (!$this->Product->exists())
				throw new Exception(__d(__PRODUCT_LOCALE, 'invalid_product'));

			$this->Product->Productimage->recursive = -1;
			$options['fields'] = array(
				'Productimage.id',
				'Productimage.image'
			);

			$options['conditions'] = array(
				'Productimage.product_id' => $id
			);
			$images = $this->Product->Productimage->find('all', $options);

			$this->Product->Orderitem->recursive = -1;
			$options['conditions'] = array(
				'Orderitem.product_id' => $id
			);
			$count = $this->Product->Orderitem->find('count', $options);
			if ($count > 0)
				throw new Exception(__d(__PRODUCT_LOCALE, 'cant_to_delete_product_in_order'));


			if ($this->Product->delete()) {

				$this->Product->Productimage->deleteAll(array('Productimage.product_id' => $id), false);
				$this->Product->Productdiscount->deleteAll(array('Productdiscount.product_id' => $id), false);
				$this->Product->Productproperty->deleteAll(array('Productproperty.product_id' => $id), false);
				$this->Product->Productrelatetag->deleteAll(array('Productrelatetag.product_id' => $id), false);
				$this->Product->Producttranslation->deleteAll(array('Producttranslation.product_id' => $id), false);

				if (!empty($images)) {
					foreach ($images as $img) {
						$this->loadModel('Productimagetranslation');
						$this->Productimagetranslation->deleteAll(array('Productimagetranslation.product_image_id' => $img['Productimage']['id']), false);
						@unlink(__PRODUCT_IMAGE_PATH . "/" . $img['Productimage']['image']);
						@unlink(__PRODUCT_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $img['Productimage']['image']);
					}
				}
			} else
				throw new Exception(__d(__PRODUCT_LOCALE, 'the_product_could_not_be_deleted_please_try_again'));

			$datasource->commit();
			$this->Redirect->flashSuccess(__d(__PRODUCT_LOCALE, 'the_product_has_been_deleted'), array('action' => 'index'));

		} catch (Exception $e) {
			$datasource->rollback();
			$this->Redirect->flashWarning($e->getMessage(), array('action' => 'index'));
		}
	}


	function _picture($data, $index)
	{
		App::uses('Sanitize', 'Utility');

		$output = array();

		if ($data['size'] > 0) {
			$ext = $this->Httpupload->get_extension($data['name']);
			$filename = md5(rand() . $_SERVER['REMOTE_ADDR']);
			if (file_exists(__PRODUCT_IMAGE_PATH . $filename . '.' . $ext)) $filename = md5(rand() . $_SERVER[REMOTE_ADDR]);

			$this->Httpupload->setmodel('Productimage');
			$this->Httpupload->setuploadindex($index);
			$this->Httpupload->setuploaddir(__PRODUCT_IMAGE_PATH);
			$this->Httpupload->setuploadname('image');
			$this->Httpupload->settargetfile($filename . '.' . $ext);
			$this->Httpupload->setmaxsize(__UPLOAD_IMAGE_MAX_SIZE);
			$this->Httpupload->setimagemaxsize(__UPLOAD_IMAGE_MAX_WIDTH, __UPLOAD_IMAGE_MAX_HEIGHT);
			$this->Httpupload->allowExt = __UPLOAD_IMAGE_EXTENSION;
			$this->Httpupload->create_thumb = true;
			$this->Httpupload->thumb_folder = __UPLOAD_THUMB;
			$this->Httpupload->thumb_width = 180;
			$this->Httpupload->thumb_height = 120;
			if (!$this->Httpupload->upload()) {
				return array('error' => true, 'filename' => '', 'message' => $this->Httpupload->get_error());
			}
			$filename .= '.' . $ext;

		} else return array('error' => true, 'filename' => '', 'message' => '');

		return array('error' => false, 'filename' => $filename);
	}


	function index($category_id)
	{

		$this->Product->Productcategory->recursive = -1;
		$options['fields'] = array(
			'Productcategory.id',
			'Productcategory.title'
		);
		$options['conditions'] = array(
			'Productcategory.id' => $category_id
		);
		$category = $this->Product->Productcategory->find('first', $options);

		$this->set('title_for_layout', __d(__PRODUCT, 'products') . ' ' . $category['Productcategory']['title']);
		$this->set('description_for_layout', $category['Productcategory']['title']);
		$this->set('keywords_for_layout', $category['Productcategory']['title']);

		$options = array();
		$this->Product->recursive = -1;
		$options['fields'] = array(
			'Product.id',
			'Product.title',
			'Product.mini_detail',
			'(select image from productimages where product_id = Product.id limit 0,1)as image'
		);
		$options['conditions'] = array(
			'Product.status' => 1,
			'Product.product_category_id' => $category_id,
		);
		$options['order'] = array(
			'Product.id' => 'desc'
		);
		//$options['limit'] = 5;
		$products = $this->Product->find('all', $options);
		$this->set('products', $products);
	}


	public function search()
	{
		//$this->request->data = Sanitize::clean($this->request->data);

		$itemspp_filter = '';
		$categoryid_filter = '';
		$search_products = '';

		if (!empty($_GET['search']))
			$search_products = Sanitize::clean($_GET['search']);

		if (!empty($_GET['itemspp_filter']))
			$itemspp_filter = Sanitize::clean($_GET['itemspp_filter']);
		if (!empty($_GET['categoryid_filter']))
			$categoryid_filter = Sanitize::clean($_GET['categoryid_filter']);


		$this->set('itemspp_filter', $itemspp_filter);
		$this->set('categoryid_filter', $categoryid_filter);


		$this->loadModel(__PRODUCT_PLUGIN . '.Productcategory');
		$productcategories = $this->Productcategory->_getCategories(0, $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID));
		$this->set('productcategories', $productcategories);
		// ---------------------------------------------------------------
		$_limit = 20;
		if ($itemspp_filter == '1')
			$_limit = 6;


		if (!empty($_REQUEST['page'])) {
			$page = $_REQUEST['page'];
		} else $page = 1;

		if (isset($page)) {
			$first = ($page - 1) * $_limit;
		} else $first = 0;


		$_Order = 'ASC';


		$this->loadModel('Productimage');
		$this->Product->recursive = -1;

		$options['fields'] = array(
			'Product.id',
			'Product.slug',
			'Product.price',
			'Producttranslation.title',
			'(select image from  productimages where product_id = Product.id limit 0,1) as image',
			'Productcategorytranslation.title',
			'Productcategory.id',
			'Discounttype.percent',
			'Discounttype.amount',
		);

		$conditions = array();
		if ($categoryid_filter != '') {
			$categories = $this->Product->Productcategory->_getCategories($categoryid_filter,$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID));
			$ids = array($categoryid_filter);
			if (!empty($categories)) {
				foreach ($categories as $category) {
					$ids[] = $category['id'];
				}
			}

			$conditions = array(
				'OR' => array(
					'Productcategory.id' => $categoryid_filter,
					'Productcategory.id IN' => $ids,
				)

			);
		}



		$options['joins'] = array(
			array(
				'table' => 'productcategories',
				'alias' => 'Productcategory',
				'type' => 'inner',
				'conditions' => array('Product.product_category_id = Productcategory.id')
			),
			array('table' => 'productcategorytranslations',
				'alias' => 'Productcategorytranslation',
				'type' => 'inner',
				'conditions' => array(
					'Productcategory.id = Productcategorytranslation.product_category_id'
				)
			)
		,
			array('table' => 'producttranslations',
				'alias' => 'Producttranslation',
				'type' => 'inner',
				'conditions' => array(
					'Product.id = Producttranslation.product_id'
				)
			)
		,
			array('table' => 'languages',
				'alias' => 'Language',
				'type' => 'inner',
				'conditions' => array(
					'Language.id = Producttranslation.language_id'
				)
			),
			array('table' => 'languages',
				'alias' => 'CatLanguage',
				'type' => 'inner',
				'conditions' => array(
					'CatLanguage.id = Productcategorytranslation.language_id'
				)
			),
			array('table' => 'productdiscounts',
				'alias' => 'Productdiscount',
				'type' => 'left',
				'conditions' => array(
					'Product.id = Productdiscount.product_id'
				)
			),
			array('table' => 'discounttypes',
				'alias' => 'Discounttype',
				'type' => 'left',
				'conditions' => array(
					'Discounttype.id = Productdiscount.discount_type_id'
				)
			)
		);

		$conditions1 = array(
			"Product.status" => 1,
			'Language.code' => $this->Session->read('Config.language'),
			'CatLanguage.code' => $this->Session->read('Config.language'),
		);

		$options['conditions'] = array_merge($conditions1,$conditions);

		$search_condition = '';
		if ($search_products != '') {
			if (!empty($options['conditions'])) {
				array_push($options['conditions'], array('Producttranslation.title like ' => '%' . $search_products . '%'));
			} else {
				$options['conditions'] = array('Product.title like ' => '%' . $search_products . '%');
			}
		}

		$total_count = $this->Product->find('count', $options);

		$options['limit'] = $_limit;
		$options['offset'] = $first;

		$products = $this->Product->find('all', $options);

		$this->set('products', $products);
		$this->set('total_count', $total_count);
		$this->set('limit', $_limit);


		$options = array();
		$this->Product->recursive = -1;
		$options['fields'] = array(
			'distinct(Product.id)',
			'Product.slug',
			'Product.price',
			'Discounttype.percent',
			'Discounttype.amount',
			'Producttranslation.title',
			'Producttranslation.mini_detail',
			'(select image from productimages where product_id = Product.id limit 0,1)as image',
			'(select count(*) from orderitems where product_id = Product.id )as count_order'
		);
		$options['joins'] = array(
			array('table' => 'orderitems',
				'alias' => 'Orderitem',
				'type' => 'inner',
				'conditions' => array(
					'Product.id = Orderitem.product_id'
				)
			),
			array('table' => 'producttranslations',
				'alias' => 'Producttranslation',
				'type' => 'inner',
				'conditions' => array(
					'Product.id = Producttranslation.product_id'
				)
			),
			array('table' => 'languages',
				'alias' => 'Language',
				'type' => 'inner',
				'conditions' => array(
					'Language.id = Producttranslation.language_id'
				)
			),
			array('table' => 'productdiscounts',
				'alias' => 'Productdiscount',
				'type' => 'left',
				'conditions' => array(
					'Product.id = Productdiscount.product_id'
				)
			),
			array('table' => 'discounttypes',
				'alias' => 'Discounttype',
				'type' => 'left',
				'conditions' => array(
					'Discounttype.id = Productdiscount.discount_type_id'
				)
			)
		);
		$options['conditions'] = array(
			'Product.status' => 1,
			'Language.code' => $this->Session->read('Config.language')
		);
		$options['order'] = array(
			'Product.id' => 'desc'
		);
		$options['limit'] = 5;
		$most_sales_products = $this->Product->find('all', $options);
		$this->set('most_sales_products', $most_sales_products);

		$this->set('title_for_layout', __d(__PRODUCT, 'shop'));
		$this->set('description_for_layout', __d(__PRODUCT, 'shop'));
	}


	public function view($id)
	{
		$this->Product->recursive = -1;


		$this->Product->id = $id;
		if (!$this->Product->exists()) {
			$product = $this->Product->findBySlug($id);
			if (empty($product)) {
				throw new NotFoundException(__('not_valid_page'));
			}
			$id = $product['Product']['id'];
		}

		$this->Product->recursive = -1;
		$options['fields'] = array(
			'Product.id',
			'Producttranslation.title',
			'Producttranslation.mini_detail',
			'Producttranslation.detail',
			'Product.status',
			'Product.price',
			'Product.product_category_id',
			'Product.created',
			'Discounttype.percent',
			'Discounttype.amount',
		);

		$options['joins'] = array(
			array('table' => 'producttranslations',
				'alias' => 'Producttranslation',
				'type' => 'inner',
				'conditions' => array(
					'Product.id = Producttranslation.product_id'
				)
			),
			array('table' => 'productdiscounts',
				'alias' => 'Productdiscount',
				'type' => 'left',
				'conditions' => array(
					'Product.id = Productdiscount.product_id'
				)
			),
			array('table' => 'discounttypes',
				'alias' => 'Discounttype',
				'type' => 'left',
				'conditions' => array(
					'Discounttype.id = Productdiscount.discount_type_id'
				)
			),
			array('table' => 'languages',
				'alias' => 'Language',
				'type' => 'left',
				'conditions' => array(
					'Language.id = Producttranslation.language_id'
				)
			)
		);

		$options['conditions'] = array(
			'Product.id' => $id,
			'Language.code' => $this->Session->read('Config.language')
		);

		$product = $this->Product->find('first', $options);

		$this->set('product', $product);

		$id = Sanitize::clean($id);

		$this->Product->Productimage->recursive = -1;
		$options['fields'] = array(
			'Productimagetranslation.title',
			'Productimage.image',
			'Productimage.id',
		);

		$options['joins'] = array(
			array('table' => 'productimagetranslations',
				'alias' => 'Productimagetranslation',
				'type' => 'inner',
				'conditions' => array(
					'Productimage.id = Productimagetranslation.product_image_id',
				)
			),
			array('table' => 'languages',
				'alias' => 'Language',
				'type' => 'left',
				'conditions' => array(
					'Language.id = Productimagetranslation.language_id'
				)
			)
		);
		$options['conditions'] = array(
			'Productimage.product_id' => $id,
			'Language.code' => $this->Session->read('Config.language')
		);

		$images = $this->Product->Productimage->find('all', $options);
		$this->set('images', $images);

		$options = array();
		$this->Product->recursive = -1;
		$options['fields'] = array(
			'Product.id',
			'Product.slug',
			'Product.price',
			'Producttranslation.title',
			'Producttranslation.mini_detail',
			'(select image from productimages where product_id = Product.id limit 0,1)as image',
			'Discounttype.percent',
			'Discounttype.amount',
			'Productcategorytranslation.title',
			'Productcategory.id',
		);
		$options['joins'] = array(
			array('table' => 'producttranslations',
				'alias' => 'Producttranslation',
				'type' => 'inner',
				'conditions' => array(
					'Product.id = Producttranslation.product_id'
				)
			),
			array('table' => 'productdiscounts',
				'alias' => 'Productdiscount',
				'type' => 'left',
				'conditions' => array(
					'Product.id = Productdiscount.product_id'
				)
			),
			array('table' => 'discounttypes',
				'alias' => 'Discounttype',
				'type' => 'left',
				'conditions' => array(
					'Discounttype.id = Productdiscount.discount_type_id'
				)
			),
			array(
				'table' => 'productcategories',
				'alias' => 'Productcategory',
				'type' => 'inner',
				'conditions' => array('Product.product_category_id = Productcategory.id')
			),
			array('table' => 'productcategorytranslations',
				'alias' => 'Productcategorytranslation',
				'type' => 'inner',
				'conditions' => array(
					'Productcategory.id = Productcategorytranslation.product_category_id'
				)
			),
			array('table' => 'languages',
				'alias' => 'Language',
				'type' => 'inner',
				'conditions' => array(
					'Language.id = Producttranslation.language_id'
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
			'Product.status' => 1,
			'Product.id <>' => $id,
			'Language.code' => $this->Session->read('Config.language'),
			'CatLanguage.code' => $this->Session->read('Config.language')
		);

		$options['order'] = array(
			'Product.id' => 'desc'
		);
		$options['limit'] = 5;
		$lastproducts = $this->Product->find('all', $options);
		$this->set('lastproducts', $lastproducts);


		$this->loadModel('Productproperty');
		$this->loadModel('Property');
		$this->loadModel('Propertydetail');
		$options = array();
		$this->Productproperty->recursive = -1;
		$options['fields'] = array(
			'Productproperty.id',
			'Productproperty.product_id',
			'Productproperty.property_id',
			'Productproperty.property_value',
			'Productproperty.created',
			'Property.id',
			'Property.name',
			'Propertydetail.value');
		$options['joins'] = array(
			array(
				'table' => 'properties',
				'alias' => 'Property',
				'type' => 'INNER',
				'conditions' => array(
					'Productproperty.property_id=Property.id'
				)
			),
			array(
				'table' => 'propertydetails',
				'alias' => 'Propertydetail',
				'type' => 'INNER',
				'conditions' => array(
					'Propertydetail.id=Productproperty.property_value'
				)
			)
		);
		$options['conditions'] = array(
			'Productproperty.product_id' => $id
		);

		$productproperties = $this->Productproperty->find('all', $options);

		$this->set('productproperties', $productproperties);

		$this->set('title_for_layout', $product['Producttranslation']['title']);
		$this->set('description_for_layout', $product['Producttranslation']['mini_detail']);
	}


	function add_to_basket()
	{

		$response['success'] = TRUE;
		$response['message'] = null;

		$product_id = Sanitize::clean($_REQUEST['product_id']);
		$count = Sanitize::clean($_REQUEST['count']);

		$options = array();
		$this->Product->recursive = -1;
		$options['fields'] = array(
			'Product.id',
			'Producttranslation.title',
			'Producttranslation.mini_detail',
			'Product.price',
			'Product.slug',
			'Product.num',
			'ProductImage.image',
			'Discounttype.amount',
		);
		$options['joins'] = array(

			array('table' => 'producttranslations',
				'alias' => 'Producttranslation',
				'type' => 'inner',
				'conditions' => array(
					'Product.id = Producttranslation.product_id'
				)
			)
		,
			array('table' => 'languages',
				'alias' => 'Language',
				'type' => 'inner',
				'conditions' => array(
					'Language.id = Producttranslation.language_id'
				)
			),

			array('table' => 'productimages',
				'alias' => 'ProductImage',
				'type' => 'INNER',
				'conditions' => array(
					'Product.id = ProductImage.product_id',
				)
			),
			array('table' => 'productdiscounts',
				'alias' => 'Productdiscount',
				'type' => 'left',
				'conditions' => array(
					'Product.id = Productdiscount.product_id'
				)
			),
			array('table' => 'discounttypes',
				'alias' => 'Discounttype',
				'type' => 'left',
				'conditions' => array(
					'Discounttype.id = Productdiscount.discount_type_id'
				)
			)
		);
		$options['conditions'] = array(
			'Product.id' => $product_id,
			'Language.code' => $this->Session->read('Config.language')
		);
		$options['limit'] = 1;
		$product = $this->Product->find('first', $options);


		if ($product['Product']['num'] - $count < 0) {
			$response['success'] = FALSE;
			$response['message'] = __d(__PRODUCT_LOCALE, 'dont_exist_this_product');
			$this->set('ajaxData', json_encode($response));
			$this->render(__PRODUCT_PLUGIN . '.Elements/Products/Ajax/ajax_result', 'ajax');
			return;
		}

		$session = array(
			'id' => $product['Product']['id'],
			'title' => $product['Producttranslation']['title'],
			'slug' => $product['Product']['slug'],
			'price' => ($product['Product']['price'] - $product['Discounttype']['amount']),
			'image' => $product['ProductImage']['image'],
			'num' => $count,
		);
		$basket_sum = 0;
		$session_arr = array();
		$session_arr = $this->Session->read('Basket_Info');
		$existProduct = FALSE;
		if (!empty($session_arr)) {
			foreach ($session_arr as $key => $value) {
				if ($value['id'] == $session['id']) {
					$existProduct = TRUE;
					if ($count > 0) {
						if ($value['id'] == $product_id) {
							$value['num'] = $value['num'] + $count;
						}
					}
					if ($product['Product']['num'] - $value['num'] < 0) {
						$response['success'] = FALSE;
						$response['message'] = __d(__PRODUCT_LOCALE, 'dont_exist_this_product');
						$this->set('ajaxData', json_encode($response));
						$this->render(__PRODUCT_PLUGIN . '.Elements/Products/Ajax/ajax_result', 'ajax');
						return;
					}
				}
				$Basket_Info[] = $value;
				$basket_sum = $basket_sum + $value['price'];
			}
		}
		$basket_sum = $basket_sum + $session['price'];
		if (!$existProduct) $Basket_Info[] = $session;
		$this->Session->write('Basket_Info', $Basket_Info);
		$this->set('basket_products', $Basket_Info);

		//$this->Session->delete('Basket_Info');

		$response['basket_sum'] = $basket_sum;

		$this->View = $this->_getViewObject();
		$response['basket_html'] = $this->View->render('Elements/Products/Ajax/refresh_basket');

		$response['message'] = $response['success'] ? __d(__PRODUCT_LOCALE, 'add_to_basket_success') : __d(__PRODUCT_LOCALE, 'add_to_basket_notsuccess');

		$this->set('ajaxData', json_encode($response));
		$this->render('Elements/Products/Ajax/ajax_result', 'ajax');
	}


	function basket()
	{
		$this->set('title_for_layout', __d(__PRODUCT_LOCALE, 'basket'));
		$this->set('description_for_layout', __d(__PRODUCT_LOCALE, 'basket'));
		$this->set('keywords_for_layout', __d(__PRODUCT_LOCALE, 'basket'));
	}


	public function refresh_basket()
	{
		$response['success'] = TRUE;
		$response['message'] = null;

		$product_id = Sanitize::clean($_REQUEST['product_id']);
		$count = Sanitize::clean($_REQUEST['count']);

		//$this->Session->delete('Basket_Info');
		$basket_count = 0;
		$basket_sum = 0;
		$session_arr = array();

		$options = array();
		$this->Product->recursive = -1;
		$options['fields'] = array(
			'Product.num'
		);
		$options['conditions'] = array(
			'Product.id' => $product_id
		);
		$product = $this->Product->find('first', $options);

		$session_arr = $this->Session->read('Basket_Info');
		if (!empty($session_arr)) {
			foreach ($session_arr as $key => $value) {

				if ($count > 0) {
					if ($value['id'] == $product_id) {
						$value['num'] = $count;
					}
				}

				if (!empty($product)) {
					if ($product['Product']['num'] - $value['num'] < 0) {
						$response['success'] = FALSE;
						$response['message'] = __d(__PRODUCT_LOCALE, 'dont_exist_this_product');
						$this->set('ajaxData', json_encode($response));
						$this->render(__PRODUCT_PLUGIN . '.Elements/Products/Ajax/ajax_result', 'ajax');
						return;
					}
				}

				$Basket_Info[] = $value;
				$basket_sum = $basket_sum + ($value['price'] * $value['num']);
				$basket_count++;
			}
		}

		//print_r($Basket_Info);
		$this->set('products', $Basket_Info);

		$this->Session->write('Basket_Info', $Basket_Info);

		$response['basket_count'] = $basket_count;

		$this->View = $this->_getViewObject();
		$response['basket_html'] = $this->View->render('Elements/Products/Ajax/basket');

		$response['message'] = $response['success'] ? __d(__PRODUCT_LOCALE, 'add_to_basket_success') : __d(__PRODUCT_LOCALE, 'add_to_basket_notsuccess');

		$this->set('ajaxData', json_encode($response));
		$this->render(__PRODUCT_PLUGIN . '.Elements/Products/Ajax/ajax_result', 'ajax');
	}


	function refresh_basket_preview()
	{
		$products = $_SESSION['Basket_Info'];
		$this->set('products', $products);
		$this->render(__PRODUCT_PLUGIN . '.Elements/Products/Ajax/basket', 'ajax');
	}

	function delete_from_basket()
	{

		$response['success'] = TRUE;
		$response['message'] = null;
		$response['count'] = 0;

		$product_id = Sanitize::clean($_REQUEST['product_id']);

		if (!empty($_SESSION['Basket_Info'])) {
			foreach ($_SESSION['Basket_Info'] as $key => $product) {
				if ($product['id'] == $product_id) {
					unset($_SESSION['Basket_Info'][$key]);
				}
			}
		}


		$response['count'] = count($_SESSION['Basket_Info']);
		$response['message'] = $response['success'] ? '' : __d(__PRODUCT_LOCALE, 'delete_from_basket_notsuccess');

		$this->set('ajaxData', json_encode($response));
		$this->render(__PRODUCT_PLUGIN . '.Elements/Products/Ajax/ajax_result', 'ajax');
	}

	function delete_quantity_basket()
	{

		$response['success'] = TRUE;
		$response['message'] = null;

		$product_id = Sanitize::clean($_REQUEST['product_id']);

		$_SESSION['Basket_Info'][$product_id]--;  // delete quantity

		if ($_SESSION['Basket_Info'][$product_id] == 0) unset($_SESSION['Basket_Info'][$product_id]);

		$response['message'] = $response['success'] ? '' : __('delete_from_basket_notsuccess');

		$this->set('ajaxData', json_encode($response));
		$this->render(__PRODUCT_PLUGIN . '.Elements/Products/Ajax/ajax_result', 'ajax');
	}


	public function delete_product_from_basket()
	{
		$response['success'] = TRUE;
		$response['message'] = null;

		$product_id = Sanitize::clean($_REQUEST['product_id']);

		$session_arr = array();

		$session_arr = $this->Session->read('Basket_Info');
		if (!empty($session_arr)) {
			foreach ($session_arr as $key => $value) {
				if ($value['id'] == $product_id) continue;
				$Basket_Info[] = $value;
			}
		}
		$this->Session->write('Basket_Info', $Basket_Info);
		$response['message'] = $response['success'] ? __d(__PRODUCT_LOCALE, 'add_to_basket_success') : __d(__PRODUCT_LOCALE, 'add_to_basket_notsuccess');

		$this->set('ajaxData', json_encode($response));
		$this->render(__PRODUCT_PLUGIN . '.Elements/Products/Ajax/ajax_result', 'ajax');
	}

}

?>
