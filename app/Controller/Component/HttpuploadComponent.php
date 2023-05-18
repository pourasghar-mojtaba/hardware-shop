<?php
App::uses('Component', 'Controller');
define('HTTPUPLOAD_ERROR_OK' , 1);
define('HTTPUPLOAD_ERROR_NO_FILE' , -1);
define('HTTPUPLOAD_ERROR_INI_SIZE' , -2); //php size limit
define('HTTPUPLOAD_ERROR_FORM_SIZE' , -3); //form size limit
define('HTTPUPLOAD_ERROR_SIZE' , -4); //class size limit
define('HTTPUPLOAD_ERROR_IMG' , -5); //image size limit
define('HTTPUPLOAD_ERROR_EXT' , -6); //extension is not allowed
define('HTTPUPLOAD_ERROR_MIME' , -7); //mime is not allowed
define('HTTPUPLOAD_ERROR_WRITE' , -8); //there was a problem during processing file
define('HTTPUPLOAD_ERROR_PARTIAL' , -9); //The uploaded file was only partially uploaded

class HttpuploadComponent extends Component {

    var $uploadDir = '';
	var $model = '';
	var $uploadThumbsDir = '';
	var $uploadName = '';
	var $uploadIndex = -1;
	var $allow_resize =false;
	var $create_thumb =false;
	var $thumb_folder='thumb';
	var $resize_width=0;
	var $resize_height=0;
	var $thumb_width=0;
	var $thumb_height=0;
	var $thumb_array=array();
	var $from_array=false;
	var $ismerge_logo = FALSE;
	var $merge_logo_addr = '';
	var $merge_mini_logo_addr = '';
	var $maxSize = 0;
	var $seperator = "/";
	var $handler = '';
	var $handlerType = ''; //move , copy , data
	var $targetName = '';
	var $savedName = '';
	var $maxWidth = '';
	var $maxHeight = '';
	var $allowExt = array();
	var $allowMime = array();
	var $fileCHMOD = 0777;
	var $prefix = false;
	var $extension = true;
	var $error_code = 0;
	var $error_lang = array(
			HTTPUPLOAD_ERROR_NO_FILE => "هیچ فایلی ارسال شده است.",
			HTTPUPLOAD_ERROR_INI_SIZE => "اندازه فایل آپلود شده بیشتر از اندازه مجاز می باشد",
			HTTPUPLOAD_ERROR_FORM_SIZE => "The uploaded file exceeds the MAX_FILE_SIZE directive",
			HTTPUPLOAD_ERROR_SIZE => "اندازه فایل آپلود شده بیشتر از اندازه مجاز می باشد",
			HTTPUPLOAD_ERROR_IMG => "ارتفاع و پهنای عکس ارسال شده بیش از حد مجاز است",
			HTTPUPLOAD_ERROR_EXT => "پسوند فایل معتبر نمی باشد",
			HTTPUPLOAD_ERROR_MIME => "File mime is not allowed.",
			HTTPUPLOAD_ERROR_WRITE => "خطا در هنگام نوشتن فایل وجود دارد.", //Maybe target file is existed or PHP cannot write the target file
			HTTPUPLOAD_ERROR_PARTIAL => "تنها بخشی از فایل آپلود شده ارسال شد.",
	);

	public function __set($name,$value){
        $this->$name = $value;
    }

    /**
     *
     * @param mixed $name
     * @return
     */
    public function __get($name){
        return $this->$name;
    }

	/**
	 * Set upload directory
	 * @param string $dir upload directory
	 **/
	function setuploaddir($dir) {
		$this->uploadDir = $dir;
	}

	function setmodel($model) {
		$this->model = $model;
	}

	/**
	 * Set upload name
	 * @param string $name $HTTP_POST_VARS[$name]
	 **/
	function setuploadname($name) {
		$this->uploadName = $name;
	}

