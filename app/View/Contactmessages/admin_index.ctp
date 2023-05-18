<?php

$items = array();
$controller = 'contactmessages';
$items['action_name'] = __('contactmessages');
$items['action'] = 'Contactmessage';
/*$items['add_style'] =
array('link'=>array(
		'title'=>__('add_role'),
		'url'  => __SITE_URL.'admin/'.$controller.'/add'
	)
);*/
$items['titles'] = array(
	array('title'=> __('name'),'index'=> 'name'),
	array('title'=> __('subject'),'index'=> 'subject'),
	array('title'=> __('email'),'index'=> 'email'),
	array('title'=> __('message'),'index'=> 'message'),
	array('title'=> __('created'),'index'=> 'created'),
);
$records = $contactmessages;
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
		echo $this->AdminHtml->actionLink(__('delete'),__SITE_URL.'admin/'.$controller.'/delete/'.$record[$items['action']]['id'],'delete' );
		echo $this->AdminHtml->endActionLink();
		echo"</td>";
		echo "<td>".$record[$items['action']]['subject']."</td>";
		echo "<td>".$record[$items['action']]['email']."</td>";
		echo "<td>".$record[$items['action']]['message']."</td>";
		echo "<td>".$this->Cms->show_persian_date(" l ، j F Y    ",strtotime($record[$items['action']]['created']))."</td>";

	}
}
echo $this->element('Admin/index_footer' );
?>

