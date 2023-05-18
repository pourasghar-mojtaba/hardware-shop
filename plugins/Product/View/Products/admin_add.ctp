<?php

echo $this->Html->css('/'.__PRODUCT.'/css/ListSelector/autocomplete.css');
echo $this->Html->css('/'.__PRODUCT.'/css/ListSelector/ui-lightness/jquery-ui-1.8.custom');
echo $this->Html->script('/'.__PRODUCT.'/js/ListSelector/jquery-ui-custom.min');

echo $this->Html->css('/'.__PRODUCT.'/css/addrow');
echo $this->Html->script('/js/admin/ckeditor415/ckeditor');
echo $this->Form->create('Product',array('enctype'=>'multipart/form-data'));
?>
<?php
$items = array();
$items['title'] = __d(__PRODUCT_LOCALE,'add_product');
$items['link'] = array('title'=>__d(__PRODUCT_LOCALE,'product_list'),'url'  =>__SITE_URL.'admin/product/products/index');
echo $this->element('Admin/add_edit_header', array('items'=>$items) );
$category_list = $this->Cms->categoryToList($productcategories,TRUE);
?>
<div class="col-md-6">
</div>
<div class="col-md-6">
	<?php
	echo  $this->Form->input('product_category_id', array(
			'type'   => 'select',
			'options'=> $category_list,
			'label'  => __d(__PRODUCT_LOCALE,'parent'),
			'class'  => 'form-control input-sm'
		));
	echo  $this->Form->input('title', array(
			'type' => 'text',
			'label'=> __d(__PRODUCT_LOCALE,'title'),
			'class'=> 'form-control',
			'name' => 'data[Producttranslation][title]'
		));

	echo  $this->Form->input('slug', array(
		'type' => 'text',
		'label'=> __d(__PRODUCT_LOCALE,'slug'),
		'class'=> 'form-control'
	));
	echo  $this->Form->input('num', array(
		'type' => 'text',
		'label'=> __d(__PRODUCT_LOCALE,'num'),
		'class'=> 'form-control'
	));
	echo  $this->Form->input('price', array(
		'type' => 'text',
		'label'=> __d(__PRODUCT_LOCALE,'price'),
		'id' => 'price',
		'class'=> 'form-control'
	));

	?>

	<label class="control-label" for="focusedInput">
		<?php echo __d(__PRODUCT_LOCALE,'tag') ?> :
	</label>
	<div id="messageForm">
		<div id="friends" class="ui-helper-clearfix"   >
			<div id="tag_place" class="col-sm-12">
			</div>
			<input id='friend_input' class="form-control" type='text' dir='rtl' size='30' style="width:50%;float: right;">
			<input class="btn btn-small btn-success add_tag" id="add_tag" value="<?php echo __d(__PRODUCT_LOCALE,'add_new_tag') ?>" type="button">
		</div>
	</div>
	<label>
		<?php
		echo __d(__PRODUCT_LOCALE,'property');
		?>
	</label>
	<table class="table table-bordered">
		<?php
		foreach($properties as $property):
			?>
			<tr>
				<td>
					<?php echo $property['Property']['name'] ?>
				</td>
				<td>
					<?php
					?>
					<select value="<?php echo($property['Property']['id']); ?>" class="clsPropertiesDetails" name="data[Productproperty][property_value][]">
						<?php
						foreach($propertydetails as $Detail):
							if($Detail['Propertydetail']['property_id']==$property['Property']['id']){
								echo ('<option value="');
								echo($Detail['Propertydetail']['id']);
								echo('">');
								echo ($Detail['Propertydetail']['value']);
								echo ('</option>');
							}
						endforeach;
						?>
					</select>
				</td>
			</tr>
			<input type="hidden" name="data[Productproperty][property_id][]" value="<?php echo $property['Property']['id'] ?>" />
		<?php
		endforeach;
		?>
	</table>
<?php
	echo  $this->Form->input('mini_detail', array(
			'type' => 'textarea',
			'label'=> __d(__PRODUCT_LOCALE,'mini_detail'),
			'class'=> 'form-control',
			'name' => 'data[Producttranslation][mini_detail]'
		));
	echo  $this->Form->input('detail', array(
			'type'       => 'textarea',
			'label'      => __d(__PRODUCT_LOCALE,'detail'),
			'id'      => 'detail',
			'class'      => 'form-control',
			'name' => 'data[Producttranslation][detail]'
		));
	?>
	<tr>
		<td colspan="5">
			<label class="control-label" for="focusedInput">
				<?php echo __d(__PRODUCT_LOCALE,'product_images') ?> :
			</label>
			<table id="expense_table" class="expense_table" cellspacing="0" cellpadding="0" width="500">
				<thead>
					<tr>
						<th>
							<?php echo __('image'); ?>
						</th>
						<th>
							<?php echo __('title'); ?>
						</th>
						<th>
							&nbsp;
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<input type="file" class="form-control" name="data[Productimage][image][]" id="image_no_01" maxlength="255"  />
						</td>
						<td>
							<input type="text" class="form-control" name="data[Productimage][title][]" id="title_no_01" maxlength="255"  />
						</td>
						<td>
							&nbsp;
						</td>
					</tr>
				</tbody>
			</table>

			<input type="button" value="<?php echo __d(__PRODUCT_LOCALE,'add_image'); ?>" id="add_ExpenseRow" />
		</td>
	</tr>
	<?php
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
<script>
	var _adurl = "<?php echo  __SITE_URL.'admin/'.__PRODUCT.'/'; ?>";
</script>
<?php echo $this->Html->script('/'.__PRODUCT.'/js/product'); ?>
