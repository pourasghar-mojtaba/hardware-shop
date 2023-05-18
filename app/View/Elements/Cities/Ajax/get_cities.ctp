<?php
 
	if(!empty($cities))
	{
		foreach($cities as $city){
			if($city['City']['id']==$city_id){
				echo "<option value=".$city['City']['id']." selected>".$city['City']['name']."</option>";
			}
			else echo "<option value=".$city['City']['id'].">".$city['City']['name']."</option>";
		}
	}
	else echo "<option value='0'>-------------</option>";

?>