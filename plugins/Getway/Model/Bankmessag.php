<?php

class Bankmessag extends GetwayAppModel {
	public $name = 'Bankmessag';
	public $useTable = "bankmessags"; 
	public $primaryKey = 'id';
	
	var $actsAs = array('Containable');
   
	/*
	public $belongsTo = array(
		'Productcategory' => array(
			'className' => 'Productcategory',
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

   public $hasMany = array(
		'Productrate' => array(
			'className' => 'Productrate',
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
        'Technicalinfoitemvalue' => array(
			'className' => 'Technicalinfoitemvalue',
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
		
	);*/
 
	
}

?>