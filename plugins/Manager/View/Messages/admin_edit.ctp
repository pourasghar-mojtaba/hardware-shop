<?php echo $this->Form->create('Message'); ?>
<?php
$items = array();
$items['title'] = __d('manager','edit_message');
$items['link'] = array('title'=>__d('manager','message_list'),'url'  =>__SITE_URL.'admin/manager/messages/index');
echo $this->element('Admin/add_edit_header', array('items'=>$items) );
?>
<div class="col-md-6">
</div>
<div class="col-md-6">
	<?php

	echo $this->Form->input('id');
	echo  $this->Form->input('message', array(
			'type'   => 'text',
			'label'=> __d('manager','message'),
			'class'  => 'form-control'
		));
		echo  $this->Form->input('user_id', array(
			'type'   => 'select',
			'options'=> $users,
			'default'=>$this->request->data['Message']['user_id'],
			'label'  => __d('manager','user'),
			'class'  => 'form-control input-sm'
		));
	echo  $this->Form->input('status', array(
			'type'   => 'select',
			'options'=> array(1=>__('active'),0=>__('inactive')),
			'label'=> __('status'),
			'default'=>'1',
			'class'  => 'form-control input-sm'
		));
	?>
</div>

<?php
echo $this->element('Admin/add_edit_footer', array('items'=>'') );
?>
<?php echo $this->Form->end(); ?>