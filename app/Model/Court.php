<?php
App::uses('AppModel', 'Model');
/**
 * Role Model
 *
 * @property User $User
 */
class Court extends AppModel
{
    public $name = 'Court';
	public $useTable = "courts";
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


	public $hasMany = array(
		'City' => array(
			'className' => 'City',
			'foreignKey' => 'court_id',
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

	function _getList(){
		return $this->find('list');
	}
}
?>
