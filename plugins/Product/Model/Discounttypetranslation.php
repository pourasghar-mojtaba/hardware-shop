<?php

class Discounttypetranslation extends ProductAppModel {
	public $name = 'Discounttypetranslation';

	public $primaryKey = 'id';

	var $actsAs = array('Containable');


	public $belongsTo = array(

		'Discounttype' => array(
			'className' => 'Discounttype',
			'foreignKey' => 'discount_type_id',
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
