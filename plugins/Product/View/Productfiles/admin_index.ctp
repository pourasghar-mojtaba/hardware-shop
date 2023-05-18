<?php

$items = array();
$controller = 'productfiles';
$items['action_name'] = __d(__SHOP_LOCALE,'productfile_list');
$items['action'] = 'Productfile';
$items['add_style'] =
array('link'=>array(
		'title'=>__d(__SHOP_LOCALE,'add_productfile'),
		'url'  => __SITE_URL.'admin/shop/'.$controller.'/add'
	)
);
$items['titles'] = array(
	array('title'=> __d(__SHOP_LOCALE,'title'),'index'=> 'title'),
	array('title'=> __d(__SHOP_LOCALE,'product_title'),'index'=> 'title','action'=>'Product'),
	array('title'=> __d(__SHOP_LOCALE,'file')),
	array('title'=> __('created'),'index'=> 'created'),
);

$records = $productfiles;
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
		echo "<td>".$record[$items['action']]['title'];
		echo $this->AdminHtml->createActionLink();
		echo $this->AdminHtml->actionLink(__('edit'),__SITE_URL.'admin/shop/'.$controller.'/edit/'.$record[$items['action']]['id'],'','|');
		echo $this->AdminHtml->actionLink(__('delete'),__SITE_URL.'admin/shop/'.$controller.'/delete/'.$record[$items['action']]['id'],'delete');
		echo $this->AdminHtml->endActionLink();
		echo"</td>";
		echo "<td>".$record['Product']['title']."</td>";
		echo "<td><a target='_blank' href='".__SITE_URL.__SHOP_FILE_URL.$record[$items['action']]['file']."'>".$record[$items['action']]['file']."</a></td>";
		echo "<td>".$this->Cms->show_persian_date(" l ، j F Y    ",strtotime($record[$items['action']]['created']))."</td>";

	}
}
echo $this->element('Admin/index_footer' );
?>

