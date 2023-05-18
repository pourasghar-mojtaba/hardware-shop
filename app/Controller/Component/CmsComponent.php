<?php
App::uses('Component', 'Controller');
class CmsComponent extends Component
{

	/**
	* create random char
	* @param undefined $length
	*
	*/
	public
	function random_char($length = 8)
	{
		$char = '';
		for($i = 0; $i < $length; $i++)
		{
			switch(rand(0,2))
			{
				case 0:
				$char .= rand(0,9);
				break;
				case 1:
				$char .= chr(rand(65,90));
				break;
				default:

				$char .= chr(rand(97,122));
			}
		}
		return $char;
	}

	public
	function random_number($length = 4)
	{
		$char = '';
		for($i = 0; $i < $length; $i++){
			switch(rand(0,2)){
				case 0:
				$char .= rand(0,9);
				break;
				case 1:
				$char .= rand(0,9);
				break;
				default:

				$char .= rand(0,9);
			}
		}
		return $char;
	}
	/*public function get_tag($text,$seprator)
	{
	$startpos = strpos($text, $seprator,0);
	$keyword_arr=array();
	$instartpos=0;
	while($startpos !== false){
	$instartpos = strpos($text, $seprator,$startpos+1);
	if($instartpos !== false){
	$keyword= substr($text,$startpos+1,($instartpos-$startpos)-1);
	if(strlen($keyword)>0){
	$startpos=$instartpos;
	//$keyword_arr[]= trim(str_replace(' ','',$keyword));
	$keyword_arr[]= trim($keyword);
	}
	}

	$startpos = strpos($text, $seprator,$startpos+1);

	}
	return $keyword_arr;
	}*/
	/**
	*
	* @param undefined $text
	* @param undefined $seprator
	*
	*/
	public
	function get_tag($text,$seprator = '#')
	{
		//preg_match_all(' / '.$seprator.'([\p{L}\p{Mn}] + ) / u',$text,$matches) ;
		//preg_match_all(' / (?!\b)(#\w + \b) / ',$string,$matches);
		preg_match_all('/(?!\b)('.$seprator.'\w+\b)/u',$text,$matches);
		foreach($matches[1] as $key=>$tag){
			$tags[$key] = str_replace($seprator,'',$tag);
		}
		return $tags;
	}

	/**
	*
	* @param undefined $text
	* @param undefined $seprator
	*
	*/
	public
	function get_username_tag($text,$seprator = '@')
	{

		$keyword = array();
		if(isset($text))
		{
			preg_match_all('/'.$seprator.'([\p{L}\p{Mn}\_0-9A-z]+)/u',$text,$matches) ;

			if(!empty($matches))
			{
				foreach($matches[1] as $tag){
					if(preg_match('/^[a-z][a-z\d\_]{2,62}[a-z\d]$/i',$tag)){
						$keyword[] = $tag;
					}
				}
			}
		}



		return $keyword;
	}

	function makefilelist($folder, $filter, $sort = true, $type = "files", $ext_filter = "")
	{
		$res = array();
		$filter = explode("|", $filter);
		if($type == "files" && !empty($ext_filter)){
			$ext_filter = explode("|", strtolower($ext_filter));
		}
		$temp = opendir($folder);
		while($file = readdir($temp)){
			if($type == "files" && !in_array($file, $filter)){
				if(!empty($ext_filter)){
					if(!in_array(substr(strtolower(stristr($file, '.')), + 1), $ext_filter) && !is_dir($folder.$file)){
						$res[] = $file;
					}
				}
				else
				{
					if(!is_dir($folder.$file)){
						$res[] = $file;
					}
				}
			}
			elseif($type == "folders" && !in_array($file, $filter)){
				if(is_dir($folder.$file)){
					$res[] = $file;
				}
			}
		}
		closedir($temp);
		if($sort){
			sort($res);
		}
		return $res;
	}

	function getDateFormat($date)
	{
		return substr($date, 0, 4) . '/' . substr($date, 4, 2) . '/' . substr($date, 6, 2);
	}

	function convertPersianToEnglish($string)
	{
		$persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
		$english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

		$output = str_replace($persian, $english, $string);
		return $output;
	}
}
?>
