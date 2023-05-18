<?php

$items = array();
$controller = 'companies';
$items['action_name'] = __d(__COMPANY_LOCALE,'company_list');
$items['url'] = 'company/companies';
$items['action'] = __COMPANY_PLUGIN;
$items['add_style'] =
array('link'=>array(
		'title'=>__d(__COMPANY_LOCALE,'add_company'),
		'url'  => __SITE_URL.'admin/company/'.$controller.'/add'
	)
);
$items['titles'] = array(
	array('title'=> __d(__COMPANY_LOCALE,'title')),
	array('title'=> __d(__COMPANY_LOCALE,'url')),
	array('title'=> __d(__COMPANY_LOCALE,'arrangment')),
	array('title'=> __('status'),'index'=> 'status'),
	array('title'=> __('created'),'index'=> 'created'),
);

$records = $companies;

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
		echo "<td>".$record['Companytranslation']['title'];
		echo $this->AdminHtml->createActionLink();
		echo $this->AdminHtml->actionLink(__('edit'),__SITE_URL.'admin/company/'.$controller.'/edit/'.$record['Company']['id'],'','|');
		echo $this->AdminHtml->actionLink(__('delete'),__SITE_URL.'admin/company/'.$controller.'/delete/'.$record['Company']['id'],'delete');
		echo $this->AdminHtml->endActionLink();
		echo"</td>";
		echo "<td><a href='".$record['Company']['url']."' target='_blank'>".$record['Company']['url']."</a></td>";
		echo "<td>".$record['Company']['arrangment']."</td>";
		echo "<td>";
		if($record['Company']['status'] == 0)
		{
			echo $this->AdminHtml->status(__('inactive'),array('class'=>'label label-danger'));
		}
		else echo $this->AdminHtml->status(__('active'),array('class'=>'label label-success'));
		echo"</td>";
		echo "<td>".$this->Cms->show_persian_date(" l ، j F Y    ",strtotime($record['Company']['created']))."</td>";

	}
}
echo $this->element('Admin/index_footer' );
?>

