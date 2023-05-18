<?php
echo $this->Html->css('/'.__BLOG.'/css/ListSelector/autocomplete.css');
echo $this->Html->css('/'.__BLOG.'/css/ListSelector/ui-lightness/jquery-ui-1.8.custom');
echo $this->Html->script('/'.__BLOG.'/js/ListSelector/jquery-ui-custom.min');
echo $this->Html->script('/js/admin/ckeditor415/ckeditor');

echo $this->Form->create('Blog',array('enctype'=>'multipart/form-data'));
?>
<?php
$items = array();
$items['title'] = __d(__BLOG_LOCALE,'add_blog');
$items['link'] = array('title'=>__d(__BLOG_LOCALE,'blog_list'),'url'  =>__SITE_URL.'admin/'.__BLOG.'/'.__BLOG_CONTROLLER.'/index');
echo $this->element('Admin/add_edit_header', array('items'=>$items) );

?>
<div class="col-md-6">
</div>
<div class="col-md-6">
	<?php

	echo  $this->Form->input('title', array(
			'type' => 'text',
			'label'=> __d(__BLOG_LOCALE,'title'),
			'class'=> 'form-control',
			'name' => 'data[Blogtranslation][title]'
		));
	echo  $this->Form->input('slug', array(
		'type' => 'text',
		'label'=> __d(__BLOG_LOCALE,'slug'),
		'class'=> 'form-control',
		'dir'=>'ltr'
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
			'id' => 'blog_image',
			'label'=> __d(__BLOG_LOCALE,'image'),
			'class'=> 'form-control'
		));
	?>
	<label class="control-label" for="focusedInput">
		<?php echo __d(__BLOG_LOCALE,'tag') ?> :
	</label>
	<div id="messageForm">
		<div id="friends" class="ui-helper-clearfix"   >
			<div id="tag_place" class="col-sm-12">
			</div>
			<input id='friend_input' class="form-control" type='text' dir='rtl' size='30' style="width:50%;float: right;">
			<input class="btn btn-small btn-success add_tag" id="add_tag" value="<?php echo __d(__BLOG_LOCALE,'add_new_tag') ?>" type="button">
		</div>
	</div>
	<?php
	echo  $this->Form->input('link', array(
			'type' => 'text',
			'label'=> __d(__BLOG_LOCALE,'source_link'),
			'class'=> 'form-control',

	));

	echo  $this->Form->input('little_detail', array(
			'type' => 'textarea',
			'label'=> __d(__BLOG_LOCALE,'little_detail'),
			'class'=> 'form-control',
			'name' => 'data[Blogtranslation][little_detail]'
		));
	?>
</div>

<div class="col-md-12">
	<?php
	echo $this->Form->input('detail', array(
		'type' => 'textarea',
		'label' => __d(__BLOG_LOCALE, 'detail'),
		'id' => 'detail',
		'class' => 'form-control',
		'name' => 'data[Blogtranslation][detail]'
	));
	?>
</div>

<?php
echo $this->element('Admin/add_edit_footer', array('items'=>'') );
?>
<?php echo $this->Form->end(); ?>
<script>
    CKEDITOR.replace( 'detail' );
</script>

<?php echo $this->Html->script('/'.__BLOG.'/js/blog'); ?>





