<?php echo $this->Form->create('Setting'); ?>
<?php
$items = array();
$items['title'] = __('site_setting');
$items['link'] = array('title'=>__('site_setting'),'url'  =>'');
echo $this->element('Admin/add_edit_header', array('items'=>$items) );
 
?>
<div class="col-md-6">
</div>
<div class="col-md-6">
	<?php

 
	echo  $this->Form->input('site_title', array(
			'type'   => 'text',
			'label'=> __('title'),
			'class'  => 'form-control'
		));
   echo  $this->Form->input('site_keywords', array(
			'type'   => 'textarea',
			'label'=> __('keywords'),
			'class'  => 'form-control'
	));	echo __('separate_with_virgol');
	echo  $this->Form->input('site_description', array(
			'type'   => 'textarea',
			'label'=> __('description'),
			'class'  => 'form-control'
	));	echo __('separate_with_virgol');	
	?>
</div>

<?php
echo $this->element('Admin/add_edit_footer', array('items'=>'') );
?>
<?php echo $this->Form->end(); ?>