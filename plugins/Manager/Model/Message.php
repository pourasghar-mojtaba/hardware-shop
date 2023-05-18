<?php

class Message extends ManagerAppModel {
	public $name = 'Message';
	public $useTable = "manager_messages"; 
	public $primaryKey = 'id';
	
	var $actsAs = array('Containable');
 
	
}

?>