	/**
	 * Set upload name index
	 * @param string $name $HTTP_POST_VARS[$name][$index]
	 **/
	function setuploadindex($index) {
		$this->uploadIndex = $index;
	}

	/**
	 * Set upload filename
	 * @param string $name File name
	 **/
	function settargetfile($name) {
		$this->targetName = $name;
	}

	/**
	 * Set upload image size
	 * @param string $w Max image width
	 * @param string $h Max image height
	 **/
	function setimagemaxsize($w = null , $h = null) {
		$this->maxWidth = $w;
		$this->maxHeight = $h;
	}

	/**
	 * Set upload mime filter
	 * @param mixed $a Filter data
	 * @param string $s Text seperator (for string filter data)
	 **/
	function setallowmime($a , $s = '|') {
		if (!is_array($a)) {
			if (strpos($a , $s) === false) {
				$a = array($a);
			} else {
				$a = explode($s , $a);
			}
		}
		$this->allowMime = array();
		foreach ($a as $val) {
			$this->allowMime[] = strtolower(trim($val));
		}
	}

	/**
	 * Set upload extension filter
	 * @param mixed $a Filter data
	 * @param string $s Text seperator (for string filter data)
	 **/
	function setallowext($a , $s = '|') {
		if (!is_array($a)) {
			if (strpos($a , $s) === false) {
				$a = array($a);
			} else {
				$a = explode($s , $a);
			}
		}
		$this->allowExt = array();
		foreach ($a as $val) {
			$val = trim($val);
			if (substr($val , 0 , 1) != ".") $val = ".$val";
			$this->allowExt[] = strtolower($val);
		}
	}


	/**
	 * Set max file size
	 * @param int $size Max file size
	 **/
	function setmaxsize($size) {
		$this->maxSize = intval($size);
	}

	function httpupload($dir = '' , $name = '' , $index = '') {
		$this->uploadDir = $dir;
		$this->uploadName = $name;
		$this->uploadIndex = $index;
	}

	function getuploadname() {
		$FILE = $this->getuploadinfo($this->uploadName , $this->uploadIndex);
		if ($FILE === false) return false;
		return @$FILE['name'];
	}

	function getuploadsize() {
		$FILE = $this->getuploadinfo($this->uploadName , $this->uploadIndex);
		if ($FILE === false) return false;
		return @$FILE['size'];
	}

	function getuploadtype() {
		$FILE = $this->getuploadinfo($this->uploadName , $this->uploadIndex);
		if ($FILE === false) return false;
		return @$FILE['type'];
	}

	function getuploadtmp() {
		$FILE = $this->getuploadinfo($this->uploadName , $this->uploadIndex);
		if ($FILE === false) return false;
		return @$FILE['tmp_name'];
	}

	function getsavedname($fullpath=true) {
		$FILE = $this->getuploadinfo($this->uploadName , $this->uploadIndex);
		if ($FILE === false || $this->savedName == '') return false;
		return ($fullpath ? $this->uploadDir . "/" : "") . $this->savedName;
	}

	function isempty() {
		$FILE = $this->getuploadinfo($this->uploadName , $this->uploadIndex);
		if ($FILE === false) return true;
		return ($FILE['size'] == 0);
	}

	function hasupload() {
		$FILE = $this->getuploadinfo($this->uploadName , $this->uploadIndex);
		if ($FILE === false) return false;
		return (isset($FILE['name']));
	}

