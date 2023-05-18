<?php
App::uses('AppModel', 'Model');
/**
 * Discountcoupon Model
 *
 * @property Discounttype $Discounttype
 */
class Discountcoupon extends ProductAppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Discounttype' => array(
			'className' => 'Discounttype',
			'foreignKey' => 'discounttype_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
