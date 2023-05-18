<?php

class Productcomment extends ProductAppModel {
	public $name = 'Productcomment';
	public $useTable = "productcomments";
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
