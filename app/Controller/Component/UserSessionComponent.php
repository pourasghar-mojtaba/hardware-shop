<?php
App::uses('Component', 'Controller');
class UserSessionComponent extends Component
{
	public $components = array('Session');
	
	private $userInfo = array();
	private $fields = array('id','name','email','role_id');
	var $settings = array();
	var $controller = null;
	private $prefix = NULL;
	private $id = NULL;
	
	public function initialize(Controller $controller)
    {
        $this->controller = $controller;
		$this->settings = array('user' => 'User_Info','admin'=>'AdminUser_Info');
		 if(isset($this->controller->request->params['prefix'])){
		 	$this->prefix = $this->controller->request->params['prefix'];
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
	
	public function getRoleId(){
		return $this->_validInfo() ? $this->userInfo[$this->fields[3]] : NULL;
	}

}
?>