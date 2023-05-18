<?php
$items = array();
$controller = 'discounttypes';
$items['action_name'] = __d(__PRODUCT_LOCALE,'discounttype_list');
$items['action'] = 'Discounttype';
$items['add_style'] =
array('link'=>array(
		'title'=>__d(__PRODUCT_LOCALE,'add_discounttype'),
		'url'  => __SITE_URL.'admin/'.__PRODUCT.'/'.$controller.'/add'
	)
);
$items['titles'] = array(
	array('title'=> __d(__PRODUCT_LOCALE,'name'),'index'=> 'name'),
	//array('title'=> __d(__PRODUCT_LOCALE,'percent'),'index'=> 'percent'),
	array('title'=> __d(__PRODUCT_LOCALE,'amount'),'index'=> 'amount'),
	array('title'=> __('created'),'index'=> 'created'),
	array('title'=> __('description'),'index'=> 'description'),
);

$records = $DiscounttypeList;
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
		echo "<td>".$record['Discounttypetranslation']['name'];
		echo $this->AdminHtml->createActionLink();
		echo $this->AdminHtml->actionLink(__('edit'),__SITE_URL.'admin/'.__PRODUCT.'/'.$controller.'/edit/'.$record[$items['action']]['id'],'','|');
		echo $this->AdminHtml->actionLink(__('delete'),__SITE_URL.'admin/'.__PRODUCT.'/'.$controller.'/delete/'.$record[$items['action']]['id'],'delete');
		echo $this->AdminHtml->endActionLink();
		echo"</td>";
		//echo "<td>".$record['Discounttype']['percent']."</td>";
		echo "<td>".number_format($record[$items['action']]['amount'])." ".__d(__PRODUCT_LOCALE,'rial')."</td>";
		echo "<td>".$this->Cms->show_persian_date(" l ، j F Y    ",strtotime($record[$items['action']]['created']))."</td>";
		echo "<td>".$record[$items['action']]['description']."</td>";
		/*if($record[$items['action']]['status'] == 0)
		{
			echo $this->AdminHtml->status(__('inactive'),array('class'=>'label label-danger'));
		}
		else echo $this->AdminHtml->status(__('active'),array('class'=>'label label-success'));*/

	}
}
echo $this->element('Admin/index_footer' );
?>

