<?php

 
$this->add_hook('admin_group_menu','link_menu');

function link_menu($arg)
{
	$active = NULL;
	$controllers = array('links');
	if(in_array($arg['request']->params['controller'],$controllers)) $active= 'active';
	echo "
		<li class='treeview ".$active."'>
			<a href='#'>
				<i class='fa fa-link'>
				</i>
				<span>
					". __d(__LINK_LOCALE,'link_managment')."
				</span>
				<i class='fa fa-angle-left pull-right'>
				</i>
			</a> 	
			<ul class='treeview-menu'>";
			$active = NULL;
			if($arg['request']->params['controller'] == 'links')	 $active = 'class="active"';	
			echo"	
				<li ".$active."> 
					<a href='".__SITE_URL."admin/link/links/index'>
						<i class='fa fa-circle-o'>
						</i> ". __d(__LINK_LOCALE,'link_managment')."
					</a>
				</li>
			</ul>
		</li>
	";
	
}


$this->add_hook('last_links','last_links');

function last_links($arg){
	
	App::uses('LinkAppModel', 'Link.Model');
	App::uses('Link', 'Link.Model');
	$link = new Link();
	$link->recursive = - 1;
	$options['fields'] = array(
		'Link.id',
		'Link.title',
		'Link.link',
		'Link.detail',
	);
  
	$options['conditions'] = array(
		'Link.status'=> 1
	);
	$options['order'] = array(
		'Link.arrangment'=>'asc'
	);
	$options['limit'] = 5;
	$links = $link->find('all',$options);
	
	echo "<h3 class='widget-title'>".__d(__LINK_LOCALE,'links')."</h3>";
		foreach($links as $link){
			echo "
				<div class='textwidget'>
					<h5>
						<span style='color: #929497'><br/><span class='icon-container'><span class='fa fa-check'></span></span></span> 
						<span style='color: #333333'><strong><a href='".$link['Link']['link']."' target='_blank' rel='nofollow' >".$link['Link']['title']."</a></strong></span>
					</h5>
					<p>".$link['Link']['detail']."</p>						
				</div>
			";
		}
		
	 
	
}
?>