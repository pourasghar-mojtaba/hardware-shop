<?php

$items = array();
$controller = 'orders';
$items['action_name'] = __d(__PRODUCT_LOCALE,'order_list');
$items['action'] = 'Order';

$items['titles'] = array(
	array('title'=> __d(__PRODUCT_LOCALE,'order_id'),'index'=> 'id'),
	array('title'=> __d(__PRODUCT_LOCALE,'title'),'index'=> 'title'),
	array('title'=> __d(__PRODUCT_LOCALE,'refid'),'index'=> 'refid'),
	array('title'=> __d(__PRODUCT_LOCALE,'item_count')),
	array('title'=> __d(__PRODUCT_LOCALE,'sum_price'),'index'=> 'sum_price'),
	array('title'=> __d(__PRODUCT_LOCALE,'bank_name')),
	array('title'=> __d(__PRODUCT_LOCALE,'bank_message')),
	array('title'=> __('status'),'index'=> 'status'),
	array('title'=> __('created'),'index'=> 'created'),
);



$records = $orders;
$items['show_search_box'] = TRUE;
echo $this->Form->create('Product', array('id'=>'SearchFrom','name'=>'SearchFrom'));
echo $this->element('Admin/index_header', array('items'=>$items) );
if(!empty($records)){

	foreach($records as $record){
		echo "
		<tr>
		<td>";
		if (!in_array($record['Order']['status'],array(4,5))  ) {
			echo "<input class='checkbox1' type='checkbox' name='orders[]'  value='".$record['Order']['id']."'>";
		}
		echo"</td>";
		echo "<td>".$record['Order']['id'];
		echo $this->AdminHtml->createActionLink();
		if ($record['Order']['manual']==0){
			echo $this->AdminHtml->actionLink(__d(__PRODUCT_LOCALE,'print'),'#','','',array('onclick'=>'show_order_product('.$record['Order']['id'].')')).'|';
			echo $this->AdminHtml->actionLink(__d(__PRODUCT_LOCALE,'show_order_product'),__SITE_URL.'admin/'.__PRODUCT.'/orderitems/items_list/'.$record['Order']['id'],'').'|';
		}
		else
			echo $this->AdminHtml->actionLink(__d(__PRODUCT_LOCALE,'create_factor'),__SITE_URL.'admin/'.__PRODUCT.'/orders/register/'.$record['Order']['id'],'').'|';
		echo $this->AdminHtml->actionLink(__('delete'),__SITE_URL.'admin/'.__PRODUCT.'/'.$controller.'/delete/'.$record['Order']['id'],'delete');
		echo $this->AdminHtml->endActionLink();
		echo"</td>";
		echo "<td>".$record['Order']['title']."</td>";
		echo "<td>".$record['Order']['refid']."</td>";
		echo "<td>".$record['Order']['items_count']."</td>";
		echo "<td>".number_format($record['Order']['sum_price'], 0, '.', ',')."</td>";
		echo "<td>".$record['Bank']['bank_name']."</td>";
		echo "<td>".$record['Bankmessag']['message']."</td>";
		echo "<td>";
		echo $this->Product->user_order_status($record['Order']['status']);
		echo"</td>";
		echo "<td>".$this->Cms->show_persian_date(" l ، j F Y    ",strtotime($record['Order']['created']))."</td>";

	}
}
?>
<tr>
	<td colspan="8"></td>
	<td >
		<select class="form-control input-sm" name="status">
		    <option value="8"><?php echo  __d(__PRODUCT_LOCALE,'checking'); ?></option>
			<option value="2"><?php echo  __d(__PRODUCT_LOCALE,'posted'); ?></option>
			<option value="3"><?php echo  __d(__PRODUCT_LOCALE,'accepted'); ?></option>
			<option value="9"><?php echo  __d(__PRODUCT_LOCALE,'not_accepted'); ?></option>
			<option value="10"><?php echo  __d(__PRODUCT_LOCALE,'first_registered'); ?></option>
			<option value="11"><?php echo  __d(__PRODUCT_LOCALE,'factor_sended'); ?></option>
		</select>
	</td>
	<td>
		<input type="submit" value="تغییر وضعیت" class="btn btn-info">
	</td>
</tr>
</form>
<?php
echo $this->element('Admin/index_footer' );
?>
<script>
	function show_order_product(id){
	var url = _url+"<?php echo __PRODUCT.'/orderitems/order_print/'; ?>"+id;
	window.open(url,'_blank', 'toolbar=0,location=0,menubar=0,resizable=1');
}
</script>
