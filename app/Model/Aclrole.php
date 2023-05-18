<?php
App::uses('AppModel', 'Model');
/**
 * Aclrole Model
 *
 * @property Role $Role
 * @property Aclitem $Aclitem
 */
class Aclrole extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'role_id';


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Role' => array(
			'className' => 'Role',
			'foreignKey' => 'role_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Aclitem' => array(
			'className' => 'Aclitem',
			'foreignKey' => 'aclitem_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>