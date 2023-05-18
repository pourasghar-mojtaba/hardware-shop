<?php
App::uses('HtmlHelper', 'View/Helper');

class ShopHelper extends AppHelper
{

	public $helpers = array('Html','Session');


	function user_order_status($status)
	{
		$status_txt = '';
		switch($status)
		{
			case 0:
			$status_txt = __d(__SHOP_LOCALE,'ordered');
			break;
			case 1:
			$status_txt = __d(__SHOP_LOCALE,'deposited');
			break;
			case 2:
			$status_txt = __d(__SHOP_LOCALE,'posted');
			break;
			case 3:
			$status_txt = __d(__SHOP_LOCALE,'accepted');
			break;
			case 4:
			$status_txt = __d(__SHOP_LOCALE,'accepted');
			break;
			case 5:
			$status_txt = __d(__SHOP_LOCALE,'accepted');
			break;
			case 8:
			$status_txt = __d(__SHOP_LOCALE,'checking');
			break;
			case 9:
			$status_txt = __d(__SHOP_LOCALE,'not_accepted');
			break;
		}

		return $status_txt;
	}
	
	
	function dataToList($items,$model)
	{
		$item_list = array();
		 
		if(!empty($items))
		{
			foreach($items as $item){
				$item_list[$item[$model]['id']] = $item[$model]['title'];
			}
		}
		return $item_list;
	}
	
}

?>

