<?php

echo $this->Form->create('Company', array('enctype' => 'multipart/form-data'));
?>
<?php
$items = array();
$items['title'] = __d(__COMPANY_LOCALE, 'add_company');
$items['link'] = array('title' => __d(__COMPANY_LOCALE, 'company_list'), 'url' => __SITE_URL . 'admin/product/links/index');
echo $this->element('Admin/add_edit_header', array('items' => $items));

?>
<div class="col-md-6">
</div>
<div class="col-md-6">
	<?php


	echo $this->Form->input('title', array(
		'type' => 'text',
		'label' => __d(__COMPANY_LOCALE, 'title'),
		'class' => 'form-control',
		'name' => 'data[Companytranslation][title]'
	));

	echo $this->Form->input('image', array(
		'type' => 'file',
		'id' => 'company_image',
		'label' => __d(__COMPANY_LOCALE, 'image'),
		'class' => 'form-control'
	));
	echo $this->Form->input('url', array(
		'type' => 'text',
		'label' => __d(__COMPANY_LOCALE, 'url'),
		'dir' => 'ltr',
		'class' => 'form-control'
	));
	echo $this->Form->input('arrangment', array(
		'type' => 'number',
		'label' => __d(__COMPANY_LOCALE, 'arrangment'),
		'class' => 'form-control'
	));

	echo $this->Form->input('status', array(
		'type' => 'select',
		'options' => array(1 => __('active'), 0 => __('inactive')),
		'label' => __('status'),
		'default' => '1',
		'class' => 'form-control input-sm'
	));
	?>
</div>

<?php
echo $this->element('Admin/add_edit_footer', array('items' => ''));
?>
<?php echo $this->Form->end(); ?>
