<?php

class Company extends CompanyAppModel
{
	public $name = 'Company';
	public $primaryKey = 'id';

	var $actsAs     = array('Containable');


	public $hasMany = array(
		'Companytranslation' => array(
			'className' => 'Companytranslation',
			'foreignKey' => 'company_id',
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
