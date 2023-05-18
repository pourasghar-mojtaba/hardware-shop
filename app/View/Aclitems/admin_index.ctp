<?php
$items = array();
$items['title'] = __('permisions').' '.__('to').' '.$role['Role']['name'];
$items['save'] = FALSE;
$items['link'] = array('title'=>__('roles'),'url'  =>__SITE_URL.'admin/roles/index');
echo $this->element('Admin/add_edit_header', array('items'=>$items) );
?>
<div class="col-md-3">
</div>
<div class="col-md-9">
	<table class="table" width="400">
		<thead>
			<tr>
				<th>
					<?php echo __('part')?>
				</th>
				<th>
					<?php echo __('action')?>
				</th>
				<th>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if(!empty($aclitems))
			{
				foreach($aclitems as $aclitem){
					echo"
					<tr>
					<td class='center'>".$aclitem['Aclitem']['name']."</td>
					<td class='center'>".$aclitem['Aclitem']['action_name']."</td>
					<td class='center' id='prbtn_".$aclitem['Aclitem']['id']."'>";
					if($aclitem['Aclitem']['id'] == $aclitem['Aclrole']['aclitem_id'])															echo "<a href='JavaScript:void(0);' onclick='inactive_permission(".$_REQUEST['role_id'].",".$aclitem['Aclitem']['id'].")' id='aclitem_".$aclitem['Aclitem']['id']."'>
					<span class='label label-success'>".__('active')."</span>
					</a>";
					else echo"<a href='JavaScript:void(0);' onclick='active_permission(".$_REQUEST['role_id'].",".$aclitem['Aclitem']['id'].")' id='aclitem_".$aclitem['Aclitem']['id']."'>
					<span class='label label-danger'>".__('inactive')."</span></a>";
					echo"	</td>
					</tr>
					";
				}
			}

			?>

		</tbody>
	</table>
</div>

<?php
echo $this->element('Admin/add_edit_footer', array('items'=>$items) );
echo $this->Html->script('admin/function');
?>