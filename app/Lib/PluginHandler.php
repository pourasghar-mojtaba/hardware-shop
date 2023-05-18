<?php

App::uses('Plugin', 'Model');
App::uses('View', 'View');
App::uses('HtmlHelper', 'View/Helper');

final
class PluginHandler
{

	private  $hook_list = NULL;
	public static $request = NULL;


	public static
	function Instance($req = NULL)
	{
		static $inst = null;
		if($inst === null){
			$inst = new PluginHandler();
		}
		if(!empty($req))			
		self::$request = $req;
		return $inst;
	}
	
	private function _makefilelist($folder, $filter, $sort = true, $type = "files", $ext_filter = "")
	{
		$res = array();
		$filter = explode("|", $filter);
		if($type == "files" && !empty($ext_filter)){
			$ext_filter = explode("|", strtolower($ext_filter));
		}
		$temp = opendir($folder);
		while($file = readdir($temp)){
			if($type == "files" && !in_array($file, $filter)){
				if(!empty($ext_filter)){
					if(!in_array(substr(strtolower(stristr($file, '.')), + 1), $ext_filter) && !is_dir($folder.$file)){
						$res[] = $file;
					}
				}
				else
				{
					if(!is_dir($folder.$file)){
						$res[] = $file;
					}
				}
			}
			elseif($type == "folders" && !in_array($file, $filter)){
				if(is_dir($folder.$file)){
					$res[] = $file;
				}
			}
		}
		closedir($temp);
		if($sort){
			sort($res);
		}
		return $res;
	}

	/**
	* Private ctor so nobody else can instance it
	*
	*/
	private
	function __construct()
	{
		$this->Plugin = new Plugin();
		$this->Html = new HtmlHelper(new View());
	}

	public
	function load()
	{
		$plagin_list = $this->_makefilelist(__PLUGINS, ".|..", true, "folders");
		if(!empty($plagin_list)){
			foreach($plagin_list as $plugin)
			{
				
				CakePlugin::load($plugin);
				$bootstrap = __PLUGINS.$plugin.DS . 'Config' . DS . 'bootstrap.php';
				if(file_exists($bootstrap))
					require_once $bootstrap;
			}
		}
	}

	public
	function attach()
	{
		$plugins = $this->Plugin->_getPlugins(1);
		if(!empty($plugins))
		{
			foreach($plugins as $plugin)
			{
				if($plugin['Plugin']['status'])					
				if(file_exists(__THEME_PLUGINS. $plugin['Plugin']['name'].DS.'hooks.php')){
					require_once __THEME_PLUGINS. $plugin['Plugin']['name'].DS.'hooks.php';
				}
				else require_once __PLUGINS . $plugin['Plugin']['name'].DS.'hooks.php';
			}
		}
	}

	function add_hook($hook, $function)
	{
		$arr = array($hook=>$function);
		if(count($this->hook_list) > 0)		$this->hook_list[] = $arr;
		else		$this->hook_list[] = $arr;
	}



	function run_hook($hook,$arg)
	{
		$argument = array("request"  =>self::$request,"arguments"=>$arg,'Html'=>$this->Html);
		if(!empty($this->hook_list))
		{
			foreach($this->hook_list as $key => $value)
			{

				foreach($value as $var_hook => $var_function)
				{
					if($var_hook == $hook)
					{
						call_user_func($var_function,$argument);
					}
				}
			}
		}
	}


}
?>