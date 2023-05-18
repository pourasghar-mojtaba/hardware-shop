<?php
echo $this->Html->css('/'.__SHOP.'/css/addrow');
echo $this->Html->script('/js/admin/ckeditor/ckeditor');
echo $this->Form->create('Productfile',array('enctype'=>'multipart/form-data'));
?>
<?php
$items = array();
$items['title'] = __d(__SHOP_LOCALE,'edit_productfile');
$items['link'] = array('title'=>__d(__SHOP_LOCALE,'productfile_list'),'url'  =>__SITE_URL.'admin/'.__SHOP.'/productfiles/index');
echo $this->element('Admin/add_edit_header', array('items'=>$items) );
$products = $this->Shop->dataToList($products,'Product'); 
?>
<div class="col-md-6">
<?php	
	//echo $this->request->data['Productfile']['id'];
?>
</div>
<style>
	.clsPropertiesDetails{
		
	}
</style>
<div class="col-md-6">
	<?php
	echo $this->Form->input('id');
	echo  $this->Form->input('product_id', array(
			'type'   => 'select',
			'options'=> $products,
			'label'  => __d(__SHOP_LOCALE,'parent'),
			'class'  => 'form-control input-sm'					
		));
	?> 
	 
	<tr>
		<td colspan="5">
			<label class="control-label" for="focusedInput">
				<?php echo __d(__SHOP_LOCALE,'productfiles') ?> :
			</label>
			<table id="expense_table" class="expense_table" cellspacing="0" cellpadding="0" width="500">
				<thead>
					<tr>
						<th>
							<?php echo __d(__SHOP_LOCALE,'file'); ?>
						</th>
						<th>
							<?php echo __d(__SHOP_LOCALE,'title'); ?>
						</th>
						<th>
							&nbsp;
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
					 
					if(!empty($productfiles)){
						foreach($productfiles as $productfile){
							echo "
							<tr>
							<td>
							<input type='file' class='form-control' name='data[Productfile][pfile][]' id='file_no_01' maxlength='255'  />
							</td>
							<td>
							<input type='text' class='form-control' name='data[Productfile][title][]' id='title_no_01'
							maxlength='255' value='".$productfile['Productfile']['title']."' />
							</td>";
							if(fileExistsInPath(__SHOP_FILE_PATH.$productfile['Productfile']['file'] ) && $productfile['Productfile']['file'] != '' ){
								echo "<td><a target='_blank' href= '".__SITE_URL.__SHOP_FILE_URL.$productfile['Productfile']['file']."' >";
								echo $productfile['Productfile']['title'];
								echo "</a></td>";
							}



							echo"<td><input type='button' value='Delete' class='del_ExpenseRow' /></td>";
							echo "<input type='hidden' value='".$productfile['Productfile']['id']."' name='data[Productfile][id][]'>";
							echo "<input type='hidden' value='".$productfile['Productfile']['file']."' name='data[Productfile][old_file][]'>";

							echo"</tr>";
						}
					}
					else
					{
						echo "
						<tr>
						<td>
						<input type='file' name='data[Productfile][pfile][]' id='file_no_01' maxlength='255'  />
						</td>
						<td>
						<input type='text' name='data[Productfile][title][]' id='title_no_01' maxlength='255'  />
						</td>
						<td>&nbsp;</td>
						</tr>
						";
					}

					?>

				</tbody>
			</table>

		 
		</td>
	</tr>
 
</div>
 
<?php
  echo $this->element('Admin/add_edit_footer', array('items'=>'') );
?>
<?php echo $this->Form->end(); ?>
<script>
     
	$(function()
		{
			// GET ID OF last row and increment it by one
			var $lastChar =1, $newRow;
			$get_lastID = function()
			{
				var $id = $('.expense_table tr:last-child td:first-child input').attr("id");
				$lastChar = parseInt($id.substr($id.length - 2), 10);
				console.log('GET id: ' + $lastChar + ' | $id :'+$id);
				$lastChar = $lastChar + 1;
				$newRow = "<tr> \
				<td><input type='file' name='data[Productfile][pfile][]' class='form-control' id='file_no_0"+$lastChar+"' maxlength='255' /></td> \<td><input type='text' class='form-control' name='data[Productfile][title][]' id='title_no_0"+$lastChar+"' maxlength='255' /></td> \<td><input type='button' value='Delete' class='del_ExpenseRow' /></td> \
				</tr>"
				return $newRow;
			}

			// ***** -- START ADDING NEW ROWS
			$('#add_ExpenseRow').click(function()
				{
					//if($lastChar <= 9){
					$get_lastID();
					$('.expense_table tbody').append($newRow);
					/*} else {
					alert("Reached Maximum Rows!");
					};*/
				});

			$("body").on("click",'.del_ExpenseRow', function()
				{
					$(this).closest('tr').remove();
					$lastChar = $lastChar-2;
				});
		});
		CKEDITOR.replace( 'detail' );
</script>
