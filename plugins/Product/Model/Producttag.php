<?php

class Producttag extends ProductAppModel {
	public $name = 'Producttag';
	public $useTable = "producttags";
	public $primaryKey = 'id';

	var $actsAs = array('Containable');


   public $hasMany = array(
		'Productrelatetag' => array(
			'className' => 'Productrelatetag',
			'foreignKey' => 'product_tag_id',
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
