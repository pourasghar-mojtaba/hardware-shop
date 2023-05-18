<?php echo $this->Form->create('User',array('enctype'=>'multipart/form-data')); ?>
<?php
$items = array();
$items['title'] = __('add_user');
$items['link'] = array('title'=>__('users'),'url'  =>__SITE_URL.'admin/users/index');
echo $this->element('Admin/add_edit_header', array('items'=>$items) );
?>
<div class="col-md-6">
</div>
<div class="col-md-6">
	<?php
	echo $this->Form->input('id');
	echo  $this->Form->input('role_id', array(
			'type'   => 'select',
			'options'=> $roles,
			'label'  => __('role'),
			'class'  => 'form-control input-sm'
		));
	echo  $this->Form->input('name', array(
			'type'       => 'text',
			'label'      => __('name'),
			'placeholder'=>__('enter_name'),
			'class'      => 'form-control'
		));
	echo  $this->Form->input('sex', array(
			'type'   => 'select',
			'options'=> array(1=>__('man'),0=>__('woman')),
			'label'  => __('sex'),
			'default'=>'1',
			'class'  => 'form-control input-sm'
		));
	echo  $this->Form->input('user_name', array(
			'type'       => 'text',
			'label'      => __('user_name'),
			'placeholder'=>__('enter_user_name'),
			'class'      => 'form-control'
		));
	 echo  $this->Form->input('password', array(
			'type'       => 'password',
			'label'      => __('password'),
			'placeholder'=>__('enter_password'),
			'class'      => 'form-control',
			'name' =>'password',
			'value'=>''
		)); 
	 	
	echo  $this->Form->input('email', array(
			'type'       => 'email',
			'label'      => __('email'),
			'placeholder'=>__('enter_email'),
			'class'      => 'form-control'
		));		
	echo  $this->Form->input('status', array(
			'type'   => 'select',
			'options'=> array(1=>__('active'),0=>__('inactive')),
			'label'  => __('status'),
			'default'=>'1',
			'class'  => 'form-control input-sm'
		));
	echo  $this->Form->input('image', array(
			'type'       => 'file',
			'label'      => __('image'),			
			'class'      => 'form-control'
		));	
	echo  $this->Form->input('old_image', array(
			'type'       => 'hidden',
			'value'=> $this->request->data['User']['image']
		));	
	 
	if(fileExistsInPath(__USER_IMAGE_PATH.$this->request->data['User']['image'] ) && $this->request->data['User']['image']!='' ) 
	{
		echo $this->Html->image(__SITE_URL.__USER_IMAGE_PATH.$this->request->data['User']['image'],array('id'=>'image_img','height'=>100));
	}
	?>
</div>

<?php
echo $this->element('Admin/add_edit_footer', array('items'=>'') );
?>
<?php echo $this->Form->end(); ?>
