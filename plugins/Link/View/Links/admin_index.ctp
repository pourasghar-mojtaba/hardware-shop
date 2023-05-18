<?php

$items = array();
$controller = 'links';
$items['action_name'] = __d(__LINK_LOCALE,'link_list');
$items['url'] = __LINK.'/'.__LINK.'s';
$items['action'] = __LINK_PLUGIN;
$items['add_style'] =
array('link'=>array(
		'title'=>__d(__LINK_LOCALE,'add_link'),
		'url'  => __SITE_URL.'admin/link/'.$controller.'/add'
	)
);
$items['titles'] = array(
	array('title'=> __d(__LINK_LOCALE,'title'),'index'=> 'title'),
	array('title'=> __d(__LINK_LOCALE,'link'),'index'=> 'link'),
	array('title'=> __d(__LINK_LOCALE,'arrangment'),'index'=> 'arrangment'),
	array('title'=> __d(__LINK_LOCALE,'link_type'),'index'=> 'link_type'),
	array('title'=> __('status'),'index'=> 'status'),
	array('title'=> __('created'),'index'=> 'created'),
);

$records = $links;
 
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
		echo "<td>".$record['Link']['title'];
		echo $this->AdminHtml->createActionLink();
		echo $this->AdminHtml->actionLink(__('edit'),__SITE_URL.'admin/link/'.$controller.'/edit/'.$record['Link']['id'],'','|');
		echo $this->AdminHtml->actionLink(__('delete'),__SITE_URL.'admin/link/'.$controller.'/delete/'.$record['Link']['id'],'delete');
		echo $this->AdminHtml->endActionLink();
		echo"</td>";
		echo "<td>".$record['Link']['link']."</td>";
		echo "<td>".$record['Link']['arrangment']."</td>";
		echo "<td>";
		if($record['Link']['link_type'] == 0)
			echo __d(__LINK_LOCALE,'tenders');
		else if($record['Link']['link_type'] == 1)	
		    echo __d(__LINK_LOCALE,'standards');
		else echo __d(__LINK_LOCALE,'articles');
		echo"</td>";
		echo "<td>";
		if($record['Link']['status'] == 0)
		{
			echo $this->AdminHtml->status(__('inactive'),array('class'=>'label label-danger'));
		}
		else echo $this->AdminHtml->status(__('active'),array('class'=>'label label-success'));
		echo"</td>";
		echo "<td>".$this->Cms->show_persian_date(" l ، j F Y    ",strtotime($record['Link']['created']))."</td>";

	}
}
echo $this->element('Admin/index_footer' );
?>