	function resize($name,$url, $box_w, $box_h, $savePath, $r, $g, $b){
		list($width,$height)=getimagesize($url);
		$box_h=($height/$width)*$box_w;
		$background = ImageCreateTrueColor($box_w, $box_h);
		$color=imagecolorallocate($background, $r, $g, $b);
		imagefill($background, 0, 0, $color);
		$image = $this->open_image($url, $r, $g, $b);
		if ($image === false) { throw new Exception('Unable to open image'); }
		$w = imagesx($image);
		$h = imagesy($image);
		$ratio=$w/$h;
		$target_ratio=$box_w/$box_h;
		if ($ratio>$target_ratio){
			$new_w=$box_w;
			$new_h=round($box_w/$ratio);
			$x_offset=0;
			$y_offset=round(($box_h-$new_h)/2);
		}else {
			$new_h=$box_h;
			$new_w=round($box_h*$ratio);
			$x_offset=round(($box_w-$new_w)/2);
			$y_offset=0;
		}
		$insert = ImageCreateTrueColor($new_w, $new_h);
		imagecopyResampled ($insert, $image, 0, 0, 0, 0, $new_w, $new_h, $w, $h);
		imagecopymerge($background,$insert,$x_offset,$y_offset,0,0,$new_w,$new_h,100);

        if (!(strpos($name , ".")) === false) {
			$ext = explode("." , $name);
			$ext =   $ext[count($ext) - 1];
		}
		$ext = strtolower($ext);

        switch($ext) {
            case 'jpg':
            case 'jpeg':
                imagejpeg($background, $savePath, 100);
				break;
            case 'png':
                imagepng($background, $savePath, 9);
				break;
            case 'gif':
                imagegif($background, $savePath);
				break;
        }

		//imagejpeg($background, $savePath, 100);
		imagedestroy($insert);
		imagedestroy($background);
	}

	function merge_logo($logo,$mini_logo,$base,$merge_name){

		$ext = pathinfo($base, PATHINFO_EXTENSION);
		$ext = strtolower($ext);
		switch($ext){
			case 'jpg':
				$base_image = imagecreatefromjpeg($base);
				break;
			case 'jpeg':
				$base_image = imagecreatefromjpeg($base);
				break;
			case 'png':
				$base_image = imagecreatefrompng($base);
				break;
		}

		//print_r($base);exit();

		list($width, $height) = getimagesize($logo);
		list($base_width, $base_height) = getimagesize($base);

		if(($width * 2) >= $base_width  || ($height * 2) >= $base_height){
			$logo = $mini_logo;
			list($width, $height) = getimagesize($logo);
		}

		$top_image = imagecreatefrompng($logo);

		imagesavealpha($top_image, true);
		imagealphablending($top_image, true);

		imagecopy($base_image, $top_image, 0, 0, 0, 0, $width, $height);
		imagepng($base_image, $merge_name);
	}

