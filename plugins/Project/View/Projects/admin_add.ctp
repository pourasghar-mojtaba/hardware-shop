<?php
echo $this->Html->css('/'.__PROJECT.'/css/addrow');
echo $this->Html->script('/js/admin/ckeditor/ckeditor');
echo $this->Form->create('Project',array('enctype'=>'multipart/form-data'));
?>
<?php
$items = array();
$items['title'] = __d(__PROJECT_LOCALE,'add_project');
$items['link'] = array('title'=>__d(__PROJECT_LOCALE,'project_list'),'url'  =>__SITE_URL.'admin/project/projects/index');
echo $this->element('Admin/add_edit_header', array('items'=>$items) );
$category_list = $this->Cms->categoryToList($projectcategories,TRUE);
?>
<div class="col-md-6">
</div>
<div class="col-md-6">
	<?php
	echo  $this->Form->input('project_category_id', array(
			'type'   => 'select',
			'options'=> $category_list,
			'label'  => __d(__PROJECT_LOCALE,'parent'),
			'class'  => 'form-control input-sm'					
		));
	echo  $this->Form->input('title', array(
			'type' => 'text',
			'label'=> __d(__PROJECT_LOCALE,'title'),
			'class'=> 'form-control'
		));
	echo  $this->Form->input('mini_detail', array(
			'type' => 'textarea',
			'label'=> __d(__PROJECT_LOCALE,'mini_detail'),
			'class'=> 'form-control'
		));
	echo  $this->Form->input('detail', array(
			'type'       => 'textarea',
			'label'      => __d(__PROJECT_LOCALE,'detail'),
			'id'      => 'detail',
			'class'      => 'form-control'
		));	
	?>
	<tr>
		<td colspan="5">
			<label class="control-label" for="focusedInput">
				<?php echo __d(__PROJECT_LOCALE,'project_images') ?> :
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
							<input type="file" class="form-control" name="data[Projectimage][image][]" id="image_no_01" maxlength="255"  />
						</td>
						<td>
							<input type="text" class="form-control" name="data[Projectimage][title][]" id="title_no_01" maxlength="255"  />
						</td>
						<td>
							&nbsp;
						</td>
					</tr>
				</tbody>
			</table>

			<input type="button" value="<?php echo __d(__PROJECT_LOCALE,'add_image'); ?>" id="add_ExpenseRow" />
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
				<td><input type='file' name='data[Projectimage][image][]' class='form-control' id='image_no_0"+$lastChar+"' maxlength='255' /></td> \<td><input type='text' class='form-control' name='data[Projectimage][title][]' id='title_no_0"+$lastChar+"' maxlength='255' /></td> \<td><input type='button' value='Delete' class='del_ExpenseRow' /></td> \
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

			$("body").on("click",'.del_ExpenseRow', function(){ 
        		$(this).closest('tr').remove();
        		$lastChar = $lastChar-2;
        	});
		});
		CKEDITOR.replace( 'detail' );
</script>
