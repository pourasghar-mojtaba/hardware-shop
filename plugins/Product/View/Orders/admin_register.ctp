<?php
echo $this->Html->css('/'.__PRODUCT.'/css/addrow');
echo $this->Html->script('/js/admin/ckeditor415/ckeditor');
echo $this->Form->create('Order',array('enctype'=>'multipart/form-data'));
?>
<?php
$items = array();
$items['title'] = __d(__PRODUCT_LOCALE,'create_factor');
$items['link'] = array('title'=>__d(__PRODUCT_LOCALE,'order_list'),'url'  =>__SITE_URL.'admin/product/orders/index');
echo $this->element('Admin/add_edit_header', array('items'=>$items) );
?>
<div class="col-md-6">
	<?php

	echo $this->Form->input('id');
	?>
</div>

<div class="col-md-6">
	<?php
	echo $this->Form->input('title', array(
		'type' => 'text',
		'class' => 'form-control',
		'required' => 'required',
		'label'=> __d(__PRODUCT_LOCALE,'title'),
	));

	echo  $this->Form->input('sum_price', array(
			'type' => 'text',
			'label'=> __d(__PRODUCT_LOCALE,'sum_price'),
			'class'=> 'form-control',
			'id' => 'amount'
		));

	echo  $this->Form->input('items_count', array(
			'type' => 'text',
			'label'=> __d(__PRODUCT_LOCALE,'items_count'),
			'class'=> 'form-control',
			'id' => 'amount'
		));
	echo  $this->Form->input('factor_pdf', array(
		'type' => 'file',
		'id' => 'factor_pdf',
		'label'=> __d(__PRODUCT_LOCALE,'factor_pdf'),
		'class'=> 'form-control'
	));
	if (!empty($this->request->data['Order']['factor_pdf'])){
?>
	<a target="_blank" href="<?php echo  __SITE_URL. __PRODUCT_IMAGE_URL . $this->request->data['Order']['factor_pdf']; ?>">دانلود فاکتور</a>
	<?php
	}

	echo $this->Form->input('user_description', array(
		'type' => 'textarea',
		'placeholder' => __('message'),
		'class' => 'form-control',
		'label'=> __d(__PRODUCT_LOCALE,'user_description'),
		'required' => 'required'
	));

	echo  $this->Form->input('description', array(
			'type' => 'etxtarea',
			'rows'=>'5',
			'label'=> __d(__PRODUCT_LOCALE,'admin_description'),
			'class'=> 'form-control',
			'id'=>'description'
		));
	?>

</div>

<?php
echo $this->element('Admin/add_edit_footer', array('items'=>'') );
?>
<?php echo $this->Form->end(); ?>
<script>
    CKEDITOR.replace( 'description' );
</script>
