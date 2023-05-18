<?php

class Bannerlocation extends BannerAppModel {
	public $name = 'Bannerlocation';
  
	public $primaryKey = 'id';
	
	var $actsAs = array('Containable');
   
   	
  public $hasMany = array(
		'Banner' => array(
			'className' => 'Banner',
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