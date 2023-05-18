<?php
App::uses('AppController', 'Controller');
/**
* Roles Controller
*
* @property Role $Role
* @property PaginatorComponent $Paginator
*/
class PluginsController extends AppController
{

	public
	function admin_index()
	{
		$this->set('title_for_layout',__('list_of_plugins'));
		$this->set('plugins',$this->Plugin->_getPlugins());
	}

	public
	function admin_get_plugin($plugin_name)
	{
		$plugin = $this->Plugin->_getPlugin($plugin_name);
		return $plugin;
	}

	public
	function admin_active($name)
	{
		$result = $this->Plugin->updateAll(
			array('Plugin.status'=> '1' ),   //fields to update
			array('Plugin.name'=> $name )  //condition
		);
		if($result)
		{
			$this->Redirect->flashSuccess(__('the_plugin_has_been_activated'),array('action'=> 'index'));
		}
		else		$this->Redirect->flashWarning(__('the_plugin_has_been_noactivated'),array('action'=> 'index'));
	}

	public
	function admin_inactive($name)
	{
		$result = $this->Plugin->updateAll(
			array('Plugin.status'=> '0' ),   //fields to update
			array('Plugin.name'=> $name )  //condition
		);
		if($result)
		{
			$this->Redirect->flashSuccess(__('the_plugin_has_been_inactivated'),array('action'=> 'index'));
		}
		else $this->Redirect->flashWarning(__('the_plugin_has_been_noinactivated'),array('action'=> 'index'));
	}

	public
	function admin_install($name)
	{
		if(empty($name)){
			$this->Redirect->flashWarning(__('the_plugin_invalid'),array('action'=> 'index'));
		}

		if(@file_exists(__PLUGINS.$name."/plugin.php")){
			$datasource = $this->Plugin->getDataSource();
			try
			{
				$datasource->begin();

				require_once(__PLUGINS.$name.'/plugin.php');
				
				if(!empty($install_query_array) && count($install_query_array) > 0){
					foreach($install_query_array as $key=>$value){
						if(!$this->Plugin->query($value))
						throw new Exception(__('exist_error_on_install_query'));
					}
				}
								
				if(!empty($install_menu_query)){
					$this->loadModel('Aclitem');
					$this->Aclitem->recursive = -1;
					foreach($install_menu_query as $menu){											
						$this->request->data = array();	
						$this->request->data['Aclitem']['name'] = $menu['name'];
						$this->request->data['Aclitem']['controller'] = $menu['controller'];
						$this->request->data['Aclitem']['action'] = $menu['action'];
						$this->request->data['Aclitem']['action_name'] = $menu['action_name'];
						$this->request->data['Aclitem']['active'] = 1;
						$this->Aclitem->create();
						if(!$this->Aclitem->save($this->request->data))			        
							throw new Exception(__('the_menu_not_saved'));							
					}
				}
				$this->request->data = array();
				$this->request->data['Plugin']['name'] = $name;
				$this->request->data['Plugin']['status'] = 0;
				if(!$this->Plugin->save($this->request->data))			        
					throw new Exception(__('the_plugin_not_saved'));

				$datasource->commit();

				$this->Redirect->flashSuccess(__('the_plugin_has_been_installed'),array('action'=> 'index'));
			} catch(Exception $e){
				$datasource->rollback();
				$this->Redirect->flashWarning($e->getMessage(),array('action'=> 'index'));
			}
		}

	}
	
	public
	function admin_uninstall($name)
	{
		if(empty($name)){
			$this->Redirect->flashWarning(__('the_plugin_invalid'),array('action'=> 'index'));
		}

		if(@file_exists(__PLUGINS.$name."/plugin.php")){
			$datasource = $this->Plugin->getDataSource();
			try
			{
				$datasource->begin();

				require_once(__PLUGINS.$name.'/plugin.php');
				if(!empty($remove_query_array) && count($remove_query_array) > 0){
					foreach($remove_query_array as $key=>$value){
						if(!$this->Plugin->query($value))						
							throw new Exception(__('exist_error_on_uninstall_query'));
					}
				}
				
				if(!empty($remove_menu_query)){
					$this->loadModel('Aclitem');
					$this->Aclitem->recursive = -1;
					foreach($remove_menu_query as $menu){
						if(!$this->Aclitem->deleteAll(array('Aclitem.controller'=>$menu['controller']),FALSE))			        
							throw new Exception(__('the_menu_not_deleted'));
					}
				}	
				
				if(!$this->Plugin->deleteAll(array('Plugin.name'=>$name),FALSE))			        
					throw new Exception(__('the_plugin_not_deleted'));

				$datasource->commit();

				$this->Redirect->flashSuccess(__('the_plugin_has_been_uninstalled'),array('action'=> 'index'));
			} catch(Exception $e){
				$datasource->rollback();
				$this->Redirect->flashWarning($e->getMessage(),array('action'=> 'index'));
			}
		}

	}

}
?>