<?php
App::uses('PluginHandler', 'Lib');
class PluginHelper extends AppHelper
{
	public $helpers = array('Html','Form');
		
	function run_hook($hook,$arg=array()){
		PluginHandler::Instance()->run_hook($hook,$arg);
	}
}






?>