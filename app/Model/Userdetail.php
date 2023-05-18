<?php

App::uses('CakeEmail', 'Network/Email');

class Userdetail extends AppModel
{

	public $name = 'Userdetail';
	public $useTable = "user_details";
	var $actsAs = array('Containable');


	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Country' => array(
			'className' => 'Country',
			'foreignKey' => 'country_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Court' => array(
			'className' => 'Court',
			'foreignKey' => 'court_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'City' => array(
			'className' => 'City',
			'foreignKey' => 'city_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	,
		'Local' => array(
			'className' => 'Local',
			'foreignKey' => 'local_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public
	function _getUserData($user_id)
	{
		$this->recursive = -1;
		$result = $this->find('first', array('conditions' => array('Userdetail.user_id' => $user_id)));
		return $result;
	}

	public function _getAddressess($user_id)
	{
		$this->recursive = -1;
		$options['fields'] = array(
			'Court.name',
			'City.name',
			'Local.name',
			'Userdetail.id',
			'Userdetail.address',
			'Userdetail.telephon',
			'Userdetail.visit_price_booklet',
			'Userdetail.visit_price_free',
			'Userdetail.latitude',
			'Userdetail.longitude',
			'Userdetail.day_type1',
			'Userdetail.from_time1',
			'Userdetail.to_time1',
			'Userdetail.day_type2',
			'Userdetail.from_time2',
			'Userdetail.to_time2'
		);
		$options['joins'] = array(
			array('table' => 'courts',
				'alias' => 'Court',
				'type' => 'LEFT',
				'conditions' => array(
					'Court.id = Userdetail.court_id and Court.status = 1',
				)
			),
			array('table' => 'cities',
				'alias' => 'City',
				'type' => 'LEFT',
				'conditions' => array(
					'City.id = Userdetail.city_id and City.status = 1',
				)
			),
			array('table' => 'locals',
				'alias' => 'Local',
				'type' => 'LEFT',
				'conditions' => array(
					'Local.id = Userdetail.local_id and Local.status = 1',
				)
			)

		);
		$options['conditions'] = array(
			'Userdetail.user_id ' => $user_id
		);
		$user_details = $this->find('all', $options);
		return $user_details;
	}

}
