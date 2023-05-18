<?php
echo $this->Html->css('/'.__SHOP.'/css/addrow');
echo $this->Html->script('/js/admin/ckeditor/ckeditor');
echo $this->Form->create('Productfile',array('enctype'=>'multipart/form-data'));
?>
<?php
$items = array();
$items['title'] = __d(__SHOP_LOCALE,'add_product');
$items['link'] = array('title'=>__d(__SHOP_LOCALE,'product_list'),'url'  =>__SITE_URL.'admin/shop/products/index');
echo $this->element('Admin/add_edit_header', array('items'=>$items) );
$products = $this->Shop->dataToList($products,'Product'); 

?>
<style>
	.clsPropertiesDetails{
		
	}
</style>
<div class="col-md-6">
 
</div>
<div class="col-md-6">
	<?php
	echo  $this->Form->input('product_id', array(
			'type'   => 'select',
			'options'=> $products,
			'label'  => __d(__SHOP_LOCALE,'parent'),
			'class'  => 'form-control input-sm'					
		));
	 

	?>
 
 
	<table class="table table-bordered">
 
	
		<tr>
			<td colspan="5">
				<label class="control-label" for="focusedInput">
					<?php echo __d(__SHOP_LOCALE,'product_files') ?> :
				</label>
				<table id="expense_table" class="files_table" cellspacing="0" cellpadding="0" width="500">
					<thead>
						<tr>
							<th>
								<?php echo __d(__SHOP_LOCALE,'file'); ?>
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
								<input type="file" class="form-control" name="data[Productfile][pfile][]" id="file_no_01" maxlength="255"  />
							</td>
							<td>
								<input type="text" class="form-control" name="data[Productfile][title][]" id="filetitle_no_01" maxlength="255"  />
							</td>
							<td>
								&nbsp;
							</td>
						</tr>
					</tbody>
				</table>

				<input type="button" value="<?php echo __d(__SHOP_LOCALE,'add_file'); ?>" class="add_ExpenseRow" id="add_FileRow" />
			</td>
		</tr>		
	</table> 
 
</div>
 
 
<?php
echo $this->element('Admin/add_edit_footer', array('items'=>'') );
?>
<?php echo $this->Form->end(); ?>






<script>
	 
	$(function()
		{
						
			//===================================================================================================
			var $fileCount =1, $newRow;
			$get_lastFileID = function()
			{
				var $id = $('.files_table tr:last-child td:first-child input').attr("id");
				$fileCount = parseInt($id.substr($id.length - 2), 10);
				console.log('GET id: ' + $fileCount + ' | $id :'+$id);
				$fileCount = $fileCount + 1;
				$newRow = "<tr> \
				<td><input type='file' name='data[Productfile][pfile][]' class='form-control' id='file_no_0"+$fileCount+"' maxlength='255' /></td> \<td><input type='text' class='form-control' name='data[Productfile][title][]' id='filetitle_no_0"+$fileCount+"' maxlength='255' /></td> \<td><input type='button' value='Delete' class='del_ExpenseRow' /></td> \
				</tr>"
				return $newRow;
			}

			// ***** -- START ADDING NEW ROWS
			$('#add_FileRow').click(function()
				{
					//if($fileCount <= 9){
					$get_lastFileID();
					$('.files_table tbody').append($newRow);
					/*} else {
					alert("Reached Maximum Rows!");
					};*/
				});

			$("body").on("click",'.del_ExpenseRow', function(){ 
					$(this).closest('tr').remove();
					$fileCount = $fileCount-2;
				});
			//===================================================================================================		
			
		});
	CKEDITOR.replace( 'detail' );
</script>
