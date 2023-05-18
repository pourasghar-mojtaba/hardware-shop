<?php
App::uses('AppModel', 'Model');
/**
 * Productdiscount Model
 *
 * @property Product $Product
 * @property Discount $Discount
 */
class Productdiscount extends ProductAppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Product' => array(
			'className' => 'Product',
			'foreignKey' => 'product_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Discounttype' => array(
			'className' => 'Discounttype',
			'foreignKey' => 'discount_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
