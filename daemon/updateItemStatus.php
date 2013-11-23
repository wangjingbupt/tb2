<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include('../config/config.php');
include(UTIL.'/Curl.class.php');
include(CONFIG.'/db.conf.php');


function connMongo($dbName = 'blog')
{

	$m = new Mongo(DbConf::$mongoConf);
	$m_db = DbConf::$BDprefix."_".$dbName;
	$db = $m->selectDB($m_db);
	//$db->authenticate(DbConf::$mongoAuth[0],DbConf::$mongoAuth[1] );
	return $db;

}
function getItems($db)
{
	$c = $db->selectCollection('items');
	$items = $c->find(array('status'=>1));
	return mongoObj2Array($items);

}
function mongoObj2Array($cursor)
{
	$res = array();
	foreach($cursor as $doc)
	{   
		$doc['_id'] = $doc['_id']->__toString();
		$res[] = $doc;
	}   
	return $res;
}
function getItem($db,$id)
{
	$c = $db->selectCollection('items');
	$item = $c->findOne(array('id'=>$id));
	if(is_array($item) && !empty($item))
		return $item;

	return false;

}
function updateItem($db,$id,$item)
{
	$c = $db->selectCollection('items');
	$sign = $c->update(array('id'=>$id),$item);  
	return $sign;
}

function insertFinder($db,$item)
{
	$c = $db->selectCollection('finder');
	$sign = $c->insert($item);  
	return $sign;
}

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

function fetchItem($id)
{
	$url = "http://dongdamen.yiss.com/styles/{$id}.html";
	$data =array();
/*
	$header[] = 'Cookie:53gid2=7033675505; 53uvid=1; onliner_zdfq70668856=0; 53gid1=7033675505; JSESSIONID=6C44D5767692C027F37CC4EF1C875173; CUSTOMER_ID=16821; 53gid0=7033675505; visitor_type=old; 53kf_70668856_keyword=http%3A%2F%2Fwww.baidu.com%2Fs%3Fie%3Dutf-8%26bs%3Dsystem%2Berror%253A%2BInvalid%2Bcross-device%2Blink%253B%2Berrno%253D18%26f%3D8%26rsv_bp%3D1%26rsv_spt%3D3%26wd%3D%25E4%25B8%2580%25E6%2597%25B6%25E5%25B0%259A%26rsv_sug3%3D17%26rsv_sug1%3D15%26rsv_sug4%3D143%26rsv_sug%3D0%26inputT%3D1112126; kf_70668856_keyword_ok=1; __utma=101803145.1618824704.1382926945.1384858598.1384913467.82; __utmb=101803145.20.10.1384913467; __utmc=101803145; __utmz=101803145.1384913467.82.21.utmcsr=tb.sleepwalker.pro|utmccn=(referral)|utmcmd=referral|utmcct=/order';
	$header[] = 'Accept-Encoding:deflate,sdch';
	$header[] = 'Accept-Language:zh-CN,zh;q=0.8';
	$header[] = 'Cache-Control:max-age=0';
	$header[] = 'Connection:keep-alive';
	$header[] = 'Host:dongdamen.yiss.com';
	$header[] = 'Referer:http://dongdamen.yiss.com/trend/newest/t-shirts.html';
	$header[] = 'User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36';
	*/
	$header =array();

	$content = get($url,$header);

	$data['onsale'] = false;
	if(preg_match('/id=\"purchasing\"/i',$content,$m))
	{
		$data['onsale'] = true;
	}
	if(preg_match('/class=\"from\".*?at.*?(<a.*?<\/a>.*?).*?price.*?>([0-9\.]+).*?<\/span/is',$content,$m))
	{
		$data['band'] = $m[1];
		$data['price'] = floatval($m[2]);
	}

	return $data;
}

$db = connMongo('tb');
$items = getItems($db);
if(is_array($items) && !empty($items))
{
	$finder = array();
	foreach($items as $item)
	{
		$id = $item['id'];
		$newItem = fetchItem($id);
		$item['onsale'] = $newItem['onsale'];
		if(isset($newItem['band']))
		{
			$item['band'] = $newItem['band'];
		}

		if(isset($newItem['price']))
		{
			$item['price'] = $newItem['price'];
		}

		unset($item['_id']);
		$ret = updateItem($db,$item['id'],$item);
	}

}

?>
