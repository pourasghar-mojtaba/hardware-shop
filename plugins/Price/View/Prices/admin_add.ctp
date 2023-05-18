<?php

 

echo $this->Html->css('/'.__PRICE.'/js/PersianDatePicker/src/Mh1PersianDatePicker');
echo $this->Html->script('/'.__PRICE.'/js/PersianDatePicker/src/Mh1PersianDatePicker');


echo $this->Form->create('Price',array('enctype'=>'multipart/form-data'));
?>
<?php
$items = array();
$items['title'] = __d(__PRICE_LOCALE,'add_price');
$items['price'] = array('title'=>__d(__PRICE_LOCALE,'price_list'),'url'  =>__SITE_URL.'admin/product/productcategories/index');
echo $this->element('Admin/add_edit_header', array('items'=>$items) );
 
?>
<div class="col-md-6">
</div>
<div class="col-md-6">
	<?php

	 
	echo  $this->Form->input('title', array(
			'type' => 'text',
			'label'=> __d(__PRICE_LOCALE,'title'),
			'class'=> 'form-control'
		));
 	echo  $this->Form->input('buy_price', array(
			'type' => 'text',
			'label'=> __d(__PRICE_LOCALE,'buy_price'),
			'style'=> 'direction:ltr',
			'class'=> 'form-control'
		));
	echo  $this->Form->input('sel_price', array(
			'type' => 'text',
			'label'=> __d(__PRICE_LOCALE,'sel_price'),
			'style'=> 'direction:ltr',
			'class'=> 'form-control'
	));	
	
	echo  $this->Form->input('price_date', array(
			'type' => 'text',
			'label'=> __d(__PRICE_LOCALE,'price_date'),
			'style'=> 'direction:ltr',
			'class'=> 'form-control',
			'onclick' => 'Mh1PersianDatePicker.Show(this, "'.$this->Cms->get_current_date("Y/m/d").'");'
	));	
	echo  $this->Form->input('arrangment', array(
			'type' => 'number',
			'label'=> __d(__PRICE_LOCALE,'arrangment'),
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