<?php

$items = array();
$controller = 'catalogs';
$items['action_name'] = __d(__CATALOG_LOCALE,'catalog_list');
$items['url'] = __CATALOG.'/'.__CATALOG.'s';
$items['action'] = __CATALOG_PLUGIN;
$items['add_style'] =
array('link'=>array(
		'title'=>__d(__CATALOG_LOCALE,'add_catalog'),
		'url'  => __SITE_URL.'admin/catalog/'.$controller.'/add'
	)
);
$items['titles'] = array(
	array('title'=> __d(__CATALOG_LOCALE,'title'),'index'=> 'title'),
	array('title'=> __d(__CATALOG_LOCALE,'file'),'index'=> 'file'),
	array('title'=> __d(__CATALOG_LOCALE,'arrangment'),'index'=> 'arrangment'),	
	array('title'=> __('status'),'index'=> 'status'),
	
	array('title'=> __('created'),'index'=> 'created'),
);

$records = $catalogs;
 
$items['show_search_box'] = FALSE;
echo $this->element('Admin/index_header', array('items'=>$items) );
if(!empty($records)){

	foreach($records as $record){
		echo "
		<tr>
		<td>
		<input type='checkbox' >
		</td>
		";
		echo "<td>".$record['Catalog']['title'];
		echo $this->AdminHtml->createActionLink();
		echo $this->AdminHtml->actionLink(__('edit'),__SITE_URL.'admin/catalog/'.$controller.'/edit/'.$record['Catalog']['id'],'','|');
		echo $this->AdminHtml->actionLink(__('delete'),__SITE_URL.'admin/catalog/'.$controller.'/delete/'.$record['Catalog']['id'],'delete');
		echo $this->AdminHtml->endActionLink();
		echo"</td>";
		$file = $record['Catalog']['file']; 
		 	
		echo "<td>"."<a href='".__SITE_URL.__CATALOG_FILE_URL.$file."' target='_blank'>".__d(__CATALOG_LOCALE,'file')."</a>"."</td>";
		echo "<td>".$record['Catalog']['arrangment']."</td>";
		echo "<td>";
		if($record['Catalog']['status'] == 0)
		{
			echo $this->AdminHtml->status(__('inactive'),array('class'=>'label label-danger'));
		}
		else echo $this->AdminHtml->status(__('active'),array('class'=>'label label-success'));
		echo"</td>";
		echo "<td>".$this->Cms->show_persian_date(" l ، j F Y    ",strtotime($record['Catalog']['created']))."</td>";

	}
}
echo $this->element('Admin/index_footer' );
?>

