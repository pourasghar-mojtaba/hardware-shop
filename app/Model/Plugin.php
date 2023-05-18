<?php
App::uses('AppModel', 'Model');
/**
* Plugin Model
*
*/
class Plugin extends AppModel
{

	/**
	* Primary key field
	*
	* @var string
	*/
	function _getPlugins($active = -1)
	{
		if($active==1){
			return $this->find('all',array('conditions'=>array('status'=>$active)));
		}
		return $this->find('all');	 
	}
	
	function _getPlugin($plugin_name)
	{
		$plugin = $this->find('first',array('conditions'=>array('name'=>$plugin_name)));	
		return $plugin;
	}

}
?>