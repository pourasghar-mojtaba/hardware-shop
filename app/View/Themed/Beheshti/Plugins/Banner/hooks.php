<?php

 $this->add_hook('admin_group_menu','banner_admin_menu');

function banner_admin_menu($arg)
{
	$active = NULL;
	$controllers = array('banners');
	if(in_array($arg['arguments']['controller'],$controllers)) $active= 'active';
	echo "
		<li class='treeview ".$active."'>
			<a href='#'>
				<i class='fa fa-map-signs'>
				</i>
				<span>
					". __d(__BANNER_LOCALE,'banner_managment')."
				</span>
				<i class='fa fa-angle-left pull-right'>
				</i>
			</a> 	
			<ul class='treeview-menu'>";
			$active = NULL;
			if($arg['arguments']['controller'] == 'banners')	 $active = 'class="active"';
			echo"
				<li ".$active." >
					<a href='".__SITE_URL."admin/".__BANNER."/".__BANNER_CONTROLLER."/index'>
						<i class='fa fa-circle-o'>
						</i> ".__d(__BANNER_LOCALE,'banner_managment')."
					</a>
				</li>";
			$active = NULL;
			
			echo"
			</ul>
		</li>
	";
	
}
?>