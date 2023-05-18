<?php
App::uses('AppController', 'Controller');
/**
 * Discountcoupons Controller
 *
 * @property Discountcoupon $Discountcoupon
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class DiscountcouponsController extends ProductAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Flash');

	public function admin_index() {
		$this->Discountcoupon->recursive = -1;
		$this->set('title_for_layout',__d(__SHOP_LOCALE,'Discountcoupon_list'));
		if(isset($_REQUEST['filter'])){
			$limit = $_REQUEST['filter'];
		}
		else $limit = 10;

		if(isset($this->request->data['Discountcoupon']['search'])){
			$this->request->data = Sanitize::clean($this->request->data);
			$this->paginate = array(
				'fields'=>array(
					'Discountcoupon.id',
					'Discountcoupon.discounttype_id',
					'discounttypes.name',
					'Discountcoupon.code',
					'Discountcoupon.created'
				),
				'joins'=> array(array(
					'table'=> 'discounttypes',
					'alias'=> 'discounttypes',
					'type'=> 'INNER',
						'conditions'=> array(
							'discounttypes.id = Discountcoupon.discounttype_id'))),
				'conditions' => array('discounttypes.name LIKE'=> ''.$this->request->data['Discountcoupon']['search'].'%' ),
				'limit'     => $limit,
				'order'                     => array(
					'Discountcoupon.id'=> 'desc'
				)
			);
		}
		else
		{
			$this->paginate = array(
				'fields'=>array(
					'Discountcoupon.id',
					'Discountcoupon.discounttype_id',
					'discounttypes.name',
					'Discountcoupon.code',
					'Discountcoupon.created'
				),
				'joins'=> array(array(
					'table'=> 'discounttypes',
					'alias'=> 'discounttypes',
					'type'=> 'INNER',
						'conditions'=> array(
							'discounttypes.id = Discountcoupon.discounttype_id'))),
				'limit'     => $limit,
				'order'                     => array(
					'Discountcoupon.id'=> 'desc'
				)
			);
		}
		$DiscountcouponList = $this->paginate('Discountcoupon');
		$this->set(compact('DiscountcouponList'));
	}

	public function admin_add() {
		$this->set('title_for_layout',__d(__SHOP_LOCALE,'add_Discountcoupon'));
		if($this->request->is('post')){
			$datasource = $this->Discountcoupon->getDataSource();
			try
			{
				$datasource->begin();

				$dscntLst = array();
				$i=0;
				for($i=0;$i<=(int)$this->request->data['count1'];$i++)
				{
					$dscntLst[]=array(
						'discounttype_id'	=>	$this->request->data['dscntid'],
						'code'				=>	strtoupper(md5(rand()+date("Y-m-d")))
					);
				}

				if(!$this->Discountcoupon->saveMany($dscntLst,array('deep' => true)))
					throw new Exception(__d(__SHOP_LOCALE,'the_Discountcoupon_could_not_be_saved_Please_try_again'));

				$datasource->commit();
				$this->Redirect->flashSuccess(__d(__SHOP_LOCALE,'the_Discountcoupon_has_been_saved'),array('action'=>'index'));

			} catch(Exception $e){
				$datasource->rollback();
				$this->Redirect->flashWarning($e->getMessage(),array('action'=>'index'));
			}
		}
		$this->LoadCombo();
	}

	public function LoadCombo()
	{
		$this->loadModel('discounttypes');
		$this->discounttypes->recursive = -1;

		$options= array(
		'fields' => array('discounttypes.id','discounttypes.name' ),
		'joins'=>array(),
		'order'=>array('discounttypes.name'=>'asc'),
		'conditions'=>array());

		$lstDiscountType = $this->discounttypes->find('all',$options);
		$this->set('lstDiscountType',$lstDiscountType);
	}

	public function admin_delete($id = null) {
		$this->Discountcoupon->id = $id;
		if(!$this->Discountcoupon->exists()){
			$this->Redirect->flashWarning(__d(__SHOP_LOCALE,'invalid_Discountcoupon'));
		}

		if($this->Discountcoupon->delete()){
			$this->Redirect->flashSuccess(__d(__SHOP_LOCALE,'the_Discountcoupon_has_been_deleted'));
		}
		else
		{
			$this->Redirect->flashWarning(__d(__SHOP_LOCALE,'the_Discountcoupon_could_not_be_deleted_please_try_again'));
		}
		return $this->redirect(array('action'=> 'index'));
	}

	public function admin_edit($id = null)
	{
		return $this->redirect(array('action'=> 'index'));
		$this->set('title_for_layout',__d(__SHOP_LOCALE,'edit_Discountcoupon'));
		if(!$this->Discountcoupon->exists($id)){
			$this->Redirect->flashWarning(__d(__SHOP_LOCALE,'invalid_Discountcoupon'));
		}
		if($this->request->is(array('post', 'put'))){

			$datasource = $this->Discountcoupon->getDataSource();
			try
			{
				$datasource->begin();
				if(!$this->Discountcoupon->save($this->request->data))
				throw new Exception(__d(__SHOP_LOCALE,'the_Discountcoupon_could_not_be_saved_Please_try_again'));

				$datasource->commit();
				$this->Redirect->flashSuccess(__d(__SHOP_LOCALE,'the_Discountcoupon_has_been_saved'),array('action'=>'index'));

			} catch(Exception $e)
			{
				$datasource->rollback();
				$this->Redirect->flashWarning($e->getMessage(),array('action'=>'index'));
			}

		}
		else
		{
			$this->Discountcoupon->recursive = -1;
			$options = array('conditions' => array('Discountcoupon.' . $this->Discountcoupon->primaryKey=> $id));

			$this->request->data = $this->Discountcoupon->find('first', $options);

		}
	}
}
