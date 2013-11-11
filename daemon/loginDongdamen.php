<?php
	$ch = curl_init();
$url = 'http://dongdamen.yiss.com/logindo.html';
$args = array(
	'email'=>'619315402@qq.com',
	'password'=>'1988711711',
	'loginFlag'=>0,
);
	curl_setopt ($ch, CURLOPT_HEADER,1);
	
curl_setopt($ch, CURLOPT_URL, $url);
	//curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_POST,count($args)) ;
	curl_setopt($ch, CURLOPT_POSTFIELDS,$args) ; 
//	curl_setopt($ch, CURLOPT_POST, 1 );
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_VERBOSE, 0);
//	curl_setopt($ch, CURLOPT_VERBOSE, 0);
	$output = curl_exec($ch);
	curl_close($ch);

	preg_match('/Set-Cookie:(.*?);/is',$output,$m);
	$cookie = trim($m[1]);

	echo $cookie;

	



?>
