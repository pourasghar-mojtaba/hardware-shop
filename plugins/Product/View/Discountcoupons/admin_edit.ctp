<?php
echo $this->Html->css('/'.__SHOP.'/css/addrow');
echo $this->Html->script('/js/admin/ckeditor/ckeditor');
echo $this->Form->create('Discountcoupon',array('enctype'=>'multipart/form-data'));
?>
<?php
$items = array();
$items['title'] = __d(__SHOP_LOCALE,'edit_Discountcoupon');
$items['link'] = array('title'=>__d(__SHOP_LOCALE,'Discountcoupon_list'),'url'  =>__SITE_URL.'admin/'.__SHOP.'/Discountcoupons/index');
echo $this->element('Admin/add_edit_header', array('items'=>$items) );
?> 
<div class="col-md-6">
	<?php	
	echo $this->Form->input('id');
	pr($this->request->data);
	?>
</div>
<div class="col-md-6">
	<?php 
	echo  $this->Form->input('name', array(
			'type' => 'text',
			'label'=> __d(__SHOP_LOCALE,'name'),
			'default'=> $this->request->data['Discountcoupon']['name'],
			'class'=> 'form-control'
		));
	echo  $this->Form->input('percent', array(
			'type' => 'number',
			'label'=> __d(__SHOP_LOCALE,'percent'),
			'default'=> $this->request->data['Discountcoupon']['percent'],
			'class'=> 'form-control'
		));
	echo  $this->Form->input('amount', array(
			'type' => 'number',
			'label'=> __d(__SHOP_LOCALE,'amount'),
			'default'=> $this->request->data['Discountcoupon']['amount'],
			'class'=> 'form-control'
		)); 
	echo  $this->Form->input('description', array(
			'type' => 'etxtarea',
			'rows'=>'5',
			'label'=> __d(__SHOP_LOCALE,'description'),
			'default'=> $this->request->data['Discountcoupon']['description'],
			'class'=> 'form-control'
		)); 
	?>  
	<div class="box-footer"> 
		<button class="btn btn-primary" type="submit"  ><?php echo __('save'); ?></button>
	</div>
</div>