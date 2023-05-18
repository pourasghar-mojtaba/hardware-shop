<?php

App::uses('Component', 'Controller');
class CmsAclComponent extends Component
{

    public $components = array('Session','UserSession','Redirect');
	var $settings = array();

	public $memberAllow = array('display');
	private $allUsers = array('display','view');
	public $adminMemberAllow = array(
            'admin_dashboard',
            'admin_logout',
            'admin_index',
            'admin_active_permission',
            'admin_inactive_permission',
            'admin_add',
            'admin_edit',
            'admin_delete',
            'admin_inactive_permission'
           ,'admin_active_permission'
           ,'admin_get_plugin'
           ,'admin_inactive'
           ,'admin_active'
           ,'admin_install'
           ,'admin_uninstall'
		);
	private $adminAllUsers = array('admin_login', 'admin_logout');

	function __construct(ComponentCollection $collection, $settings = array()){
		parent::__construct($collection, $settings);
		$this->settings['memberAllow'] = $this->memberAllow;
		$this->settings['allUsers'] = $this->allUsers;
		$this->settings['adminMemberAllow'] = $this->adminMemberAllow;
		$this->settings['adminAllUsers'] = $this->adminAllUsers;
		if(!empty($settings['memberAllow'])) $this->settings['memberAllow'] = array_merge($this->memberAllow,$settings['memberAllow']);
		if(!empty($settings['allUsers'])) $this->settings['allUsers'] = array_merge($this->allUsers,$settings['allUsers']);
		if(!empty($settings['adminMemberAllow'])) $this->settings['adminMemberAllow'] = array_merge($this->adminMemberAllow,$settings['adminMemberAllow']);
		if(!empty($settings['adminAllUsers'])) $this->settings['adminAllUsers'] = array_merge($this->adminAllUsers,$settings['adminAllUsers']);
	}

    public function initialize(Controller $controller)
    {
        $this->controller = $controller;
    }

    public function check_permision($params)
    {

        if (isset($params['prefix']))
        {
            if ($params['prefix'] == 'admin')
            {
                if ($params['action'] == 'admin_logout')
                    return;
                if ($params['action'] == 'admin_dashboard')
                    return;
                if ($params['action'] == 'admin_login')
                    return;
                if (!$this->check_role_permision($params['controller'], $params['action']))
                {
                    $this->Session->setFlash(__('invalid_permision'), 'admin_error');
                    $this->controller->redirect($this->controller->referer());
                }
            }
        }

    }

    public function check_role_permision($controller, $action)
    {
        App::import('Model', 'User');
        $user = new User();
        $user->recursive = -1;

        if ($this->UserSession->getRoleId() == 1)
        {
            return 1;
        }
		$userId = $this->UserSession->getId();
		if(!isset($userId) && empty($userId)){
			$this->Redirect->flashWarning(__('can_not_login_in_admin'),__SITE_URL.'admin');
		}

        $sql = "SELECT count(*) as count

										FROM `users` as User

									   inner join roles as Role
									           on Role.id=User.role_id
									   inner join aclroles as Aclrole
									           on Aclrole.role_id = Role.id 
									   inner join aclitems as Aclitem        
									   	    on Aclitem.id=Aclrole.aclitem_id	
									           
									 where User.id= " . $this->UserSession->getId() . "  
									   and Aclitem.controller = '" . $controller . "'
									   and Aclitem.action = '" . $action . "'
 		                                ";

        //pr($sql);
        $result = $user->query($sql);
        return $result['0']['0']['count'];
    }


    public function _memberAllow()
    {
        return $this->settings['memberAllow'];
    }

    public function _allUsers()
    {
        return $this->settings['allUsers'];
    }

    public function _adminMemberAllow()
    {
	   return $this->settings['adminMemberAllow'];
    }

    public function _adminAllUsers()
    {
        return $this->settings['adminAllUsers'];
    }
}
?>
