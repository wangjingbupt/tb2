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
	$sign = $c->update(array('_id'=>$id),$item);  
	return $sign;
}

function insertItem($db,$item)
{
	$c = $db->selectCollection('items');
	$sign = $c->insert($item);  
	return $sign;
}

function fetchItem($id)
{
	//$id = 1694554;
	//$id = 1571921;
	$url = "http://dongdamen.yiss.com/styles/{$id}.html";
	$data =array();

	$content = file_get_contents($url);
	//$content = file_get_contents('1');

	if(preg_match('/img.*?src=\"(.*?tall.jpg)\"/i',$content,$m))
	{
		$data['img'] = str_replace('tall.jpg','small',$m[1]);	
	}
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
	if(preg_match('/synopsis.*?title.*?>(.*?)</is',$content,$m))
	{
		$data['title'] = $m[1];

	}
	$data['url'] = $url;
	$data['id'] = $id;

	return $data;
}

$db = connMongo('tb');
$fp = fopen('ids','r');
while(($line = trim(fgets($fp,4096))))
{
	list($id,$myPrice,$date) = explode(' ',$line);
	$item = fetchItem($id);
	if(count($item) <> 7)
	{
		echo 'fetch error:'.$id."\n";
		continue;
	}
	$item['myPrice'] = $myPrice;
	$item['status'] = 1;
	$item['createtime'] =strtotime($date);

	$oItem = getItem($db,$id);
	if($oItem)
	{	
		$ret = updateItem($db,$oItem['_id'],$item);
	}
	else
	{
		$ret = insertItem($db,$item);
	}
	if(!$ret)
		echo 'error:'.$id."\n";
}

?>
