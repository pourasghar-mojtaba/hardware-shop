<?php
App::uses('AppModel', 'Model');
/**
 * Role Model
 *
 * @property User $User
 */
class City extends ProductAppModel
{
    public $name = 'City';
	public $useTable = "cities";
	public $primaryKey = 'id';

	var $actsAs = array('Containable');

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

 /* hasMany associations
 *
 * @var array
 */

 	 public $belongsTo = array(
		'Court' => array(
			'className'  => 'Court',
			'foreignKey' => 'court_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)

	);

	public $hasMany = array(
		'Userdetail' => array(
			'className' => 'Userdetail',
			'foreignKey' => 'city_id',
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
