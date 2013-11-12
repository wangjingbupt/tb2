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

function fetchItem($id)
{
	$url = "http://dongdamen.yiss.com/styles/{$id}.html";
	$data =array();

	$content = file_get_contents($url);
	//$content = file_get_contents('1');

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
