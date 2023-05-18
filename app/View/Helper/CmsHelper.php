<?php

class CmsHelper extends AppHelper
{

	public $helpers = array('Html','Session');
	/**
	*
	* @param undefined $content
	*
	*/
	public
	function filter_editor($content)
	{
		$content = str_replace("&lt;", "<", $content);
		$content = str_replace("&gt;", ">", $content);
		$content = str_replace("&amp;", "&", $content);
		$content = str_replace("&nbsp;", " ", $content);
		$content = str_replace("&quot;", "\"", $content);
		$content = str_replace("\\n", "<br>", $content);
		//$content = $this->convert_tag_to_link($content);
		// $content = $this->convert_username_to_link($content);
		//$content = $this->gifbb2html($content);
		return $content;
	}

	public
	function convert_character_editor($content)
	{
		$content = str_replace("&lt;", "<", $content);
		$content = str_replace("&gt;", ">", $content);
		$content = str_replace("&amp;", "&", $content);
		$content = str_replace("&nbsp;", " ", $content);
		$content = str_replace("&quot;", "\"", $content);
		$content = str_replace("\\n", "", $content);
		return $content;
	}

	/**
	*
	* @param undefined $formats
	* @param undefined $time
	*
	*/
	public
	function show_persian_date($format = "Y/m/d - H:i",$time = 1)
	{
		App::import('Vendor', 'jdf');
		$timezone = 0;//برای 3:30 عدد 12600 و برای 4:30 عدد 16200 را تنظیم کنید
		$now      = date("Y-m-d", $time + $timezone);
		$time     = date("H:i:s", $time + $timezone);
		list($year, $month, $day) = explode('-', $now);
		list($hour, $minute, $second) = explode(':', $time);
		$timestamp   = mktime($hour, $minute, $second, $month, $day, $year);
		$jalali_date = jdate($format,$timestamp);
		return $jalali_date;
	}

	public
	function show_format_persian_date($format = "Y/m/d",$created)
	{
		App::import('Vendor', 'jdf');
		$jalali_date = jdate($format, $created);
		return $jalali_date;
	}
	/**
	*
	*
	*/
	public
	function get_current_persian_date()
	{
		App::import('Vendor', 'jdate');
		$date = new jdate();
		return $date->show_date("l d F Y " , time());
		//return jdate("l d F Y ",$time);
	}
	public
	function get_current_date($format)
	{
		App::import('Vendor', 'jdate');
		$date = new jdate();
		return $date->show_date($format , time());
		//return jdate("l d F Y ",$time);
	}

	/**
	*
	* @param undefined $text
	* @param undefined $seprator
	*
	*/
	public
	function get_tag($text,$seprator = '#')
	{
		preg_match_all('/(?!\b)('.$seprator.'\w+\b)/u',$text,$matches);
		return $matches[1];
	}

	public
	function get_username_tag($text,$seprator = '@')
	{

		$keyword = array();
		if(isset($text)){
			preg_match_all('/'.$seprator.'([\p{L}\p{Mn}\_0-9A-z]+)/u',$text,$matches) ;

			if(!empty($matches)){
				foreach($matches[1] as $tag)
				{
					if(preg_match('/^[a-z][a-z\d\_]{2,62}[a-z\d]$/i',$tag))
					{
						$keyword[] = $tag;
					}
				}
			}
		}
		return $keyword;
	}

	/**
	*
	* @param undefined $text
	*
	*/
	public
	function convert_tag_to_link($text)
	{
		$tags = $this->get_tag($text,'#');
		// print_r($tags);
		if(isset($tags) && !empty($tags)){
			foreach($tags as $tag)
			{
				$taglink = str_replace('#','',$tag);
				$text    = str_replace($tag,"<a href='".__SITE_URL."posts/tags/".$taglink."'>".$tag."</a>", $text);

			}
		}
		return $text;
	}
	/**
	*
	* @param undefined $text
	*
	*/
	public
	function convert_username_to_link($text)
	{
		$tags = $this->get_username_tag($text);

		if(isset($tags) && !empty($tags)){
			foreach($tags as $tag)
			{
				$text = str_replace('@'.$tag,"@<a href='".__SITE_URL.$tag."'>".$tag."</a>", $text);
			}
		}
		return $text;
	}

