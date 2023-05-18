<?php

class Productcategorytranslation extends ProductAppModel {
	public $name = 'Productcategorytranslation';

	public $primaryKey = 'id';

	var $actsAs = array('Containable');


	public $belongsTo = array(

		'Productcategory' => array(
			'className' => 'Productcategory',
			'foreignKey' => 'product_category_id',
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
