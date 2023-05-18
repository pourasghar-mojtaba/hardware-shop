<?php

class Order extends ProductAppModel {
	public $name = 'Order';
	public $useTable = "orders";
	public $primaryKey = 'id';

	var $actsAs = array('Containable');


   public $hasMany = array(
		'Orderitem' => array(
			'className' => 'Orderitem',
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
		)

	);


}

?>
