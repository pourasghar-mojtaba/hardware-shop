<?php

class UserSessionHelper extends AppHelper
{
	public $helpers = array('Html','Session','Cookie');
	
	private $userInfo = array();
	private $fields = array('id','name','email','role_id');
	var $settings = array();
	var $view = null;
	private $prefix = NULL;
	
	public function __construct(View $view, $settings = array()) {
         parent::__construct($view, $settings);
		 $this->settings = array_merge(array('user' => 'User_Info','admin'=>'AdminUser_Info'), $settings);
		 $this->view = $view;
		 if(isset($this->view->request->params['prefix'])){
		 	$this->prefix = $this->view->request->params['prefix'];
		 }
         $this->userInfo=$this->Session->read($this->_getValidKey());
		 
    }
	
	private function _getValidKey(){
		if(isset($this->prefix) && !empty($this->prefix)){
			return $this->settings['admin'];
		}
		return $this->settings['user'];
	}
	
	private function _validInfo(){	
		if (isset($this->userInfo) && !empty($this->userInfo)){
			return TRUE;
		}	
		return FALSE;
	}
	
	public function getId(){
		return $this->_validInfo() ? $this->userInfo[$this->fields[0]] : NULL;
	}
	
	public function getName(){
		return $this->_validInfo() ? $this->userInfo[$this->fields[1]] : NULL;
	}

}






?>