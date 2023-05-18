<?php

$items = array();
$controller = 'projectcategories';
$items['action_name'] = __d(__PROJECT_LOCALE,'category_list');
 
$items['url'] = 'project/projectcategories';
$items['action'] = 'Projectcategory';
$items['add_style'] =
array('link'=>array(
		'title'=>__d(__PROJECT_LOCALE,'add_category'),
		'url'  => __SITE_URL.'admin/project/'.$controller.'/add'
	)
);
$items['titles'] = array(
	array('title'=> __d(__PROJECT_LOCALE,'title')),
	array('title'=> __d(__PROJECT_LOCALE,'slug')),
	array('title'=> __d(__PROJECT_LOCALE,'arrangment')),
	array('title'=> __('status'),'index'=> 'status'),
	array('title'=> __('created'),'index'=> 'created'),
);

$records = $projectcategories;
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
		echo "<td>".$record['title'];
		echo $this->AdminHtml->createActionLink();
		echo $this->AdminHtml->actionLink(__('edit'),__SITE_URL.'admin/project/'.$controller.'/edit/'.$record['id'],'','|');
		echo $this->AdminHtml->actionLink(__('delete'),__SITE_URL.'admin/project/'.$controller.'/delete/'.$record['id'],'delete');
		echo $this->AdminHtml->endActionLink();
		echo"</td>";
		echo "<td>".$record['slug']."</td>";
		echo "<td>".$record['arrangment']."</td>";
		echo "<td>";
		if($record['status'] == 0)
		{
			echo $this->AdminHtml->status(__('inactive'),array('class'=>'label label-danger'));
		}
		else echo $this->AdminHtml->status(__('active'),array('class'=>'label label-success'));
		echo"</td>";
		echo "<td>".$this->Cms->show_persian_date(" l ، j F Y    ",strtotime($record['created']))."</td>";

	}
}
echo $this->element('Admin/index_footer' );
?>

