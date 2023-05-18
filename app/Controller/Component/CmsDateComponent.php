<?php
App::uses('Component', 'Controller');

class CmsDateComponent extends Component {
	
/**
* 
* @param undefined $date1
* @param undefined $date2
* 
*/
public function diffdate($date1,$date2)
{
	 $date1 = strtotime($date1);
     $date2 = strtotime($date2);
     $datediff = $date2 - $date1;
     return floor($datediff/(60*60*24));
}
/**
* 
* @param undefined $date
* @param undefined $day
* 
*/
public function addday($date,$day)
{
	 $date = strtotime($date);
     $date = strtotime("+".$day." day",$date);
     return date('Y-M-d h:i:s',$date);
}

public function adddayWithoutTime($date,$day)
{
	 $date = strtotime($date);
     $date = strtotime("+".$day." day",$date);
     return date('Y-m-d',$date);
}
/**
* 
* @param undefined $date
* @param undefined $day
* 
*/
public function subday($date,$day)
{
	 $date = strtotime($date);
     $date = strtotime("-".$day." day",$date);
     return date('Y-M-d h:i:s',$date);
}

public function subdayWithoutTime($date,$day)
{
	 $date = strtotime($date);
     $date = strtotime("-".$day." day",$date);
     return date('Y-m-d',$date);
}
/**
* 
* @param undefined $date
* @param undefined $month
* 
*/
public function addmonth($date,$month)
{
	 $date = strtotime($date);
     $date = strtotime("+".$month." month",$date);
     return date('Y-M-d h:i:s',$date);
}

/**
* 
* @param undefined $date
* @param undefined $month
* 
*/
public function submonth($date,$month)
{
	 $date = strtotime($date);
     $date = strtotime("-".$month." month",$date);
     return date('Y-M-d h:i:s',$date);
}
}
?>