	/**
	*
	* @param undefined $url
	*
	*/
	public
	function filter_url($url)
	{
		$new_url = parse_url($url, PHP_URL_HOST);
		if(strlen($url) > strlen($new_url) + 10){
			$new_url .= '/... ';
		}
		return $new_url;
	}

	function farsidigit($in_num)
	{
		$in_num = str_replace('0' , '٠' , $in_num);
		$in_num = str_replace('1' , '١' , $in_num);
		$in_num = str_replace('2' , '٢' , $in_num);
		$in_num = str_replace('3' , '٣' , $in_num);
		$in_num = str_replace('4' , '۴' , $in_num);
		$in_num = str_replace('5' , '۵' , $in_num);
		$in_num = str_replace('6' , '۶' , $in_num);
		$in_num = str_replace('7' , '٧' , $in_num);
		$in_num = str_replace('8' , '٨' , $in_num);
		$in_num = str_replace('9' , '٩' , $in_num);
		return $in_num;
	}

	public
	function change_to_validnum($number)
	{
		$number = Trim($number);

		if(substr($number,0, 3) == '%2B')
		{
			$ret    = substr($number,0, 3);
			$number = str_replace($ret,'0',$number);
			return $number;
		}

		if(substr($number,0, 3) == '%2b')
		{
			$ret    = substr($number,0, 3);
			$number = str_replace($ret,'0',$number);
			return $number;
		}

		if(substr($number,0, 4) == '0098')
		{
			$ret    = substr($number,0, 4);
			$number = str_replace($ret,'0',$number);
			return $number;
		}

		if(substr($number,0, 3) == '098')
		{
			$ret    = substr($number,0, 3);
			$number = str_replace($ret,'0',$number);
			return $number;
		}


		if(substr($number,0, 3) == '+98')
		{
			$ret    = substr($number,0, 3);
			$number = str_replace($ret,'0',$number);
			return $number;
		}

		if(substr($number,0, 2) == '98')
		{
			$ret    = substr($number,0, 2);
			$number = str_replace($ret,'0',$number);
			return $number;
		}

		if(substr($number,0, 1) == '0')
		{
			$ret    = substr($number,0, 1);
			$number = str_replace($ret,'0',$number);
			return $number;
		}

		return $number;
	}


	/**
	*
	* @param undefined $text
	*
	*/
	function bb2html($text)
	{
		$bbcode = array(
			":angel:",
			":@",
			":D",
			":blush:",
			":s",
			":cool:",
			":dodgy:",
			":exclamation:",
			":heart:",
			":huh:",
			":idea:",
			":rolleyes:",
			":(",
			":shy:",
			":sleepy:",
			":)",
			":P",
			":-/",
			";)",
			"<",">",
			"[list]","[*]","[/list]",
			"[img]","[/img]",
			"[b]","[/b]",
			"[u]","[/u]",
			"[i]","[/i]",
			'[color="',"[/color]",
			"[size=\"","[/size]",
			'[url="',"[/url]",
			"[mail=\"","[/mail]",
			"[code]","[/code]",
			"[quote]","[/quote]",
			'"]'
		);
		$htmlcode = array(

			"<img src='".__SITE_URL."/img/icons/smilies/angel.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/angry.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/biggrin.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/blush.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/confused.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/cool.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/dodgy.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/exclamation.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/heart.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/huh.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/lightbulb.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/rolleyes.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/sad.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/shy.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/sleepy.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/smile.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/tongue.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/undecided.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/wink.gif'  />",
			"&lt;","&gt;",
			"<ul>","<li>","</ul>",
			"<img src=\"","\">",
			"<b>","</b>",
			"<u>","</u>",
			"<i>","</i>",
			"<span style=\"color:","</span>",
			"<span style=\"font-size:","</span>",
			'<a href="',"</a>",
			"<a href=\"mailto:","</a>",
			"<code>","</code>",
			"<table width=100% bgcolor=lightgray><tr><td bgcolor=white>","</td></tr></table>",
			'">'
		);
		$newtext = str_replace($bbcode, $htmlcode, $text);
		$newtext = nl2br($newtext);//second pass
		$content = str_replace("&lt;", "<", $newtext);
		$content = str_replace("&gt;", ">", $content);
		return $content;
	}

