<?php

$items = array();
$controller = 'products';
$items['action_name'] = __d(__PRODUCT_LOCALE,'product_list');

$items['url'] = __PRODUCT.'/'.__PRODUCT.'s';
$items['action'] = __PRODUCT_PLUGIN;
$items['add_style'] =
array('link'=>array(
		'title'=>__d(__PRODUCT_LOCALE,'add_product'),
		'url'  => __SITE_URL.'admin/product/'.$controller.'/add'
	)
);
$items['titles'] = array(
	array('title'=> __d(__PRODUCT_LOCALE,'title'),'index'=> 'title'),
	array('title'=> __d(__PRODUCT_LOCALE,'category'),'index'=> 'title','action'=>'Productcategory'),
	array('title'=> __d(__PRODUCT_LOCALE,'detail'),'index'=> 'detail'),
	array('title'=> __d(__PRODUCT_LOCALE,'num'),'index'=> 'num'),
	array('title'=> __d(__PRODUCT_LOCALE,'image')),
	array('title'=> __('status'),'index'=> 'status'),
	array('title'=> __('created'),'index'=> 'created'),
);

$records = $products;
$items['show_search_box'] = true;
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
		echo $this->AdminHtml->actionLink(__('edit'),__SITE_URL.'admin/product/'.$controller.'/edit/'.$record[$items['action']]['id'],'','|');
		echo $this->AdminHtml->actionLink(__('delete'),__SITE_URL.'admin/product/'.$controller.'/delete/'.$record[$items['action']]['id'],'delete');
		echo $this->AdminHtml->endActionLink();
		echo"</td>";
		echo "<td>".$record['Productcategorytranslation']['title']."</td>";
		echo "<td>".$record['Producttranslation']['mini_detail']."</td>";
		echo "<td>".$record['Product']['num']."</td>";
		echo "<td>";
		$user_image = '';
		$width      = 70;
		$height     = 70;
		$image      = $record['0']['image'];
		echo$this->Html->image('/'.__PRODUCT_IMAGE_URL.__UPLOAD_THUMB.'/'.$image,array('width' =>$width,'height'=>$height));
		echo"</td>";
		echo "<td>";
		if($record[$items['action']]['status'] == 0)
		{
			echo $this->AdminHtml->status(__('inactive'),array('class'=>'label label-danger'));
		}
		else echo $this->AdminHtml->status(__('active'),array('class'=>'label label-success'));
		echo"</td>";
		echo "<td>".$this->Cms->show_persian_date(" l ، j F Y    ",strtotime($record[$items['action']]['created']))."</td>";

	}
}
echo $this->element('Admin/index_footer' );
?>

