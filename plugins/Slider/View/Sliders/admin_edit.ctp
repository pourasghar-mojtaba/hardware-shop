<?php
echo $this->Form->create('Slider',array('enctype'=>'multipart/form-data'));
?>
<?php
$items = array();
$items['title'] = __d(__SLIDER_LOCALE,'edit_slider');
$items['link'] = array('title'=>__d(__SLIDER_LOCALE,'slider_list'),'url'  =>__SITE_URL.'admin/'.__SLIDER.'/sliders/index');
echo $this->element('Admin/add_edit_header', array('items'=>$items) );
 
?>
<div class="col-md-6">
</div>
<div class="col-md-6">
	<?php

	echo $this->Form->input('id');
	 
	echo  $this->Form->input('title', array(
			'type' => 'text',
			'label'=> __d(__SLIDER_LOCALE,'title'),
			'class'=> 'form-control',
			'value'=> $this->request->data['Slidertranslation']['title'],
			'name' => 'data[Slidertranslation][title]'
		));
	echo  $this->Form->input('detail', array(
			'type' => 'textarea',
			'label'=> __d(__SLIDER_LOCALE,'detail'),
			'class'=> 'form-control',
			'value'=> $this->request->data['Slidertranslation']['detail'],
			'name' => 'data[Slidertranslation][detail]'
		));
	echo  $this->Form->input('url', array(
			'type' => 'text',
			'label'=> __d(__SLIDER_LOCALE,'url'),
			'style'=>'direction:ltr',
			'class'=> 'form-control',
			'value'=> $this->request->data['Slidertranslation']['url'],
			'name' => 'data[Slidertranslation][url]'
		)); 
	$user_image = '';
		$width      = 400;
		$height     = 200;
		$image      = $this->request->data['Slidertranslation']['image'];
		if(fileExistsInPath(__SLIDER_IMAGE_PATH.$image ) && $image != '' ){
			$user_image = $this->Html->image('/'.__SLIDER_IMAGE_URL.$image,array('width' =>$width,'height'=>$height,'id'=>'blog_thumb_image_'.$this->request->data['Slider']['id']));
		}
		else
		{
			$user_image = $this->Html->image('/'.__BLOG.'/new_blog.png',array('width' =>$width,'height'=>$height,'alt'   =>''));
		}
		echo $user_image;	
	echo  $this->Form->input('image', array(
			'type' => 'file',
			'id' => 'slider_image',
			'label'=> __d(__SLIDER_LOCALE,'image'),
			'class'=> 'form-control',
			'value'=> $this->request->data['Slidertranslation']['image'],
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
