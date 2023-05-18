<?php
echo $this->Html->css('/'.__PRODUCT.'/css/addrow');
echo $this->Html->script('/js/admin/ckeditor/ckeditor');
echo $this->Form->create('Discounttype',array('enctype'=>'multipart/form-data'));
?>
<?php
$items = array();
$items['title'] = __d(__PRODUCT_LOCALE,'edit_discounttype');
$items['link'] = array('title'=>__d(__PRODUCT_LOCALE,'Discounttype_list'),'url'  =>__SITE_URL.'admin/'.__PRODUCT.'/Discounttypes/index');
echo $this->element('Admin/add_edit_header', array('items'=>$items) );
?>
<div class="col-md-6">
	<?php

	echo $this->Form->input('id');
	?>
</div>
<div class="col-md-6">
	<?php
	echo  $this->Form->input('name', array(
			'type' => 'text',
			'label'=> __d(__PRODUCT_LOCALE,'name'),
			'class'=> 'form-control',
			'name' => 'data[Discounttypetranslation][name]',
			'value'=> $this->request->data['Discounttypetranslation']['name']
		));
	echo  $this->Form->input('percent', array(
			'type' => 'number',
			'label'=> __d(__PRODUCT_LOCALE,'percent'),
			'default'=> $this->request->data['Discounttype']['percent'],
			'class'=> 'form-control'
		));
	echo  $this->Form->input('amount', array(
			'type' => 'text',
			'label'=> __d(__PRODUCT_LOCALE,'amount'),
			'default'=> $this->request->data['Discounttype']['amount'],
			'class'=> 'form-control',
			'id' => 'amount'
		));
	echo  $this->Form->input('description', array(
			'type' => 'etxtarea',
			'rows'=>'5',
			'label'=> __d(__PRODUCT_LOCALE,'description'),
			'default'=> $this->request->data['Discounttype']['description'],
			'class'=> 'form-control'
		));
	?>

</div>

<?php
echo $this->element('Admin/add_edit_footer', array('items'=>'') );
?>
<?php echo $this->Form->end(); ?>
<?php echo $this->Html->script('/'.__PRODUCT.'/js/discount'); ?>
