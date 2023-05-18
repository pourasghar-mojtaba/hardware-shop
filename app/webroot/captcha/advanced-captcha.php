<?php
if(session_id() == ""){
	session_name("CAKEPHP");
	session_start();
} //MUST START SESSION
$string_length = 6; //NUMBER OF CHARS TO DISPLAY
$large_letters = array('m','w');
$rand_string = '';

for($i=0; $i<$string_length; $i++){
	//PICK A RANDOM LOWERCASE LETTER USING ASCII CODE
	$rand_string .= chr(rand(97,122));
}
//48,57
//IMAGE VARIABLES
$width = 100;
$height = 36;

//INIT IMAGE
$img = imagecreatetruecolor($width, $height);

//ALLOCATE COLORS
$black = imagecolorallocate($img, 0, 128, 100);
$gray = imagecolorallocate($img, 100, 110, 110);
$medgray = imagecolorallocate($img, 180, 180, 180);
$lightgray = imagecolorallocate($img, 220, 220, 220);
//FILL BACKGROUND
imagefilledrectangle($img, 0, 0, $width, $height, $lightgray);

//ADD NOISE - DRAW background squares
$square_count = 6;
for($i = 0; $i < 10; $i++){
	$cx = (int)rand(0, $width/2);
	$cy = (int)rand(0, $height);
	$h  = $cy + (int)rand(0, $height/5);
	$w  = $cx + (int)rand($width/3, $width);
	imagefilledrectangle($img, $cx, $cy, $w, $h, $medgray);
}

//ADD NOISE - DRAW ELLIPSES
$ellipse_count = 5;
for($i = 0; $i < $ellipse_count; $i++){
	$cx = (int)rand(-1*($width/2), $width + ($width/2));
	$cy = (int)rand(-1*($height/2), $height + ($height/2));
	$h  = (int)rand($height/2, 2*$height);
	$w  = (int)rand($width/2, 2*$width);
	imageellipse($img, $cx, $cy, $w, $h, $gray);
}

//REPLACE THIS WITH THE FONT YOU UPLOAD
$font = 'fonts/BIRTH_OF_A_HERO.TTF';
$font_size = 20;

//CALC APPROX LOCATION - CUSTOMIZED FOR ABOVE FONT
$y_value = ($height/2) + ($font_size/2);
$x_value = 0;

//DRAW STRING USING TRUE TYPE FUNCTION
$captchatext = md5(time());
$captchatext = substr($captchatext, 0, 6);
//$rand_string = $captchatext;
$_SESSION['encoded_captcha'] = md5($rand_string . 'DYhG93b');
for($i = 0; $i < $string_length; $i++){
	$chr = substr($rand_string, $i, 1);
	$x_value += 3 * ($font_size/5);
	imagettftext($img, $font_size, 0, $x_value, $y_value, $black, $font, $chr);
	//check to see if larger than normal letters, if so add more horiz space
	if(in_array($chr, $large_letters)){
		$x_value += 4;
	}
}



//OUTPUT IMAGE HEADER AND SEND TO BROWSER
header("Content-Type: image/png");
imagepng($img);
ob_flush();
flush();
?>
