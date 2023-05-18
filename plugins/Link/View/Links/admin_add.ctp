<?php

echo $this->Form->create('Link',array('enctype'=>'multipart/form-data'));
?>
<?php
$items = array();
$items['title'] = __d(__LINK_LOCALE,'add_link');
$items['link'] = array('title'=>__d(__LINK_LOCALE,'link_list'),'url'  =>__SITE_URL.'admin/product/links/index');
echo $this->element('Admin/add_edit_header', array('items'=>$items) );
 
?>
<div class="col-md-6">
</div>
<div class="col-md-6">
	<?php

	 
	echo  $this->Form->input('title', array(
			'type' => 'text',
			'label'=> __d(__LINK_LOCALE,'title'),
			'class'=> 'form-control'
		));
 	echo  $this->Form->input('link', array(
			'type' => 'text',
			'label'=> __d(__LINK_LOCALE,'link'),
			'style'=> 'direction:ltr',
			'class'=> 'form-control'
		));
	echo  $this->Form->input('detail', array(
			'type' => 'text',
			'label'=> __d(__LINK_LOCALE,'detail'),
			'class'=> 'form-control'
		));	
	echo  $this->Form->input('link_type', array(
			'type'   => 'select',
			'options'=> array(0=>__d(__LINK_LOCALE,'tenders'),1=>__d(__LINK_LOCALE,'standards'),2=>__d(__LINK_LOCALE,'articles')),
			'label'  => __d(__LINK_LOCALE,'link_type'),
			'default'=>'0',
			'class'  => 'form-control input-sm'
		));	
	echo  $this->Form->input('arrangment', array(
			'type' => 'number',
			'label'=> __d(__LINK_LOCALE,'arrangment'),
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