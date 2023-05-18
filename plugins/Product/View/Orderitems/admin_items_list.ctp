
<?php

$items = array();
$controller = 'orderitems';
$items['action_name'] =  __d(__PRODUCT_LOCALE,'order_item_list').' '.$order_id;
$items['action'] = 'Orderitem';

$items['titles'] = array(
	array('title'=> __d(__PRODUCT_LOCALE,'title'),'index'=> 'Product.title'),
	array('title'=> __d(__PRODUCT_LOCALE,'count'),'index'=> 'Orderitem.item_count'),
	array('title'=> __d(__PRODUCT_LOCALE,'sum_price'),'index'=> 'Orderitem.sum_price'),
	array('title'=> __d(__PRODUCT_LOCALE,'image')),

	array('title'=> __('created'),'index'=> 'created'),
);

$records = $order_items;
$items['show_search_box'] = TRUE;

echo $this->element('Admin/index_header', array('items'=>$items) );
if(!empty($records)){

	foreach($records as $record){
		echo "
		<tr>
		<td>";

		if (!in_array($record['Orderitem']['status'],array(4,5))  ) {
			echo "<input class='checkbox1' type='checkbox' name='orders[]'  value='".$record['Orderitem']['id']."'>";
		}
		echo"</td>
		";
		echo "<td>".$record['Producttranslation']['title'];
		echo"</td>";
		echo "<td>".$record['Orderitem']['item_count']."</td>";
		echo "<td>".number_format($record['Orderitem']['sum_price'])."</td>";
		echo "<td>";
		$user_image = '';
		$width      = 70;
		$height     = 70;
		$image      = $record['0']['image'];
		echo$this->Html->image('/'.__PRODUCT_IMAGE_URL.__UPLOAD_THUMB.'/'.$image,array('width' =>$width,'height'=>$height));
		echo"</td>";

		echo "<td>".$this->Cms->show_persian_date(" l ، j F Y    ",strtotime($record['Orderitem']['created']))."</td>";

	}
}

	echo $this->element('Admin/index_footer' );
?>
