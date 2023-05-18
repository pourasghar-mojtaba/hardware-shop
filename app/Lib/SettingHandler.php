<?php

App::uses('Setting', 'Model');


final
class SettingHandler
{

	public  $siteTitle = NULL;
	public  $siteKeywords = NULL;
	public  $siteDescription = NULL;


	public static
	function Instance($req = NULL)
	{
		static $inst = null;
		if($inst === null){
			$inst = new SettingHandler();
		}
		if(!empty($req))
		self::$request = $req;
		return $inst;
	}

	/**
	* Private ctor so nobody else can instance it
	*
	*/
	private
	function __construct()
	{
		$this->Setting = new Setting();

		$setting = $this->Setting->_getSetting(empty($_COOKIE['CakeCookie'][__ADMIN_LANG_DEFAULT_ID])?$_COOKIE['CakeCookie']:$_COOKIE['CakeCookie'][__ADMIN_LANG_DEFAULT_ID]);

		if(!empty($setting)){
			$this->siteTitle = $setting['Setting']['site_title'];
			$this->siteKeywords = $setting['Setting']['site_keywords'];
			$this->siteDescription = $setting['Setting']['site_description'];
		}
	}



}
?>
