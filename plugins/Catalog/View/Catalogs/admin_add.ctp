<?php

echo $this->Form->create('Catalog',array('enctype'=>'multipart/form-data'));
?>
<?php
$items = array();
$items['title'] = __d(__CATALOG_LOCALE,'add_catalog');
$items['link'] = array('title'=>__d(__CATALOG_LOCALE,'catalog_list'),'url'  =>__SITE_URL.'admin/product/catalogs/index');
echo $this->element('Admin/add_edit_header', array('items'=>$items) );
 
?>
<div class="col-md-6">
</div>
<div class="col-md-6">
	<?php

	 
	echo  $this->Form->input('title', array(
			'type' => 'text',
			'label'=> __d(__CATALOG_LOCALE,'title'),
			'class'=> 'form-control'
		));
	echo  $this->Form->input('file', array(
			'type' => 'file',
			'id' => 'catalog_file',
			'label'=> __d(__CATALOG_LOCALE,'file'),
			'class'=> 'form-control'
		));	
	echo  $this->Form->input('arrangment', array(
			'type' => 'number',
			'label'=> __d(__CATALOG_LOCALE,'arrangment'),
			'class'=> 'form-control'
		));	

	echo  $this->Form->input('status', array(
			'type'   => 'select',
			'options'=> array(1=>__('active'),0=>__('inactive')),
			'label'  => __('status'),
			'default'=>'1',
			'class'  => 'form-control input-sm'
		));
	?>
</div>

<?php
echo $this->element('Admin/add_edit_footer', array('items'=>'') );
?>
<?php echo $this->Form->end(); ?>