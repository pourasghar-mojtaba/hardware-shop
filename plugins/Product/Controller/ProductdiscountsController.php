<?php
App::uses('AppController', 'Controller');

/**
 * Productdiscounts Controller
 *
 * @property Productdiscount $Productdiscount
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class ProductdiscountsController extends ProductAppController
{

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator', 'Session', 'Flash');

	public function admin_index()
	{
		$this->Productdiscount->recursive = -1;
		$this->set('title_for_layout', __d(__PRODUCT_LOCALE, 'productdiscount_list'));
		if (isset($_REQUEST['filter'])) {
			$limit = $_REQUEST['filter'];
		} else $limit = 10;

		if (isset($this->request->data['Productdiscount']['search'])) {
			$this->request->data = Sanitize::clean($this->request->data);
			$this->paginate = array(
				'fields' => array(
					'Productdiscount.id',
					'Productdiscount.product_id',
					'Productdiscount.discount_type_id',
					'Productdiscount.start_date',
					'Productdiscount.end_date',
					'Productdiscount.status',
					'Productdiscount.approved',
					'Productdiscount.created',
					'Producttranslation.title',
					'Discounttypetranslation.name',
				),
				'joins' => array(array(
					'table' => 'discounttypes',
					'alias' => 'Discounttype',
					'type' => 'INNER',
					'conditions' => array(
						'Discounttype.id = Productdiscount.discount_type_id')
				), array(
					'table' => 'products',
					'alias' => 'Product',
					'type' => 'INNER',
					'conditions' => array(
						'Product.id = Productdiscount.product_id')
				)
				,
					array('table' => 'producttranslations',
						'alias' => 'Producttranslation',
						'type' => 'left',
						'conditions' => array(
							'Product.id = Producttranslation.product_id',
							"Producttranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
						)
					),
					array('table' => 'discounttypetranslations',
						'alias' => 'Discounttypetranslation',
						'type' => 'left',
						'conditions' => array(
							'Discounttype.id = Discounttypetranslation.discount_type_id',
							"Discounttypetranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
						)
					)
				),
				'conditions' => array('Product.title LIKE' => '' . $this->request->data['Productdiscount']['search'] . '%'),
				'limit' => $limit,
				'order' => array(
					'Productdiscount.id' => 'desc'
				)
			);
		} else {
			$this->paginate = array(
				'fields' => array(
					'Productdiscount.id',
					'Productdiscount.product_id',
					'Productdiscount.discount_type_id',
					'Productdiscount.start_date',
					'Productdiscount.end_date',
					'Productdiscount.status',
					'Productdiscount.approved',
					'Productdiscount.created',
					'Producttranslation.title',
					'Discounttypetranslation.name',
				),
				'joins' => array(array(
					'table' => 'discounttypes',
					'alias' => 'Discounttype',
					'type' => 'INNER',
					'conditions' => array(
						'Discounttype.id = Productdiscount.discount_type_id')
				),
					array(
						'table' => 'products',
						'alias' => 'Product',
						'type' => 'INNER',
						'conditions' => array(
							'Product.id = Productdiscount.product_id')
					),
					array('table' => 'producttranslations',
						'alias' => 'Producttranslation',
						'type' => 'left',
						'conditions' => array(
							'Product.id = Producttranslation.product_id',
							"Producttranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
						)
					),
					array('table' => 'discounttypetranslations',
						'alias' => 'Discounttypetranslation',
						'type' => 'left',
						'conditions' => array(
							'Discounttype.id = Discounttypetranslation.discount_type_id',
							"Discounttypetranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
						)
					)
				),
				'limit' => $limit,
				'order' => array(
					'Productdiscount.id' => 'desc'
				)
			);
		}
		$ProductdiscountList = $this->paginate('Productdiscount');
		$this->set(compact('ProductdiscountList'));

	}

	public function LoadCombo()
	{
		$this->Productdiscount->Discounttype->recursive = -1;

		$options = array(
			'fields' => array('Discounttype.id', 'Discounttypetranslation.name'),
			'joins' => array(
				array('table' => 'discounttypetranslations',
					'alias' => 'Discounttypetranslation',
					'type' => 'left',
					'conditions' => array(
						'Discounttype.id = Discounttypetranslation.discount_type_id',
						"Discounttypetranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
					)
				)
			),
			'order' => array('Discounttypetranslation.name' => 'asc'),
			'conditions' => array());

		$lstproductdiscount = $this->Productdiscount->Discounttype->find('all', $options);
		$this->set('lstproductdiscount', $lstproductdiscount);

		$this->Productdiscount->Product->recursive = -1;

		$options = array(
			'fields' => array('Product.id', 'Producttranslation.title'),
			'joins' => array(
				array('table' => 'producttranslations',
					'alias' => 'Producttranslation',
					'type' => 'left',
					'conditions' => array(
						'Product.id = Producttranslation.product_id',
						"Producttranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
					)
				)
			),
			'order' => array('Producttranslation.title' => 'asc'),
			'conditions' => array());

		$lstProducts = $this->Productdiscount->Product->find('all', $options);
		$this->set('lstProducts', $lstProducts);
	}

	public function admin_add()
	{
		$this->set('title_for_layout', __d(__PRODUCT_LOCALE, 'add_productdiscount'));
		if ($this->request->is('post')) {
			$datasource = $this->Productdiscount->getDataSource();
			try {
				$datasource->begin();
				//pr($this->request->data);
				//return;
				$this->request->data['Productdiscount']['start_date'] = $this->Cms->convertPersianToEnglish(str_replace('/', '', $this->request->data['Productdiscount']['start_date']));
				$this->request->data['Productdiscount']['end_date'] = $this->Cms->convertPersianToEnglish(str_replace('/', '', $this->request->data['Productdiscount']['end_date']));
				if (!$this->Productdiscount->save($this->request->data))
					throw new Exception(__d(__PRODUCT_LOCALE, 'the_productdiscount_could_not_be_saved_Please_try_again'));

				$datasource->commit();
				$this->Redirect->flashSuccess(__d(__PRODUCT_LOCALE, 'the_discounttype_has_been_saved'), array('action' => 'index'));

			} catch (Exception $e) {
				$datasource->rollback();
				$this->Redirect->flashWarning($e->getMessage(), array('action' => 'index'));
			}
		}
		$this->LoadCombo();
	}

	public function admin_delete($id = null)
	{
		$this->Productdiscount->id = $id;
		if (!$this->Productdiscount->exists()) {
			$this->Redirect->flashWarning(__d(__PRODUCT_LOCALE, 'invalid_Productdiscount'));
		}

		$datasource = $this->Productdiscount->getDataSource();

		$datasource->begin();
		if ($this->Productdiscount->delete()) {
			$this->Redirect->flashSuccess(__d(__PRODUCT_LOCALE, 'the_Productdiscount_has_been_deleted'));
			$datasource->commit();
		} else {
			$datasource->rollback();
			$this->Redirect->flashWarning(__d(__PRODUCT_LOCALE, 'the_Productdiscount_could_not_be_deleted_please_try_again'));
		}

		return $this->redirect(array('action' => 'index'));
	}

	public function admin_edit($id = null)
	{
		$this->set('title_for_layout', __d(__PRODUCT_LOCALE, 'edit_productdiscount'));
		if (!$this->Productdiscount->exists($id)) {
			$this->Redirect->flashWarning(__d(__PRODUCT_LOCALE, 'invalid_Productdiscount'));
		}
		if ($this->request->is(array('post', 'put'))) {

			$datasource = $this->Productdiscount->getDataSource();
			try {
				$datasource->begin();

				$this->Productdiscount->id = $id;
				$this->request->data['Productdiscount']['start_date'] = $this->Cms->convertPersianToEnglish(str_replace('/', '', $this->request->data['Productdiscount']['start_date']));
				$this->request->data['Productdiscount']['end_date'] = $this->Cms->convertPersianToEnglish(str_replace('/', '', $this->request->data['Productdiscount']['end_date']));
				if (!$this->Productdiscount->save($this->request->data))
					throw new Exception(__d(__PRODUCT_LOCALE, 'the_Productdiscount_could_not_be_saved_Please_try_again'));

				$datasource->commit();
				$this->Redirect->flashSuccess(__d(__PRODUCT_LOCALE, 'the_Productdiscount_has_been_saved'), array('action' => 'index'));

			} catch (Exception $e) {
				$datasource->rollback();
				$this->Redirect->flashWarning($e->getMessage(), array('action' => 'index'));
			}

		} else {
			$this->Productdiscount->recursive = -1;
			$options = array('conditions' => array('Productdiscount.' . $this->Productdiscount->primaryKey => $id));
			$this->request->data = $this->Productdiscount->find('first', $options);
		}
		$this->LoadCombo();
	}
}
