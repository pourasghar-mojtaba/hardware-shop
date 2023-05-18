<?php
/**
 */
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class OrdersController extends ProductAppController
{

	var $name = 'Orders';
	var $components = array('Cms', 'Httpupload');

	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow(array('app_preper_pay_order', 'admin_ordered_list', 'preper_pay_order'));
		$this->_add_member_permision(array('purchases', 'register', 'end_order', 'detail'));
		$this->_add_admin_member_permision(array('admin_register'));
	}


//var $helpers = array('Cms');
//var $components = array('Cms','Httpupload');
	/**
	 * Controller name
	 *
	 *
	 * /**
	 * follow to anoher user
	 * @param undefined $id
	 *
	 */
	function purchases()
	{
		$User_Info = $this->Session->read('User_Info');
		$this->Order->recursive = -1;
		if (isset($_REQUEST['filter'])) {
			$limit = $_REQUEST['filter'];
		} else $limit = 10;
		$this->paginate = array(
			'fields' => array(
				'Order.id',
				'Order.title',
				'Order.refid',
				'Order.description',
				'Order.created',
				'Order.status',
				'Order.sum_price',
				'Bankmessag.message',
				'(select sum(item_count) from orderitems where order_id = Order.id) as item_count',
			),
			'joins' => array(
				array('table' => 'bankmessags',
					'alias' => 'Bankmessag',
					'type' => 'LEFT',
					'conditions' => array(
						'Bankmessag.id = Order.bankmessage_id ',
					)
				)

			)
		,
			'conditions' => array('user_id' => $User_Info['id']),
			'limit' => $limit,
			'order' => array(
				'Order.id' => 'desc'
			)
		);

		$orders = $this->paginate('Order');
		$this->set(compact('orders'));
		$this->set('limit', $limit);
		$this->set('total_count', count($orders));

		$this->set('title_for_layout', __d(__PRODUCT_LOCALE, 'product_order_info'));
		$this->set('description_for_layout', __d(__PRODUCT_LOCALE, 'product_order_info'));
		$this->set('keywords_for_layout', __d(__PRODUCT_LOCALE, 'product_order_info'));

	}

	function detail($id)
	{

		$this->Order->recursive = -1;
		$this->Order->id = $id;

		$User_Info = $this->Session->read('User_Info');
		$options['fields'] = array(
			'Order.id',
			'Order.title',
			'Order.refid',
			'Order.items_count',
			'Order.factor_pdf',
			'Order.manual',
			'Order.description',
			'Order.user_description',
			'Order.created',
			'Order.status',
			'Order.sum_price',
			'(select sum(item_count) from orderitems where order_id = Order.id) as item_count',
			'Bankmessag.message'
		);

		$options['joins'] = array(
			array('table' => 'bankmessags',
				'alias' => 'Bankmessag',
				'type' => 'LEFT',
				'conditions' => array(
					'Bankmessag.id = Order.bankmessage_id ',
				)
			)
		);

		$options['conditions'] = array(
			"Order.id" => $id,
			'Order.user_id' => $User_Info['id']
		);

		$order = $this->Order->find('first', $options);
		if (empty($order)) {
			throw new NotFoundException(__d(__PRODUCT_LOCALE, 'not_valid_order_id'));
		}

		$this->set(compact('order'));
		$options = array();
		$this->Order->Orderitem->recursive = -1;
		$options['fields'] = array(
			'Orderitem.product_id',
			'Orderitem.item_count',
			'Orderitem.sum_price',
			'Product.id',
			'Product.slug',
			'Product.price',
			'Producttranslation.title',
			'(select image from  productimages where product_id = Product.id limit 0,1) as image',
		);

		$options['joins'] = array(
			array('table' => 'products',
				'alias' => 'Product',
				'type' => 'LEFT',
				'conditions' => array(
					'Product.id = Orderitem.product_id ',
				)
			),
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
			)
		);

		$options['conditions'] = array(
			'Orderitem.order_id' => $id,
			'Language.code' => $this->Session->read('Config.language'),
		);
		$orderitems = $this->Order->Orderitem->find('all', $options);
		$this->set(compact('orderitems'));
		$this->set('title_for_layout', __d(__PRODUCT_LOCALE, 'order_detail'));
		$this->set('description_for_layout', __d(__PRODUCT_LOCALE, 'order_detail'));
		$this->set('keywords_for_layout', __d(__PRODUCT_LOCALE, 'order_detail'));
	}

	function register()
	{
		$this->set('title_for_layout', __d(__PRODUCT_LOCALE, 'register_order'));
		$this->set('description_for_layout', __d(__PRODUCT_LOCALE, 'register_order'));
		$this->set('keywords_for_layout', __d(__PRODUCT_LOCALE, 'register_order'));
		$User_Info = $this->Session->read('User_Info');
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data = Sanitize::clean($this->request->data);
			$this->request->data['Order']['status'] = 10;
			$this->request->data['Order']['manual'] = 1;
			$this->request->data['Order']['user_id'] = $User_Info['id'];;
			if (!$this->Order->save($this->request->data))
				$this->Redirect->flashWarning(__d(__PRODUCT_LOCALE, 'order_doesnt_saved'));

			$this->Redirect->flashSuccess(__d(__PRODUCT_LOCALE, 'order_saved_successfully'), array('action' => 'purchases', 'controller' => 'orders'));
		}

	}

	public function admin_register($id)
	{
		$this->set('title_for_layout', __d(__PRODUCT_LOCALE, 'create_factor'));
		$this->set('description_for_layout', __d(__PRODUCT_LOCALE, 'create_factor'));
		$this->set('keywords_for_layout', __d(__PRODUCT_LOCALE, 'create_factor'));

		if ($this->request->is('post') || $this->request->is('put')) {
			$order = $this->Order->findById($id);
			$data = Sanitize::clean($this->request->data);
			$this->request->data['Order']['id'] = $id;
			$file = $data['Order']['factor_pdf'];
			if ($file['size'] > 0) {
				$output = $this->_upload_file();
				if (!$output['error']) {
					$factor_pdf = $output['filename'];
				} else {
					$factor_pdf = '';
				}
			} else $factor_pdf = $order['Order']['factor_pdf'];
			$this->request->data['Order']['factor_pdf'] = $factor_pdf;

			if (!$this->Order->save($this->request->data))
				$this->Redirect->flashWarning(__d(__PRODUCT_LOCALE, 'the_order_could_not_be_saved'));

			$this->Redirect->flashSuccess(__d(__PRODUCT_LOCALE, 'the_order_has_been_saved'), array('action' => 'index'));
		}

		$this->request->data = $this->Order->findById($id);
	}

	function _upload_file()
	{
		App::uses('Sanitize', 'Utility');

		$output = array();
		$data = Sanitize::clean($this->request->data);
		$file = $data['Order']['factor_pdf'];

		if ($file['size'] > 0) {
			$ext = $this->Httpupload->get_extension($file['name']);
			$filename = md5(rand() . $_SERVER['REMOTE_ADDR']);
			if (file_exists(__PRODUCT_IMAGE_URL . $filename . '.' . $ext)) $filename = md5(rand() . $_SERVER[REMOTE_ADDR]);

			$this->Httpupload->setmodel('Order');
			$this->Httpupload->setuploaddir(__PRODUCT_IMAGE_PATH);
			$this->Httpupload->setuploadname('factor_pdf');
			$this->Httpupload->settargetfile($filename . '.' . $ext);
			$this->Httpupload->setmaxsize(4194304);
			$this->Httpupload->allowExt = __UPLOAD_File_EXT;
			if (!$this->Httpupload->upload()) {
				return array('error' => true, 'filename' => '', 'message' => $this->Httpupload->get_error());
			}
			$filename .= '.' . $ext;

		}
		return array('error' => false, 'filename' => $filename);
	}


	function admin_index()
	{
		$this->set('title_for_layout', __d(__PRODUCT_LOCALE, 'product_order_info'));
		$this->set('description_for_layout', __d(__PRODUCT_LOCALE, 'product_order_info'));
		$this->set('keywords_for_layout', __d(__PRODUCT_LOCALE, 'product_order_info'));

		$User_Info = $this->Session->read('User_Info');

		$this->Order->recursive = -1;
		if (isset($_REQUEST['filter'])) {
			$limit = $_REQUEST['filter'];
		} else $limit = 10;

		if (isset($this->request->data['orders'])) {
			$orders = Sanitize::clean($this->request->data['orders']);

			if (!empty($orders)) {
				foreach ($orders as $key => $id) {
					$ret = $this->Order->updateAll(
						array('Order.status' => '"' . Sanitize::clean($this->request->data['status']) . '"'
						),   //fields to update
						array('Order.id' => $id)  //condition
					);
				}
			}
		}

		if (isset($this->request->data['Order']['search'])) {
			$this->request->data = Sanitize::clean($this->request->data);
			$this->paginate = array(
				'fields' => array(
					'Order.id',
					'Order.title',
					'Order.refid',
					'Order.manual',
					'Order.description',
					'Order.created',
					'Order.sum_price',
					'Order.items_count',
					'Order.status',
					'Bankmessag.message',
					'Bank.bank_name',
				),
				'joins' => array(
					array('table' => 'bankmessags',
						'alias' => 'Bankmessag',
						'type' => 'LEFT',
						'conditions' => array(
							'Bankmessag.id = Order.bankmessage_id ',
						)
					),

					array('table' => 'banks',
						'alias' => 'Bank',
						'type' => 'LEFT',
						'conditions' => array(
							'Bank.id = Order.bank_id ',
						)
					)

				),
				'conditions' => array('Order.refid LIKE' => '%' . $this->request->data['Order']['search'] . '%'),
				'limit' => $limit,
				'order' => array(
					'Order.id' => 'desc'
				)
			);
		} else {
			$this->paginate = array(
				'fields' => array(
					'Order.id',
					'Order.title',
					'Order.refid',
					'Order.manual',
					'Order.description',
					'Order.created',
					'Order.sum_price',
					'Order.items_count',
					'Order.status',
					'Bankmessag.message',
					'Bank.bank_name',
				),
				'joins' => array(

					array('table' => 'bankmessags',
						'alias' => 'Bankmessag',
						'type' => 'LEFT',
						'conditions' => array(
							'Bankmessag.id = Order.bankmessage_id ',
						)
					),

					array('table' => 'banks',
						'alias' => 'Bank',
						'type' => 'LEFT',
						'conditions' => array(
							'Bank.id = Order.bank_id ',
						)
					)

				)
			,

				'limit' => $limit,
				'order' => array(
					'Order.id' => 'desc'
				)
			);
		}


		$orders = $this->paginate('Order');

		$this->set(compact('orders'));

	}

	/**
	 *
	 *
	 */
	function admin_add()
	{
		if ($this->request->is('post') || $this->request->is('put')) {
			$datasource = $this->Order->getDataSource();
			$User_Info = $this->Session->read('AdminUser_Info');
			try {
				$datasource->begin();

				//pr($this->request->data);throw new Exception();

				if (trim($this->request->data['Orderrate']['rate']) == '' || trim($this->request->data['Orderrate']['rate']) == 0) {
					throw new Exception(__d(__PRODUCT_LOCALE, 'the_productrate_not_valid'));
				}

				if (!$this->Order->save($this->request->data))
					throw new Exception(__d(__PRODUCT_LOCALE, 'the_product_not_saved'));
				$product_id = $this->Order->getLastInsertID();

				if (!empty($this->request->data['Orderrate'])) {
					foreach ($this->request->data['Orderrate'] as $value) {
						$data[] = array('Orderrate' => array(
							'product_id' => $product_id,
							'user_id' => $User_Info['id'],
							'rate' => $value
						));
					}
					if (!$this->Order->Orderrate->saveMany($data, array('deep' => true)))
						throw new Exception(__d(__PRODUCT_LOCALE, 'the_productrate_not_saved'));
				}
				if (!empty($this->request->data['Technicalinfoitemvalue']['value'])) {
					foreach ($this->request->data['Technicalinfoitemvalue']['value'] as $key => $value) {
						if (trim($value) == '') {
							unset($this->request->data['Technicalinfoitemvalue']['value'][$key]);
							unset($this->request->data['Technicalinfoitemvalue']['technical_info_item_id'][$key]);
						}
					}
					$data = array();
					foreach ($this->request->data['Technicalinfoitemvalue']['value'] as $key => $value) {
						$data[] = array('Technicalinfoitemvalue' => array(
							'value' => $value,
							'technical_info_item_id' => $this->request->data['Technicalinfoitemvalue']['technical_info_item_id'][$key],
							'product_id' => $product_id
						));
					}
					if (!$this->Order->Technicalinfoitemvalue->saveMany($data, array('deep' => true)))
						throw new Exception(__d(__PRODUCT_LOCALE, 'the_technicalinfoitemvalue_not_saved'));
				}


				if (isset($_POST['new_tags']) && !empty($_POST['new_tags'])) {
					$tags = $_POST['new_tags'];//explode('#',$this->request->data['Orderrelatetag']['tag']);
					$tags = array_filter($tags, 'strlen');
					$this->loadModel('Ordertag');
					if (!empty($tags)) {
						foreach ($tags as $tag) {
							$this->request->data['Ordertag']['title'] = $tag;
							$this->Ordertag->create();

							if ($this->Ordertag->save($this->request->data)) {
								$tag_id[] = $this->Ordertag->getLastInsertID();
							} else throw new Exception(__d(__PRODUCT_LOCALE, 'the_tag_not_saved'));
						}
					}

				}
				$data = array();
				if (isset($this->request->data['Orderrelatetag']['product_tag_id'])) {
					foreach ($this->request->data['Orderrelatetag']['product_tag_id'] as $id) {
						$dt = array('Orderrelatetag' => array('product_id' => $product_id, 'product_tag_id' => $id));
						array_push($data, $dt);
					}
				}

				if (!empty($tag_id)) {
					foreach ($tag_id as $tid) {
						$dt = array('Orderrelatetag' => array('product_id' => $product_id, 'product_tag_id' => $tid));
						array_push($data, $dt);
					}

				}

				if (!empty($this->request->data['Orderrelatetag']['product_tag_id']) || !empty($tag_id)) {
					$this->Order->Orderrelatetag->create();
					if (!$this->Order->Orderrelatetag->saveMany($data))
						throw new Exception(__d(__PRODUCT_LOCALE, 'the_product_tag_not_saved'));
				}

				// /*pr($this->request->data);*/pr($_FILES);throw new Exception();

				if (!empty($this->request->data['Orderimage']['image'])) {

					foreach ($this->request->data['Orderimage']['image'] as $key => $value) {
						if (trim($value['name']) == '') {
							unset($this->request->data['Orderimage']['image'][$key]);
							unset($this->request->data['Orderimage']['title'][$key]);
						}
					}
					$data = array();
					$image_list = array();
					foreach ($this->request->data['Orderimage']['image'] as $key => $value) {
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
							throw new Exception($output['message'] . '  ' . __d(__PRODUCT_LOCALE, 'نام تصویر ') . $value['name']);
						}

						$image_list[] = $image;

						$data[] = array('Orderimage' => array(
							'image' => $image,
							'title' => $this->request->data['Orderimage']['title'][$key],
							'product_id' => $product_id
						));
					}
					if (!$this->Order->Orderimage->saveMany($data, array('deep' => true)))
						throw new Exception(__d(__PRODUCT_LOCALE, 'the_product_image_not_saved'));


				}


				$datasource->commit();

				$this->Session->setFlash(__d(__PRODUCT_LOCALE, 'the_product_has_been_saved'), 'admin_success');
				$this->redirect(array('action' => 'index'));
			} catch (Exception $e) {
				$datasource->rollback();
				$this->Session->setFlash($e->getMessage(), 'admin_error');
			}
		}
		$this->set('technicalinfos', $this->_get_Technicalinfo());


	}


	/**
	 *
	 * @param undefined $id
	 *
	 */
	function admin_edit($id = null)
	{
		$this->Order->recursive = -1;
		$this->Order->id = $id;
		if (!$this->Order->exists()) {
			$this->Session->setFlash(__d(__PRODUCT_LOCALE, 'invalid_id_for_product'));
			$this->redirect(array('action' => 'index'));
		}

		$User_Info = $this->Session->read('AdminUser_Info');

		if ($this->request->is('post') || $this->request->is('put')) {

			$datasource = $this->Order->getDataSource();
			try {
				$datasource->begin();


				if (trim($this->request->data['Orderrate']['rate']) == '' || trim($this->request->data['Orderrate']['rate']) == 0) {
					throw new Exception(__d(__PRODUCT_LOCALE, 'the_productrate_not_valid'));
				}


				if (!$this->Order->save($this->request->data))
					throw new Exception(__d(__PRODUCT_LOCALE, 'the_product_not_saved'));


				$ret = $this->Order->Orderrate->updateAll(
					array('Orderrate.rate' => '"' . $this->request->data['Orderrate']['rate'] . '"'
					),   //fields to update
					array('Orderrate.product_id' => $id)  //condition
				);
				if (!$ret) {
					throw new Exception(__d(__PRODUCT_LOCALE, 'the_productrate_not_saved'));
				}
				// pr($this->request->data); throw new Exception();
				// tecnical item oprtion
				if (!$this->Order->Technicalinfoitemvalue->deleteAll(array('Technicalinfoitemvalue.product_id' => $id), FALSE))
					throw new Exception(__d(__PRODUCT_LOCALE, 'the_technicalinfoitemvalue_not_saved'));

				if (!empty($this->request->data['Technicalinfoitemvalue']['value'])) {
					foreach ($this->request->data['Technicalinfoitemvalue']['value'] as $key => $value) {
						if (trim($value) == '') {
							unset($this->request->data['Technicalinfoitemvalue']['value'][$key]);
							unset($this->request->data['Technicalinfoitemvalue']['technical_info_item_id'][$key]);
						}
					}
					$data = array();
					foreach ($this->request->data['Technicalinfoitemvalue']['value'] as $key => $value) {
						$data[] = array('Technicalinfoitemvalue' => array(
							'value' => $value,
							'technical_info_item_id' => $this->request->data['Technicalinfoitemvalue']['technical_info_item_id'][$key],
							'product_id' => $id
						));
					}
					if (!$this->Order->Technicalinfoitemvalue->saveMany($data, array('deep' => true)))
						throw new Exception(__d(__PRODUCT_LOCALE, 'the_technicalinfoitemvalue_not_saved'));
				}
				// tecnical item oprtion

				// tag oprtion

				if (!$this->Order->Orderrelatetag->deleteAll(array('Orderrelatetag.product_id' => $id), FALSE))
					throw new Exception(__d(__PRODUCT_LOCALE, 'the_tag_not_saved'));

				if (isset($_POST['new_tags']) && !empty($_POST['new_tags'])) {
					$tags = $_POST['new_tags'];//explode('#',$this->request->data['Orderrelatetag']['tag']);
					$tags = array_filter($tags, 'strlen');
					$this->loadModel('Ordertag');
					if (!empty($tags)) {
						foreach ($tags as $tag) {
							$this->request->data['Ordertag']['title'] = $tag;
							$this->Ordertag->create();

							if ($this->Ordertag->save($this->request->data)) {
								$tag_id[] = $this->Ordertag->getLastInsertID();
							} else throw new Exception(__d(__PRODUCT_LOCALE, 'the_tag_not_saved'));
						}
					}

				}
				$data = array();
				if (isset($this->request->data['Orderrelatetag']['product_tag_id'])) {
					foreach ($this->request->data['Orderrelatetag']['product_tag_id'] as $tagid) {
						$dt = array('Orderrelatetag' => array('product_id' => $id, 'product_tag_id' => $tagid));
						array_push($data, $dt);
					}
				}

				if (!empty($tag_id)) {
					foreach ($tag_id as $tid) {
						$dt = array('Orderrelatetag' => array('product_id' => $id, 'product_tag_id' => $tid));
						array_push($data, $dt);
					}

				}
				//pr($data);throw new Exception();

				if ($this->request->data['Orderrelatetag']['product_tag_id'] || !empty($tag_id)) {
					if (!$this->Order->Orderrelatetag->saveMany($data, array('deep' => true)))
						throw new Exception(__d(__PRODUCT_LOCALE, 'the_product_tag_not_saved'));
				}
				// tag opration


				// image opration

				$options = array();
				$this->Order->Orderimage->recursive = -1;
				$options['fields'] = array(
					'Orderimage.id',
					'Orderimage.title',
					'Orderimage.image'
				);
				$options['conditions'] = array(
					'Orderimage.product_id' => $id
				);
				$productimages = $this->Order->Orderimage->find('all', $options);
				//pr($this->request->data);throw new Exception();
				if (!empty($productimages)) {
					foreach ($productimages as $productimage) {
						if (!in_array($productimage['Orderimage']['id'], $this->request->data['Orderimage']['id'])) {
							if (!$this->Order->Orderimage->delete($productimage['Orderimage']['id']))
								throw new Exception(__d(__PRODUCT_LOCALE, 'the_productimage_not_saved'));
							else {
								@unlink(__PRODUCT_IMAGE_PATH . "/" . $productimage['Orderimage']['image']);
								@unlink(__PRODUCT_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $productimage['Orderimage']['image']);
							}
						}
					}
				}


				if (!empty($this->request->data['Orderimage']['id'])) {
					foreach ($this->request->data['Orderimage']['id'] as $key => $value) {

						if ($this->request->data['Orderimage']['image'][$key]['size'] > 0) {

							@unlink(__PRODUCT_IMAGE_PATH . "/" . $this->request->data['Orderimage']['old_image'][$key]);
							@unlink(__PRODUCT_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $this->request->data['Orderimage']['old_image'][$key]);
							$output = $this->_picture($this->request->data['Orderimage']['image'][$key], $key);
							if (!$output['error']) $image = $output['filename'];
							else {
								$image = '';
								if (!empty($image_list)) {
									foreach ($image_list as $img) {
										@unlink(__PRODUCT_IMAGE_PATH . "/" . $img);
										@unlink(__PRODUCT_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $img);
									}
								}
								throw new Exception($output['message'] . '  ' . __d(__PRODUCT_LOCALE, 'نام تصویر ') . $this->request->data['Orderimage']['image'][$key]['name']);
							}

							$image_list[] = $image;
						} else $image = $this->request->data['Orderimage']['old_image'][$key];

						$ret = $this->Order->Orderimage->updateAll(
							array('Orderimage.title' => '"' . $this->request->data['Orderimage']['title'][$key] . '"',
								'Orderimage.image' => '"' . $image . '"'
							),   //fields to update
							array('Orderimage.id' => $value)  //condition
						);
						if (!$ret) {
							throw new Exception(__d(__PRODUCT_LOCALE, 'the_productimage_not_saved'));
						}
					}
				}


				if (!empty($this->request->data['Orderimage']['id'])) {
					foreach ($this->request->data['Orderimage']['id'] as $key => $value) {
						unset($this->request->data['Orderimage']['title'][$key]);
						unset($this->request->data['Orderimage']['image'][$key]);
					}
				}


				$data = array();
				if (!empty($this->request->data['Orderimage']['image'])) {

					foreach ($this->request->data['Orderimage']['image'] as $key => $value) {
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
							throw new Exception($output['message'] . '  ' . __d(__PRODUCT_LOCALE, 'نام تصویر ') . $value['name']);
						}

						$image_list[] = $image;

						$data[] = array('Orderimage' => array(
							'image' => $image,
							'title' => $this->request->data['Orderimage']['title'][$key],
							'product_id' => $id
						));
					}
					//pr($data);throw new Exception();
					if (!empty($data)) {
						if (!$this->Order->Orderimage->saveMany($data, array('deep' => true)))
							throw new Exception(__d(__PRODUCT_LOCALE, 'the_productimage_not_saved'));
					}
				}


				// image opration


				$datasource->commit();
				$this->Session->setFlash(__d(__PRODUCT_LOCALE, 'the_technicalinfoitem_has_been_saved'), 'admin_success');
				$this->redirect(array('action' => 'index'));
			} catch (Exception $e) {
				$datasource->rollback();
				$this->Session->setFlash($e->getMessage(), 'admin_error');
			}

		}


		$options['conditions'] = array(
			'Order.id' => $id
		);
		$product = $this->Order->find('first', $options);
		$this->set('product', $product);

		$options = array();

		$options['conditions'] = array(
			'Orderrate.user_id' => $User_Info['id']
		);
		$productrate = $this->Order->Orderrate->find('first', $options);
		$this->set('productrate', $productrate);

		$this->set('technicalinfos', $this->_get_Technicalinfo());

		$options = array();

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
		$technicalinfoitemvalues = $this->Order->Technicalinfoitemvalue->find('all', $options);
		$this->set('technicalinfoitemvalues', $technicalinfoitemvalues);

		$options = array();
		$options['fields'] = array(
			'Orderimage.id',
			'Orderimage.title',
			'Orderimage.image'
		);
		$options['conditions'] = array(
			'Orderimage.product_id' => $id
		);
		$productimages = $this->Order->Orderimage->find('all', $options);
		$this->set('productimages', $productimages);

		$options = array();
		$options['fields'] = array(
			'Orderrelatetag.id',
			'Ordertag.title',
			'Ordertag.id'
		);
		$options['joins'] = array(
			array('table' => 'producttags',
				'alias' => 'Ordertag',
				'type' => 'INNER',
				'conditions' => array(
					'Ordertag.id = Orderrelatetag.product_tag_id'
				)
			)
		);
		$options['conditions'] = array(
			'Orderrelatetag.product_id' => $id
		);
		$productrelatetags = $this->Order->Orderrelatetag->find('all', $options);
		$this->set('productrelatetags', $productrelatetags);

		$this->set('technicalinfos', $this->_get_Technicalinfo());

		$this->set('categories', $this->_getback_categories($product['Order']['product_category_id']));
	}


	function admin_delete($id = null)
	{
		$options = array();
		$this->Order->Orderitem->recursive = -1;
		$options['fields'] = array(
			'Orderitem.product_id',
			'Orderitem.item_count'
		);
		$options['conditions'] = array(
			'Orderitem.order_id' => $id
		);
		$orderitems = $this->Order->Orderitem->find('all', $options);

		if ($this->Order->delete($id)) {

			$this->loadModel('Product');
			$this->Product->recursive = -1;

			if (!empty($orderitems)) {
				foreach ($orderitems as $orderitem) {
					$ret = $this->Product->updateAll(
						array('Product.order' => 'Product.order - ' . $orderitem['Orderitem']['item_count'],
							'Product.num' => 'Product.num + ' . $orderitem['Orderitem']['item_count']),
						array('Product.id' => $orderitem['Orderitem']['product_id'])  //condition
					);
				}
			}

			$this->Session->setFlash(__d(__PRODUCT_LOCALE, 'the_order_deleted'), 'admin_success');
		} else $this->Session->setFlash(__d(__PRODUCT_LOCALE, 'the_order_not_deleted'), 'admin_error');
		$this->redirect($this->referer(array('action' => 'index')));
	}


	public function admin_ordered_list()
	{

		$this->Order->recursive = -1;
		if (isset($_REQUEST['filter'])) {
			$limit = $_REQUEST['filter'];
		} else $limit = 10;

		if (isset($this->request->data['Order']['search'])) {
			$this->request->data = Sanitize::clean($this->request->data);
			$this->paginate = array(
				'fields' => array(
					'Order.id',
					'Order.refid',
					'Order.description',
					'Order.created',
					'Order.sum_price',
					'Bankmessag.message',
					'(select sum(item_count) from orderitems where order_id = Order.id) as item_count',
					'(select sum(item_count) from orderitems where order_id = Order.id and status = 2) as send_count',
					'(select sum(item_count) from orderitems where order_id = Order.id and status = 3) as accept_count',
					'(select sum(item_count) from orderitems where order_id = Order.id and status not in (2,3)) as not_accept_count'
				),
				'joins' => array(
					array('table' => 'bankmessags',
						'alias' => 'Bankmessag',
						'type' => 'LEFT',
						'conditions' => array(
							'Bankmessag.id = Order.bankmessage_id ',
						)
					)

				),
				'conditions' => array('Order.refid LIKE' => '%' . $this->request->data['Order']['search'] . '%'),
				'limit' => $limit,
				'order' => array(
					'Order.id' => 'desc'
				)
			);
		} else {
			$this->paginate = array(
				'fields' => array(
					'Order.id',
					'Order.refid',
					'Order.description',
					'Order.created',
					'Order.sum_price',
					'Bankmessag.message',
					'(select sum(item_count) from orderitems where order_id = Order.id) as item_count',
					'(select sum(item_count) from orderitems where order_id = Order.id and status = 2) as send_count',
					'(select sum(item_count) from orderitems where order_id = Order.id and status = 3) as accept_count',
					'(select sum(item_count) from orderitems where order_id = Order.id and status not in (2,3)) as not_accept_count'
				),
				'joins' => array(
					array('table' => 'bankmessags',
						'alias' => 'Bankmessag',
						'type' => 'LEFT',
						'conditions' => array(
							'Bankmessag.id = Order.bankmessage_id ',
						)
					)

				)
			,
				//'conditions' => array('user_id'=>$User_Info['id']),
				'limit' => $limit,
				'order' => array(
					'Order.id' => 'desc'
				)
			);
		}


		$orders = $this->paginate('Order');
		$this->set(compact('orders'));

	}


	function preper_pay_order($order_id = NULL)
	{

		$User_Info = $this->Session->read('User_Info');
		$this->Session->write('back_to_basket', 1);

		if (empty($User_Info)) {
			$this->redirect(__SITE_URL . 'users/login');
		}

		$this->loadModel('Userdetail');
		$userDetail = $this->Userdetail->_getUserData($User_Info['id']);
		if (empty($userDetail)) {
			$this->redirect(__SITE_URL . 'users/edit_address');
		}

		$this->Session->delete('back_to_basket');

		$this->Order->recursive = -1;
		$this->request->data = array();

		/*Controller::loadModel('Siteinformation');
		$setting=$this->Siteinformation->get_setting();
		$percent = $setting['Siteinformation']['percent'];*/
		$percent = 0;
		$info = $this->Order->find('first', array('conditions' => array('Order.user_id' => $User_Info['id'], 'Order.id' => $order_id)));

		if (!empty($info)) {
			$id = $info['Order']['id'];

			$this->Order->Orderitem->recursive = -1;
			$order_item = $this->Order->Orderitem->find('all', array('fields' => array('(SUM(Orderitem.item_count)) as qty'), 'conditions' => array('Orderitem.order_id' => $id)));

			$long = strtotime(date('Y-m-d H:i:s'));
			$random = rand(1000, 1000000);

			$this->Session->write('Pay_Info', array(
				'title' => __d(__PRODUCT_LOCALE, 'product_order_info'),
				'sum_price' => $info['Order']['sum_price'],
				'other_price' => 0,
				'sum_item' => $order_item['0']['0']['qty'],
				'orderid' => $long,
				'model' => 'Order',
				'token' => $random,
				'row_id' => $id,
				'cn' => 'orders',
				'ac' => 'end_order'

			));
			$this->redirect('/getway/banks/pay/' . $random . '?cn=orders&ac=end_order');
		} else {

			if (empty($_SESSION['Basket_Info'])) {
				$this->redirect(__SITE_URL . __SHOP . '/products/search');
			} else {
				$datasource = $this->Order->getDataSource();
				try {
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
					foreach ($_SESSION['Basket_Info'] as $product) {
						$total += $product['price'] * $product['num'];
						$sum_quantity += $product['num'];
					}
					$total += 300000;
					$this->request->data['Order']['user_id'] = $User_Info['id'];
					$this->request->data['Order']['bank_id'] = 0;
					$this->request->data['Order']['sum_price'] = $total;
					$this->request->data['Order']['items_count'] = $sum_quantity;
					$this->request->data['Order']['bankmessage_id'] = -1;
					$this->request->data['Order']['refid'] = 0;

					$this->Order->create();
					if (!$this->Order->save($this->request->data))
						throw new Exception(__d(__PRODUCT_LOCALE, 'the_order_not_saved'));

					$order_id = $this->Order->getLastInsertID();

					$data = array();
					$sum_price = 0;
					foreach ($_SESSION['Basket_Info'] as $product) {

						$sum_price = $product['price'] * $product['num'];
						$admin_price = $sum_price * ($percent / 100);
						$user_price = $sum_price - $admin_price;
						$dt = array();
						$dt = array('Orderitem' => array(
							'order_id' => $order_id,
							'product_id' => $product['id'],
							'item_count' => $product['num'],
							'sum_price' => $sum_price,
							'admin_price' => $admin_price,
							'user_price' => $user_price,
						));
						array_push($data, $dt);
					}

					if (!$this->Order->Orderitem->saveMany($data, array('deep' => true)))
						throw new Exception(__d(__PRODUCT_LOCALE, 'the_order_items_not_saved'));

					/*foreach($products as $product){
						$ret= $this->Product->updateAll(
							array( 'Product.order' =>'Product.order + '.$product['quantity'],
								   'Product.num' =>'Product.num - '.$product['quantity']),
							array( 'Product.id' => $product['id'] )  //condition
						   );
						if(!$ret){
							throw new Exception(__d(__PRODUCT_LOCALE,'the_order_items_not_saved'));
						}
					}	*/

					$long = strtotime(date('Y-m-d H:i:s'));
					$random = rand(1000, 1000000);

					$this->Session->write('Pay_Info', array(
						'title' => __d(__PRODUCT_LOCALE, 'product_order_info'),
						'sum_price' => $total,
						'other_price' => 0,
						'sum_item' => $sum_quantity,
						'orderid' => $long,
						'model' => 'Order',
						'token' => $random,
						'row_id' => $order_id,
						'cn' => 'orders',
						'ac' => 'end_order'

					));

					$datasource->commit();

					$this->Session->delete('Basket_Info');
					$this->redirect('/getway/banks/pay/' . $random . '?cn=orders&ac=end_order');

					//$this->Session->setFlash(__d(__PRODUCT_LOCALE,'the_product_has_been_saved'), 'success_panel');
					//$this->redirect(array('action' => 'product_list'));
				} catch (Exception $e) {
					$datasource->rollback();
					$this->Session->setFlash($e->getMessage(), 'error');
					$this->redirect(__SITE_URL . 'products/basket');
				}

			}

		}

	}


	function end_order()
	{
		$this->autoRender = false;
		$CallBack_Info = $this->Session->read('CallBack_Info');
		pr($CallBack_Info);
		$token = $_REQUEST['token'];
		$step = 0;

		try {

			if (empty($CallBack_Info)) {
				$step = 10;
				throw new Exception(__d(__PRODUCT_LOCALE, 'not_exist_orders_information'));
			}

			if ($token != $CallBack_Info['token']) {
				$step = 20;
				throw new Exception(__d(__PRODUCT_LOCALE, 'not_exist_orders_information'));
			}

			if ($CallBack_Info['refid'] > 0) {
				//pr($CallBack_Info);exit();
				$this->Order->recursive = -1;
				/*$ret = $this->Order->query("
					update orders as Order set
					   Order.refid = '".$CallBack_Info['refid']."' ,
					   Order.status = 1
					   where Order.id = ".$CallBack_Info['row_id']."
				");*/

				$ret = $this->Order->updateAll(
					array('Order.refid' => '"' . $CallBack_Info['refid'] . '"'),   //fields to update
					array('Order.id' => $CallBack_Info['row_id'])  //condition
				);

				/*if(!$ret){
					throw new Exception(__d(__PRODUCT_LOCALE,'save_user_panel_not_succeed'));
				}*/


				$this->Redirect->flashSuccess(__d(__PRODUCT_LOCALE, 'save_order_sucessed'), array('action' => 'purchases', 'controller' => 'orders'));
			} else {

				$options = array();
				$this->loadModel('Orderitem');
				$this->Orderitem->recursive = -1;

				$options['fields'] = array(
					'Orderitem.product_id',
					'Orderitem.item_count'
				);
				$options['conditions'] = array(
					'Orderitem.order_id' => $CallBack_Info['row_id']
				);
				$items = $this->Orderitem->find('all', $options);

				$this->loadModel('Product');
				$this->Product->recursive = -1;
				//pr($items);exit;
				if (!empty($items)) {

					foreach ($items as $item) {
						$ret = $this->Product->updateAll(
							array('Product.order' => 'Product.order - ' . $item['Orderitem']['item_count'],
								'Product.num' => 'Product.num + ' . $item['Orderitem']['item_count']),
							array('Product.id' => $item['Orderitem']['product_id'])  //condition
						);
						if (!$ret) {
							$step = 40;
							throw new Exception(__d(__PRODUCT_LOCALE, 'the_back_product_operation_has_error'));
						}
					}
				}

				$this->Order->deleteAll(array('Order.id' => $CallBack_Info['row_id']), FALSE);
				throw new Exception(__d(__PRODUCT_LOCALE, 'save_order_not_sucessed'));
			}


		} catch (Exception $e) {
			Controller::loadModel('Errorlog');
			$this->Session->delete('CallBack_Info');
			//$this->Errorlog->get_log('OrdersController','end_order, '.$e->getMessage().' step = '.$step );
			$this->Redirect->flashWarning($e->getMessage(), array('action' => 'purchases', 'controller' => 'orders'));
		}

		$this->Session->delete('CallBack_Info');
		$this->redirect(__SITE_URL);
	}


}
