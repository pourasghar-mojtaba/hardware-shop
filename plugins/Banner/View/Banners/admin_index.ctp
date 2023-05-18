<?php

$items = array();
$controller = 'banners';
$items['action_name'] = __d(__BANNER_LOCALE,'banner_list');
$items['url'] = __BANNER.'/'.__BANNER.'s';
$items['action'] = __BANNER_PLUGIN;
$items['add_style'] =
array('link'=>array(
		'title'=>__d(__BANNER_LOCALE,'add_banner'),
		'url'  => __SITE_URL.'admin/'.__BANNER.'/'.$controller.'/add'
	)
);
$items['titles'] = array(
	array('title'=> __d(__BANNER_LOCALE,'id'),'index'=>'id'),
	array('title'=> __d(__BANNER_LOCALE,'title'),'index'=>'Banner.title'),
	array('title'=> __d(__BANNER_LOCALE,'name'),'index'=>'User.name'),
	array('title'=> __d(__BANNER_LOCALE,'image')),
	array('title'=> __('status'),'index'=> 'status'),
	array('title'=> __('created'),'index'=> 'created'),
);

$records = $banners;
$items['show_search_box'] = TRUE;
echo $this->element('Admin/index_header', array('items'=>$items) );
if(!empty($records)){

	foreach($records as $record){
		echo "
		<tr>
		<td>
		<input type='checkbox' >
		</td>
		";
		echo "<td>".$record['Banner']['id']."</td>";
		echo "<td>".$record['Bannertranslation']['title'];
		echo $this->AdminHtml->createActionLink();
		echo $this->AdminHtml->actionLink(__('edit'),__SITE_URL.'admin/'.__BANNER.'/'.$controller.'/edit/'.$record['Banner']['id'],'','|');
		echo $this->AdminHtml->actionLink(__('delete'),__SITE_URL.'admin/'.__BANNER.'/'.$controller.'/delete/'.$record['Banner']['id'],'delete');
		echo $this->AdminHtml->endActionLink();
		echo"</td>";
		echo "<td>".$record['User']['name']."</td>";
		echo "<td>";
		$user_image = '';
		$width      = 70;
		$height     = 70;
		$image      = $record['Bannertranslation']['image'];
		if(fileExistsInPath(__BANNER_IMAGE_PATH.$image ) && $image != '' ){
			$user_image = $this->Html->image('/'.__BANNER_IMAGE_URL.$image,array('width' =>$width,'height'=>$height,'id'=>'banner_thumb_image_'.$record['Banner']['id']));
		}
		else
		{
			$user_image = $this->Html->image('/'.__BANNER.'/new_banner.png',array('width' =>$width,'height'=>$height,'alt'   =>''));
		}
		echo $user_image;
		echo"</td>";
		echo "<td>";
		if($record['Banner']['status'] == 0)
		{
			echo $this->AdminHtml->status(__('inactive'),array('class'=>'label label-danger'));
		}
		else echo $this->AdminHtml->status(__('active'),array('class'=>'label label-success'));
		echo"</td>";
		echo "<td>".$this->Cms->show_persian_date(" l ، j F Y    ",strtotime($record['Banner']['created']))."</td>";

	}
}
echo $this->element('Admin/index_footer' );
?>





