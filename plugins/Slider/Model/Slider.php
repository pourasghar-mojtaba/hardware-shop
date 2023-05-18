<?php

class Slider extends SliderAppModel
{
	public $name = 'Slider';
	public $primaryKey = 'id';

	var $actsAs     = array('Containable');
 

	public $hasMany = array(
		'Slidertranslation' => array(
			'className' => 'Slidertranslation',
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
		),
	);
}

?>