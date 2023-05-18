<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');
/**
* Users Controller
*
* @property User $User
* @property PaginatorComponent $Paginator
*/
class LanguagesController extends AppController
{
	
	public function beforeFilter() {
		parent::beforeFilter();
		
		$this->Auth->allow(array('')); 
		 
		$this->_add_admin_member_permision(array('admin_getall','admin_change'));
		
		$this->_add_member_permision(array(''));
	 }
	
	
	/**
	* Components
	*
	* @var array
	*/
	public $components = array('Paginator','Httpupload');
	public $helpers = array('AdminHtml'=>array('action'=>'User'));
	/**
	* index method
	*
	* @return void
	*/	
	 
	public function admin_getall(){
		return $this->Language->_getAllLangs();
	}
	
	public function admin_change($lang,$id){
		$this->Cookie->write(__ADMIN_LANG_INDEX, $lang, false, 3600*3600);
		$this->Cookie->write(__ADMIN_LANG_DEFAULT_ID, $id, false, 3600*3600);
		$this->Redirect($_SERVER["HTTP_REFERER"]);
	}
}
?>