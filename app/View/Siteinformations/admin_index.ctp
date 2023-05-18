<?php

$items = array();
$controller = 'siteinformations';
$items['action_name'] = __('siteinformations');
$items['action'] = 'Siteinformation';
 
$items['titles'] = array(
	array('title'=> __('referer_url'),'index'=> 'referer_url'),
	array('title'=> __('referer_host'),'index'=> 'referer_host'),
	array('title'=> __('browser'),'index'=> 'browser'),
	array('title'=> __('ip'),'index'=> 'ip'),
	array('title'=> __('request_uri'),'index'=> 'request_uri'),
	array('title'=> __('created'),'index'=> 'created'),
);
$records = $siteinformations;
$items['show_search_box'] = true;
echo $this->element('Admin/index_header', array('items'=>$items) );
if(!empty($records)){

	foreach($records as $record){
		echo "
		<tr>
		<td>
		<input type='checkbox' >
		</td>
		";
		echo "<td>".$record[$items['action']]['referer_url']."</td>";
		echo "<td>".$record[$items['action']]['referer_host']."</td>";
		echo "<td>".$record[$items['action']]['browser']."</td>";
		echo "<td>".$record[$items['action']]['ip']."</td>";
		echo "<td>".$record[$items['action']]['request_uri']."</td>";
		echo "<td>".$this->Cms->show_persian_date(" l ، j F Y   H:s ",strtotime($record[$items['action']]['created']))."</td>";

	}
}
echo $this->element('Admin/index_footer' );
?>

