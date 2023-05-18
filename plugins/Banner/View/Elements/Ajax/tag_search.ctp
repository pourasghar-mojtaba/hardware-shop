<?php
 //print_r($search_result);


 if ($search_result)
{
	$x = 0;
	foreach($search_result as $value)
	{		
		$friends[$x] = array("name" => $value['Blogtag']["title"],"id" => $value['Blogtag']["id"],'image'=>'');
		$x++;	
	}
	
	$response = $_GET["callback"] . "(" . json_encode($friends) . ")";
	
	echo $response;
}




?>

 