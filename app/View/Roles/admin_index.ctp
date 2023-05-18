<?php

$items = array();
$controller = 'roles';
$items['action_name'] = __('roles');
$items['action'] = 'Role';
$items['add_style'] =
array('link'=>array(
		'title'=>__('add_role'),
		'url'  => __SITE_URL.'admin/'.$controller.'/add'
	)
);
$items['titles'] = array(
	array('title'=> __('role'),'index'=> 'name'),
	array('title'=> __('status'),'index'=> 'status'),
	array('title'=> __('created'),'index'=> 'created'),
);
$records = $roles;
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
		echo "<td>".$record[$items['action']]['name'];
		echo $this->AdminHtml->createActionLink();
		echo $this->AdminHtml->actionLink(__('edit'),__SITE_URL.'admin/'.$controller.'/edit/'.$record[$items['action']]['id'],'','|');
		echo $this->AdminHtml->actionLink(__('delete'),__SITE_URL.'admin/'.$controller.'/delete/'.$record[$items['action']]['id'],'delete','|');
		echo $this->AdminHtml->actionLink(__('permission'),__SITE_URL."admin/aclitems/index?role_id=".$record[$items['action']]['id'],'permission');
		echo $this->AdminHtml->endActionLink();
		echo"</td>";
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