	function gifbb2html($text)
	{
		$bbcode = array(
			":)",
			":(",
			";)",
			":D",
			";;)",
			">:D<",
			":-/",
			":x",
			':">',
			":P",
			":-*",
			"=((",
			":-O",
			"X(",
			":>",
			"B-)",
			":-S",
			"#:-S",
			">:)",
			":((",
			":))",
			":|",
			"/:)",
			"=))",
			"O:-)",
			":-B",
			"=;",
			":-c",
			":)]",
			"~X(",
			":-h",
			":-t",
			"8->",
			"I-)",
			"8-|",
			"L-)",
			":-&",
			":-$",
			"[-(",
			":O)",
			"8-}",
			"<:-P",
			"(:|",
			"=P~",
			":-?",
			"#-o",
			"=D>",
			":-SS",
			"@-)",
			":^o",
			":-w",
			":-<",
			">:P",
			"<):)",
			"X_X",
			":!!",
			"\m/",
			":-q",
			":-bd",
			"^#(^",
			":ar!"


		);
		$htmlcode = array(
			"<img src='".__SITE_URL."/img/icons/smilies/1.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/2.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/3.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/4.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/5.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/6.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/7.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/8.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/9.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/10.gif'  />",

			"<img src='".__SITE_URL."/img/icons/smilies/11.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/12.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/13.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/14.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/15.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/16.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/17.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/18.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/19.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/20.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/21.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/22.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/23.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/24.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/25.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/26.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/27.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/28.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/29.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/30.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/31.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/32.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/33.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/34.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/35.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/36.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/37.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/38.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/39.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/40.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/41.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/42.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/43.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/44.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/45.gif'  />",

			"<img src='".__SITE_URL."/img/icons/smilies/46.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/47.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/48.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/100.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/101.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/102.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/103.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/104.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/105.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/109.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/110.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/111.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/112.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/113.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/114.gif'  />",
			"<img src='".__SITE_URL."/img/icons/smilies/pirate_2.gif'  />"
		);
		$newtext = str_replace($bbcode, $htmlcode, $text);
		$newtext = nl2br($newtext);//second pass
		$content = str_replace("&lt;", "<", $newtext);
		$content = str_replace("&gt;", ">", $content);
		return $content;
	}




	/**
	*
	* @param undefined $inputFile
	* @param undefined $outputFile
	*
	*/
	function autoCompileLess($inputFile, $outputFile)
	{

		App::import('Vendor', 'less/lessc');

		// load the cache
		$cacheFile = $inputFile.".cache";

		if(file_exists($cacheFile)){
			$cache = unserialize(file_get_contents($cacheFile));
		}
		else
		{
			$cache = $inputFile;
		}

		$less     = new lessc;
		$less->setFormatter("compressed");
		$newCache = $less->cachedCompile($cache);

		if(!is_array($cache) || $newCache["updated"] > $cache["updated"]){
			file_put_contents($cacheFile, serialize($newCache));
			file_put_contents($outputFile, $newCache['compiled']);
		}

	}


	public
	function user_image($image,$alt = '',$id = 'image_img',$height = 160,$width = 160,$class = '')
	{
		$user_image = '';
		if(fileExistsInPath(__USER_IMAGE_PATH.$image ) && $image != '' )
		{
			$user_image = $this->Html->image('/'.__USER_IMAGE_PATH.__UPLOAD_THUMB.'/'.$image,array('width' =>$width,'height'=>$height,'alt'   =>$alt,'id'    =>$id,'class' =>$class));
		}
		else
		{
			$user_image = $this->Html->image('user-96x96.png',array('width' =>$width,'height'=>$height,'alt'   =>$alt,'id'    =>$id,'class' =>$class));
		}

		return $user_image;
	}


