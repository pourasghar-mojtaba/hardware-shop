<?php


class BannerAppController extends AppController{
	public $components = array('Paginator','Httpupload','CmsAcl'=>array('allUsers'=>array('index')));
	//public $helpers = array(__SHOP_PLUGIN.'.Shop');
	public function beforeFilter(){
		parent::beforeFilter();	  	
			
		//$this->layout = 'Shop.main';
	}
}
?>