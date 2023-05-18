<?php

class Request extends ProductAppModel {
	public $name = 'Request';
	public $useTable = "requests";
	public $primaryKey = 'id';

	var $actsAs = array('Containable');

}

?>