	function open_image ($file, $r='255', $g='255', $b='255') {
		$size=getimagesize($file);

		switch($size["mime"]){
			case "image/jpeg":
				$im = imagecreatefromjpeg($file); //jpeg file
			break;
			case "image/gif":
				$im = imagecreatefromgif($file); //gif file
				imageAlphaBlending($im, false);
				imageSaveAlpha($im, true);
				$background = imagecolorallocate($im, 0, 0, 0);
				imagecolortransparent($im, $background);

				$color=imagecolorallocate($im, $r, $g, $b);
				for ($i=0;$i<imagesy($im);$i++){
					for ($j=0; $j<imagesx($im); $j++){
						$rgb=imagecolorat($im, $j, $i);
						if ($rgb==2){
							imagesetpixel($im, $j, $i, $color);
						}
					}
				}

		  break;
		  case "image/png":
			  $im = imagecreatefrompng($file); //png file
			  $background = imagecolorallocate($im, 0, 0, 0);
			  imageAlphaBlending($im, false);
			  imageSaveAlpha($im, true);
			  imagecolortransparent($im, $background);
			  $color=imagecolorallocate($im, $r, $g, $b);
				for ($i=0;$i<imagesy($im);$i++){
					for ($j=0; $j<imagesx($im); $j++){
						$rgb=imagecolorat($im, $j, $i);
						if ($rgb==2){
							imagesetpixel($im, $j, $i, $color);
						}
					}
				}

		  break;
		default:
			$im=false;
		break;
		}
		return $im;
	}
	/**
	 * Default file upload handler
	 * @access private
	 **/
	function processfile($b , $t , $mod , $overWrite = false) {
		$FILE = $this->getuploadinfo($this->uploadName , $this->uploadIndex);

		if ($FILE === false) return false;

		$p = '';
		$p2 = $FILE['tmp_name'];

		if (trim($b) == '') {
			$p = $t;
		} else {
			if (substr($b , strlen($b) - 1 , 1) != $this->seperator) $p = $b . $this->seperator;
			else $p = $b;
			$p .= $t;
		}
		if (file_exists($p)) {
			//exist file , have to check
			if (is_dir($p)) return false;
			if (!$overWrite) return false;
		}

		if($this->allow_resize)
		{
			$url=$p2;
			$r=255; $g=255; $b=255;
			$this->resize($FILE['name'],$url, $this->resize_width,$this->resize_height,$p, $r, $g, $b);
		}
		else
		{
			if  (!@copy($p2 , $p)) return false;
			@chmod($p , $mod);
			$this->savedName = $t;
		}

		if($this->ismerge_logo){
			$this->merge_logo($this->merge_logo_addr,$this->merge_mini_logo_addr,$this->uploadDir."/".$t,$this->uploadDir."/".$t);
		}


		if($this->create_thumb)
		{
		   if($this->from_array)
		   {
			   foreach($this->thumb_array as $key=>$value)
			   {
					   $dir=$this->uploadDir.'/'.$value['thumb_folder'];
					   $url=$p2;
					   $r=255; $g=255; $b=255;
					   if(is_dir($dir))
						  $this->resize($FILE['name'],$url, $value['thumb_width'],$value['thumb_height'],$dir."/".$t, $r, $g, $b);
					   else
					   if(@mkdir($dir))
						  $this->resize($FILE['name'],$url, $value['thumb_width'],$value['thumb_height'],$dir."/".$t, $r, $g, $b);
			   }
		   }
		   else
		   {
			   $dir=$this->uploadDir.'/'.$this->thumb_folder;

			   $url=$p2;
			   $r=255; $g=255; $b=255;
			   if(is_dir($dir))
				  $this->resize($FILE['name'],$url, $this->thumb_width,$this->thumb_height,$dir."/".$t, $r, $g, $b);
			   else
			   if(@mkdir($dir))
				  $this->resize($FILE['name'],$url, $this->thumb_width,$this->thumb_height,$dir."/".$t, $r, $g, $b);
		   }
		}
		return true;
	}

