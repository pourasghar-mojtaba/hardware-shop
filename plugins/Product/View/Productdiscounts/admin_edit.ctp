<?php
echo $this->Html->css('/' . __PRODUCT . '/css/addrow');
echo $this->Html->script('/js/admin/ckeditor/ckeditor');
echo $this->Form->create('Productdiscount', array('enctype' => 'multipart/form-data'));
?>
<?php
$items = array();
$items['title'] = __d(__PRODUCT_LOCALE, 'edit_productdiscount');
$items['link'] = array('title' => __d(__PRODUCT_LOCALE, 'productdiscount_list'), 'url' => __SITE_URL . 'admin/' . __PRODUCT . '/productdiscounts/index');
echo $this->element('Admin/add_edit_header', array('items' => $items));

echo $this->Html->css('/' . __PRODUCT . '/css/pwtdatepicker/persian-datepicker.min.css');
echo $this->Html->script('/' . __PRODUCT . '/js/pwtdatepicker/persian-date.min.js');
echo $this->Html->script('/' . __PRODUCT . '/js/pwtdatepicker/persian-datepicker.min.js');

?>
<div class="col-md-6">
	<!-- <input type="hidden" id="id" name = "id" value="<?php echo($this->request->data['Productdiscount']['id']) ?>"> -->
	<?php
	echo $this->Form->input('id');
	?>
</div>
<div class="col-md-6">
	<label>
		<?php echo(__d(__PRODUCT_LOCALE, 'discounttype_name')) ?>
	</label>
	<select id='Productdiscountdiscountid' name='data[Productdiscount][discount_id]' class='form-control'>
		<?php
		foreach ($lstproductdiscount as $dscnttype) {
			if ($this->request->data['Productdiscount']['discount_type_id']==$dscnttype['Discounttype']['id'])
			echo("<option value='" . $dscnttype['Discounttype']['id'] . "' selected>" . $dscnttype['Discounttypetranslation']['name'] . "</option>");
			else echo("<option value='" . $dscnttype['Discounttype']['id'] . "'>" . $dscnttype['Discounttypetranslation']['name'] . "</option>");
		}
		?>
	</select>
	<label>
		<?php echo(__d(__PRODUCT_LOCALE, 'product_title')) ?>
	</label>
	<select id='ProductdiscountProductId' name='data[Productdiscount][product_id]' class='form-control'>
		<?php
		foreach ($lstProducts as $prdct) {
			if ($this->request->data['Productdiscount']['product_id']==$prdct['Product']['id'])
			echo("<option value='" . $prdct['Product']['id'] . "' selected>" . $prdct['Producttranslation']['title'] . "</option>");
			else echo("<option value='" . $prdct['Product']['id'] . "'>" . $prdct['Producttranslation']['title'] . "</option>");
		}
		?>
	</select>

	<?php

	echo $this->Form->input('start_date', array(
		'type' => 'text',
		'label' => __d(__PRODUCT_LOCALE, 'start_date'),
		'class' => 'form-control',
		'id' => 'start_date',
		'value' => $this->Cms->convert_persian_int_to_gregorian("Y-m-d", $this->request->data['Productdiscount']['start_date'])
	));

	echo $this->Form->input('end_date', array(
		'type' => 'text',
		'label' => __d(__PRODUCT_LOCALE, 'end_date'),
		'class' => 'form-control',
		'id' => 'end_date',
		'value' => $this->Cms->convert_persian_int_to_gregorian("Y-m-d", $this->request->data['Productdiscount']['end_date']),
	));

	echo $this->Form->input('status', array(
		'type' => 'select',
		'options' => array(1 => __('active'), 0 => __('inactive')),
		'label' => __('active'),
		'default' => '1',
		'class' => 'form-control input-sm',
	));
	?>


</div>

<?php
echo $this->element('Admin/add_edit_footer', array('items' => ''));
?>
<?php echo $this->Form->end(); ?>
<script>
    $(document).ready(function () {

        $('#start_date').persianDatepicker({
            minDate: new persianDate().unix(),
            observer: true,
            format: 'YYYY/MM/DD',
            altField: '.observer-example-alt',
        });

        $('#end_date').persianDatepicker({
            minDate: new persianDate().unix(),
            observer: true,
            format: 'YYYY/MM/DD',
            altField: '.observer-example-alt',

        });
    });


</script>
