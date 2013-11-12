<?php
include('loginDongdamen.php');


function get($url,$header=array())
{
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_HEADER,0);

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_POST, 0 );
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_VERBOSE, 0);
	$output = curl_exec($ch);
	curl_close($ch);
	return $output;

}

function post($url,$post=array(),$header=array())
{

	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_HEADER,1);

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_POST, count($post) );
	curl_setopt($ch, CURLOPT_POSTFIELDS,$post) ; 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_VERBOSE, 0);
	$output = curl_exec($ch);
	curl_close($ch);

	return $output;

}
$serialNum=1;
$size = 50;
while(1)
{
	$url = 'http://dongdamen.yiss.com/front/showPageAjax.html';

	$header[] ='Cookie:'.$cookie.'; CUSTOMER_ID=16821;';
	$post =array(
			'serialNum'=>$serialNum,
			'perNum'=>$size,
			'hql'=>'myOrderList',
			'entityName'=>'salesOrder',
			'key'=>'16821',
			);
	$output = post($url,$post,$header);

	preg_match('/<td><strong>(\d+).*?条记录<\/strong><\/td>/is',$output,$num);
	$all = intval($num[1]);

	preg_match_all('/(http:\/\/dongdamen\.yiss\.com\/customer\/myOrderView\.html\?key=(\d+))/is',$output,$m);

	foreach($m[1] as $k=>$v)
	{
		$orderList[] = array(
			'id'=>$m[2][$k],
			'url'=>$v,
			);
	}
	break;
	if($serialNum * $size >= $all)
		break;
	$serialNum++;
}

foreach($orderList as &$order)
{
	$url = $order['url'];
	$output = get($url,$header);

	preg_match('/<span id=\"order_status\">(.*?)<\/span>/is',$output,$sta);
	$order_status = $sta[1];
	if($order_status != '')
		$order['status'] = trim($order_status);

	//2013-11-12 10:03:23
	preg_match('/<strong>(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})<\/strong>/is',$output,$dat);
	$date = $dat[1];
	if($date !='')
		$order['date'] = trim($date); 

	if(preg_match_all('/item-list(.*?)<\/table>/is',$output,$itemList))
	{
		foreach($itemList[1] as $itemLine)
		{
			if(preg_match_all('/img src=\"(.*?)\".*?<a href=\".*?relateId=(\d+)\".*?数量.*?<span>(.*?)<\/span>.*?状态.*?<span>(.*?)<\/span>/is',$itemLine,$m))
			{
				
				foreach($m[1] as $k=> $v)
				{
					$v = str_replace('!73.jpg','!small',$v);
					$order['items'][] = json_encode(array(
						'img'=>$v,
						'id'=>$m[2][$k],
						'url'=>"http://dongdamen.yiss.com/styles/{$m[2][$k]}.html",
						'num' => trim($m[3][$k]),
						'status'=>trim($m[4][$k]),
					));
				}
			}
		}
	}
}

include('../config/config.php');
include(UTIL.'/Curl.class.php');
include(CONFIG.'/db.conf.php');
function updateItem($db,$id,$item)
{
	$c = $db->selectCollection('order');
	$sign = $c->update(array('id'=>$id),$item,array('upsert'=>true));  
	return $sign;
}
function connMongo($dbName = 'blog')
{

	$m = new Mongo(DbConf::$mongoConf);
	$m_db = DbConf::$BDprefix."_".$dbName;
	$db = $m->selectDB($m_db);
	//$db->authenticate(DbConf::$mongoAuth[0],DbConf::$mongoAuth[1] );
	return $db;
}

$db = connMongo('tb');

foreach($orderList as $order)
{
	$id = $order['id'];
	$ret = updateItem($db,$id,$order);
	if(!$ret)
		echo 'error:'.$id."\n";

}


?>