	/**
	 * Check and Save upload file
	 * @param bool $overWrite Overwrite existed file
	 * @return bool
	 **/
	function upload($overWrite = false) {

		$this->savedName = '';
		$this->set_error(0);
		//if (!$this->hasUpload()) return $this->set_error(HTTPUPLOAD_ERROR_NO_FILE);
		$FILE = $this->getuploadinfo($this->uploadName , $this->uploadIndex);

        /*
		pr($FILE);
		throw new Exception();
		exit();*/
		switch ($FILE['error']) {
			case 1:
				return $this->set_error(HTTPUPLOAD_ERROR_INI_SIZE);
			break;
			case 2:
				return $this->set_error(HTTPUPLOAD_ERROR_FORM_SIZE);
			break;
			case 3:
				return $this->set_error(HTTPUPLOAD_ERROR_PARTIAL);
			break;
			case 4:
				return $this->set_error(HTTPUPLOAD_ERROR_NO_FILE);
			break;
		}
		//$ext = ".";
		if (!(strpos($FILE['name'] , ".")) === false) {
			$ext = explode("." , $FILE['name']);
			$ext =   $ext[count($ext) - 1];
		}
		$ext = strtolower($ext);
		$this->allowExt = explode(',',$this->allowExt);
		//check max file size


		//check extension
		if (is_array($this->allowExt) && count($this->allowExt) > 0 && !in_array($ext , $this->allowExt))
		return $this->set_error(HTTPUPLOAD_ERROR_EXT);

		if (intval($this->maxSize) > 0 && $FILE['size'] > $this->maxSize)
		return $this->set_error(HTTPUPLOAD_ERROR_SIZE);

		//check mime
		if (is_array($this->allowMime) && count($this->allowMime) > 0 && !in_array($FILE['type'] , $this->allowMime))
		return $this->set_error(HTTPUPLOAD_ERROR_MIME);
		//check image size

	 	if (intval($this->maxWidth) > 0 || intval($this->maxHeight) > 0) {
			$imageSize['size'] =  filesize($FILE['tmp_name']);
			if ($imageSize['size']>$this->maxWidth   && $imageSize['size']<$this->maxHeight)
			   return $this->set_error(HTTPUPLOAD_ERROR_IMG);
			$imageSize = @getimagesize($FILE['tmp_name']);
			if ($imageSize === false) return false;
			if (intval($this->maxWidth) > 0 && $imageSize[0] > intval($this->maxWidth))
			return $this->set_error(HTTPUPLOAD_ERROR_IMG);
			if (intval($this->maxHeight) > 0 && $imageSize[1] > intval($this->maxHeight))
			return $this->set_error(HTTPUPLOAD_ERROR_IMG);
		}

		//process file
		if (trim($this->targetName) == '') {
			//Self Generator
			if ($this->prefix === false) {
				$f = $FILE['name'];
				if (!(strpos($f , ".") === false)) {
					$f = explode("." , $f);
					unset($f[count($f) -1]);
					$f = implode("." , $f);
				}
			} else {
				$f = uniqid(trim($this->prefix));
			}
			if ($this->extension === false) {
				if ($ext != '.') $f .= $ext;
			} else {
				if (substr($this->extension , 0 , 1) != ".") $this->extension = "." . $this->extension;
				if (trim($this->extension) != '.') $f .= $this->extension;
			}
		} else {
			//User name
			$f = trim($this->targetName);
		}
		$this->savedName = $f;
		//ok , now process copy
		if ($this->handlerType == '' || $this->handler == '') {
			//process default handler
			if ($this->processfile($this->uploadDir , $f , $this->fileCHMOD , $overWrite)) return $this->set_error(HTTPUPLOAD_ERROR_OK);
			else return $this->set_error(HTTPUPLOAD_ERROR_WRITE);
		} else {
			//process user handler
			$b = $this->uploadDir;
			if (trim($b) == '') {
				$p = $f;
			} else {
				if (substr($b , strlen($b) - 1 , 1) != $this->seperator) $p = $b . $this->seperator;
				else $p = $b;
				$p .= $f;
			}
			$f = $this->handler;
			switch (trim(strtolower($this->handlerType))) {
				case 'copy':
				case 'move':
					// function (src , tgt , CHMOD)
					/*
					if (is_array($f)) {
						return $f[0]->$f[1]($p , $FILE['tmp_name'] , $this->fileCHMOD);
					}
					else return $f($p , $FILE['tmp_name'] , $this->fileCHMOD);
					*/
					if (@call_user_func($f , $p , $FILE['tmp_name'] , $this->fileCHMOD)) return $this->set_error(HTTPUPLOAD_ERROR_OK);
					else return $this->set_error(HTTPUPLOAD_ERROR_WRITE);
				break;
				case 'data':
					// function (targetFile , data , CHMOD)
					/*
					if (is_readable($FILE['tmp_name'])) $data = implode("" , file($FILE['tmp_name']));
					else return false;
					if (is_array($f)) {
						return $f[0]->$f[1]($p , $data , $this->fileCHMOD);
					}
					else return $f($p , $data , $this->fileCHMOD);
					*/
					if (@call_user_func($f , $p , $data , $this->fileCHMOD)) return $this->set_error(HTTPUPLOAD_ERROR_OK);
					else return $this->set_error(HTTPUPLOAD_ERROR_WRITE);
				break;
				default:
					if ($this->processfile($this->uploadDir , $f , $this->fileCHMOD , $overWrite)) return $this->set_error(HTTPUPLOAD_ERROR_OK);
					else return $this->set_error(HTTPUPLOAD_ERROR_WRITE);
			}
		}
	}

