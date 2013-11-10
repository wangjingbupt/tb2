<?php
/*
	$post = array(
		'callCount'=>'1',
		'page'=>'/login.html',
		'scriptSessionId'=>'0996B01F72D2699FECEDC854EF937608622',
		'c0-scriptName'=>'validationDwr',
		'c0-methodName'=>'doValidateOnSubmit',
		'c0-id'=>'0',
		'c0-param0'=>'string:frontLoginValidation',
		'c0-param1'=>'string:loginFlag%3D%3D%3D%3D0%7C%7C%7C%7CactionUrl%3D%3D%3D%3D%7C%7C%7C%7Cemail%3D%3D%3D%3D619315402%2540qq.com%7C%7C%7C%7Cpassword%3D%3D%3D%3D1988711711',
		'batchId'=>'0',


	);
	$ch = curl_init();
$url ='http://dongdamen.yiss.com/dwr/call/plaincall/validationDwr.doValidateOnSubmit.dwr'; 
	curl_setopt ($ch, CURLOPT_HEADER,1);
	
curl_setopt($ch, CURLOPT_URL, $url);
	//curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$post) ; 
	curl_setopt($ch, CURLOPT_POST, 1 );
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_VERBOSE, 0);
	curl_setopt($ch, CURLOPT_VERBOSE, 0);
	$output = curl_exec($ch);
	curl_close($ch);
*/
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
	$sArr = explode('=',$cookie);
	$ss = $sArr[1]; 

	$header[] ='Cookie:JSESSIONID='.$ss.'; CUSTOMER_ID=16821;';// __utma=101803145.793316517.1384091003.1384091003.1384093725.2; __utmb=101803145.3.10.1384093725; __utmc=101803145; __utmz=101803145.1384091003.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none)';
	//$header[]= 'Cookie:SESSIONID=742A921ABEB8EDFE40D831CEB8FB9D97; CUSTOMER_ID=16821; __utma=101803145.793316517.1384091003.1384091003.1384093725.2; __utmb=101803145.3.10.1384093725; __utmc=101803145; __utmz=101803145.1384091003.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none)';
	//$header[] ='Cookie:JSESSIONID=742A921ABEB8EDFE40D831CEB8FB9D97; CUSTOMER_ID=16821;';// __utma=101803145.793316517.1384091003.1384091003.1384093725.2; __utmb=101803145.6.10.1384093725; __utmc=101803145; __utmz=101803145.1384091003.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none)';
	$ch = curl_init();
$url = 'http://dongdamen.yiss.com/customer/myOrderList.html';
	curl_setopt ($ch, CURLOPT_HEADER,1);
	
curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	//curl_setopt($ch, CURLOPT_POSTFIELDS,$args_test) ; 
	curl_setopt($ch, CURLOPT_POST, 0 );
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_VERBOSE, 0);
	curl_setopt($ch, CURLOPT_VERBOSE, 0);
	$output = curl_exec($ch);
	curl_close($ch);

	print_r($output);

	



?>
