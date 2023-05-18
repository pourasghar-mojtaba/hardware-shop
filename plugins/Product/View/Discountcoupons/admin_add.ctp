<?php
echo $this->Html->css('/'.__SHOP.'/css/addrow');
echo $this->Html->script('/js/admin/ckeditor/ckeditor');
echo $this->Form->create('Discountcoupons',array('enctype'=>'multipart/form-data'));
?>
<?php
$items = array();
$items['title'] = __d(__SHOP_LOCALE,'add_discountcoupon');
$items['link'] = array('title'=>__d(__SHOP_LOCALE,'discountcoupon_list'),'url'  =>__SITE_URL.'admin/shop/discountcoupons/index');
echo $this->element('Admin/add_edit_header', array('items'=>$items));
?> 
 

<div class="col-md-6">
 
</div>
<div class="col-md-6">
	<label>
	<?php echo(__d(__SHOP_LOCALE,'name')) ?>
	</label>
	<select id='dscntid' name = 'dscntid' class='form-control'>
		<?php
		foreach($lstDiscountType as $dscnttype)
		{
			echo("<option value='".$dscnttype['discounttypes']['id']."'>".$dscnttype['discounttypes']['name']."</option>");
		}
		?>
	</select>

	<lable>
	<?php
		echo(__d(__SHOP_LOCALE,'count'));
	?>
	</lable>
	<input type='text' id='count1' name='count1' class='form-control'>
	 
</div>

<?php
echo $this->element('Admin/add_edit_footer', array('items'=>'') );
?>
<?php echo $this->Form->end(); ?>
 
<script>
    function generateCodes(e) {
		alert('starting job...');
        e.preventDefault();  
		var i;    
		console.log($('#count1').text());
		for(i=0;i<10;i++)
		{
			//$('#DscntFields').append('<input type="text" name="data[discounttypes][code][]" id="fld_dscntid_001" value='+<?php echo(strtoupper(md5(rand()))); ?>+' />');
			//$('#DscntFields').append('<input type="text" />');
		} 
        return false;
    }
</script>