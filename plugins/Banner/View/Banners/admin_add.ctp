<?php
 
echo $this->Form->create('Banner',array('enctype'=>'multipart/form-data'));
?>
<?php
$items = array();
$items['title'] = __d(__BANNER_LOCALE,'add_banner');
$items['link'] = array('title'=>__d(__BANNER_LOCALE,'banner_list'),'url'  =>__SITE_URL.'admin/'.__BANNER.'/'.__BANNER_CONTROLLER.'/index');
echo $this->element('Admin/add_edit_header', array('items'=>$items) );
 
?>
<div class="col-md-6">
</div>
<div class="col-md-6">
	<?php
	
	echo  $this->Form->input('bannerlocation_id', array(
			'type'   => 'select',
			'options'=> $bannerlocations,
			'label'  => __d(__BANNER_LOCALE,'banner_location'),
			'class'  => 'form-control input-sm',
								
		));
	
	echo  $this->Form->input('title', array(
			'type' => 'text',
			'label'=> __d(__BANNER_LOCALE,'title'),
			'class'=> 'form-control',
			'name' => 'data[Bannertranslation][title]'
		));
		
	echo  $this->Form->input('status', array(
			'type'   => 'select',
			'options'=> array(1=>__('active'),0=>__('inactive')),
			'label'  => __('status'),
			'default'=>'1',
			'class'  => 'form-control input-sm'
		));
			
	echo  $this->Form->input('image', array(
			'type' => 'file',
			'id' => 'banner_image',
			'label'=> __d(__BANNER_LOCALE,'image'),
			'class'=> 'form-control',
			'name' => 'data[Bannertranslation][image]'	
		));
	?>
 
	<?php 	
	echo  $this->Form->input('link', array(
			'type' => 'text',
			'label'=> __d(__BANNER_LOCALE,'source_link'),
			'class'=> 'form-control'
	));	
	
 	
	?>
</div>
 
<?php
echo $this->element('Admin/add_edit_footer', array('items'=>'') );
?>
 
 




