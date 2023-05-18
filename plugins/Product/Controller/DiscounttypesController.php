<?php
App::uses('AppController', 'Controller');

/**
 * Discounttypes Controller
 *
 * @property Discounttype $Discounttype
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class DiscounttypesController extends ProductAppController
{

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator', 'Session', 'Flash');

	public function admin_index()
	{
		$this->Discounttype->recursive = -1;
		$this->set('title_for_layout', __d(__PRODUCT_LOCALE, 'discounttype_list'));
		if (isset($_REQUEST['filter'])) {
			$limit = $_REQUEST['filter'];
		} else $limit = 10;

		if (isset($this->request->data['Discounttype']['search'])) {
			$this->request->data = Sanitize::clean($this->request->data);
			$this->paginate = array(
				'fields' => array(
					'Discounttype.id',
					'Discounttype.name',
					'Discounttype.percent',
					'Discounttype.amount',
					'Discounttype.created',
					'Discounttype.description'
				),
				'conditions' => array('Discounttype.title LIKE' => '' . $this->request->data['Discounttype']['search'] . '%'),
				'limit' => $limit,
				'order' => array(
					'Discounttype.id' => 'desc'
				)
			);
		} else {
			$this->paginate = array(
				'fields' => array(
					'Discounttype.id',
					'Discounttypetranslation.name',
					'Discounttype.percent',
					'Discounttype.amount',
					'Discounttype.created',
					'Discounttype.description'
				),
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
				'limit' => $limit,
				'order' => array(
					'Discounttype.id' => 'desc'
				)
			);
		}
		$DiscounttypeList = $this->paginate('Discounttype');
		$this->set(compact('DiscounttypeList'));
	}

	public function admin_add()
	{
		$this->set('title_for_layout', __d(__PRODUCT_LOCALE, 'add_discounttype'));
		if ($this->request->is('post')) {
			$datasource = $this->Discounttype->getDataSource();
			try {
				$datasource->begin();
				$this->request->data['Discounttype']['amount'] = str_replace(',', '', $this->request->data['Discounttype']['amount']);

				if (!$this->Discounttype->save($this->request->data))
					throw new Exception(__d(__PRODUCT_LOCALE, 'the_discounttype_could_not_be_saved_please_try_again'));
				$discount_type_id = $this->Discounttype->getLastInsertID();
				/** @product translate */

				$this->Discounttype->Discounttypetranslation->recursive = -1;
				$this->request->data['Discounttypetranslation']['discount_type_id'] = $discount_type_id;
				$this->request->data['Discounttypetranslation']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
				$this->request->data['Discounttypetranslation']['name'] = trim($this->request->data['Discounttypetranslation']['name']);
				$this->Discounttype->Discounttypetranslation->create();

				if (!$this->Discounttype->Discounttypetranslation->save($this->request->data))
					throw new Exception(__d(__PRODUCT_LOCALE, 'the_discounttype_could_not_be_saved_please_try_again'));

				/** product translate */

				$datasource->commit();
				$this->Redirect->flashSuccess(__d(__PRODUCT_LOCALE, 'the_discounttype_has_been_saved'), array('action' => 'index'));

			} catch (Exception $e) {
				$datasource->rollback();
				$this->Redirect->flashWarning($e->getMessage(), array('action' => 'index'));
			}
		}
	}

	public function admin_delete($id = null)
	{
		$this->Discounttype->id = $id;
		if (!$this->Discounttype->exists()) {
			$this->Redirect->flashWarning(__d(__PRODUCT_LOCALE, 'invalid_Discounttype'));
		}

		$datasource = $this->Discounttype->getDataSource();
		try {
			$datasource->begin();
			if (!$this->Discounttype->delete())
				throw new Exception(__d(__PRODUCT_LOCALE, 'the_discounttype_could_not_be_deleted_please_try_again'));
			if (!$this->Discounttype->Discounttypetranslation->deleteAll(array('discount_type_id' => $id), false))
				throw new Exception(__d(__PRODUCT_LOCALE, 'the_discounttype_could_not_be_deleted_please_try_again'));
			//if (!$this->Discounttype->Discountcoupon->deleteAll(array('discounttype_id' => $id), false))
				//throw new Exception(__d(__PRODUCT_LOCALE, 'the_discounttype_could_not_be_deleted_please_try_again'));

			$datasource->commit();

			$this->Redirect->flashSuccess(__d(__PRODUCT_LOCALE, 'the_discounttype_has_been_deleted'));
		} catch (Exception $e) {
			$datasource->rollback();
			$this->Redirect->flashWarning($e->getMessage(), array('action' => 'index'));
		}

		return $this->redirect(array('action' => 'index'));
	}

	public
	function admin_edit($id = null)
	{
		$this->set('title_for_layout', __d(__PRODUCT_LOCALE, 'edit_Discounttype'));
		if (!$this->Discounttype->exists($id)) {
			$this->Redirect->flashWarning(__d(__PRODUCT_LOCALE, 'invalid_Discounttype'));
		}
		if ($this->request->is(array('post', 'put'))) {

			$datasource = $this->Discounttype->getDataSource();
			try {
				$datasource->begin();
				$this->request->data['Discounttype']['amount'] = str_replace(',', '', $this->request->data['Discounttype']['amount']);
				if (!$this->Discounttype->save($this->request->data))
					throw new Exception(__d(__PRODUCT_LOCALE, 'the_discounttype_could_not_be_saved_please_try_again'));


				$this->Discounttype->Discounttypetranslation->recursive = -1;
				$options = array();
				$options['conditions'] = array(
					"Discounttypetranslation.discount_type_id" => $id,
					"Discounttypetranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
				);
				$count = $this->Discounttype->Discounttypetranslation->find('count', $options);
				/*
				* @product translate
				*/
				if ($count == 0) {
					$this->Discounttype->Discounttypetranslation->recursive = -1;
					$this->request->data['Discounttypetranslation']['discount_type_id'] = $id;
					$this->request->data['Discounttypetranslation']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
					$this->request->data['Discounttypetranslation']['name'] = trim($this->request->data['Discounttypetranslation']['name']);
					$this->Discounttype->create();
					if (!$this->Discounttype->Discounttypetranslation->save($this->request->data))
						throw new Exception(__d(__PRODUCT_LOCALE, 'the_discounttype_could_not_be_saved_please_try_again'));
				} else {
					$ret = $this->Discounttype->Discounttypetranslation->updateAll(
						array('Discounttypetranslation.name' => '"' . trim($this->request->data['Discounttypetranslation']['name']) . '"',
						),
						array('Discounttypetranslation.discount_type_id' => $id, 'language_id' => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID))

					);
					if (!$ret) {

						throw new Exception(__d(__PRODUCT_LOCALE, 'the_discounttype_could_not_be_saved_please_try_againfh'));
					}
				}

				$datasource->commit();
				$this->Redirect->flashSuccess(__d(__PRODUCT_LOCALE, 'the_discounttype_has_been_saved'), array('action' => 'index'));

			} catch (Exception $e) {
				$datasource->rollback();
				$this->Redirect->flashWarning($e->getMessage(), array('action' => 'index'));
			}

		} else {
			$this->Discounttype->recursive = -1;

			$options = array();
			$options['fields'] = array(
				'Discounttype.id',
				'Discounttype.percent',
				'Discounttype.amount',
				'Discounttype.created',
				'Discounttype.description',
				'Discounttypetranslation.name',
			);
			$options['joins'] = array(
				array('table' => 'discounttypetranslations',
					'alias' => 'Discounttypetranslation',
					'type' => 'left',
					'conditions' => array(
						'Discounttype.id = Discounttypetranslation.discount_type_id',
						"Discounttypetranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
					)
				)
			);
			$options['conditions'] = array(
				"Discounttype.id" => $id,
			);

			$this->request->data = $this->Discounttype->find('first', $options);

		}
	}
}