	//multi-file upload
	function upload_ex($name,$overwrite=false) {
		$FILES = $this->getuploadinfo($name,null);
		if (isset($FILES['name']) && is_array($FILES['name'])) {
			$results = array();
			$old_index = $this->uploadIndex;
			$old_name = $this->uploadName;

			$this->uploadName = $name;

			foreach ($FILES['name'] as $index => $dummy) {
				//handle each file
				//echo $dummy;
				$this->uploadIndex = $index;
				$this->upload($overwrite);

				$results[] = array(
					'error_code' => $this->error_code ,
					'name' => $this->getuploadname() ,
					'size' => $this->getuploadsize() ,
					'type' => $this->getuploadtype() ,
					'tmp_name' => $this->getuploadtmp() ,
					'file' => $this->getsavedname(false) ,
					'fullpath' => $this->getsavedname(true) ,
					'index' => $index ,
				);
			}
			$this->uploadIndex = $old_index;
			$this->uploadName = $old_name;
			return $results;
		} else return false;
	}

	function getuploadinfo($name , $index = -1) {
		global $_FILES;

		   if($index==-1){
				  	//return array('moj1' =>$index);
                    if (isset($_FILES['data']['name'][$this->model][$name])) {
					return array(
						'name' => $_FILES['data']['name'][$this->model][$name],
						'tmp_name' => $_FILES['data']['tmp_name'][$this->model][$name],
						'size' => $_FILES['data']['size'][$this->model][$name],
						'type' => $_FILES['data']['type'][$this->model][$name],
						'error' => $_FILES['data']['error'][$this->model][$name],
					);
				  }
		   }
		   elseif($index>=0){

               //return array('moj2' =>$index);
			return array(
						'name' => $_FILES['data']['name'][$this->model][$name][$index],
						'tmp_name' => $_FILES['data']['tmp_name'][$this->model][$name][$index],
						'size' => $_FILES['data']['size'][$this->model][$name][$index],
						'type' => $_FILES['data']['type'][$this->model][$name][$index],
						'error' => $_FILES['data']['error'][$this->model][$name][$index],
					);
		   }

		return false;
	}

	function set_error($code) {
		$this->error_code = $code;
		if ($code != HTTPUPLOAD_ERROR_OK) return false;
		return true;
	}

	function get_error($code = null) {
		if ($code === null) $code = $this->error_code;
		return @$this->error_lang[$code];
	}



function get_extension($filename)
{
	$path_info = pathinfo($filename);
	return $path_info['extension'];;
}
//=========================================================================
 function upload_image($filename,$dir1,$dir2,$new_file_name,$twidth="165",$theight = "130")

