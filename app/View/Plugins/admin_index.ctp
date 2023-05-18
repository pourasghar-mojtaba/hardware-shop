<?php
$items = array();
$controller = 'plugins';
$items['title'] = __('list_of_plugins');
$items['save'] = FALSE;
echo $this->element('Admin/add_edit_header', array('items'=>$items) );
?>
<div class="col-md-3">
</div>
<div class="col-md-9">
	<table class="table" width="400">
		<thead>
			<tr>
				<th>
					<?php echo __('plugin')?>
				</th>
				<th>
					<?php echo __('detail')?>
				</th>
				<th>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php
			 
			$plagin_list= $this->Cms->makefilelist(__PLUGINS, ".|..", true, "folders");
			if(!empty($plagin_list))
			{
				foreach($plagin_list as $plugin_name){

					if(file_exists(__PLUGINS.$plugin_name."/plugin.php")){
						require_once(__PLUGINS.$plugin_name.'/plugin.php');
						echo "<tr>";
						echo"<td>";
						echo $plugin_name;						 					
						echo $this->AdminHtml->createActionLink();
						$info = array();
						$info = $this->requestAction(__SITE_URL.'admin/plugins/get_plugin/'.$plugin_name);
						if(empty($info))
						echo $this->AdminHtml->actionLink(__('install'),__SITE_URL.'admin/'.$controller.'/install/'.$plugin_name,'','|');
						else echo $this->AdminHtml->actionLink(__('unistall'),__SITE_URL.'admin/'.$controller.'/uninstall/'.$plugin_name,'delete','|');
						//pr($info);
						if(!empty($info) && $info['Plugin']['status'] == 0)
						echo $this->AdminHtml->actionLink(__('active'),__SITE_URL.'admin/'.$controller.'/active/'.$plugin_name,'permission');
						
						if(!empty($info) && $info['Plugin']['status'] == 1)
						echo $this->AdminHtml->actionLink(__('inactive'),__SITE_URL.'admin/'.$controller.'/inactive/'.$plugin_name,'delete');
						
						echo $this->AdminHtml->endActionLink();
						echo"</td>";
						echo"<td>";
						echo"<div>";
						echo $info_array['description'];
						echo "</div>";
						echo"<div>".__('create_from')." : ";						
						echo $this->Html->link($info_array['author'],"http://".$info_array['website'],array('target'=>'_blank'));
						echo"</div>";
						echo"<div>".$info_array['version']."</div>";
						echo"</td>";
						echo"<td>";
						echo" </td>
						</tr>";
					}
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