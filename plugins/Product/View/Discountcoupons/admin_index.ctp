<?php
$items = array();
$controller = 'discountcoupons';
$items['action_name'] = __d(__SHOP_LOCALE,'Discountcoupon_list');
$items['action'] = 'Discountcoupon';
$items['add_style'] =
array('link'=>array(
		'title'=>__d(__SHOP_LOCALE,'add_Discountcoupon'),
		'url'  => __SITE_URL.'admin/shop/'.$controller.'/add'
	)
);
$items['titles'] = array(
	array('title'=> __d(__SHOP_LOCALE,'name'),'index'=> 'name'),
	array('title'=> __d(__SHOP_LOCALE,'code'),'index'=> 'code'),
	array('title'=> __('created'),'index'=> 'created')
);

//pr(md5(rand().$_SERVER[REMOTE_ADDR]));
//pr(strtoupper(md5(rand())));

$records = $DiscountcouponList;
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
		echo "<td>".$record['discounttypes']['name'];
		echo $this->AdminHtml->createActionLink();
		echo $this->AdminHtml->actionLink(__('delete'),__SITE_URL.'admin/shop/'.$controller.'/delete/'.$record[$items['action']]['id'],'delete');
		echo $this->AdminHtml->endActionLink();
		echo"</td>";
		echo "<td>".$record['Discountcoupon']['code']."</td>";
		echo "<td>".$this->Cms->show_persian_date(" l ، j F Y    ",strtotime($record[$items['action']]['created']))."</td>";
	}
}
echo $this->element('Admin/index_footer' );
?>