	public
	function get_size_files($files)
	{
		$size = 0;
		if(!empty($files)){
			foreach($files as $file){
				if($file['Ufile']['use_file'] == 0){
					$size += @filesize(__PRODUCT_FILE_PREVIEW_PATH.$file['Ufile']['file']);
				}
				else $size += @filesize(__PRODUCT_FILE_DOWNLOAD_PATH.$file['Ufile']['file']);
			}
		}
		$textsize = $this->formatSizeUnits($size);
		return array('size'    =>$size,'textsize'=>$textsize);
	}

	public
	function create_file_link($id = null,$use_file = null,$file)
	{
		switch($use_file){
			case 0:
			return __SITE_URL.__PRODUCT_FILE_PREVIEW_PATH.$file;
			break;
			case 1 :
			return __SITE_URL.'products/download/'.md5($id);
			break;
			case 2 :
			return __PRODUCT_FILE_DOWNLOAD_PATH.$file;
			break;
		}

	}

	public
	function formatSizeUnits($bytes)
	{
		if($bytes >= 1073741824)
		{
			$bytes = number_format($bytes / 1073741824, 2) . ' GB';
		}
		elseif($bytes >= 1048576)
		{
			$bytes = number_format($bytes / 1048576, 2) . ' MB';
		}
		elseif($bytes >= 1024)
		{
			$bytes = number_format($bytes / 1024, 2) . ' KB';
		}
		elseif($bytes > 1)
		{
			$bytes = $bytes . ' bytes';
		}
		elseif($bytes == 1)
		{
			$bytes = $bytes . ' byte';
		}
		else
		{
			$bytes = '0 bytes';
		}

		return $bytes;
	}



	public
	function toByteSize($p_sFormatted)
	{
		$aUnits = array('B' =>0,'KB'=>1,'MB'=>2,'GB'=>3,'TB'=>4,'PB'=>5,'EB'=>6,'ZB'=>7,'YB'=>8);
		$sUnit = strtoupper(trim(substr($p_sFormatted, - 2)));
		if(intval($sUnit) !== 0){
			$sUnit = 'B';
		}
		if(!in_array($sUnit, array_keys($aUnits))){
			return false;
		}
		$iUnits = trim(substr($p_sFormatted, 0, strlen($p_sFormatted) - 2));
		if(!intval($iUnits) == $iUnits){
			return false;
		}
		return $iUnits * pow(1024, $aUnits[$sUnit]);
	}


