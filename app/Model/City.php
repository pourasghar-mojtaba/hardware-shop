<?php
App::uses('AppModel', 'Model');
/**
 * Role Model
 *
 * @property User $User
 */
class City extends AppModel
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
}
?>