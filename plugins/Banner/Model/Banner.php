<?php

class Banner extends BannerAppModel {
	public $name = 'Banner';
	public $useTable = "banners"; 
	public $primaryKey = 'id';
	
	var $actsAs = array('Containable');
   
   
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
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
		'Bannerlocation' => array(
			'className' => 'Bannerlocation',
			'foreignKey' => 'bannerlocation_id',
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
		'Bannertranslation' => array(
			'className' => 'Bannertranslation',
			'foreignKey' => 'banner_id',
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
	);
	
 
	
}

?>