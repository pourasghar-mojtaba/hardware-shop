<?php

$items = array();
$controller = 'users';
$items['action_name'] = __('users');
$items['action'] = 'User';
$items['add_style'] =
array('link'=>array(
		'title'=>__('add_user'),
		'url'  => __SITE_URL.'admin/'.$controller.'/add'
	)
);
$items['titles'] = array(
	array('title'=> __('name'),'index'=> 'name'),
	array('title'=> __('user_name'),'index'=> 'user_name'),
	array('title' => __('role'),'index' => 'name','action'=>'Role'),
	array('title'=> __('email'),'index'=> 'email'),
	array('title'=> __('status'),'index'=> 'status'),
	array('title'=> __('created'),'index'=> 'created'),
);
$items['show_search_box'] = FALSE;
echo $this->element('Admin/index_header', array('items'=>$items) );
$records = $users;


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
		echo $this->AdminHtml->actionLink(__('delete'),__SITE_URL.'admin/'.$controller.'/delete/'.$record[$items['action']]['id'],'delete');
		echo $this->AdminHtml->endActionLink();
		echo"</td>";
		echo "<td>".$record[$items['action']]['user_name']."</td>";
		echo "<td>".$record['Role']['name']."</td>";
		echo "<td>".$record[$items['action']]['email']."</td>";
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

