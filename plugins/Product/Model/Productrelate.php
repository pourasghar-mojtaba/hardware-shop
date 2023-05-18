<?php

class Productrelate extends ProductAppModel {
	public $name = 'Productrelate';
	public $useTable = "productrelates";
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
