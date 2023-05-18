<?php

$items = array();
$controller = 'salesagencies';
$items['action_name'] = __('salesagencies');
$items['action'] = 'Salesagency';
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
	array('title'=> __d(__USER_LOCAL,'mobile'),'index'=> 'mobile'),
	array('title'=> __('request_file')),
	array('title'=> __('message'),'index'=> 'message'),
	array('title'=> __('created'),'index'=> 'created'),
);
$records = $salesagencies;
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
		echo "<td>";
		if($record[$items['action']]['form_type'] == 0)
		{
			echo __('obtaining_sales_representative');
		}
		else echo __('employment');
		echo"</td>";
		echo "<td>".$record[$items['action']]['email']."</td>";
		echo "<td>".$record[$items['action']]['mobile']."</td>";
		echo "<td><a href='".__SITE_URL.__SALES_AGENCY_PATH.'/'.$record[$items['action']]['file']."'>".__('download')."</td>";
		echo "<td>".$record[$items['action']]['message']."</td>";
		echo "<td>".$this->Cms->show_persian_date(" l ، j F Y    ",strtotime($record[$items['action']]['created']))."</td>";

	}
}
echo $this->element('Admin/index_footer' );
?>

