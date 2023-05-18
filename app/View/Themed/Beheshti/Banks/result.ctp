<?php

	echo $this->Html->css('/getway/css/getway');
	$Pay_Info= $this->Session->read('Pay_Info');
	$User_Info= $this->Session->read('User_Info');
	//print_r($Pay_Info);
	
	echo $this->Html->css('setting_'.$locale);
	

	
?>

 

 