	public
	function downloadFile($fileLocation,$fileName,$maxSpeed = 100,$doStream = false)
	{
		if(connection_status() != 0) return(false);
		$extension = strtolower(end(explode('.',$fileName)));

		/* List of File Types */
		$fileTypes['swf'] = 'application/x-shockwave-flash';
		$fileTypes['pdf'] = 'application/pdf';
		$fileTypes['exe'] = 'application/octet-stream';
		$fileTypes['zip'] = 'application/zip';
		$fileTypes['doc'] = 'application/msword';
		$fileTypes['docx'] = 'application/msword';
		$fileTypes['srt'] = 'application/msword';
		$fileTypes['xls'] = 'application/vnd.ms-excel';
		$fileTypes['ppt'] = 'application/vnd.ms-powerpoint';
		$fileTypes['gif'] = 'image/gif';
		$fileTypes['png'] = 'image/png';
		$fileTypes['jpeg'] = 'image/jpg';
		$fileTypes['jpg'] = 'image/jpg';
		$fileTypes['rar'] = 'application/rar';

		$fileTypes['ra'] = 'audio/x-pn-realaudio';
		$fileTypes['ram'] = 'audio/x-pn-realaudio';
		$fileTypes['ogg'] = 'audio/x-pn-realaudio';

		$fileTypes['wav'] = 'video/x-msvideo';
		$fileTypes['wmv'] = 'video/x-msvideo';
		$fileTypes['avi'] = 'video/x-msvideo';
		$fileTypes['asf'] = 'video/x-msvideo';
		$fileTypes['divx'] = 'video/x-msvideo';

		$fileTypes['mp3'] = 'audio/mpeg';
		$fileTypes['mp4'] = 'audio/mpeg';
		$fileTypes['mpeg'] = 'video/mpeg';
		$fileTypes['mpg'] = 'video/mpeg';
		$fileTypes['mpe'] = 'video/mpeg';
		$fileTypes['mov'] = 'video/quicktime';
		$fileTypes['swf'] = 'video/quicktime';
		$fileTypes['3gp'] = 'video/quicktime';
		$fileTypes['m4a'] = 'video/quicktime';
		$fileTypes['aac'] = 'video/quicktime';
		$fileTypes['m3u'] = 'video/quicktime';
		$fileTypes['flv'] = 'video/x-flv';

		$contentType        = $fileTypes[$extension];


		header("Cache-Control: public");
		header("Content-Transfer-Encoding: binary\n");
		header('Content-Type: $contentType');

		$contentDisposition = 'attachment';

		if($doStream == true){
			/* extensions to stream */
			$array_listen = array('mp3','m3u','m4a','mid','ogg','ra','ram','wm',
				'wav','wma','aac','3gp','avi','mov','mp4','mpeg','mpg','swf','wmv','divx','asf');
			if(in_array($extension,$array_listen)){
				$contentDisposition = 'inline';
			}
		}

		if(strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")){
			$fileName = preg_replace('/\./', '%2e', $fileName, substr_count($fileName,
					'.') - 1);
			header("Content-Disposition: $contentDisposition;
				filename=\"$fileName\"");
		}
		else
		{
			header("Content-Disposition: $contentDisposition;
				filename=\"$fileName\"");
		}

		header("Accept-Ranges: bytes");
		$range = 0;
		$size  = filesize($fileLocation);

		if(isset($_SERVER['HTTP_RANGE'])){
			list($a, $range) = explode("=",$_SERVER['HTTP_RANGE']);
			str_replace($range, "-", $range);
			$size2      = $size - 1;
			$new_length = $size - $range;
			header("HTTP/1.1 206 Partial Content");
			header("Content-Length: $new_length");
			header("Content-Range: bytes $range$size2/$size");
		}
		else
		{
			$size2 = $size - 1;
			header("Content-Range: bytes 0-$size2/$size");
			header("Content-Length: ".$size);
		}

		if($size == 0 ){
			die('Zero byte file! Aborting download');
		}
		set_magic_quotes_runtime(0);
		$fp = fopen("$fileLocation","rb");

		fseek($fp,$range);

		while(!feof($fp) and (connection_status() == 0))
		{
			set_time_limit(0);
			print(fread($fp,1024 * $maxSpeed));
			flush();
			ob_flush();
			sleep(1);
		}
		fclose($fp);

		return((connection_status() == 0) and !connection_aborted());
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


	function categoryToList($productcategories,$noParent= FALSE)
	{
		$category_list = array();
		if($noParent){
			$category_list[0] = __d(__PRODUCT_LOCALE,'with_out_parent');
		}
		if(!empty($productcategories))
		{
			foreach($productcategories as $product_category){
				$category_list[$product_category['id']] = $product_category['title'];
			}
		}
		return $category_list;
	}


	function addDateSlash($date)
	{
		return substr($date, 0, 4) . '/' . substr($date, 4, 2) . '/' . substr($date, 6, 2);
	}

	public
	function convert_persian_int_date($format = "Y/m/d", $persian_date)
	{
		App::import('Vendor', 'jdf');
		$gregorian_date = jalali_to_gregorian(substr($persian_date, 0, 4), substr($persian_date, 4, 2), substr($persian_date, 6, 2));
		$date = strtotime($gregorian_date[0] . '-' . $gregorian_date[1] . '-' . $gregorian_date[2]);
		$jalali_date = jdate($format, $date);
		return $jalali_date;
	}

	public
	function convert_persian_int_to_gregorian($format = "Y/m/d", $persian_date)
	{
		App::import('Vendor', 'jdf');
		$gregorian_date = jalali_to_gregorian(substr($persian_date, 0, 4), substr($persian_date, 4, 2), substr($persian_date, 6, 2));
		return $gregorian_date[0] . '-' . $gregorian_date[1] . '-' . $gregorian_date[2];
	}

}






?>
