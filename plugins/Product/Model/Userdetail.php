<?php

App::uses('CakeEmail', 'Network/Email');

class Userdetail extends ProductAppModel {

    public $name = 'Userdetail';
	public $useTable = "user_details";
    var $actsAs = array( 'Containable');


  public $belongsTo = array(
		'User' => array(
			'className'  => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Court' => array(
			'className'  => 'Court',
			'foreignKey' => 'court_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'City' => array(
			'className'  => 'City',
			'foreignKey' => 'city_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


}
