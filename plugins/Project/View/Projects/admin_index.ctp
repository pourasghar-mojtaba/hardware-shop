<?php

$items = array();
$controller = 'projects';
$items['action_name'] = __d(__PROJECT_LOCALE,'project_list');
 
$items['url'] = __PROJECT.'/'.__PROJECT.'s';
$items['action'] = __PROJECT_PLUGIN;
$items['add_style'] =
array('link'=>array(
		'title'=>__d(__PROJECT_LOCALE,'add_project'),
		'url'  => __SITE_URL.'admin/project/'.$controller.'/add'
	)
);
$items['titles'] = array(
	array('title'=> __d(__PROJECT_LOCALE,'title'),'index'=> 'title'),
	array('title'=> __d(__PROJECT_LOCALE,'category'),'index'=> 'title','action'=>'Projectcategory'),
	array('title'=> __d(__PROJECT_LOCALE,'detail'),'index'=> 'detail'),
	array('title'=> __('status'),'index'=> 'status'),
	array('title'=> __('created'),'index'=> 'created'),
);

$records = $projects;
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
		echo "<td>".$record[$items['action']]['title'];
		echo $this->AdminHtml->createActionLink();
		echo $this->AdminHtml->actionLink(__('edit'),__SITE_URL.'admin/project/'.$controller.'/edit/'.$record[$items['action']]['id'],'','|');
		echo $this->AdminHtml->actionLink(__('delete'),__SITE_URL.'admin/project/'.$controller.'/delete/'.$record[$items['action']]['id'],'delete');
		echo $this->AdminHtml->endActionLink();
		echo"</td>";
		echo "<td>".$record['Projectcategory']['title']."</td>";
		echo "<td>".$record[$items['action']]['mini_detail']."</td>";
		echo "<td>";
		if($record[$items['action']]['status'] == 0)
		{
			echo $this->AdminHtml->status(__('inactive'),array('class'=>'label label-danger'));
		}
		else echo $this->AdminHtml->status(__('active'),array('class'=>'label label-success'));
		echo"</td>";
		echo "<td>".$this->Cms->show_persian_date(" l ، j F Y    ",strtotime($record[$items['action']]['created']))."</td>";

	}
}
echo $this->element('Admin/index_footer' );
?>

