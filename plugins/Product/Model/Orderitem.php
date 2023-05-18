<?php

class Orderitem extends ProductAppModel {
	public $name = 'Orderitem';
	public $useTable = "orderitems";
	public $primaryKey = 'id';

	var $actsAs = array('Containable');


   public $belongsTo = array(
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'order_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	   'Product' => array(
		   'className' => 'Product',
		   'foreignKey' => 'product_id',
		   'dependent' => false,
		   'conditions' => '',
		   'fields' => '',
		   'order' => '',
		   'limit' => '',
		   'offset' => '',
		   'exclusive' => '',
		   'finderQuery' => '',
		   'counterQuery' => ''
	   ),
		'Settlement' => array(
			'className' => 'Settlement',
			'foreignKey' => 'settlement_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	 public $hasMany = array(
		/*'Product' => array(
			'className' => 'Product',
			'foreignKey' => 'product_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)*/

	);

}

?>