 {
$idir = $dir1;   // Path To Images Directory
$tdir = $dir2;
$RetArr=array();
if ($_FILES[$filename]['error'] > 0)
        {
         switch ($_FILES[$filename]['error'])
         {
          case 1:
          $msg='حجم فایل شما زیاد است لطفا حجم فایل خود را کم کنید';
	      $RetArr[0]=false;
	      $RetArr[1]=$msg;
	      return $RetArr;
	      break;
          case 2:
          $msg='حجم فایل شما زیاد است لطفا حجم فایل خود را کم کنید';
	      $RetArr[0]=false;
	      $RetArr[1]=$msg;
	      return $RetArr;
	      break;
          case 3:
          $msg='بخشی از فایل شما آپلود شد ،فایل خود را با نام دیگر دوباره آپلود کنید';
	      $RetArr[0]=false;
	      $RetArr[1]=$msg;
	      return $RetArr;
	     break;
         case 4:
          $msg='هیچ فایلی آپلود نشده است';
	      $RetArr[0]=false;
		 // $RetArr[0]=true;
	      $RetArr[1]=$msg;
	      return $RetArr;
	      break;
       }
	   }
 else {
		   $url = $_FILES[$filename]['name'];
		   if ($_FILES[$filename]['type'] == "image/jpg" || $_FILES[$filename]['type'] == "image/jpeg" || $_FILES[$filename]['type'] == "image/pjpeg")
		   {
			  $file_ext = strrchr($_FILES[$filename]['name'], '.');
			  $path= $idir.$new_file_name;
			  @$copy = copy($_FILES[$filename]['tmp_name'],$path);
	          $url=$new_file_name;
			  if ($copy)
			  {
				 $simg = imagecreatefromjpeg("$idir" . $url);
                 $currwidth = imagesx($simg);   // Current Image Width
                 $currheight = imagesy($simg);   // Current Image Height
                 if ($currheight > $currwidth)
				  {
                   $zoom = $twidth / $currheight;   // Length Ratio For Width
                   $newheight = $theight;   // Height Is Equal To Max Height
                   $newwidth = $currwidth * $zoom;   // Creates The New Width
                  }
				  else
				  {
                   $zoom = $twidth / $currwidth;   // Length Ratio For Height
                   $newwidth = $twidth;   // Width Is Equal To Max Width
                   $newheight = $currheight * $zoom;   // Creates The New Height
                  }
				  $dimg = imagecreate($newwidth, $newheight);
                  imagetruecolortopalette($simg, false, 256);
                  $palsize = ImageColorsTotal($simg);
                  for ($i = 0; $i < $palsize; $i++)
				  {
                   $colors = ImageColorsForIndex($simg, $i);
                   ImageColorAllocate($dimg, $colors['red'],
				   $colors['green'], $colors['blue']);
                  }
				  imagecopyresized($dimg, $simg, 0, 0, 0, 0, $newwidth,
				  $newheight, $currwidth, $currheight);
                  imagejpeg($dimg, "$tdir" . $url);   // Saving The Image
                  imagedestroy($simg);   // Destroying The Temporary Image
                  imagedestroy($dimg);   // Destroying The Other Temporary Image
                  //print 'Image thumbnail created successfully.';
				  $RetArr[0]=true;
	              return $RetArr;
			  }
			  else
			  {
               //print '<font color="#FF0000">ERROR: Unable to upload image.</font>';
			   $msg='وب سایت نمی تواند فایل شما را در مسیر تعریف شده کپی کند';
			   $RetArr[0]=false;
	           $RetArr[1]=$msg;
	           return $RetArr;
			  }
		   }
		   else
		   {
             $msg='پسوند فایل شما باید از نوع فایل jpg باشد';
	         $RetArr[0]=false;
	         $RetArr[1]=$msg;
	         return $RetArr;
           }

 }

       $RetArr[0]=true;
	   return $RetArr;

}
//=========================================================================
//===========================================================================
 function upload_file($filename,$dir,$allowExt="")
 {
$RetArr=array();
if ($_FILES[$filename]['error'] > 0)
        {
         switch ($_FILES[$filename]['error'])
         {
          case 1:
          $msg='حجم فایل شما زیاد است لطفا حجم فایل خود را کم کنید';
	      $RetArr[0]=false;
	      $RetArr[1]=$msg;
	      return $RetArr;
	      break;
          case 2:
          $msg='حجم فایل شما زیاد است لطفا حجم فایل خود را کم کنید';
	      $RetArr[0]=false;
	      $RetArr[1]=$msg;
	      return $RetArr;
	      break;
          case 3:
          $msg='بخشی از فایل شما آپلود شد ،فایل خود را با نام دیگر دوباره آپلود کنید';
	      $RetArr[0]=false;
	      $RetArr[1]=$msg;
	      return $RetArr;
	     break;
         case 4:
          $msg='هیچ فایلی آپلود نشده است';
	      $RetArr[0]=false;
		  //$RetArr[0]=true;
	      $RetArr[1]=$msg;
	      return $RetArr;
	      break;
       }
	   }
 else {
		   $path_info = pathinfo($_FILES[$filename]['name']);
		   $ext=$path_info['extension'];
		   $ext=strtolower($ext);
		   if($allowExt!="")
		   {
		    if( !in_array($ext,$allowExt))
		     {

				$msg='فایل ارسال شده نا معتبر می باشد ';
	            $RetArr[0]=false;
	            $RetArr[1]=$msg;
	            return $RetArr;
			 }
		   }
		   $pic=$_FILES[$filename]['name'];
           $upfile =$dir.$_FILES[$filename]['name'];
		   echo $upfile;
		   if(file_exists($upfile))
           {
             $msg='فایلی با همین نام وجود دارد لطفا نام فایل خود را عوض کنید';
	         $RetArr[0]=false;
	         $RetArr[1]=$msg;
	         return $RetArr;
           }else
		   {
		    if (is_uploaded_file($_FILES[$filename]['tmp_name']))
             {
              if (@!move_uploaded_file($_FILES[$filename]['tmp_name'], $upfile))
              {
                $msg='وب سایت نمی تواند فایل شما را در مسیر تعریف شده کپی کند';
	            $RetArr[0]=false;
	            $RetArr[1]=$msg;
	            return $RetArr;
              }

			  else
			  {
                     $RetArr[0]=true;
	                 return $RetArr;
			  }
             }
		   }
		  }
}
//=========================================================================
 function reArrayFiles(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}
//=========================================================================
 function upload_multi_file($filename,$new_file_name,$error,$tmp_name,$dir)
 {
$RetArr=array();
if ($error > 0)
        {
         switch ($error)
         {
          case 1:
          $msg='حجم فایل شما زیاد است لطفا حجم فایل خود را کم کنید';
	      $RetArr[0]=false;
	      $RetArr[1]=$msg;
	      return $RetArr;
	      break;
          case 2:
          $msg='حجم فایل شما زیاد است لطفا حجم فایل خود را کم کنید';
	      $RetArr[0]=false;
	      $RetArr[1]=$msg;
	      return $RetArr;
	      break;
          case 3:
          $msg='بخشی از فایل شما آپلود شد ،فایل خود را با نام دیگر دوباره آپلود کنید';
	      $RetArr[0]=false;
	      $RetArr[1]=$msg;
	      return $RetArr;
	     break;
         case 4:
          $msg='هیچ فایلی آپلود نشده است';
	      //$RetArr[0]=false;
		  $RetArr[0]=true;
	      $RetArr[1]=$msg;

	      return $RetArr;
	      break;
       }
	   }
 else {
		   $pic=$filename;
           $upfile =$dir.$new_file_name;
		   //echo $upfile;
		   if(file_exists($upfile))
           {
             $msg='فایل  '.$filename.' با همین نام وجود دارد لطفا نام فایل خود را عوض کنید';
	         $RetArr[0]=false;
	         $RetArr[1]=$msg;
	         return $RetArr;
           }else
		   {
		    if (is_uploaded_file($tmp_name))
             {
              $file_ext = strrchr($_FILES[$filename]['name'], '.');
			  $path= $idir.$new_file_name;
			  if (@!move_uploaded_file($tmp_name, $upfile))
              {
                $msg='وب سایت نمی تواند فایل شما را در مسیر تعریف شده کپی کند';
	            $RetArr[0]=false;
	            $RetArr[1]=$msg;
	            return $RetArr;
              }

			  else
			  {
                     $RetArr[0]=true;
	                 return $RetArr;
			  }
             }
		   }
		  }
}

}
?>
