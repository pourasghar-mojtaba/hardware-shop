<?php
App::uses('AppModel', 'Model');
/**
 * Contactmessage Model
 *
 * @property User $User
 */
class Contactmessage  extends AppModel {

	public $useTable = "contactmessages"; 
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';

}
?>