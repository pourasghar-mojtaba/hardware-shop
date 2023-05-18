<?php

$items = array();
$controller = 'galleries';
$items['action_name'] = __d(__GALLERY_LOCALE,'gallery_list');
 
$items['url'] = __GALLERY.'/'.__GALLERY.'s';
$items['action'] = __GALLERY_PLUGIN;
$items['add_style'] =
array('link'=>array(
		'title'=>__d(__GALLERY_LOCALE,'add_gallery'),
		'url'  => __SITE_URL.'admin/gallery/'.$controller.'/add'
	)
);
$items['titles'] = array(
	array('title'=> __d(__GALLERY_LOCALE,'id'),'index'=> 'Gallery.id'),
	array('title'=> __d(__GALLERY_LOCALE,'title'),'index'=> 'Gallerytranslation.title'),
	array('title'=> __d(__GALLERY_LOCALE,'number_images')),
	array('title'=> __('status'),'index'=> 'status'),
	array('title'=> __('created'),'index'=> 'created'),
);

$records = $galleries;
 
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
		echo "<td>".$record[$items['action']]['id'];
		echo "<td>".$record['Gallerytranslation']['title'];
		echo $this->AdminHtml->createActionLink();
		echo $this->AdminHtml->actionLink(__('edit'),__SITE_URL.'admin/gallery/'.$controller.'/edit/'.$record[$items['action']]['id'],'','|');
		echo $this->AdminHtml->actionLink(__('delete'),__SITE_URL.'admin/gallery/'.$controller.'/delete/'.$record[$items['action']]['id'],'delete');
		echo $this->AdminHtml->endActionLink();
		echo"</td>";
		echo "<td>".$record['0']['imagecount']."</td>";
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

