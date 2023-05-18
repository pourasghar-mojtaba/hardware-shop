<?php echo $this->Form->create('Page'); ?>
<?php
echo $this->Html->script('/js/admin/ckeditor/ckeditor');
$items = array();
$items['title'] = __('edit_page');
$items['link'] = array('title'=>__('pages'),'url'  =>__SITE_URL.'admin/pages/index');
echo $this->element('Admin/add_edit_header', array('items'=>$items) );
?>
<div class="col-md-6">
</div>
<div class="col-md-6">
	<?php
	echo $this->Form->input('id');
	echo  $this->Form->input('title', array(
			'type'       => 'text',
			'label'      => __('title'),
			'class'      => 'form-control'
		));
	/*echo  $this->Form->input('status', array(
			'type'   => 'select',
			'options'=> array(1=>__('active'),0=>__('inactive')),
			'label'  => __('status'),
			'default'=>'1',
			'class'  => 'form-control input-sm'
		));	
	echo  $this->Form->input('keyword', array(
			'type'       => 'text',
			'label'      => __('keyword'),
			'placeholder'=>__('separate_with_sharp'),
			'class'      => 'form-control'
		));
	echo  $this->Form->input('meta', array(
			'type'       => 'text',
			'label'      => __('meta'),
			'placeholder'=>__('separate_with_sharp'),
			'class'      => 'form-control'
		));*/
	echo  $this->Form->input('body', array(
			'type'       => 'textarea',
			'label'      => __('body'),
			'id'      => 'body',
			'value'=>$this->Cms->convert_character_editor($this->request->data['Page']['body']),
			'class'      => 'form-control'
		));
	
	?>
</div>

<?php
echo $this->element('Admin/add_edit_footer', array('items'=>'') );
?>
<?php echo $this->Form->end(); ?>


<script>
	CKEDITOR.replace( 'body' );
</script>