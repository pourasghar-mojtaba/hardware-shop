<?php

App::uses('HtmlHelper', 'View/Helper');
class PaginateHelper extends HtmlHelper {
   
   function get_current_url(){
   	 $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
     $host = $_SERVER['HTTP_HOST'];
     $script = $_SERVER['REQUEST_URI'];
     $params = $_SERVER['QUERY_STRING'];
     $currentUrl = $protocol . '://' . $host . $script . '?' . $params;	
	 if(!empty($_REQUEST['page'])){
	 	$old_url = strpos($currentUrl,'&page');
	 	$currentUrl = substr($currentUrl,0,$old_url);
	 }  	 		 		
     return $currentUrl;
   }
   
  function with_hide($total_pages,$page,$limit=10,$targetpage,$targetparams=''){
   		
		//$targetpage = $this->get_current_url();
		if(!empty($targetparams)){
			$targetpage .='&'.$targetparams; 
		}
		
		$stages = 3;
		if($page){
			$start = ($page - 1) * $limit; 
		}else{
			$start = 0;	
			}		
		// Initial page num setup
		if ($page == 0){$page = 1;}
		$prev = $page - 1;	
		$next = $page + 1;							
		$lastpage = ceil($total_pages/$limit);		
		$LastPagem1 = $lastpage - 1;					
		
		
		$paginate = '';
		if($lastpage > 1)
		{	

			$paginate .= "<ul class='pagination'>";
			// Previous
			if ($page > 1){
				$paginate.= "<li><a href='$targetpage&page=$prev'><i class='fa fa-caret-right'></i></a></li>";
			}else{
				//$paginate.= "<li class='disable'><a href='javascript:void(0);'><span class='icon icon-left-circled'></span></a></li>";	
				}

			// Pages	
			if ($lastpage < 7 + ($stages * 2))	// Not enough pages to breaking it up
			{	
				for ($counter = 1; $counter <= $lastpage; $counter++)
				{
					if ($counter == $page){
						$paginate.= "<li><span class='page-numbers current'>$counter</span></li>";
					}else{
						$paginate.= "<li><a class='page-numbers' href='$targetpage&page=$counter'>$counter</a></li>";}					
				}
			}
			elseif($lastpage > 5 + ($stages * 2))	// Enough pages to hide a few&
			{
				// Beginning only hide later pages
				if($page < 1 + ($stages * 2))		
				{
					for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)
					{
						if ($counter == $page){
							$paginate.= "<li ><span class='page-numbers current'>$counter</span></li>";
						}else{
							$paginate.= "<li><a class='page-numbers' href='$targetpage&page=$counter'>$counter</a></li>";}					
					}
					$paginate.= "...";
					$paginate.= "<li><a class='page-numbers' href='$targetpage&page=$LastPagem1'>$LastPagem1</a></li>";
					$paginate.= "<li><a class='page-numbers' href='$targetpage&page=$lastpage'>$lastpage</a></li>";		
				}
				// Middle hide some front and some back
				elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2))
				{
					$paginate.= "<li><a class='page-numbers' href='$targetpage&page=1'>1</a></li>";
					$paginate.= "<li><a class='page-numbers' href='$targetpage&page=2'>2</a></li>";
					$paginate.= "...";
					for ($counter = $page - $stages; $counter <= $page + $stages; $counter++)
					{
						if ($counter == $page){
							$paginate.= "<li><span class='page-numbers current'>$counter</span></li>";
						}else{
							$paginate.= "<li><a class='page-numbers' href='$targetpage&page=$counter'>$counter</a></li>";}					
					}
					$paginate.= "...";
					$paginate.= "<li><a class='page-numbers' href='$targetpage&page=$LastPagem1'>$LastPagem1</a></li>";
					$paginate.= "<li><a class='page-numbers' href='$targetpage&page=$lastpage'>$lastpage</a></li>";		
				}
				// End only hide early pages
				else
				{
					$paginate.= "<li><a class='page-numbers' href='$targetpage&page=1'>1</a></li>";
					$paginate.= "<li><a class='page-numbers' href='$targetpage&page=2'>2</a></li>";
					$paginate.= "...";
					for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)
					{
						if ($counter == $page){
							$paginate.= "<li><span class='page-numbers current'>$counter</span></li>";
						}else{
							$paginate.= "<li><a class='page-numbers' href='$targetpage&page=$counter'>$counter</a></li>";}					
					}
				}
			}
						
					// Next
			if ($page < $counter - 1){ 
				$paginate.= "<li><a class='next page-numbers' href='$targetpage&page=$next'><i class='fa fa-caret-left'></i></a></li>";
			}else{
				//$paginate.= "<li class='disable'><a href='javascript:void(0);'><span class='icon icon-right-circled'></span></a></li>";
				}
				
			$paginate.= "</ul>";			
	}
	// echo $total_pages.' Results';
	 // pagination
	 echo $paginate;

   }
   
   function with_hide_search($total_pages,$page,$limit=10,$targetpage,$targetparams=''){
   		
		//$targetpage = $this->get_current_url();
		if(!empty($targetparams)){
			$targetpage .='&'.$targetparams; 
		}
		
		$stages = 3;
		if($page){
			$start = ($page - 1) * $limit; 
		}else{
			$start = 0;	
			}		
		// Initial page num setup
		if ($page == 0){$page = 1;}
		$prev = $page - 1;	
		$next = $page + 1;							
		$lastpage = ceil($total_pages/$limit);		
		$LastPagem1 = $lastpage - 1;					
		
		
		$paginate = '';
		if($lastpage > 1)
		{	

			$paginate .= "<ul class='pagination justify-content-center pagination-lg'>";
			// Previous
			if ($page > 1){
				$paginate.= "<li class='page-item'><a href='$targetpage&page=$prev' class='page-link'>قبل</a></li>";
			}else{
				$paginate.= "<li class='page-item disabled'><a href='javascript:void(0);' class='page-link'>قبل</a></li>";	}

			// Pages	
			if ($lastpage < 7 + ($stages * 2))	// Not enough pages to breaking it up
			{	
				for ($counter = 1; $counter <= $lastpage; $counter++)
				{
					if ($counter == $page){
						$paginate.= "<li class='page-item active'><a class='page-link' href='javascript:void(0);'>$counter</a></li>";
					}else{
						$paginate.= "<li class='page-item'><a class='page-link' href='$targetpage&page=$counter'>$counter</a></li>";}					
				}
			}
			elseif($lastpage > 5 + ($stages * 2))	// Enough pages to hide a few&
			{
				// Beginning only hide later pages
				if($page < 1 + ($stages * 2))		
				{
					for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)
					{
						if ($counter == $page){
							$paginate.= "<li class='page-item active'><a class='page-link' href='javascript:void(0);'>$counter</a></li>";
						}else{
							$paginate.= "<li class='page-item'><a class='page-link' href='$targetpage&page=$counter'>$counter</a></li>";}					
					}
					$paginate.= "<li class='page-item'><a href='javascript:void(0);' class='page-link'>...</a></li>";
					$paginate.= "<li class='page-item'><a class='page-link' href='$targetpage&page=$LastPagem1'>$LastPagem1</a></li>";
					$paginate.= "<li class='page-item'><a class='page-link' href='$targetpage&page=$lastpage'>$lastpage</a></li>";		
				}
				// Middle hide some front and some back
				elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2))
				{
					$paginate.= "<li class='page-item'><a class='page-link' href='$targetpage&page=1'>1</a></li>";
					$paginate.= "<li class='page-item'><a class='page-link' href='$targetpage&page=2'>2</a></li>";
					$paginate.= "<li class='page-item'><a href='javascript:void(0);' class='page-link'>...</a></li>";
					for ($counter = $page - $stages; $counter <= $page + $stages; $counter++)
					{
						if ($counter == $page){
							$paginate.= "<li class='page-item active'><a class='page-link' href='javascript:void(0);'>$counter</a></li>";
						}else{
							$paginate.= "<li class='page-item'><a class='page-link' href='$targetpage&page=$counter'>$counter</a></li>";}					
					}
					$paginate.= "<li class='page-item'><a href='javascript:void(0);' class='page-link'>...</a></li>";
					$paginate.= "<li class='page-item'><a class='page-link' href='$targetpage&page=$LastPagem1'>$LastPagem1</a></li>";
					$paginate.= "<li class='page-item'><a class='page-link' href='$targetpage&page=$lastpage'>$lastpage</a></li>";		
				}
				// End only hide early pages
				else
				{
					$paginate.= "<li><a class='page-link' href='$targetpage&page=1'>1</a></li>";
					$paginate.= "<li><a class='page-link' href='$targetpage&page=2'>2</a></li>";
					$paginate.= "<li class='page-item'><a href='javascript:void(0);' class='page-link'>...</a></li>";
					for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)
					{
						if ($counter == $page){
							$paginate.= "<li class='page-link' class='page-item active'><a class='page-link' href='javascript:void(0);'>$counter</a></li>";
						}else{
							$paginate.= "<li class='page-link' class='page-item'><a href='$targetpage&page=$counter'>$counter</a></li>";}					
					}
				}
			}
						
					// Next
			if ($page < $counter - 1){ 
				$paginate.= "<li class='page-item'><a class='page-link' href='$targetpage&page=$next'>بعد</a></li>";
			}else{
				$paginate.= "<li class='page-item disabled'><a class='page-link' href='javascript:void(0);'>بعد</a></li>";
				}
				
			$paginate.= "</ul>";			
	}
	// echo $total_pages.' Results';
	 // pagination
	 echo $paginate;

   }
   
}


?>