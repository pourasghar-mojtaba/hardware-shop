<?php
App::uses('AppModel', 'Model');
/**
 * Discounttype Model
 *
 */
class Discounttype extends ProductAppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	public $hasMany = array(
		'Discountcoupon' => array(
			'className' => 'Discountcoupon',
			'foreignKey' => 'discounttype_id',
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
		'Productdiscount' => array(
			'className' => 'Productdiscount',
			'foreignKey' => 'discount_type_id',
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
		'Discounttypetranslation' => array(
			'className' => 'Discounttypetranslation',
			'foreignKey' => 'discount_type_id',
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
