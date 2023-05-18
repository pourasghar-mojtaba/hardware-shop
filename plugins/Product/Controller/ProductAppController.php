<?php

App::uses('Sanitize', 'Utility');
class ProductAppController extends AppController {
   /*public function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'Shop.main';
    }*/
	public $helpers = array(__PRODUCT_PLUGIN.'.Product');
	var $components = array('Cms','Httpupload');


}
?>
