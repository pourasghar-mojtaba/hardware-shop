<?php

class Productimagetranslation extends ProductAppModel {

	var $actsAs = array('Containable');



 	public $belongsTo = array(

		'Productimage' => array(
			'className' => 'Productimage',
			'foreignKey' => 'product_image_id',
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
