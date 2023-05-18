<?php

class Productrate extends ProductAppModel {
	public $name = 'Productrate';
	public $useTable = "productrates";
	public $primaryKey = 'id';

	var $actsAs = array('Containable');


   public $belongsTo = array(
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
		)
	);


}

?>
