<?php

class Bannertranslation extends BannerAppModel {
	public $name = 'Bannertranslation';
 
	public $primaryKey = 'id';
	
	var $actsAs = array('Containable');
   
   
	public $belongsTo = array(
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
		)
	);
	
 
	
}

?>