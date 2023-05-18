<?php echo $this->Form->create('Role'); ?>
<?php
$items = array();
$items['title'] = __('edit_role');
$items['link'] = array('title'=>__('roles'),'url'  =>__SITE_URL.'admin/roles/index');
echo $this->element('Admin/add_edit_header', array('items'=>$items) );
?>
<div class="col-md-6">
</div>
<div class="col-md-6">
	<?php

	echo $this->Form->input('id');
	echo  $this->Form->input('name', array(
			'type'   => 'text',
			'label'=> __('name'),
			'placeholder'=>__('enter_role'),
			'class'  => 'form-control'
		));
	echo  $this->Form->input('status', array(
			'type'   => 'select',
			'options'=> array(1=>__('active'),0=>__('inactive')),
			'label'=> __('status'),
			'class'  => 'form-control input-sm'
		));
	?>
</div>

<?php
echo $this->element('Admin/add_edit_footer', array('items'=>'') );
?>
<?php echo $this->Form->end(); ?>