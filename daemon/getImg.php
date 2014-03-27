<?php
is_start();
error_reporting(E_ERROR);ini_set('display_errors',1);

$date = date('Ymd');

include('../config/config.php');

$itemPath = DATA ."/items/{$date}.log";

$imgPath = IMG_PATH ."sys/";

if(!file_exists($itemPath))
{
	exit;
}

$fp = fopen($itemPath,'r');
while(($line = trim(fgets($fp))))
{
	list($id,$url) = explode("\t",$line);
	$imgFile = $imgPath .$id.".jpg";
	if(file_exists($imgFile))
		continue;
	$url = 'http://dimage.yissimg.com'.$url;
	$data = request($url,array(),'GET',false,NULL,3,10);
	if($data)
		file_put_contents($imgFile,$data);

}

function request($url, $data = array(), $method  = 'GET', $isHttps = false, $cookie = NULL, $linkTime=1, $dealTime=1, $httpHeader= array())
{

	$ch = curl_init();
	$curlOptions = array(
			CURLOPT_URL				=>	$url,
			CURLOPT_CONNECTTIMEOUT	=>	$linkTime,
			CURLOPT_TIMEOUT			=>	$dealTime,
			CURLOPT_RETURNTRANSFER	=>	true,
			CURLOPT_HEADER			=>	false,
			CURLOPT_FOLLOWLOCATION	=>	true,
			CURLOPT_HTTPHEADER		=>  $httpHeader,
			CURLOPT_USERAGENT => 'tingapi',
			);

	if($method === 'POST'){
		$curlOptions[CURLOPT_POST] = true;
	}
	if($method === 'PUT'){
		$curlOptions[CURLOPT_PUT] = true;
	}

	if('POST' === $method || 'PUT' === $method)
	{
		if(is_array($data))
		{
			$curlOptions[CURLOPT_POSTFIELDS] = http_build_query($data);
		}else
		{
			$curlOptions[CURLOPT_POSTFIELDS] = $data;
		}
	}
	if(true === $isHttps)
	{
		$curlOptions[CURLOPT_SSL_VERIFYPEER] = false;
	}
	if(isset($cookie))
	{
		$curlOptions[CURLOPT_COOKIE] = $cookie;
	}
	curl_setopt_array($ch, $curlOptions);
	$response = curl_exec($ch);
	$errno = curl_errno($ch);
	if(0 != $errno)
	{
		header("Cache-Control:no-cache");
		curl_close($ch);

		$data['errno'] = $errno;

		return false;
	}

	curl_close($ch);

	return $response;
}

function is_start($key="",$file="")
{
	global  $argv ;
	if ($key!= "")
	{
		$s = "ps auwwx | grep '". $argv[0] ." "  . $key  . "' | grep -v grep | grep -v vi | grep -v '/bin/sh' | wc -l";
	}
	else
	{
		$s = "ps auwwx | grep '". $argv[0] . "' | grep -v grep | grep -v vi | grep -v '/bin/sh' | wc -l";
	}

	$handle = popen($s, "r");
	if($handle)
	{
		$num = fread($handle, 1024);
	}
	else
	{
		exit ;
	}
	pclose($handle);
	if($num  > 1)
	{
		exit ;
		return false ;
	}
	return true ;
}

?>
