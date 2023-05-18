<?php
App::uses('Component', 'Controller');
class RedirectComponent extends Component {
  
  var $controller = null;
  
  var $components = array('Session');
  
  var $settings = array();
  
  var $success = null;
  
  var $warning = null;
  
  var $perfix = NULL; 
  
  function initialize(Controller $controller)
  {
    $this->controller = $controller;
	if(isset($this->controller->request->params['prefix'])){
		$this->perfix = $this->controller->request->params['prefix'];
	}else $this->perfix = '';
	
    $this->settings = array_merge(array('success' => 'success', 'warning' => 'warning','adminsuccess'=>'admin_success','adminwarning' => 'admin_warning'));
    $this->success = $this->settings[$this->perfix.'success'];
    $this->warning = $this->settings[$this->perfix.'warning'];
  }
  
  function flashSuccess($msg, $url = null)
  {
    $this->Session->setFlash(__($msg, true), $this->success);
    if (!empty($url)) 
    {
     $this->controller->redirect($url, null, true); 
    }
  }
  
  function flashWarning($msg, $url = null)
  {
    $this->Session->setFlash(__($msg, true), $this->warning);
    if (!empty($url)) 
    {
     $this->controller->redirect($url, null, true); 
    }
  }  
  
  function idEmpty($id, $url)
  {
    if (!$id && empty($this->controller->data)) {
			$this->flashWarning('Invalid Id. Please check your link.', $url);
		}
  }
  
  function urlToNamed()
  {
    $urlArray = $this->controller->params['url'];
    unset($urlArray['url']);
    if (!empty($urlArray)) 
    {
      $this->controller->redirect($urlArray, null, true);
    }
  }
   
}
?>