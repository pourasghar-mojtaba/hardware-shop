<?php

 
$this->add_hook('admin_group_menu','catalog_menu');

function catalog_menu($arg)
{
	$active = NULL;
	$controllers = array('catalogs');
	if(in_array($arg['request']->params['controller'],$controllers)) $active= 'active';
	echo "
		<li class='treeview ".$active."'>
			<a href='#'>
				<i class='fa fa-file-pdf-o'>
				</i>
				<span>
					". __d(__CATALOG_LOCALE,'catalog_managment')."
				</span>
				<i class='fa fa-angle-left pull-right'>
				</i>
			</a> 	
			<ul class='treeview-menu'>";
			$active = NULL;
			if($arg['request']->params['controller'] == 'catalogs')	 $active = 'class="active"';	
			echo"	
				<li ".$active."> 
					<a href='".__SITE_URL."admin/catalog/catalogs/index'>
						<i class='fa fa-circle-o'>
						</i> ". __d(__CATALOG_LOCALE,'catalog_managment')."
					</a>
				</li>
			</ul>
		</li>
	";
	
}


$this->add_hook('catalogs','catalogs');

function catalogs($arg){
	
	App::uses('CatalogAppModel', 'Catalog.Model');
	App::uses('Catalog', 'Catalog.Model');
	$catalog = new Catalog();
	$catalog->recursive = - 1;
	$options['fields'] = array(
		'Catalog.id',
		'Catalog.title',
		'Catalog.file'
	);	 
	$options['conditions'] = array(
		'Catalog.status'=> 1
	);
	$options['order'] = array(
			'Catalog.arrangment'=>'asc'
	);
	//$options['limit'] = 5;
	$catalogs = $catalog->find('all',$options);
	echo "<h6 class='footer__headings'>".__d(__CATALOG_LOCALE,'catalog')."</h6>
			<div class='textwidget'>
	";
	foreach($catalogs as $catalog){
		
		echo "<a class='brochure-box' href='".__SITE_URL.__CATALOG_FILE_URL.$catalog['Catalog']['file']."' target='_blank'>
				<i class='fa  fa-file-pdf-o'></i>
				<h5 class='brochure-box__text'>".$catalog['Catalog']['title']."</h5>
			 </a>";
	}
	
	echo "</div>";		 
	
}
?>