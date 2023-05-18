<?php
/**
*/
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class FilemanagersController extends AppController
{

	var $helpers = array('Cms');
	var $components = array('Cms','Httpupload');
	var $uses = false;
	/**
	* Controller name
	*

	/**
	* follow to anoher user
	* @param undefined $id
	*
	*/

	public
	function beforeFilter()
	{
		parent::beforeFilter();
		$this->_add_admin_member_permision(array('admin_manager'));
	}


	function admin_manager()
	{
		$this->set('title_for_layout',__('file_manager'));
		$this->set('description_for_layout',__('file_manager'));
		$this->set('keywords_for_layout',__('file_manager'));
	}


}
?>