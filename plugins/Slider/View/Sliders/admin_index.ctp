<?php

$items = array();
$controller = 'sliders';
$items['action_name'] = __d(__SLIDER_LOCALE,'slider_list');
 
$items['url'] = __SLIDER.'/'.__SLIDER.'s';
$items['action'] = __SLIDER_PLUGIN;
$items['add_style'] =
array('link'=>array(
		'title'=>__d(__SLIDER_LOCALE,'add_slider'),
		'url'  => __SITE_URL.'admin/slider/'.$controller.'/add'
	)
);
$items['titles'] = array(
	array('title'=> __d(__SLIDER_LOCALE,'title'),'index'=> 'title'),
	array('title'=> __d(__SLIDER_LOCALE,'url'),'index'=> 'url'),
	array('title'=> __d(__SLIDER_LOCALE,'arrangment'),'index'=> 'arrangment'),	
	array('title'=> __('status'),'index'=> 'status'),
	array('title'=> __('created'),'index'=> 'created'),
);

$records = $sliders;
 
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
		echo "<td>".$record['Slidertranslation']['title'];
		echo $this->AdminHtml->createActionLink();
		echo $this->AdminHtml->actionLink(__('edit'),__SITE_URL.'admin/slider/'.$controller.'/edit/'.$record['Slider']['id'],'','|');
		echo $this->AdminHtml->actionLink(__('delete'),__SITE_URL.'admin/slider/'.$controller.'/delete/'.$record['Slider']['id'],'delete');
		echo $this->AdminHtml->endActionLink();
		echo"</td>";
		echo "<td>".$record['Slidertranslation']['url']."</td>";
		echo "<td>".$record['Slider']['arrangment']."</td>";
		echo "<td>";
		if($record['Slider']['status'] == 0)
		{
			echo $this->AdminHtml->status(__('inactive'),array('class'=>'label label-danger'));
		}
		else echo $this->AdminHtml->status(__('active'),array('class'=>'label label-success'));
		echo"</td>";
		echo "<td>".$this->Cms->show_persian_date(" l ، j F Y    ",strtotime($record['Slider']['created']))."</td>";

	}
}
echo $this->element('Admin/index_footer' );
?>

