<?php

App::uses('Controller', 'Controller');
App::uses('PluginHandler', 'Lib');
App::uses('SettingHandler', 'Lib');

class AppController extends Controller
{
	public $components = array(
		'Cookie',
		'Session',
		'RequestHandler',
		'Auth',
		'CmsAcl',
		'Redirect',
		'UserSession',
		'Cms',
		'CmsDate');
	public $helpers = array(
		'Html',
		'Form',
		'Session',
		'Text',
		'Time',
		'Paginator',
		'UserSession',
		'PersianDate',
		'Cms',
		'Plugin'
	, 'Paginate');

	//public $view = 'Themed';
	//public $theme = __THEME;

	public function beforeRender()
	{
		$this->_configureErrorLayout();
	}

	public function _configureErrorLayout()
	{
		if ($this->name == 'CakeError') {
			if ($this->_isAdminMode()) {
				$this->layout = 'admin_error';
			} else {
				$this->layout = 'error';
			}
		}
	}

	public function _isAdminMode()
	{
		$adminRoute = Configure::read('Routing.prefixes');
		if (isset($this->params['prefix']) && in_array($this->params['prefix'], $adminRoute)) {
			return true;
		}
		return false;
	}


	public function beforeFilter()
	{

		PluginHandler::Instance($this->request)->attach();
		SettingHandler::Instance();

		$this->theme = __THEME;

		$this->_setLanguage();


		$this->_saveRequestInformation();


		$this->CmsAcl->check_permision($this->request->params);

		if ($this->request->is('ajax')) {
			Configure::write('debug', 0);
			$this->layout = 'ajax';
			$this->autoRender = false;
		}

		$this->Auth->authorize = array('Actions' => array('actionPath' => 'controllers'));

		if (isset($this->request->params['admin']) && ($this->request->params['prefix'] == 'admin')) {
			//$components = array('AdminHtml');
			$this->Auth->loginAction = array(
				'controller' => 'users',
				'action' => 'login',
				'admin' => true);
			$this->Auth->logoutRedirect = array(
				'controller' => 'users',
				'action' => 'login',
				'admin' => true);
			$this->Auth->loginRedirect = array('controller' => 'users', 'action' => 'dashboard', 'admin' => true);

			$this->Auth->authenticate = array(AuthComponent::ALL => array(
				'userModel' => 'User',
				'fields' => array('username' => 'email', 'password' => 'password'),
				'scope' => array('User.status' => 1, 'User.role_id <>' => 2 /* admin */)),
				'Form');
			$this->_setAdminLanguage();

		} else {

			$this->Auth->loginAction = array(
				'controller' => 'pages',
				'action' => 'display',
				'admin' => false);
			//$this->Auth->loginRedirect = array('controller' => 'orders', 'action' => 'index', 'admin' => true);
			$this->Auth->logoutRedirect = array('controller' => 'pages', 'action' => 'display', 'admin' => false);

			$this->Auth->authenticate = array(AuthComponent::ALL => array(
				'userModel' => 'User',
				'fields' => array('username' => 'mobile', 'password' => 'password'),
				'scope' => array('User.status' => 1 /*,
                            'User.role_id'=>2     /* user role */)), 'Form');
		}


		if (isset($this->request->params['admin']) && ($this->request->params['prefix'] == 'admin')) {

			if (!$this->_check_admin_login_user()) {
				$this->layout = 'admin_login';
				$this->Auth->allow($this->CmsAcl->_adminAllUsers());

			} else {
				$this->layout = 'admin';
				$this->Auth->allow($this->CmsAcl->_adminMemberAllow());
			}

		} else {
			if (in_array($this->request['action'], array('edit_profile', 'edit_address', 'edit_password'))) {
				//$this->layout = 'user_panel';
			} else
				//$this->layout = __THEME;

				if (isset($this->is_mobile) && $this->is_mobile) {
					$this->layout = 'mobile';
				} else {
					if (!$this->_check_login_user()) {
						$this->Auth->allow($this->CmsAcl->_allUsers());
					} else {
						$this->Auth->allow($this->CmsAcl->_memberAllow());
					}
				}
		}

	}

	private function _saveRequestInformation()
	{

		$this->loadModel('Siteinformation');
		$this->Siteinformation->saveinformation($_SERVER);
	}

	private function _setLanguage()
	{
		/* $this->Session->write('Config.language', 'fas');
		 $this->Cookie->write('lang', 'fas', false, '2000 days');
		 $this->set('locale', 'fas');*/

		if ($this->Cookie->read('lang')) {
			$this->Session->write('Config.language', $this->Cookie->read('lang'));
			$locale = $this->Cookie->read('lang');
			$this->set('locale', $locale);
		}
		//if the user clicked the language URL
		// $this->params['language']);

		if (isset($this->params['named']['language']) && ($this->params['named']['language'] != $this->Session->read('Config.language'))) {
			$this->Session->write('Config.language', $this->params['named']['language']);
			$this->Cookie->write('lang', $this->params['named']['language'], false, '2000 days');
			$locale = $this->Cookie->read('lang');
			$this->set('locale', $locale);

		}

		if (isset($this->params['language']) && ($this->params['language'] != $this->Session->read('Config.language'))) {
			$this->Session->write('Config.language', $this->params['language']);
			$this->Cookie->write('lang', $this->params['language'], false, '2000 days');
			$locale = $this->Cookie->read('lang');
			$this->set('locale', $locale);
		}

		$lang = $this->Cookie->read('lang');
		if (!isset($lang)) {
			$this->Session->write('Config.language', 'fas');
			$this->Cookie->write('lang', 'fas', false, '2000 days');
			$this->set('locale', 'fas');
		}


		if (!isset($this->params['language']) && $this->Cookie->read('lang') == '') {

			$locale = Configure::read('Config.language');
			//echo(Configure::read('Config.language'));
			$this->Session->write('Config.language', $locale);
			$this->set('locale', $locale);
			if ($this->Session->check('Config.language')) {
				Configure::write('Config.language', $this->Session->read('Config.language'));
			}

		}

	}

	private function _setAdminLanguage()
	{
		$cookie = $this->Cookie->read(__ADMIN_LANG_INDEX);

		if (empty($cookie)) {
			$this->Cookie->write(__ADMIN_LANG_INDEX, 'fas', false, 3600 * 3600);
			$this->Cookie->write(__ADMIN_LANG_DEFAULT_ID, '1', false, 3600 * 3600);
		}
	}

	/**
	 * check user for login
	 *
	 */
	function _check_login_user()
	{
		if ($this->Session->check('User_Info')) {
			return true;
		}
		return false;
	}

	/**
	 * check user for login
	 *
	 */
	function _check_admin_login_user()
	{
		if ($this->Session->check('AdminUser_Info')) {
			return true;
		}
		return false;
	}

	function _add_admin_member_permision($actions)
	{
		if (isset($this->request->params['admin']) && ($this->request->params['prefix'] ==
				'admin')) {
			if ($this->_check_admin_login_user()) {
				if (!empty($actions)) {
					foreach ($actions as $key => $action) {
						array_push($this->CmsAcl->adminMemberAllow, $action);
						$this->Auth->allow($this->CmsAcl->adminMemberAllow);
					}
				}
			}
		}
	}

	function _add_member_permision($actions)
	{
		if (!isset($this->request->params['admin'])) {
			if ($this->_check_login_user()) {
				if (!empty($actions)) {
					foreach ($actions as $key => $action) {
						array_push($this->CmsAcl->memberAllow, $action);
						$this->Auth->allow($this->CmsAcl->memberAllow);
					}
				}
			}
		}
	}

}

?>
