<?php
 //print_r($search_result);


 if ($search_result)
{
	$x = 0;
	foreach($search_result as $value)
	{		
		$friends[$x] = array("name" => $value['Producttag']["title"],"id" => $value['Producttag']["id"],'image'=>'');
		$x++;	
	}
	
	$response = $_GET["callback"] . "(" . json_encode($friends) . ")";
	
	echo $response;
}




?>

 