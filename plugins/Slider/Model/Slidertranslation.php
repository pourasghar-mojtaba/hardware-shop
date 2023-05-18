<?php

class Slidertranslation extends SliderAppModel {
	public $name = 'Slidertranslation';
 
	public $primaryKey = 'id';
	
	var $actsAs = array('Containable');
   
   
	public $belongsTo = array(
		'Slider' => array(
			'className' => 'Slider',
			'foreignKey' => 'slider_id',
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