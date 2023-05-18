<?php

echo $this->Form->create('Slider',array('enctype'=>'multipart/form-data'));
?>
<?php
$items = array();
$items['title'] = __d(__SLIDER_LOCALE,'add_slider');
$items['link'] = array('title'=>__d(__SLIDER_LOCALE,'slider_list'),'url'  =>__SITE_URL.'admin/product/sliders/index');
echo $this->element('Admin/add_edit_header', array('items'=>$items) );
 
?>
<div class="col-md-6">
</div>
<div class="col-md-6">
	<?php

	 
	echo  $this->Form->input('title', array(
			'type' => 'text',
			'label'=> __d(__SLIDER_LOCALE,'title'),
			'class'=> 'form-control',
			'name' => 'data[Slidertranslation][title]'
		));
	echo  $this->Form->input('detail', array(
			'type'       => 'textarea',
			'label'      => __d(__SLIDER_LOCALE,'detail'),
			'id'      => 'detail',
			'class'      => 'form-control',
			'name' => 'data[Slidertranslation][detail]'
		));		
 echo  $this->Form->input('url', array(
			'type' => 'text',
			'label'=> __d(__SLIDER_LOCALE,'url'),
			'style'=>'direction:ltr',
			'class'=> 'form-control',
			'name' => 'data[Slidertranslation][url]'
		));
	echo  $this->Form->input('image', array(
			'type' => 'file',
			'id' => 'slider_image',
			'label'=> __d(__SLIDER_LOCALE,'image'),
			'class'=> 'form-control',
			'name' => 'data[Slidertranslation][image]'
		));	
	echo  $this->Form->input('arrangment', array(
			'type' => 'number',
			'label'=> __d(__SLIDER_LOCALE,'arrangment'),
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