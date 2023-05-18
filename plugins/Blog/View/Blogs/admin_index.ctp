<?php

$items = array();
$controller = 'blogs';
$items['action_name'] = __d(__BLOG_LOCALE,'blog_list');
$items['url'] = __BLOG.'/'.__BLOG.'s';
$items['action'] = __BLOG_PLUGIN;
$items['add_style'] =
array('link'=>array(
		'title'=>__d(__BLOG_LOCALE,'add_blog'),
		'url'  => __SITE_URL.'admin/'.__BLOG.'/'.$controller.'/add'
	)
);
$items['titles'] = array(
	array('title'=> __d(__BLOG_LOCALE,'id'),'index'=>'id'),
	array('title'=> __d(__BLOG_LOCALE,'title'),'index'=>'title'),
	array('title'=> __d(__BLOG_LOCALE,'name'),'index'=>'User.name'),
	array('title'=> __d(__BLOG_LOCALE,'image')),
	array('title'=> __d(__BLOG_LOCALE,'num_viewed'),'index'=>'num_viewed'),
	//array('title'=> __d(__BLOG_LOCALE,'num_new_comment'),'index'=>'num_new_comment'),
	//array('title'=> __d(__BLOG_LOCALE,'num_comment'),'index'=>'num_comment'),
	array('title'=> __('status'),'index'=> 'status'),
	array('title'=> __('created'),'index'=> 'created'),
);

$records = $blogs;
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
		echo "<td>".$record['Blog']['id']."</td>";
		echo "<td>".$record['Blogtranslation']['title'];
		echo $this->AdminHtml->createActionLink();
		echo $this->AdminHtml->actionLink(__('edit'),__SITE_URL.'admin/'.__BLOG.'/'.$controller.'/edit/'.$record['Blog']['id'],'','|');
		if($record['Blog']['pinsts'] == 0)
		echo $this->AdminHtml->actionLink(__d(__BLOG_LOCALE,'pin'),__SITE_URL.'admin/'.__BLOG.'/'.$controller.'/pin/'.$record['Blog']['id'],'','|');
		else echo $this->AdminHtml->actionLink(__d(__BLOG_LOCALE,'unpin'),__SITE_URL.'admin/'.__BLOG.'/'.$controller.'/unpin/'.$record['Blog']['id'],'delete','|');
		echo $this->AdminHtml->actionLink(__('delete'),__SITE_URL.'admin/'.__BLOG.'/'.$controller.'/delete/'.$record['Blog']['id'],'delete');
		echo $this->AdminHtml->endActionLink();
		echo"</td>";
		echo "<td>".$record['User']['name']."</td>";
		echo "<td>";
		$user_image = '';
		$width      = 70;
		$height     = 70;
		$image      = $record['Blog']['image'];
		if(fileExistsInPath(__BLOG_IMAGE_PATH.$image ) && $image != '' ){
			$user_image = $this->Html->image('/'.__BLOG_IMAGE_URL.$image,array('width' =>$width,'height'=>$height,'id'=>'blog_thumb_image_'.$record['Blog']['id']));
		}
		else
		{
			$user_image = $this->Html->image('/'.__BLOG.'/new_blog.png',array('width' =>$width,'height'=>$height,'alt'   =>''));
		}
		echo $user_image;
		echo"</td>";
		echo "<td>".$record['Blog']['num_viewed']."</td>";
		/*echo "<td><a href='".__SITE_URL."admin/blog/blogcomments/index/".$record['Blog']['id']."' class='btn btn-info'>".$record['Blog']['num_new_comment']."</a></td>";
		echo "<td><a href='".__SITE_URL."admin/blog/blogcomments/index/".$record['Blog']['id']."' class='btn btn-info'>".$record['Blog']['num_comment']."</a></td>";*/
		echo "<td>";
		if($record['Blog']['status'] == 0)
		{
			echo $this->AdminHtml->status(__('inactive'),array('class'=>'label label-danger'));
		}
		else echo $this->AdminHtml->status(__('active'),array('class'=>'label label-success'));
		echo"</td>";
		echo "<td>".$this->Cms->show_persian_date(" l ، j F Y    ",strtotime($record['Blog']['created']))."</td>";

	}
}
echo $this->element('Admin/index_footer' );
?>





