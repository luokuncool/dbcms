<?php
/**
 * HyCheckcode 验证码 1.0.0
 *
 * Copyright (c) 2013 YinHailin All rights reserved.
 * @Author: YinHailin
 * @Authorize: Boren Network
 * @Created by YinHailin at 2014-11-27
 */

$length = 4;  //验证码长度
$mode = 1;  //验证码模式 1=数字验证码 2=大写字母验证码（验证码转小写） 3=小写字母验证码 4=区分大小写字母混合验证码 5=不区分大小写字母混合验证码 6=区分大小写字母、数字验证码 7=不区分大小写字母、数字验证码
$width = 110;  //验证码宽度
$height = 40;  //验证码高度
$noise = 80;  //噪点数量，数字越大，噪点越多
/**
 * 随机数库
 */
$seek = array(
	'0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J',
	'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd',
	'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x',
	'y', 'z'
);

//产生验证码
switch ($mode) {
	case 1:
		$floor = 0; $ceil = 9;
		break;
	case 2:
		$floor = 10; $ceil = 35;
		break;
	case 3:
		$floor = 36; $ceil = 61;
		break;
	case 4:
	case 5:
		$floor = 10; $ceil = 61;
		break;
	case 6:
	case 7:
		$floor = 0; $ceil = 61;
		break;
}
//存储验证码
session_start();
$checkcode = '';
for ($i = 0; $i < $length; $i++) {
	$sub = rand($floor, $ceil);
	$checkcode .= $seek[$sub];
}
if ($mode !== 4 && $mode !== 6) {
	$checkcode = strtolower($checkcode);
}

$_SESSION['checkcode'] = $checkcode;

//输出验证码
header("Content-type: image/jpeg");
$image = imagecreate($width, $height);
$foreground = imagecolorallocate($image, 47, 127, 200);
$background = imagecolorallocate($image, 237, 244, 249);
imagefill($image, 0, 0, $background);

//生成干扰线
$style = array($foreground, $background, $background, $background);
imagesetstyle($image, $style);
imageline($image, 0, rand(0, $height), $width, rand(0, $height), IMG_COLOR_STYLED);
imageline($image, 0, rand(0, $height), $width, rand(0, $height), IMG_COLOR_STYLED);

//生成噪点
for ($i = 0; $i < $noise; $i++) {
	imagesetpixel($image, rand(0, $width), rand(0, $height), $foreground);
}

//随机放置验证字符
$space = intval(($width - 22) / $length);
$x = rand(10, $space);
for ($i = 0; $i< $length; $i++) {
	$y = rand(30, $height-5);
	//imagestring($image, 5, $x, $y, substr($checkcode, $i, 1), $foreground);
  $textcolor = imagecolorallocate($image,58,97,130);
  imagefttext($image, 22, rand(-30,30), $x, $y, $textcolor, 'themes/public/fonts/AgencyFB.ttf', substr($checkcode, $i, 1));
	$x += rand(18 , 22);
}

imagepng($image);
imagedestroy($image);