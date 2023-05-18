<?php
$items = array();
$controller = 'productdiscounts';
$items['action_name'] = __d(__PRODUCT_LOCALE,'productdiscount_list');
$items['action'] = 'Productdiscount';
$items['add_style'] =
array('link'=>array(
		'title'=>__d(__PRODUCT_LOCALE,'add_productdiscount'),
		'url'  => __SITE_URL.'admin/'.__PRODUCT.'/'.$controller.'/add'
	)
);
$items['titles'] = array(
	array('title'=> __d(__PRODUCT_LOCALE,'product_title'),'index'=> 'title'),
	array('title'=> __d(__PRODUCT_LOCALE,'discounttype_name'),'index'=> 'name'),
	array('title'=> __d(__PRODUCT_LOCALE,'start_date'),'index'=> 'start_date'),
	array('title'=> __d(__PRODUCT_LOCALE,'end_date'),'index'=> 'end_date'),
	array('title'=> __d(__PRODUCT_LOCALE,'status'),'index'=> 'status'),
	array('title'=> __('created'),'index'=> 'created')
);

//pr(md5(rand().$_SERVER[REMOTE_ADDR]));
//pr(strtoupper(md5(rand())));

$records = $ProductdiscountList;
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
		echo "<td>".$record['Producttranslation']['title'];
		echo $this->AdminHtml->createActionLink();
		echo $this->AdminHtml->actionLink(__('edit'),__SITE_URL.'admin/'.__PRODUCT.'/'.$controller.'/edit/'.$record[$items['action']]['id'],'','|');
		echo $this->AdminHtml->actionLink(__('delete'),__SITE_URL.'admin/'.__PRODUCT.'/'.$controller.'/delete/'.$record[$items['action']]['id'],'delete');
		echo $this->AdminHtml->endActionLink();
		echo"</td>";
		echo "<td>".$record['Discounttypetranslation']['name']."</td>";
		echo "<td>".$this->Cms->addDateSlash($record['Productdiscount']['start_date'])."</td>";
		echo "<td>".$this->Cms->addDateSlash($record['Productdiscount']['end_date'])."</td>";
		echo "<td>";
		if($record[$items['action']]['status'] == 0)
		{
			echo $this->AdminHtml->status(__('instatus'),array('class'=>'label label-danger'));
		}
		else
			echo $this->AdminHtml->status(__('status'),array('class'=>'label label-success'));
		echo"</td>";
		echo "<td>".$this->Cms->show_persian_date(" l ، j F Y    ",strtotime($record[$items['action']]['created']))."</td>";
	}
}
echo $this->element('Admin/index_footer' );
?>

