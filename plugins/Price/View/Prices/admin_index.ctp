<?php

$items = array();
$controller = 'prices';
$items['action_name'] = __d(__PRICE_LOCALE,'price_list');
$items['url'] = __PRICE.'/'.__PRICE.'s';
$items['action'] = __PRICE_PLUGIN;
$items['add_style'] =
array('link'=>array(
		'title'=>__d(__PRICE_LOCALE,'add_price'),
		'url'  => __SITE_URL.'admin/price/'.$controller.'/add'
	)
);
$items['titles'] = array(
	array('title'=> __d(__PRICE_LOCALE,'title'),'index'=> 'title'),
	array('title'=> __d(__PRICE_LOCALE,'buy_price'),'index'=> 'buy_price'),
	array('title'=> __d(__PRICE_LOCALE,'sel_price'),'index'=> 'sel_price'),
	array('title'=> __d(__PRICE_LOCALE,'price_date'),'index'=> 'price_date'),
	array('title'=> __d(__PRICE_LOCALE,'arrangment'),'index'=> 'arrangment'),
	array('title'=> __('status'),'index'=> 'status'),
	array('title'=> __('created'),'index'=> 'created'),
);

$records = $prices;
 
$items['show_search_box'] = FALSE;
echo $this->element('Admin/index_header', array('items'=>$items) );
if(!empty($records)){

	foreach($records as $record){
		echo "
		<tr>
		<td>
		<input type='checkbox' >
		</td>
		";
		echo "<td>".$record['Price']['title'];
		echo $this->AdminHtml->createActionLink();
		echo $this->AdminHtml->actionLink(__('edit'),__SITE_URL.'admin/price/'.$controller.'/edit/'.$record['Price']['id'],'','|');
		echo $this->AdminHtml->actionLink(__('delete'),__SITE_URL.'admin/price/'.$controller.'/delete/'.$record['Price']['id'],'delete');
		echo $this->AdminHtml->endActionLink();
		echo"</td>";
		echo "<td>".$record['Price']['buy_price']."</td>";
		echo "<td>".$record['Price']['sel_price']."</td>";
		echo "<td>".$record['Price']['price_date']."</td>";
		echo "<td>".$record['Price']['arrangment']."</td>";
		echo "<td>";
		if($record['Price']['status'] == 0)
		{
			echo $this->AdminHtml->status(__('inactive'),array('class'=>'label label-danger'));
		}
		else echo $this->AdminHtml->status(__('active'),array('class'=>'label label-success'));
		echo"</td>";
		echo "<td>".$this->Cms->show_persian_date(" l ، j F Y    ",strtotime($record['Price']['created']))."</td>";

	}
}
echo $this->element('Admin/index_footer' );
?>

